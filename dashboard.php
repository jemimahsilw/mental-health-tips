<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


include 'db.php';


try {
    
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_categories FROM Categories");
    $stmt->execute();
    $totalCategories = $stmt->fetch(PDO::FETCH_ASSOC)['total_categories'];

    
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_users FROM Users");
    $stmt->execute();
    $totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

    
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_tips FROM HealthTips");
    $stmt->execute();
    $totalTips = $stmt->fetch(PDO::FETCH_ASSOC)['total_tips'];

} catch (PDOException $e) {
    
    echo "Error: " . $e->getMessage();
    die(); 
}

ob_start(); 
?>

<!-- HTML content for the dashboard page -->
<h2>Welcome to the Admin Dashboard</h2>

<!-- Dashboard cards -->
<div class="dashboard-cards">
    <!-- Fitness Categories Card -->
    <div class="card" style="background-color: #4CAF50;"> <!-- Green background -->
        <div class="card-left">
            <h2><?php echo htmlspecialchars($totalCategories); ?></h2> <!-- Safely output dynamic data -->
            <p>Fitness Categories</p>
        </div>
        <div class="card-right">
            <i class="fas fa-dumbbell"></i> <!-- Icon for fitness categories -->
        </div>
    </div>

    <!-- Total Users Card -->
    <div class="card" style="background-color: #2196F3;"> <!-- Blue background -->
        <div class="card-left">
            <h2><?php echo htmlspecialchars($totalUsers); ?></h2> <!-- Safely output dynamic data -->
            <p>Total Users</p>
        </div>
        <div class="card-right">
            <i class="fas fa-users"></i> <!-- Icon for users -->
        </div>
    </div>

    <!-- Health Tips Card -->
    <div class="card" style="background-color: #FFC107;"> <!-- Yellow background -->
        <div class="card-left">
            <h2><?php echo htmlspecialchars($totalTips); ?></h2> <!-- Safely output dynamic data -->
            <p>Total Health Tips</p>
        </div>
        <div class="card-right">
            <i class="fas fa-file-alt"></i> <!-- Icon for health tips -->
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); 

include 'admin_base.php'; 
?>
