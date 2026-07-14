<!DOCTYPE html>
    <head>
        <meta name="description" content="FoodSafe Inspector Homepage">
        <meta name="keywords" content="FoodSafe, Inspector, Homepage ">
        <meta name="author" content="CCDEVAP Group 3">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../../src/images/logo-tab.png">
        <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../../styles/css/global.css">
        <link rel="stylesheet" href="../../styles/css/admin/homepage.css">
        <script src="../../styles/js/nav-bar.js"></script>
        <script src="../../styles/js/jquery-3.7.1.min.js"></script>
        <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    
        <title>FoodSafe Inspector Homepage</title>
    </head>
    <body> 
    <div id="navBar"></div>
        
    <main class="homepage-main">
        <h1 class="title-text">Welcome, <span class="titlecolor-orange"><?= htmlspecialchars($firstName) ?></span></h1>
        <p class="subtitle">What would you like to focus on?</p>

        <div class="button-container">
            <div class="button-row">
                <a href="../../controller/FoodBusiness.controller.php" class="btn-pill">Food Business Directory</a>
                <a href="#" class="btn-pill">Report Dashboard</a>
                <a href="inspection-entry.php" class="btn-pill">Log Entry</a>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        FoodSafe - Copyright 2026
    </footer>

    </body>
</html>