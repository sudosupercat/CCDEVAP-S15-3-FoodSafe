<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header('Location: ../loginPage.controller.php');
    exit();
}

require __DIR__ . '/../../model/inspector.model.php';

// REPORTS -- UPDATE STATUS
if (isset($_POST['action']) && $_POST['action'] === 'update' && isset($_POST['id'])) {

    updateReportStatus($pdo, $_POST['id'], $_POST['status']);

    header('Location: ?toast=' . $_POST['status']);
    exit();
}

// REPORTS -- READ
$userID = $_SESSION['userID'];
$role = $_SESSION['role'];
$reports = getReports($pdo, $userID, $role);

// REPORTS -- LOAD SELECTED REPORT
// if (isset($_GET['reportID'])) {
//     $selectedReport = getReportByID($pdo, $_GET['reportID']);
// }

require __DIR__ . '/../../view/inspector/reports.php';

?>