<?php
$host     = 'localhost:3308';
$dbname   = 'foodsafe_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO (
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connected to db.";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>