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

$currentYear = (int)date('Y');
$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : $currentYear;
$availableYears = getAvailableYears($pdo, $userID);
$totalInspections = getTotalInspections($pdo, $userID, $selectedYear);
$pendingReports = getPendingReportsCount($pdo, $userID, $selectedYear);
$monthlyCounts = getInspectionsPerMonth($pdo, $userID, $selectedYear);
$gradeDistribution = getGradeDistribution($pdo, $userID, $selectedYear);

require 'view/inspector/dashboard.php';

?>