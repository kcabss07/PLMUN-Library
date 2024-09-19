<?php
include 'db.php'; // Include your database connection file

if (isset($_GET['token'])) {
    $token = htmlspecialchars(trim($_GET['token']));

    // Prepare a statement to find the user with the given token
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE verification_token = ? AND is_verified = 0");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Token exists, mark email as verified
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        $stmt = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            echo "<script>alert('Email verified successfully! You can now log in.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Error verifying email. Please try again later.'); window.location.href = 'signup.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid or expired token.'); window.location.href = 'signup.html';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No token provided.'); window.location.href = 'signup.html';</script>";
}

$conn->close();
?>
