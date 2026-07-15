<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../model/RestaurantModel.php';
require_once __DIR__ . '/../model/ComplaintModel.php';

$dbConnection = isset($pdo) ? $pdo : (isset($conn) ? $conn : $db);
$restaurantModel = new RestaurantModel($dbConnection);
$complaintModel = new ComplaintModel($dbConnection);

$restaurants = $restaurantModel->getAllRestaurants();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_complaint'])) {
    $restoID = isset($_POST['restoID']) ? intval($_POST['restoID']) : 0;
    $complainant_name = isset($_POST['complainant_name']) ? trim($_POST['complainant_name']) : '';
    $complainant_email = isset($_POST['complainant_email']) ? trim($_POST['complainant_email']) : '';
    $details = isset($_POST['details']) ? trim($_POST['details']) : '';

    if ($restoID > 0 && !empty($complainant_name) && filter_var($complainant_email, FILTER_VALIDATE_EMAIL) && !empty($details)) {
        if ($complaintModel->createComplaint($restoID, $complainant_name, $complainant_email, $details)) {
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

require_once __DIR__ . '/../view/public/complaint.php';
