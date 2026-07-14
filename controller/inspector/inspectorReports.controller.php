<?php

// if (!isset($_SESSION['userID'])) {
//     header("Location: /CCDEVAP-S15-3-FoodSafe/controller/loginPage.controller.php");
//     exit();
// }

require '../../model/inspector.model.php';


// REPORTS -- UPDATE STATUS
if (isset($_POST['action']) && $_POST['action'] === 'update' && isset($_POST['id'])) {

    updateReportStatus($pdo, $_POST['id'], $_POST['status']);

    header('Location: /CCDEVAP-S15-3-FoodSafe/controller/inspector/inspectorReports.controller.php?toast=' . $_POST['status']);
    exit();
}

// REPORTS -- READ ; di pa tested yung session
$userID = $_SESSION['userID'];
$role = $_SESSION['role'];
$reports = getReports($pdo, $userID, $role);

// REPORTS -- LOAD SELECTED REPORT
if (isset($_GET['reportID'])) {
    $selectedReport = getReportByID($pdo, $_GET['reportID']);
}

require '../../view/inspector/reports.php';

?>