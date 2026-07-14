<?php
session_start();
require '../config/db.php';
require '../model/userSession.model.php';

if (isset($_POST['action']) && $_POST['action'] === 'login') {

    $email = trim($_POST['email'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if (empty($email) || empty($pass)) {
        header('Location: ../view/login.php?error=empty');
        exit();
    }

    $user = getUserByEmail($pdo, $email);

    if ($user && password_verify($pass, $user['password'])) {

        if ($user['status'] == 0) {
            header('Location: ../view/login.php?error=disabled');
            exit();
        }

        $_SESSION['userID'] = $user['userID'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['firstName'] = $user['firstName'];

        if ($user['role'] === 'Admin') {
            header('Location: ../controller/admin/adminDashboard.controller.php');
            exit();
        } else {
            header('Location: ../view/inspector/inspector-homepage.php');
            exit();
        }

    } else {
        header('Location: ../view/login.php?error=invalid');
        exit();
    }
}

require '../view/login.php';