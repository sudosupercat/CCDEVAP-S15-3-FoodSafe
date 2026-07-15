<?php
require 'config/db.php'; 

try {
    $stmt = $pdo->query("SELECT userID, password FROM users WHERE password NOT LIKE '$%'");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Found " . count($users) . " users to migrate
.<br><br>";

    $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE userID = ?");

    $count = 0;
    foreach ($users as $user) {
        $userId = $user['userID'];
        $plainTextPassword = $user['password'];

        $hashedPassword = password_hash($plainTextPassword, PASSWORD_DEFAULT);

        $updateStmt->execute([$hashedPassword, $userId]);
        $count++;
    }

    echo "Successfully encrypted and updated $count user passwords!";

} catch (PDOException $e) {
    die("Error during migration: " . $e->getMessage());
}
?>