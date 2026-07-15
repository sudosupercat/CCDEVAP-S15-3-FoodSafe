<?php
require __DIR__ . '/../config/db.php';

//READ
function getReports($pdo, $userID, $role) {
    if ($role == 'Inspector') {
        $sql = $pdo->prepare("SELECT rp.reportID, r.name as establishment, rq.title, rp.createdAt as date, rp.status
                    FROM reports rp
                    JOIN restaurants r ON rp.restoID = r.restoID
                    JOIN requirements rq ON rp.requirementCode = rq.requirementCode
                    JOIN districts d ON r.districtID = d.districtID
                    JOIN users u ON d.districtID = u.districtID
                    WHERE u.userID = ?
                    ORDER BY rp.createdAt;");
        $sql->execute([$userID]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $sql = $pdo->query("SELECT rp.reportID, r.name as establishment, rq.title, rp.createdAt as date, rp.status
                    FROM reports rp
                    JOIN restaurants r ON rp.restoID = r.restoID
                    JOIN requirements rq ON rp.requirementCode = rq.requirementCode
                    ORDER BY rp.createdAt;");
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return $result;
}

// READ -- Selected
function getReportByID($pdo, $reportID) {
    $sql = $pdo->prepare("SELECT rp.reportID, r.name as establishment, rq.title, rp.createdAt as date, rp.description, rp.status
                        FROM reports rp
                        JOIN restaurants r ON rp.restoID = r.restoID
                        JOIN requirements rq ON rp.requirementCode = rq.requirementCode
                        WHERE reportID = ?");
    $sql->execute([$reportID]);
    return $sql->fetch(PDO::FETCH_ASSOC);
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
function getTotalInspections($pdo, $userID) {
    $sql = $pdo->prepare("SELECT COUNT(*) AS total FROM inspections WHERE userID = ?");
    $sql->execute([$userID]);
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

function getPendingReportsCount($pdo) {
    $sql = $pdo->prepare("SELECT COUNT(*) AS total FROM reports WHERE status = 'Pending'");
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

function getInspectionsPerMonth($pdo, $userID) {
    $currentYear = date('Y');
    $sql = $pdo->prepare("
        SELECT MONTH(inspectionDate) as month_num, COUNT(*) as count 
        FROM inspections 
        WHERE userID = ? AND YEAR(inspectionDate) = ?
        GROUP BY MONTH(inspectionDate)
    ");
    $sql->execute([$userID, $currentYear]);
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);

    // Initialize all 12 months with 0
    $monthlyData = array_fill(1, 12, 0);
    foreach ($results as $row) {
        $monthlyData[(int)$row['month_num']] = (int)$row['count'];
    }
    
    return array_values($monthlyData);
}
?>