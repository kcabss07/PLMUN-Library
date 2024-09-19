<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLMUN - Student Monitoring</title>
    <link rel="icon" type="image/x-icon" href="plmun.ico">
    <link rel="stylesheet" href="student_monitoring.css">
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
            <li class="active"><a href="#"><i class="fas fa-user-graduate"></i> Student Monitoring</a></li>
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
        <div class="scanner-container">
            <h1>Library Student Monitoring</h1>
            <div class="scanner-content">
                <div id="qr-reader"></div>
                <div class="student-info">
                    <form id="scanner-form" action="process_qr.php" method="post">
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
                        
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div class="transaction-list">
                <h2>In and Out List</h2>
                <div class="table-controls">
                    <input type="text" id="search" placeholder="Search...">
                    <select id="date-type">
                        <option value="entry_time">Entry Time</option>
                        <option value="exit_time">Exit Time</option>
                    </select>
                    <input type="date" id="start-date">
                    <input type="date" id="end-date">
                    <button onclick="filterByDate()">Filter</button>
                    <button onclick="printTable()">Print</button>
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
                                <th>Entry Time</th>
                                <th>Exit Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'db.php';
                            $result = $conn->query("SELECT student_number, last_name, first_name, course, year_level, entry_time, exit_time, status FROM library_monitoring");
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['student_number']}</td>
                                        <td>{$row['last_name']}</td>
                                        <td>{$row['first_name']}</td>
                                        <td>{$row['course']}</td>
                                        <td>{$row['year_level']}</td>
                                        <td>{$row['entry_time']}</td>
                                        <td>{$row['exit_time']}</td>
                                        <td>{$row['status']}</td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="student_monitoring.js"></script>
</body>
</html>
