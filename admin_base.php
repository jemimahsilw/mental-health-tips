<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['username'])) {
    
    header('Location: ../index.php');
    exit(); 
}


$currentPage = basename($_SERVER['PHP_SELF'], ".php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https:
    <link rel="stylesheet" href="../assets/css/admin_base.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <!-- App Name -->
            <div class="app-name">
                <h1>Health Tips</h1>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" placeholder="Search...">
            </div>

            <!-- User Info -->
            <div class="user-info">
                <span class="notification-icon">🔔</span>
                <img class="user-image" src="../assets/img/admin_profile.jpg" alt="User Image">
                <span class="username">
                    <?php 
                        
                        echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; 
                    ?>
                </span>
            </div>
        </div>
    </header>

    <!-- Container for sidebar and content -->
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <nav>
                <ul>
                    <li>
                        <a href="dashboard.php" class="<?= $currentPage == 'dashboard' ? 'active' : '' ?>">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="users.php" class="<?= $currentPage == 'users' ? 'active' : '' ?>">
                            <i class="fas fa-users"></i> Manage Users
                        </a>
                    </li>
                    <li>
                        <a href="settings.php" class="<?= $currentPage == 'settings' ? 'active' : '' ?>">
                            <i class="fas fa-cogs"></i> Settings
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" class="<?= $currentPage == 'logout' ? 'active' : '' ?>">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Dynamic content will be injected here -->
            <?php echo $content; ?>
        </main>
    </div>
</body>
</html>
