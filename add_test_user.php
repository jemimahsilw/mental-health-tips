<?php
session_start();
include 'db.php'; 


$username = 'admin'; 
$password = 'Password@123'; 
$is_staff = 1; 


$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$stmt = $pdo->prepare("INSERT INTO Users (username, password_hash, is_staff) VALUES (:username, :password, :is_staff)");

try {
    $stmt->execute([
        'username' => $username,
        'password' => $hashed_password,
        'is_staff' => $is_staff
    ]);
    echo "User added successfully!";
} catch (PDOException $e) {
    echo "Error adding user: " . $e->getMessage();
}
?>
