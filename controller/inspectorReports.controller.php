<?php
// sesion_start();
// $_SESSION['userID'] = $user['userID'];

require '../model/inspector.model.php';


// REPORTS -- UPDATE STATUS
if (isset($_POST['action']) && $_POST['action'] === 'update' && isset($_POST['id'])) {

    updateReportStatus($pdo, $_POST['id'], $_POST['status']);

    header('Location: /CCDEVAP-S15-3-FoodSafe/controller/inspectorReports.controller.php');
    exit();
}

// REPORTS -- READ
// $userID = $_GET['userID'];
$userID = 3;
$reports = getReports($pdo, $userID);

// REPORTS -- LOAD SELECTED REPORT
if (isset($_GET['reportID'])) {
    $selectedReport = getReportByID($pdo, $_GET['reportID']);
}

require '../users/inspector/reports.php';

?>