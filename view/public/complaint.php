<?php
require_once '../../controller/ComplaintController.php';

$dbConnection = isset($pdo) ? $pdo : (isset($conn) ? $conn : $db);
$controller = new ComplaintController($dbConnection);
$restaurants = $controller->getRestaurants();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_complaint'])) {
    $restoID = isset($_POST['restoID']) ? intval($_POST['restoID']) : 0;
    $complainant_name = isset($_POST['complainant_name']) ? trim($_POST['complainant_name']) : '';
    $complainant_email = isset($_POST['complainant_email']) ? trim($_POST['complainant_email']) : '';
    $details = isset($_POST['details']) ? trim($_POST['details']) : '';

    if ($restoID > 0 && !empty($complainant_name) && filter_var($complainant_email, FILTER_VALIDATE_EMAIL) && !empty($details)) {
        if ($controller->submitComplaint($restoID, $complainant_name, $complainant_email, $details)) {
            $message = "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <i class='bi bi-check-circle-fill me-2'></i>Your report was registered. Food safety personnel have been assigned.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        } else {
            $message = "<div class='alert alert-danger'>An internal connection error occurred.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Form incomplete. Please check syntax parameters.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodSafe - Report Food Safety Infractions</title>
    <link class="icon" type="image/png" rel="icon" href="src/images/logo-tab.png">
    <link rel="stylesheet" href="styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="styles/css/global.css">
    <script src="styles/js/jquery-3.7.1.min.js"></script>
    <script src="styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <script src="styles/js/nav-bar.js"></script>
</head>
<body class="bg-light">
    <div id="navBar"><?php include __DIR__ . '/../navbar.php';?></div>

    <div class="container my-5" style="max-width: 600px;">
        <?= $message ?>
        <div class="card border-0 shadow">
            <div class="card-header bg-danger text-white py-3">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i> Public Health Violation Report</h5>
            </div>
            <div class="card-body p-4">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="restoID" class="form-label">Establishment Name</label>
                        <select name="restoID" id="restoID" class="form-select" required>
                            <option value="">-- Choose Target Facility --</option>
                            <?php foreach($restaurants as $res): ?>
                                <option value="<?= $res['restoID'] ?>"><?= htmlspecialchars($res['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="complainant_name" class="form-label">Your Name</label>
                        <input type="text" name="complainant_name" id="complainant_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="complainant_email" class="form-label">Contact Email Address</label>
                        <input type="email" name="complainant_email" id="complainant_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="details" class="form-label">Describe Incident Details</label>
                        <textarea name="details" id="details" rows="5" class="form-control" placeholder="Please explain contamination, food storage, dirty practices, pest sightings, or structural damage..." required></textarea>
                    </div>
                    <button type="submit" name="submit_complaint" class="btn btn-danger w-100 py-2 mt-3">
                        <i class="bi bi-send-fill me-2"></i> Dispatch Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
