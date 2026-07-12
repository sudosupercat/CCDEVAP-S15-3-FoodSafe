<?php
require '../model/admin-model.php';

// DASHBOARD
$year = $_GET['yearPicker'] ?? date('Y');
$month = $_GET['monthPicker'] ?? '';
$userCounts = getInspectorCounts($pdo, $year, $month);
require '../users/admin/dashboard.php';



?>