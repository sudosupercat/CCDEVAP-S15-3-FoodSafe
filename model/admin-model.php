<?php
require '../db.php';

// DASHBOARD
function getInspectorCounts($pdo, $year, $month) {
    $result = new stdClass();

    $monthFilter = "";
    $params = [$year];

    //If no month is selected, display year result
    if ($month != '') {
        $monthFilter = " AND MONTH(createdAt) = ?";
        $params[] = $month + 1;
    }

    # Get total number for created users
    $sql_created = $pdo->prepare("SELECT COUNT(*) AS created 
                            FROM users
                            WHERE role='Inspector'
                            AND YEAR(createdAt) = ?
                            $monthFilter");
    $sql_created->execute($params);
    $created_results = $sql_created->fetch(PDO::FETCH_ASSOC);

    # Get total number of disabled users
    $sql_disabled = $pdo->prepare("SELECT COUNT(*) AS disabled 
                                FROM users
                                WHERE role='Inspector' 
                                AND status='0'
                                AND YEAR(createdAt) = ?
                                $monthFilter");
    $sql_disabled->execute($params);
    $disabled_results = $sql_disabled->fetch(PDO::FETCH_ASSOC);

    # Get total number of deleted users
    $sql_deleted = $pdo->prepare("SELECT COUNT(*) AS deleted
                                FROM users
                                WHERE role='Inspector' 
                                AND deleteFlag = '1'
                                AND YEAR(createdAt) = ?
                                $monthFilter");
    $sql_deleted->execute($params);
    $deleted_results = $sql_deleted->fetch(PDO::FETCH_ASSOC);

    $result->created = $created_results['created'];
    $result->disabled = $disabled_results['disabled'];
    $result->deleted = $deleted_results['deleted'];

    return $result;
}



?>