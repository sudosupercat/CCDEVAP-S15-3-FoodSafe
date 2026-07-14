<?php
require '../config/db.php';

function getUserEmail($pdo, $email) {
    $sql = $pdo->prepare ("SELECT * FROM users WHERE email = ? AND deleteFlag = 0");
    $sql->execute([$email]);
    return $sql->fetch(PDO::FETCH_ASSOC);
}
?>