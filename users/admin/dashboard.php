<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../styles/bootstrap-4.6.2-dist/css/bootstrap.min.css">
    <script src="../../styles/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- delete if may global na for nav
    <link rel="stylesheet" href="../../styles/css/login-style.css">  -->
    <link rel="stylesheet" href="../../styles/bootstrap-4.6.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../styles/css/global.css">
    <script src="../../styles/js/nav-bar.js"></script>
    <script src="../../styles/js/jquery-3.7.1.min.js"></script>
    <script src="../../styles/bootstrap-4.6.2-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../../styles/css/admin/dashboard.css">
</head>
<body>
    <div id="navBar"></div>

    <div class="header">
        <h1>Web Analytics <br>Dashboard</h1>
        
        <div class="header-pickers">
        <div class="picker">
            <label for="year">Year:</label>
            <select id="yearPicker" name="yearPicker"></select>
        </div>

        <div class="picker">
            <label for="month">Month:</label>
            <select id="monthPicker" name="monthPicker"></select>
        </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="stats">
            <div class="stat-box">
                <div class="total-created">21</div>
                <div class="label">Total Created Users</div>
            </div>

            <div class="stat-box">
                <div class="total-disabled">7</div>
                <div class="label">Total Users Disabled</div>
            </div>

            <div class="stat-box">
                <div class="total-deleted">7</div>
                <div class="label">Total Users Deleted</div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-lg-6">
                <div class="chart">
                    <h4>Inspection Trend</h4>
                     <div class="chart-canvas">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="chart">
                    <h4>Ratio of Violations (in %)</h4>
                    <div class="chart-canvas">
                        <canvas id="pieChart"></canvas>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>

    <footer class="site-footer">
        FoodSafe - Copyright 2026
    </footer>

    <script src="../../styles/js/admin/admin-charts.js"></script>

    <script>
        let yearSelect = document.getElementById('yearPicker');
        const today = new Date();
        let currYear = today.getFullYear();
        for (let i=currYear; i >= currYear-5; i--) {
            var option = document.createElement('option');
            option.value = option.innerHTML = i;
            if (i === currYear)
                option.selected = true;

            yearPicker.appendChild(option);
        }

        const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

        let monthSelect = document.getElementById('monthPicker');
        let currMonth = today.getMonth();
        months.forEach((month,i)=> {
            var option = document.createElement('option');
            option.value = option.innerHTML = i;
            option.innerHTML = month;
            if (i === currMonth)
                option.selected = true;
            monthPicker.appendChild(option);
        })
    </script>
</body>
</html>