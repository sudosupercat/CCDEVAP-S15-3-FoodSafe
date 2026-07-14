<?php
$host     = 'localhost:3306';
$dbname   = 'foodsafe_db';
$username = 'root';
$password = 'x4lobxot';

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