<?php
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../../controller/loginPage.controller.php');
    exit();
}

$adminName = $_SESSION['firstName'] ?? 'Admin';
?>