<?php
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../loginPage.controller.php');
    exit();
}

require __DIR__ . '/../../model/admin.model.php';

$year = $_GET['yearPicker'] ?? date('Y');
$month = $_GET['monthPicker'] ?? '';
$userCounts = getInspectorCounts($pdo, $year, $month);
$gradeInspecCount = getGradeInspection($pdo, $year);

$violationCount = getViolationCount($pdo, $year, $month);
$distFailedCount = getDistrictFailedCount($pdo, $year, $month);
$distViolationTypeCount = getDistrictViolationTypeCount($pdo, $year, $month);

require __DIR__ . '/../../view/admin/dashboard.php';
?>