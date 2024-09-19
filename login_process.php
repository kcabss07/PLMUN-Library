<?php
include 'db.php'; // Include your database connection file
session_start(); // Start the session to access CAPTCHA code

// Ensure the form method is POST and the fields are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['captcha'])) {
    // Sanitize user inputs
    $usernameOrEmail = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);
    $captcha = trim($_POST['captcha']);

    // Check if CAPTCHA is correct
    if ($captcha == $_SESSION['captcha_code']) {
        // Prepare the SQL statement with two placeholders
        $stmt = $conn->prepare("SELECT password, is_verified FROM users WHERE username = ? OR institutional_email = ?");
        
        // Bind parameters to the SQL query
        $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail); // Bind both username and email

        // Execute the query
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $is_verified);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                if ($is_verified) {
                    // Successful login
                    echo "<script>alert('Login successful!'); window.location.href = 'dashboard.php';</script>";
                } else {
                    // Email not verified
                    echo "<script>alert('Please verify your email address before logging in.'); window.location.href = 'login.php';</script>";
                }
            } else {
                // Invalid password
                echo "<script>alert('Invalid username or password.'); window.location.href = 'login.php';</script>";
            }
        } else {
            // User not found
            echo "<script>alert('Invalid username or password.'); window.location.href = 'login.php';</script>";
        }

        $stmt->close();
    } else {
        // Invalid CAPTCHA
        echo "<script>alert('Invalid CAPTCHA. Please try again.'); window.location.href = 'login.php';</script>";
    }
} else {
    echo "<script>alert('Please fill in all fields.'); window.location.href = 'login.php';</script>";
}

$conn->close();
?>
