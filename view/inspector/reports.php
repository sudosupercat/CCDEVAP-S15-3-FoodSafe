<?php
require __DIR__ . '/../theme-cookie.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../styles/css/global.css">
    <link rel="stylesheet" href="../../styles/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../styles/css/inspector/reports.css">
    <link rel="icon" type="image/x-icon" href="../../src/images/logo-tab.png">
    <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <script src="../../styles/js/nav-bar.js"></script>
    <script src="../../styles/js/jquery-3.7.1.min.js"></script>
    <script src="../../styles/js/dataTables.min.js"></script>
    <script src="../../styles/js/inspector/reports.js"></script>
</head>
<body>
    <?php include __DIR__ . '/../navbar.php';?>

    <div class="page-header">
        <h1 class="fw-bold">Report Management</h1>
    </div>

    <div class="table-custom table-responsive">
        <table id="reports-table" class="display table table-striped">
            
            <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Establishment</th>
                <th>Violation</th>
                <th>Status</th> 
                <th>Update Status</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($reports as $report) {
                    echo "<tr class='viewOnly' data-description='" . htmlspecialchars($report['description']) . "'>";
                    echo "<td>" . $i . "</td>";
                    echo "<td>" . htmlspecialchars(date('F j, Y', strtotime($report['date']))) . "</td>";
                    echo "<td>" . htmlspecialchars($report['establishment']) . "</td>";
                    echo "<td>" . htmlspecialchars($report['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($report['status']) . "</td>";
                    
                    echo "<td>";
                    echo "<div class='actions-button'>";
                    if($report['status'] == 'Pending') {
                        echo "
                        <form method='POST' action='../../controller/inspector/inspectorReports.controller.php'>
                            <input type='hidden' name='action' value='update'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($report['reportID']) . "'>
                            <input type='hidden' name='status' value='Reviewed'>
                            <button type='submit' class='btn-reviewed'>Reviewed</button>
                        </form>";
                        echo "
                        <form method='POST' action='../../controller/inspector/inspectorReports.controller.php'>
                            <input type='hidden' name='action' value='update'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($report['reportID']) . "'>
                            <input type='hidden' name='status' value='Dismissed'>
                            <button type='submit' class='btn-dismissed'>Dismissed</button>
                        </form>";
                    }
                    echo "</td>";
                    echo "</tr>";

                    $i++;
                }
                ?>
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Establishment</th>
                <th>Violation</th>
                <th>Status</th> 
                <th>Update Status</th>
            </tr>
            </tfoot>
        </table>
    </div>
    </div>

    <!-- Details Modal -->
    <div id="report-details-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>View Report Details</h2>
            </div>
            <div class="modal-body">
                <p><strong>Date:</strong> <span id="detail-date"></span></p>
                <p><strong>Establishment:</strong> <span id="detail-establishment"></span></p>
                <p><strong>Violation:</strong> <span id="detail-violation"></span></p>
                <p><strong>Description:</strong> <span id="detail-description"></span></p>
                <p><strong>Status:</strong> <span id="detail-status"></span></p>
            </div>
            <div class="modal-footer">
            <button type="button" id="report-modal-close">Close</button>
            </div>
        </div>
    </div>

    <div id="toast" class="custom-toast hidden">
            <div class="toast-text">
                <strong id="toast-title">Toast Title</strong>
                <p id="toast-message">Toast Message</p>
            </div>
            <span class="toast-close" onclick="hideToast()">&times;</span>
    </div>

    <?php require __DIR__ . '/../footer.php'; ?>

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
            "Pending" => "Report marked pending.",
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

        document.querySelectorAll('#reports-table tbody tr.viewOnly').forEach(row => {
            row.addEventListener('click', function(e) {
                if (e.target.tagName === 'BUTTON') return;

                const data = this.querySelectorAll('td');

                document.getElementById('detail-date').textContent = data[1].textContent;
                document.getElementById('detail-establishment').textContent = data[2].textContent;
                document.getElementById('detail-violation').textContent = data[3].textContent;
                document.getElementById('detail-description').textContent = this.dataset.description;
                document.getElementById('detail-status').textContent = data[4].textContent;

                document.getElementById('report-details-modal').style.display = 'block';
                document.body.classList.add('modal-open');
            });
        });

        document.getElementById('report-modal-close').onclick = function() {
            document.getElementById('report-details-modal').style.display = 'none';
            document.body.classList.remove('modal-open');
        };

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('report-details-modal');
            if (e.target === modal) {
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');
            }
        });
    </script>
</body>
</html>