<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PLMUN Library</title>
    <link rel="icon" type="image/x-icon" href="plmun.ico">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="form-wrapper">
        <div class="form-container">
            <!-- PLMUN Logo -->
            <img src="plmun.png" alt="PLMUN Logo" class="logo">
            <p class="school-name">Pamantasan ng Lungsod ng Muntinlupa - Library Management System</p>
            
            <h2>Login</h2>

            <form id="login-form" class="form" action="login_process.php" method="post">
                <div class="input-container">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" id="username" placeholder="Username or Email" required>
                </div>
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <div id="caps-lock-warning-password" class="caps-lock-warning">
                        Caps Lock is on!
                    </div>
                </div>
                <div class="input-container captcha-container">
    <img src="captcha.php" alt="CAPTCHA Image">
    <input type="text" name="captcha" id="captcha" placeholder="Enter CAPTCHA" required>
</div>

                
                <button type="submit">Login</button>

                <p>Don't have an account yet? <a href="signup.html">Sign up here</a></p>
            </form>
        </div>
    </div>
    <script>
        // capslock detection
        document.addEventListener('DOMContentLoaded', function () {
            const passwordField = document.getElementById('password');
            const capsLockWarningPassword = document.getElementById('caps-lock-warning-password');

            function checkCapsLock(event) {
                const isCapsLock = event.getModifierState && event.getModifierState('CapsLock');
                if (isCapsLock) {
                    capsLockWarningPassword.style.display = 'block';
                } else {
                    capsLockWarningPassword.style.display = 'none';
                }
            }

            passwordField.addEventListener('keydown', checkCapsLock);
            passwordField.addEventListener('keyup', checkCapsLock);

            capsLockWarningPassword.style.display = 'none';
        });
    </script>
</body>
</html>
