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

    if($user) {
        //Check if the user is disabled
        if ($user['status'] == 0) {
                header('Location: ../view/login.php?error=disabled');
                exit();
            }

        if ($user && password_verify($password, $user['password'])) {
            //reset login attempts to 0 on successful login
            resetLoginAttempts($pdo, $user['userID']); 

            $_SESSION['userID'] = $user['userID'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['firstName'] = $user['firstName'];

            if ($user['role'] === 'Admin') {
                //redirect to admin hompage controller
                header('Location: adminHomepage'); 
                exit();
            } else {
                //redirect to inspector hompage controller
                header('Location: inspectorHomepage'); 
            }

        } else {
            $nextLoginAttempt = $user['loginAttempt'] + 1;

            if($nextLoginAttempt >= 5) {
                //disable the user account
                incrementLoginAttempts($pdo, $user['userID']);
                disableUserAccount($pdo, $user['userID']);
                header('Location: ../view/login.php?error=disabled');
                exit();
            } else {
                //increment login attempts by 1
                incrementLoginAttempts($pdo, $user['userID']);
                header('Location: ../view/login.php?error=invalid');
                exit();
            }
           
        }
    }
    header('Location: ../view/login.php?error=invalid');
    exit();
}

require '../view/login.php';     
?>