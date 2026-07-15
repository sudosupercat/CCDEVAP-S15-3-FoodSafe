<?php
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Inspector') {
    // If not authorized, kick them back to the login page controller
    header('Location: ../loginPage.controller.php');
    exit();
}
require 'config/db.php';
require 'model/inspector.model.php';
$userID = $_SESSION['userID'];

$totalInspections = getTotalInspections($pdo, $userID);
$pendingReports = getPendingReportsCount($pdo, $userID);
$monthlyCounts = getInspectionsPerMonth($pdo, $userID);
$gradeDistribution = getGradeDistribution($pdo, $userID);

require 'view/inspector/dashboard.php';

?>