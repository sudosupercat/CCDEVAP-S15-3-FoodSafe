<?php
require '../config/db.php';

function getUserEmail($pdo, $email) {
    $sql = $pdo->prepare ("SELECT * FROM users WHERE email = ? AND deleteFlag = 0");
    $sql->execute([$email]);
    return $sql->fetch(PDO::FETCH_ASSOC);
}
//Reset login attempts to 0 on a successful login
function resetLoginAttempts($pdo, $userID) {
    $sql = $pdo->prepare("UPDATE users SET loginAttempt = 0 WHERE userID = ?");
    $sql->execute([$userID]);
}

//Increment login attempts by 1
function incrementLoginAttempts($pdo, $userID) {
    $sql = $pdo->prepare("UPDATE users SET loginAttempt = loginAttempt + 1 WHERE userID = ?");
    $sql->execute([$userID]);
}

//Disable the user account (set status to 0)
function disableUserAccount($pdo, $userID) {
    $sql = $pdo->prepare("UPDATE users SET status = 0 WHERE userID = ?");
    $sql->execute([$userID]);
}
?>