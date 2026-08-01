<?php
require 'controller/IndexController.php';
require __DIR__ . '/theme-cookie.php';

$controller = new IndexController();
$homepageData = $controller->getData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodSafe - Home</title>
    <link rel="icon" type="image/png" href="src/images/logo-tab.png">
    <link rel="stylesheet" href="styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="styles/css/global.css">
    <link rel="stylesheet" href="styles/css/public/index.css">
    <script src="styles/js/jquery-3.7.1.min.js"></script>
    <script src="styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <script src="styles/js/nav-bar.js"></script>
</head>
<body>
    <?php include __DIR__ . '/../navbar.php';?>
    <header class="main-section">
        <div id="navbar-placeholder"></div>
        <div class="main-content">
            <h1>More than <span class="text-orange"><?php echo htmlspecialchars($homepageData['totalRestaurants']); ?></span> restaurants<br>inspected for the people.</h1>
            <p>Find out if it's as clean as it is from the outside.</p>

            <form action="view/public/search.php" method="GET" class="search-form">
                <input type="text" name="query" class="search-input" placeholder="<?php echo htmlspecialchars($homepageData['randomPlaceholder']); ?>" required>
            </form>
        </div>
    </header>

    <section class="latest-review">
        <div class="review-text-container">
            <h2>See the latest restaurant<br>we reviewed.</h2>
        </div>

        <a href="/restaurant-detail?id=<?php echo htmlspecialchars($homepageData['latestRestoID']); ?>" class="review-link-wrapper">
            <div class="review-image-container" style="background-image: url('<?php echo htmlspecialchars($homepageData['latestRestoImage']); ?>');">
                <div class="restaurant-name-banner">
                    <?php echo htmlspecialchars($homepageData['latestRestoName']); ?>
                </div>
            </div>
        </a>
    </section>

    <section class="report-hazard">
        <div class="hazard-text-container">
            <h2>Spotted a <span class="text-orange">hazard?</span></h2>
        </div>
        
        <div class="hazard-action-container">
            <a href="/complaint" class="btn-dark">File a report.</a>
        </div>
    </section>

    <footer class="site-footer">
        FoodSafe - Copyright 2026
    </footer>
</body>
</html>