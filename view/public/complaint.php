<?php
require_once '../../controller/ComplaintController.php';

$dbConnection = isset($pdo) ? $pdo : (isset($conn) ? $conn : $db);
$controller = new ComplaintController($dbConnection);
$restaurants = $controller->getRestaurants();
$requirementTypes = $controller->getRequirementTypes();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_complaint'])) {
    $restoID = isset($_POST['restoID']) ? intval($_POST['restoID']) : 0;
    $firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $contactNo = isset($_POST['contactNo']) ? trim($_POST['contactNo']) : '';
    $requirementCode = isset($_POST['requirementCode']) ? intval($_POST['requirementCode']) : 0;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    if ($restoID > 0 && !empty($firstName) && !empty($lastName) && filter_var($email, FILTER_VALIDATE_EMAIL) && $requirementCode > 0 && !empty($description)) {
        if ($controller->submitComplaint($restoID, $firstName, $lastName, $email, $contactNo, $requirementCode, $description)) {
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
                        <label for="requirementCode" class="form-label">Type of Violation</label>
                        <select name="requirementCode" id="requirementCode" class="form-select" required>
                            <option value="">-- Select Violation Type --</option>
                            <?php foreach($requirementTypes as $req): ?>
                                <option value="<?= $req['requirementCode'] ?>"><?= htmlspecialchars($req['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" name="firstName" id="firstName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" name="lastName" id="lastName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Contact Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactNo" class="form-label">Contact Number <span class="text-muted">(optional)</span></label>
                        <input type="tel" name="contactNo" id="contactNo" class="form-control" pattern="[0-9]{10,11}" placeholder="Philippine cellphone#">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Describe Incident Details</label>
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Please explain contamination, food storage, dirty practices, pest sightings, or structural damage..." required></textarea>
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
