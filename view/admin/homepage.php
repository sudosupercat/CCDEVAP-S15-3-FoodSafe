<?php require 'controller/admin/adminHomepage.controller.php'; ?>

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
                <a href="/adminUsers" class="btn-pill">Add New User</a>
                <a href="/adminAddUsers" class="btn-pill">User Management</a> 
                <a href="/business-directory" class="btn-pill">Restaurant Management</a>
                <a href="/exportData" class="btn-pill">Export System Data</a>
            </div>
            <div class="button-row">
                <a href="/adminDashboard" class="btn-pill">Check Website Report</a>
            </div>
        </div>
    </main>
    <footer class="site-footer">
        FoodSafe - Copyright 2026
    </footer>
</body>
</html>