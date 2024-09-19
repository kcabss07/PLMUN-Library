<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLMUN - Resources Management</title>
    <link rel="icon" type="image/x-icon" href="plmun.ico">
    <link rel="stylesheet" href="borrowed_returned_books.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
</head>
<body>
    <div class="sidebar">
        <div class="logo-container">
            <img src="plmun.png" alt="PLMUN Logo">
            <h2>PLMUN Library Management System</h2>
        </div>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="student_monitoring.php"><i class="fas fa-user-graduate"></i> Student Monitoring</a></li>
            <li class="active"><a href="#"><i class="fas fa-book"></i> Borrowed-Returned Books</a></li>
            <li><a href="users.php"><i class="fas fa-users"></i> Manage Users</a></li>
            <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn"><i class="fas fa-list"></i> Books <i class="fas fa-caret-down"></i></a>
    <div class="dropdown-content">
        <a href="list_of_books.php">Book List</a>
        <a href="generate_barcode.php">Generate Barcode</a>
    </div>
</li>

            <li class="logout"><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="container">
        <div class="scanner-container">
            <h1>Borrowing & Returning of Books</h1>
            <div class="scanner-content">
                <div id="qr-reader"></div>
                <div class="book-info">
                    <form id="transaction-form" action="processTransaction.php" method="POST">
                        <label for="student-number">Student Number:</label>
                        <input type="text" id="student_number" name="student_number" readonly>
                        
                        <label for="last-name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" readonly>
                        
                        <label for="first-name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" readonly>
                        
                        <label for="course">Course:</label>
                        <input type="text" id="course" name="course" readonly>
                        
                        <label for="year-level">Year Level:</label>
                        <input type="text" id="year_level" name="year_level" readonly>
                    </div>
                    <div class="book-info">
                        <label for="book-name">Book Name:</label>
                        <input type="text" id="book-name" name="book_name" readonly>
                        
                        <label for="isbn">ISBN:</label>
                        <input type="text" id="isbn" name="isbn" readonly>
                        
                        <label for="author">Author:</label>
                        <input type="text" id="author" name="author" readonly>
                        
                        <label for="year-published">Year Published:</label>
                        <input type="text" id="year-published" name="year_published" readonly>
                        
                        <input type="hidden" name="stat" id="stat" value="borrowed">
                        
                        <button type="submit">Submit</button>
                    </div>
                </form>
            </div>
            <div class="transaction-list">
                <h2>Transaction List</h2>
                <div class="table-controls">
                    <input type="text" id="search" placeholder="Search...">
                    <select id="date-type">
                        <option value="borrow_time">Borrowed Date</option>
                        <option value="due_date">Due Date</option>
                        <option value="return_time">Returned Date</option>
                    </select>
                    <input type="date" id="start-date">
                    <input type="date" id="end-date">
                    <button onclick="filterByDate()">Filter</button>
                    <button onclick="exportTableToExcel('transactionTable', 'transactions')">Export to Excel</button>
                </div>
                <div class="table-container">
                    <table id="transactionTable">
                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Course</th>
                                <th>Year Level</th>
                                <th>Book Name</th>
                                <th>ISBN</th>
                                <th>Author</th>
                                <th>Borrow Time</th>
                                <th>Due Date</th>
                                <th>Return Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'db.php';
                            $result = $conn->query("SELECT student_number, last_name, first_name, course, year_level, book_name, isbn, author, borrow_time, due_date, return_time, stat FROM transactions");
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['student_number']}</td>
                                        <td>{$row['last_name']}</td>
                                        <td>{$row['first_name']}</td>
                                        <td>{$row['course']}</td>
                                        <td>{$row['year_level']}</td>
                                        <td>{$row['book_name']}</td>
                                        <td>{$row['isbn']}</td>
                                        <td>{$row['author']}</td>
                                        <td>{$row['borrow_time']}</td>
                                        <td>{$row['due_date']}</td>
                                        <td>{$row['return_time']}</td>
                                        <td>{$row['stat']}</td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="borrowed_returned_books.js"></script>

</body>
</html>