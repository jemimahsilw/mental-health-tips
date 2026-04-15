<?php
session_start();
include 'db.php'; // Include the database connection

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // Retrieve user information from the database
    $stmt = $pdo->prepare("SELECT is_staff, username FROM Users WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Redirect based on user role
    if ($user) {
        if ($user['is_staff']) {
            header("Location: admin/dashboard.php"); // Redirect to admin dashboard
            exit;
        } else {
            header("Location: user/comments.php"); // Redirect to user dashboard
            exit;
        }
    }
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (!empty($username) && !empty($password)) {
        // Prepare SQL statement to fetch user data
        $stmt = $pdo->prepare("SELECT user_id, password_hash, is_staff, username FROM Users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($user && password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['is_staff'] = $user['is_staff'];
            $_SESSION['username'] = $user['username']; // Store username in session for display

            // Redirect based on user role
            if ($user['is_staff']) {
                header("Location: admin/dashboard.php"); // Admin dashboard
                exit;
            } else {
                header("Location: user/comments.php"); // User dashboard
                exit;
            }
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Please enter both username and password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
    <div class="login_container">
        <h2>Login</h2>
        <div class="login_error"><?php echo isset($error) ? $error : ''; ?></div>
        <form action="" method="post">
            <div class="login_input-container">
                <label for="username">Username</label>
                <div class="login_input-wrapper">
                    <i class="login_icon fa fa-user"></i> 
                    <input type="text" id="username" name="username" required>
                </div>
            </div>

            <div class="login_input-container">
                <label for="password">Password</label>
                <div class="login_input-wrapper">
                    <i class="login_icon fa fa-lock"></i> 
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="login_toggle-password" id="toggle-password">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit">Login</button>
            <div class="login_forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
            <div class="login_register-prompt">
                <span>New to the System? <a href="#">Register here</a></span>
            </div>
        </form>
    </div>

    <script>
        // Function to toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('#toggle-password i'); // Get the icon inside the toggle button
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'; // Change input type to text
                toggleIcon.classList.remove('fa-eye'); // Change icon to eye-slash
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password'; // Change input type back to password
                toggleIcon.classList.remove('fa-eye-slash'); // Change icon to eye
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Add event listener for the toggle button
        document.getElementById('toggle-password').addEventListener('click', togglePassword);

    </script>
</body>
</html>

