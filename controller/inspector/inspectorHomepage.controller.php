<?php
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Inspector') {
    header('Location: ../loginPage.controller.php');
    exit();
}

$firstName = $_SESSION['firstName'];

require 'view/inspector/inspector-homepage.php';
exit();

?>