<?php
require '../model/admin.model.php';

$year = $_GET['yearPicker'] ?? date('Y');
$month = $_GET['monthPicker'] ?? '';
$userCounts = getInspectorCounts($pdo, $year, $month);
require '../view/admin/dashboard.php';
?>