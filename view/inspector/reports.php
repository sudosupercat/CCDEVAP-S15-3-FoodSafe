<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/css/global.css">
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/css/inspector/reports.css">
    <link rel="icon" type="image/x-icon" href="/CCDEVAP-S15-3-FoodSafe/src/images/logo-tab.png">
    <script src="/CCDEVAP-S15-3-FoodSafe/styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <script src="/CCDEVAP-S15-3-FoodSafe/styles/js/nav-bar.js"></script>
    <script src="/CCDEVAP-S15-3-FoodSafe/styles/js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div id="navBar"></div>

    <div class="page-content">
        <div class="container">
            <h2>Incoming Reports</h2>

            <input type="text" placeholder="Search for a complaint..." id="search-input" onkeyup="searchReports()">
            
            <div id="reports-container">
                <?php
                    foreach ($reports as $report) {
                        if ($report['status'] == 'Pending') {
                        echo '<a href="?reportID=' . htmlspecialchars($report['reportID']) . '" class="reports">';
                        echo '<p>Report Date: ' . htmlspecialchars(date('F j, Y', strtotime($report['date']))) . ' - ' . htmlspecialchars($report['establishment']) . '</p>';
                        echo '<p>Violation: ' . htmlspecialchars($report['title']) . '</p>';
                        echo '<p>Status: ' . htmlspecialchars($report['status']) . '</p>';
                        echo '</a>';
                        }
                    }
                ?>
            </div>
        </div>

        <div id="details-container">
                <h3>Report Details</h3>
                <?php if (isset($selectedReport)): ?>
                <p>Report ID: <?= htmlspecialchars($selectedReport['reportID']) ?></p>
                <p>Date: <?= htmlspecialchars(date('F j, Y', strtotime($selectedReport['date']))) ?></p>
                <p>Establishment: <?= htmlspecialchars($selectedReport['establishment']) ?></p>
                <p>Violation: <?= htmlspecialchars($selectedReport['title']) ?></p>
                <p>Description: <?= htmlspecialchars($selectedReport['description']) ?></p>

                <div class="actions-button">
                    <form method="POST" action="/CCDEVAP-S15-3-FoodSafe/controller/inspector/inspectorReports.controller.php">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($selectedReport['reportID']) ?>">
                            <input type="hidden" name="status" value="Reviewed">

                            <button type="submit">Reviewed</button>
                    </form>

                    <form method="POST" action="/CCDEVAP-S15-3-FoodSafe/controller/inspector/inspectorReports.controller.php">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($selectedReport['reportID']) ?>">
                        <input type="hidden" name="status" value="Dismissed">

                        <button type="submit">Dismissed</button>
                    </form>
                </div>
                <?php else: ?>

                <p>Select a report.</p>

                <?php endif; ?>
        </div>
    </div>

    <div id="toast" class="custom-toast hidden">
            <div class="toast-text">
                <strong id="toast-title">Toast Title</strong>
                <p id="toast-message">Toast Message</p>
            </div>
            <span class="toast-close" onclick="hideToast()">&times;</span>
    </div>
    
    <footer class="site-footer">
        FoodSafe - Copyright 2026
    </footer>

    <script>
        function searchReports() {
            var input, filter, reports;
            input = document.getElementById("search-input");
            filter = input.value.toUpperCase();
            reports = document.querySelectorAll('.reports');

            reports.forEach(report => {
                const key = report.textContent.toUpperCase();

                if (key.includes(filter)) {
                    report.style.display='';
                } else {
                    report.style.display='none';
                }
            }
            )
        }

        let toastTimeout;

        <?php
        $toastMessages = [
            "Reviewed" => "Report marked reviewed.",
            "Dismissed" => "Report marked dismissed."
        ];

        if (isset($_GET['toast']) && isset($toastMessages[$_GET['toast']])):
        ?>

        function showToast(type, title, message) {
            const toast = document.getElementById('toast');

            document.getElementById('toast-title').textContent = title;
            document.getElementById('toast-message').textContent = message;

            toast.classList.remove('pending', 'reviewed', 'dismissed');
            toast.classList.remove('hidden');
            toast.classList.add(type);

            clearTimeout(toastTimeout);

            toastTimeout = setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove(type);
            }, 5000);
        }

        window.onload = function() {
            showToast(
                "<?php echo strtolower($_GET['toast']) ?>",
                "Updated Report Status",
                "<?php echo $toastMessages[$_GET['toast']] ?>"
            );
        }

        <?php endif; ?>

        function hideToast() {
            const toast = document.getElementById('toast');

            toast.classList.add('hidden');
            toast.classList.remove('pending', 'reviewed', 'dismissed');

            clearTimeout(toastTimeout);
        }
    </script>
</body>
</html>