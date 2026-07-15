<?php
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login');
    exit();
}

$adminName = $_SESSION['firstName'] ?? 'Admin';
<<<<<<< HEAD
require 'view/admin/homepage.php';
=======

require __DIR__ . '/../../view/admin/homepage.php';
>>>>>>> e24abdd8ac21bdd9cacaf2373233b4b3b6d85de5
?>