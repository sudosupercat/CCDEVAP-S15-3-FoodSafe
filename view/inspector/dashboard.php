<?php
require __DIR__ . '/../theme-cookie.php';
?>
<!DOCTYPE html>
    <head>
        <meta name="description" content="FoodSafe Inspector Dashboard">
        <meta name="keywords" content="FoodSafe, Inspector, Dashboard ">
        <meta name="author" content="CCDEVAP Group 3">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../../src/images/logo-tab.png">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../../styles/css/inspector/dashboard.css">
        <link rel="stylesheet" href="../../styles/css/global.css">
        <script type="module" src="../../styles/js/nav-bar.js"></script>
        <script src="../../styles/js/jquery-3.7.1.min.js"></script>
        <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
        <title>FoodSafe Inspector Dashboard</title>
    </head>
    <body>
        <?php include __DIR__ . '/../navbar.php';?> 
        <div class="page-header">
            <h1>Inspector Dashboard</h1>
        </div>
        <main>
            <section class="stats-row">
                <div class="stat-box1">
                    <h2><?= $totalInspections ?></h2>
                    <p>Total Inspections Done</p>
                </div>
                <div class="stat-box2">
                    <h2><?= $pendingReports ?></h2>
                    <p>Pending Reports</p>
                </div>
            </section> 

            <section class="charts-row">
                <div class="chart-box1">
                    <h2>Inspections Per Month</h2>
                    <!-- Placeholder for chart -->
                    <div class="chart-placeholder">
                        <canvas id="inspectionsChart"></canvas>
                    </div>
                </div>
                <div class="chart-box2">
                    <h2>Grade Distribution</h2>
                    <!-- Placeholder for chart -->
                    <div class="chart-placeholder">
                        <canvas id="gradeChart"></canvas>
                    </div>
                </div>
            </section>
        </main>
        <script>
            const monthlyCounts = <?= json_encode($monthlyCounts) ?>;
            const gradeChartData = <?= json_encode($gradeDistribution) ?>;
        </script>
        <script src="../../styles/js/inspector/inspector-charts.js"></script>
        <footer class="site-footer">
            FoodSafe - Copyright 2026
        </footer>
    </body>
</html>