<?php
require 'model/admin.model.php';

$year = $_GET['yearPicker'] ?? date('Y');
$month = $_GET['monthPicker'] ?? '';
$userCounts = getInspectorCounts($pdo, $year, $month);
$passInspecCount = getPassInspection($pdo, $year);
$failInspecCount = getFailInspection($pdo, $year);
$violationCount = getViolationCount($pdo, $year);

require 'view/admin/dashboard.php';
?>