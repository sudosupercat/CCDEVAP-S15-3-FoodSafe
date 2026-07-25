<?php
require_once __DIR__ . '/../../controller/ComplaintController.php';

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
    <link rel="stylesheet" href="styles/css/public/user-complaints.css">
    <script src="styles/js/jquery-3.7.1.min.js"></script>
    <script src="styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <script src="styles/js/nav-bar.js"></script>
</head>
<body class="public-report-page">
    <?php include __DIR__ . '/../navbar.php';?>

    <div class="container" style="max-width: 1400px;">
        <?= $message ?>
    </div>

    <div class="report-main">
        <div class="report-left-title">
            <h1>
                <span class="text-main">File a</span>
                <span class="text-orange">report.</span>
            </h1>
        </div>

        <div class="report-right-form">
            <form action="" method="POST">
                <div class="form-line anon-container">
                    <label class="checkbox-label">
                        <input type="checkbox" id="anonToggle">
                        Report anonymously?
                    </label>
                </div>

                <div class="form-line split-row">
                    <div class="input-group">
                        <label for="firstName">First name:</label>
                        <input type="text" name="firstName" id="firstName" class="public-input" required>
                    </div>
                    <div class="input-group">
                        <label for="lastName">Last name:</label>
                        <input type="text" name="lastName" id="lastName" class="public-input" required>
                    </div>
                </div>

                <div class="form-line input-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="public-input" required>
                </div>

                <div class="form-line input-group">
                    <label for="contactNo">Contact #:</label>
                    <input type="tel" name="contactNo" id="contactNo" class="public-input" pattern="[0-9]{10,11}" placeholder="Philippine cellphone#">
                </div>

                <div class="form-line input-group">
                    <label for="restoID">Food business to report:</label>
                    <div class="public-select-wrapper">
                        <select name="restoID" id="restoID" class="public-select" required>
                            <option value="">-- Choose Target Facility --</option>
                            <?php foreach($restaurants as $res): ?>
                                <option value="<?= $res['restoID'] ?>"><?= htmlspecialchars($res['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-line input-group">
                    <label for="requirementCode">Type of violation/s committed:</label>
                    <div class="public-select-wrapper">
                        <select name="requirementCode" id="requirementCode" class="public-select" required>
                            <option value="">-- Select Violation Type --</option>
                            <?php foreach($requirementTypes as $req): ?>
                                <option value="<?= $req['requirementCode'] ?>"><?= htmlspecialchars($req['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-line input-group">
                    <label for="description">Additional details:</label>
                    <textarea name="description" id="description" rows="5" class="public-textarea" placeholder="Please explain contamination, food storage, dirty practices, pest sightings, or structural damage..." required></textarea>
                </div>

                <div class="btn-container-right">
                    <button type="submit" name="submit_complaint" class="public-submit-btn">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>