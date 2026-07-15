<?php
require_once '../../controller/SearchController.php';

$controller = new SearchController();
$searchResults = $controller->getData();
$searchQuery = $_GET['query'] ?? '';
$sortOrder = $_GET['sort'] ?? 'az';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodSafe - Search</title>
    <link rel="icon" type="image/png" href="../../src/images/logo-tab.png">
    <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../styles/css/global.css">
    <link rel="stylesheet" href="../../styles/css/public/search.css">
    <script src="../../styles/js/jquery-3.7.1.min.js"></script>
    <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <script src="../../styles/js/nav-bar.js"></script>
</head>
<body>
    <div id="navBar"><?php include __DIR__ . '/../navbar.php';?></div>
    <div class="search-section">
        <div class="search-content">
            <form action="search.php" method="GET" class="search-form">
                
                <input type="text" name="query" value="<?php echo htmlspecialchars($searchQuery); ?>" class="search-input">
                
                <select name="sort" class="sortby-select" onchange="this.form.submit()">
                    <option value="az" <?php echo ($sortOrder === 'az') ? 'selected' : ''; ?>>Sort by: A-Z</option>
                    <option value="za" <?php echo ($sortOrder === 'za') ? 'selected' : ''; ?>>Sort by: Z-A</option>
                    <option value="violow-hi" <?php echo ($sortOrder === 'violow-hi') ? 'selected' : ''; ?>>Sort by: Violations ↑</option>
                    <option value="viohi-low" <?php echo ($sortOrder === 'viohi-low') ? 'selected' : ''; ?>>Sort by: Violations ↓</option>
                </select>
            </form>
        </div>
    </div>

    <div class="results-section">
        <div id="results-container" class="results-container">
            
            <?php if (empty($searchResults)): ?>
                <p style="color:#ffffff; text-align:center; font-size:1.2rem; font-weight:bold;">No restaurants found matching your search.</p>
            <?php else: ?>
                <?php foreach ($searchResults as $resto): ?>
                    <?php
                        $gradeColor = ''; 
                        switch($resto['grade']) {
                            case 'A': $gradeColor = '#28a745'; break;
                            case 'B': $gradeColor = '#f38020'; break;
                            case 'C': $gradeColor = '#ffc107'; break;
                            case 'F': $gradeColor = '#dc3545'; break; 
                        }
                    ?>

                    <a href="restaurant-detail.php?id=<?php echo htmlspecialchars($resto['restoID']); ?>" class="restaurant-card">
                        <img src="<?php echo htmlspecialchars($resto['image']); ?>" alt="<?php echo htmlspecialchars($resto['name']); ?>" class="resto-image">
                        
                        <div class="resto-info">
                            <h3><?php echo htmlspecialchars($resto['name']); ?></h3>
                            <p class="violations-text"><?php echo htmlspecialchars($resto['violations']); ?> Violations Recorded</p>
                            <p class="inspection-text">Most recent inspection: <?php echo htmlspecialchars($resto['displayDate']); ?></p>
                        </div>
                        <?php if ($resto['violations'] == 0): ?>
                            <br><br>
                        <?php else: ?>
                            <div class="resto-grade" style="color: <?php echo $gradeColor; ?>;">
                                <?php echo htmlspecialchars($resto['grade']); ?>
                            </div>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>

    <footer class="site-footer">
        FoodSafe - Copyright 2026
    </footer>
</body>
</html>