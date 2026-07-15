<?php
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../loginPage.controller.php');
    exit();
}

$adminName = $_SESSION['firstName'] ?? 'Admin';

require 'view/admin/homepage.php';
exit();
?>