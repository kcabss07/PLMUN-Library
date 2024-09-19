<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLMUN - List of Books</title>
    <link rel="icon" type="image/x-icon" href="plmun.ico">
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            <li><a href="borrowed_returned_books.php"><i class="fas fa-book"></i> Borrowed-Returned Books</a></li>
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
        <div class="left-section">
            <h2>Add/Edit Book</h2>
            <form action="getBookDetails.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                <div class="input-container">
                    <label for="book_name">Book Name:</label>
                    <input type="text" name="book_name" id="book_name" required>
                </div>
                <div class="input-container">
                    <label for="author">Author:</label>
                    <input type="text" name="author" id="author" required>
                </div>
                <div class="input-container">
                    <label for="isbn">ISBN:</label>
                    <input type="text" name="isbn" id="isbn" required>
                </div>
                <div class="input-container">
                    <label for="year_published">Year Published:</label>
                    <input type="number" name="year_published" id="year_published" required>
                </div>
                <div class="input-container">
                    <label for="book_photo">Book Photo:</label>
                    <input type="file" name="book_photo" id="book_photo" accept="image/*">
                </div>
                <button type="submit" name="action" value="add">Add Book</button>
                <button type="submit" name="action" value="edit">Edit Book</button>
            </form>
        </div>
        <div class="right-section">
            <h2>Book List</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Book Name</th>
                            <th>Author</th>
                            <th>ISBN</th>
                            <th>Year Published</th>
                            <th>Photo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db.php';
                        $result = $conn->query("SELECT * FROM books");
                        while ($row = $result->fetch_assoc()) {
                            $photo = $row['photo'] ? $row['photo'] : 'no-pic.jpg';
                            echo "<tr>
                                    <td>{$row['book_name']}</td>
                                    <td>{$row['author']}</td>
                                    <td>{$row['isbn']}</td>
                                    <td>{$row['year_published']}</td>
                                    <td><img src='uploads/{$photo}' alt='Book Photo' width='50'></td>
                                    <td>
                                        <button type='button' onclick=\"editBook({$row['id']}, '{$row['book_name']}', '{$row['author']}', '{$row['isbn']}', {$row['year_published']}, '{$photo}')\">Edit</button>
                                        <form action='getBookDetails.php' method='post' style='display:inline;'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <button type='submit' name='action' value='delete'>Delete</button>
                                        </form>
                                    </td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function editBook(id, book_name, author, isbn, year_published, photo) {
            document.getElementById('id').value = id;
            document.getElementById('book_name').value = book_name;
            document.getElementById('author').value = author;
            document.getElementById('isbn').value = isbn;
            document.getElementById('year_published').value = year_published;
            // Handle photo if needed
        }
    </script>
</body>
</html>
