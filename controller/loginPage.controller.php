<?php
session_start();
require '../config/db.php';
require '../model/userSession.model.php';

if(isset($_POST['action']) && $_POST['action'] === 'login') {
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        header('Location: ../view/login.php?error=empty');
        exit();
    }
    $user = getUserEmail($pdo, $email);

    if ($user['status'] == 0) {
            header('Location: ../view/login.php?error=disabled');
            exit();
        }

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['firstName'] = $user['firstName'];

        if ($user['role'] === 'Admin') {
            //redirect to admin hompage controller
            header('Location: ../view/admin/homepage.php'); 
            exit();
        } else {
            //redirect to inspector hompage controller
            header('Location: ../view/inspector/inspector-homepage.php'); 
        }

    } else {
        header('Location: ../view/login.php?error=invalid');
        exit();
    }
}

require '../view/login.php';     
?>