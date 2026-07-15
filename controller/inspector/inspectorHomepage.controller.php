<?php
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Inspector') {
    // If not authorized, kick them back to the login page controller
    header('Location: ../loginPage.controller.php');
    exit();
}

$firstName = $_SESSION['firstName'];

require '../../view/inspector/inspector-homepage.php';
exit();

?>