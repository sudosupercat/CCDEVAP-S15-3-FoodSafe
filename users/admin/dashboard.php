<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/css/global.css">
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/CCDEVAP-S15-3-FoodSafe/styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <script src="/CCDEVAP-S15-3-FoodSafe/styles/js/nav-bar.js"></script>
    <script src="/CCDEVAP-S15-3-FoodSafe/styles/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/css/admin/dashboard.css">
</head>
<body>
    <div id="navBar"></div>

    <div class="header">
        <h1>Web Analytics <br>Dashboard</h1>
        
        <form action="/CCDEVAP-S15-3-FoodSafe/controller/admin-dashboard.php" method="GET">
            <div class="picker">
                <label for="year">Year:</label>
                <select id="yearPicker" name="yearPicker"></select>
            </div>

            <div class="picker">
                <label for="month">Month:</label>
                <select id="monthPicker" name="monthPicker"></select>
            </div>
            <button type="submit" id="picker-btn">Submit</button>
        </form>
    </div>

    <div class="container-fluid">

        <div class="stats">
            <div class="stat-box">
                <div class="total-created"><?php echo $userCounts->created?></div>
                <div class="label">Total Created Users</div>
            </div>

            <div class="stat-box">
                <div class="total-disabled"><?php echo $userCounts->disabled?></div>
                <div class="label">Total Users Disabled</div>
            </div>

            <div class="stat-box">
                <div class="total-deleted"><?php echo $userCounts->deleted?></div>
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

    <script src="/CCDEVAP-S15-3-FoodSafe/styles/js/admin/admin-charts.js"></script>

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

        let monthSelect = document.getElementById('monthPicker');

        const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

        var allMonths = document.createElement('option');
        allMonths.value = '';
        allMonths.innerHTML = 'None';
        allMonths.selected = true;
        monthPicker.appendChild(allMonths);

        months.forEach((month,i)=> {
            var option = document.createElement('option');
            option.value = option.innerHTML = i;
            option.innerHTML = month;
            monthPicker.appendChild(option);
        })
    </script>
</body>
</html>