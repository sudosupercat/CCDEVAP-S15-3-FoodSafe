<?php
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login');
    exit();
}

$adminName = $_SESSION['firstName'] ?? 'Admin';
require 'view/admin/homepage.php';

require __DIR__ . '/../../view/admin/homepage.php';
?>