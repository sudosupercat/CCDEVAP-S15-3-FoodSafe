<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../model/authFoodBusiness.model.php';

class RestaurantDetailController {
    private $pdo;
    private $foodBusinessModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->foodBusinessModel = new FoodBusiness($pdo);
    }

    private function gradeForSeverity($severityTotal) {
        if ($severityTotal == 0) return 'A';
        if ($severityTotal <= 5) return 'B';
        if ($severityTotal <= 10) return 'C';
        return 'F';
    }

    public function handleRequest() {
        $restoID = isset($_GET['restoID']) ? intval($_GET['restoID']) : (isset($_GET['id']) ? intval($_GET['id']) : 1);

        $restaurantObj = $this->foodBusinessModel->getSingleRowInfo($restoID);
        if (!$restaurantObj) {
            header("Location: /");
            exit();
        }

        $restaurant = [
            'restoID' => $restaurantObj->foodBusinessId,
            'licenseNo' => $restaurantObj->licenseNo,
            'name' => $restaurantObj->name,
            'address' => $restaurantObj->address,
            'contactNo' => $restaurantObj->contactNo,
            'maps' => $restaurantObj->mapsLink,
            'image' => $restaurantObj->imageLink,
            'status' => $restaurantObj->status,
            'district' => $restaurantObj->district
        ];

        // Inspection history: one row per inspection, with its violation count,
        // total severity, and the letter grade derived from that severity.
        $inspections = [];
        $overallRating = null;
        try {
            $stmt = $this->pdo->prepare(
                "SELECT i.inspectionID, i.inspectionDate,
                        COUNT(v.violationID) AS violationCount,
                        COALESCE(SUM(CAST(r.severityLvl AS UNSIGNED)), 0) AS severityTotal
                 FROM inspections i
                 LEFT JOIN violations v ON v.inspectionID = i.inspectionID
                 LEFT JOIN requirements r ON r.requirementCode = v.requirementCode
                 WHERE i.restoID = ?
                 GROUP BY i.inspectionID, i.inspectionDate
                 ORDER BY i.inspectionDate DESC"
            );
            $stmt->execute([$restoID]);
            $inspectionRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Violation detail (requirement titles) per inspection, for the click-through modal
            $violationStmt = $this->pdo->prepare(
                "SELECT r.title
                 FROM violations v
                 JOIN requirements r ON r.requirementCode = v.requirementCode
                 WHERE v.inspectionID = ?
                 ORDER BY r.title ASC"
            );

            foreach ($inspectionRows as $row) {
                $violationStmt->execute([$row['inspectionID']]);
                $violationTitles = $violationStmt->fetchAll(PDO::FETCH_COLUMN);

                $inspections[] = [
                    'inspectionID' => $row['inspectionID'],
                    'date' => $row['inspectionDate'],
                    'violationCount' => (int)$row['violationCount'],
                    'severityTotal' => (int)$row['severityTotal'],
                    'grade' => $this->gradeForSeverity((int)$row['severityTotal']),
                    'violationTitles' => $violationTitles
                ];
            }

            // Overall inspection rating: average of letter grades on a 5-point scale
            $gradePoints = ['A' => 5.0, 'B' => 4.0, 'C' => 3.0, 'F' => 1.0];
            if (!empty($inspections)) {
                $sum = 0;
                foreach ($inspections as $i) {
                    $sum += $gradePoints[$i['grade']] ?? 0;
                }
                $overallRating = round($sum / count($inspections), 1);
            }
        } catch (PDOException $e) {
            error_log("Inspections Fetch Error: " . $e->getMessage());
            $inspections = [];
            $overallRating = null;
        }

        require_once __DIR__ . '/../view/public/restaurant-detail.php';
    }
}

$detailController = new RestaurantDetailController($pdo);
$detailController->handleRequest();
?>
