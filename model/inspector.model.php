<?php
require __DIR__ . '/../config/db.php';

//READ
function getReports($pdo, $userID, $role) {
    if ($role == 'Inspector') {
        $sql = $pdo->prepare("SELECT rp.reportID, r.name as establishment, rq.title, rp.createdAt as date, rp.description, rp.status
                    FROM reports rp
                    JOIN restaurants r ON rp.restoID = r.restoID
                    JOIN requirements rq ON rp.requirementCode = rq.requirementCode
                    JOIN districts d ON r.districtID = d.districtID
                    JOIN users u ON d.districtID = u.districtID
                    WHERE u.userID = ?
                    ORDER BY rp.createdAt, rp.status ASC;");
        $sql->execute([$userID]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $sql = $pdo->query("SELECT rp.reportID, r.name as establishment, rq.title, rp.createdAt as date, rp.description, rp.status
                    FROM reports rp
                    JOIN restaurants r ON rp.restoID = r.restoID
                    JOIN requirements rq ON rp.requirementCode = rq.requirementCode
                    ORDER BY rp.createdAt, rp.status ASC;");
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return $result;
}

//UPDATE STATUS
function updateReportStatus($pdo, $reportID, $value) {
    $sql = $pdo->prepare("UPDATE reports
                        SET status = ?
                        WHERE reportID = ?;");
    $result = $sql->execute([$value, $reportID]);
    return $result;
}

//For Inspector Dashboard
function getAvailableYears($pdo, $userID) {
    $sql = $pdo->prepare("
        SELECT DISTINCT YEAR(inspectionDate) AS year 
        FROM inspections 
        WHERE userID = ? 
        ORDER BY year DESC
    ");
    $sql->execute([$userID]);
    $years = $sql->fetchAll(PDO::FETCH_COLUMN);

    // If  has zero inspections show the current year
    if (empty($years)) {
        $years = [date('Y')];
    }

    return $years;
}

function getTotalInspections($pdo, $userID, $year) {
    $sql = $pdo->prepare("SELECT COUNT(*) AS total FROM inspections 
                          WHERE userID = ? AND YEAR(inspectionDate) = ?");
    $sql->execute([$userID, $year]);
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

function getPendingReportsCount($pdo, $userID, $year) {
    $sql = $pdo->prepare("
        SELECT COUNT(*) AS total 
        FROM reports rp
        JOIN restaurants r ON rp.restoID = r.restoID
        JOIN districts d ON r.districtID = d.districtID
        JOIN users u ON d.districtID = u.districtID
        WHERE rp.status = 'Pending' AND u.userID = ? AND YEAR(rp.createdAt) = ?
    ");
    $sql->execute([$userID, $year]);
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

function getInspectionsPerMonth($pdo, $userID, $year) {
    $sql = $pdo->prepare("
        SELECT MONTH(inspectionDate) as month_num, COUNT(*) as count 
        FROM inspections 
        WHERE userID = ? AND YEAR(inspectionDate) = ?
        GROUP BY MONTH(inspectionDate)
    ");
    $sql->execute([$userID, $year]);
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);

    $monthlyData = array_fill(1, 12, 0);
    foreach ($results as $row) {
        $monthlyData[(int)$row['month_num']] = (int)$row['count'];
    }

    return array_values($monthlyData);
}

function getGradeDistribution($pdo, $userID, $year) {
    $sql = $pdo->prepare("
        SELECT grade, COUNT(*) AS total
        FROM inspections
        WHERE userID = ? AND YEAR(inspectionDate) = ?
        GROUP BY grade
    ");
    $sql->execute([$userID, $year]);
    $results = $sql->fetchAll(PDO::FETCH_KEY_PAIR);

    $gradeCounts = ['A' => 0, 'B' => 0, 'C' => 0, 'F' => 0];
    
    foreach ($results as $grade => $count) {    
        if (isset($gradeCounts[$grade])) {
            $gradeCounts[$grade] = (int) $count;
        }
    }
    return [
        'labels' => array_keys($gradeCounts),
        'data'   => array_values($gradeCounts)
    ];
}
?>