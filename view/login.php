<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, skip the login form entirely
if (isset($_SESSION['userID']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'Admin') {
        header('Location: adminHomepage'); //change if may controller na for admin homepage
        exit();
    } else {
        header('Location: inspectorHomepage'); //change if may controller na for inspector homepage
        exit();
    }
}
?>
<html>
    <head>
        <meta name="description" content="FoodSafe Login Page">
        <meta name="keywords" content="FoodSafe, Login, User ">
        <meta name="author" content="CCDEVAP Group 3">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../src/images/logo-tab.png">
        <link rel="stylesheet" href="../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../styles/css/login-style.css">
        <link rel="stylesheet" href="../styles/css/global.css">
        <script src="../styles/js/nav-bar.js"></script>
        <script src="../styles/js/jquery-3.7.1.min.js"></script>
        <script src="../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
        <title>FoodSafe Login</title>
    </head>
    <body>

        <header>
            <div id="navBar"><?php include __DIR__ . '/navbar.php';?></div>
        </header>
        <main>
        <section class="col-lg-6 form-left d-flex align-items-center justify-content-center">
            <div class="form-container">
                <h1 class="fw-bold mb-4">Welcome Back!</h1>
                <form id="loginForm" action="../controller/loginPage.controller.php" method="POST" novalidate>
                    <input type="hidden" name="action" value="login">

                    <div class="form-group">
                        <label id="emailLabel" for="email">E-mail</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label id="passwordLabel" for="password">Password:</label>
                        <input type="password" name="password" id="password" required>

                        <div class="togglePw">
                            <input type="checkbox" id="showPw">
                            <label for="showPw">Show Password</label>
                        </div>
                    </div>
                    <button type="submit" class="login-btn" name="submit">Log-in</button>
                </form>
            </div>
        </section>
        <div id="toast" class="custom-toast hidden">
            <div class="toast-text">
                <strong id="toast-title">Toast Title</strong>
                <p id="toast-message">Toast Message</p>
            </div>
            <span class="toast-close" onclick="hideToast()">&times;</span>
        </div>
        <section class="form-right">
            <img src="../src/images/loginbg.png" alt="Login Illustration">
        </section>
        </main>
        <script>
            const loginError = "<?= isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '' ?>";
        </script>
        <script src="../styles/js/loginpage.js?v=1.0.1"></script>
        <footer class="site-footer">
            FoodSafe - Copyright 2026
        </footer>
    </body>
</html>