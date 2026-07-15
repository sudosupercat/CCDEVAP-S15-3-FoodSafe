<?php
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../../controller/loginPage.controller.php');
    exit();
}

$adminName = $_SESSION['firstName'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodSafe - Admin Homepage</title>
    <link rel="icon" type="image/png" href="../../src/images/logo-tab.png">
    <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../styles/css/global.css">
    <link rel="stylesheet" href="../../styles/css/admin/homepage.css">
    <script src="../../styles/js/jquery-3.7.1.min.js"></script>
    <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <script src="../../styles/js/nav-bar.js"></script>
</head>
<body>
    <div id="navBar"><?php include __DIR__ . '/../navbar.php';?></div>
    <main class="homepage-main">
        <h1 class="title-text">Welcome, <span class="titlecolor-orange"><?php echo htmlspecialchars($adminName); ?></span></h1>
        
        <p class="subtitle">What would you like to focus on?</p>

        <div class="button-container">
            <div class="button-row">
                <a href="../../controller/admin/adminUsers.controller.php" class="btn-pill">Add New User</a>
                <a href="../../controller/admin/adminAddUsers.controller.php" class="btn-pill">User Management</a>
                <a href="../../controller/FoodBusiness.controller.php" class="btn-pill">Restaurant Management</a>
                <a href="../../controller/admin/exportData.controller.php" class="btn-pill">Export System Data</a>
            </div>
            <div class="button-row">
                <a href="../../controller/admin/adminDashboard.controller.php" class="btn-pill">Check Website Report</a>
            </div>
        </div>

        <!--<div class="button-container">
            <div class="button-row">
                <a href="add-user.php" class="btn-pill">Add New User</a>
                <a href="user-management.php" class="btn-pill">User Management</a>
                <a href="../inspector/business-directory.php" class="btn-pill">Restaurant Management</a>
                <a href="export_data.php" class="btn-pill">Export System Data</a>
            </div>
            <div class="button-row">
                <a href="dashboard.php" class="btn-pill">Check Website Report</a>
            </div>
        </div>-->
    </main>
    <footer class="site-footer">
        FoodSafe - Copyright 2026
    </footer>
</body>
</html>