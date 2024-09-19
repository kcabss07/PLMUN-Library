<?php
include 'db.php'; // Include database connection
date_default_timezone_set('Asia/Manila');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data
    $student_number = $_POST['student_number'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $course = $_POST['course'] ?? '';
    $year_level = $_POST['year_level'] ?? '';
    $book_name = $_POST['book_name'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    $author = $_POST['author'] ?? '';
    $year_published = $_POST['year_published'] ?? '';
    $stat = 'borrowed'; // Default to 'borrowed'

     // Get current time for borrow_time
     $current_time = date('Y-m-d H:i:s'); // Current date and time

     // Set due_date to 5 days from now at exactly 4:00 PM
     $due_date_time = new DateTime($current_time);
     $due_date_time->modify('+5 days')->setTime(16, 0); // Add 5 days and set time to 4:00 PM
     $due_date = $due_date_time->format('Y-m-d H:i:s');
 
    // Validate input
    if (empty($student_number) || empty($last_name) || empty($first_name) || empty($course) ||
        empty($year_level) || empty($book_name) || empty($isbn) || empty($author) || empty($year_published)) {
        echo "<script>alert('Incomplete details, please try again.'); window.location.href = 'borrowed_returned_books.php';</script>";
        exit();
    }

    // Check if the book is currently borrowed
    $stmt = $conn->prepare("SELECT id, stat, borrow_time, due_date FROM transactions WHERE isbn = ? ORDER BY borrow_time DESC LIMIT 1");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('s', $isbn);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Fetch the last status of the book
        $stmt->bind_result($id, $current_status, $borrow_time, $due_date);
        $stmt->fetch();

        // If the last status was "borrowed", the user is returning the book
        if ($current_status == 'borrowed') {
            $return_time = $current_time;
            $stat = (strtotime($return_time) > strtotime($due_date)) ? 'returned late' : 'returned';

            $stmt = $conn->prepare("UPDATE transactions SET return_time = ?, stat = ? WHERE id = ?");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }
            $stmt->bind_param('ssi', $return_time, $stat, $id);
            if ($stmt->execute()) {
                echo "<script>alert('Book returned successfully.'); window.location.href = 'borrowed_returned_books.php';</script>";
            } else {
                echo "<script>alert('Error updating return time.'); window.location.href = 'borrowed_returned_books.php';</script>";
            }
        } else {
            // If the book is already returned, allow it to be borrowed again
            $stmt = $conn->prepare("INSERT INTO transactions (student_number, last_name, first_name, course, year_level, book_name, isbn, author, year_published, borrow_time, due_date, stat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }
            $stmt->bind_param('ssssssssssss', $student_number, $last_name, $first_name, $course, $year_level, $book_name, $isbn, $author, $year_published, $current_time, $due_date, $stat); // stat is 'borrowed'
            if ($stmt->execute()) {
                echo "<script>alert('Book borrowed successfully.'); window.location.href = 'borrowed_returned_books.php';</script>";
            } else {
                echo "<script>alert('Error recording book borrowing.'); window.location.href = 'borrowed_returned_books.php';</script>";
            }
        }
    } else {
        // No previous borrow record, meaning this is a new borrow transaction
        $stmt = $conn->prepare("INSERT INTO transactions (student_number, last_name, first_name, course, year_level, book_name, isbn, author, year_published, borrow_time, due_date, stat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param('ssssssssssss', $student_number, $last_name, $first_name, $course, $year_level, $book_name, $isbn, $author, $year_published, $current_time, $due_date, $stat); // stat is 'borrowed'
        if ($stmt->execute()) {
            echo "<script>alert('Book borrowed successfully.'); window.location.href = 'borrowed_returned_books.php';</script>";
        } else {
            echo "<script>alert('Error recording book borrowing.'); window.location.href = 'borrowed_returned_books.php';</script>";
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'borrowed_returned_books.php';</script>";
}
?>
