<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../model/FoodBusiness.model.php';

class RestaurantDetailController {
    private $pdo;
    private $foodBusinessModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->foodBusinessModel = new FoodBusiness($pdo);
    }

    private function gradeForViolationCount($count) {
        if ($count <= 10) return 'A';
        if ($count <= 25) return 'B';
        if ($count <= 55) return 'C';
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

        // Inspection history: one row per inspection, with its violation count + letter grade
        $inspections = [];
        try {
            $stmt = $this->pdo->prepare(
                "SELECT i.inspectionID, i.inspectionDate, COUNT(v.violationID) AS violationCount
                 FROM inspections i
                 LEFT JOIN violations v ON v.inspectionID = i.inspectionID
                 WHERE i.restoID = ?
                 GROUP BY i.inspectionID, i.inspectionDate
                 ORDER BY i.inspectionDate DESC"
            );
            $stmt->execute([$restoID]);
            $inspectionRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Violation detail (requirement titles) per inspection, for the click-through modal
            $violationStmt = $this->pdo->prepare(
                "SELECT v.inspectionID, r.title
                 FROM violations v
                 JOIN requirements r ON r.requirementCode = v.requirementCode
                 WHERE v.inspectionID = ?"
            );

            foreach ($inspectionRows as $row) {
                $violationStmt->execute([$row['inspectionID']]);
                $violationTitles = $violationStmt->fetchAll(PDO::FETCH_COLUMN);

                $inspections[] = [
                    'inspectionID' => $row['inspectionID'],
                    'date' => $row['inspectionDate'],
                    'violationCount' => (int)$row['violationCount'],
                    'grade' => $this->gradeForViolationCount((int)$row['violationCount']),
                    'violationTitles' => $violationTitles
                ];
            }
        } catch (PDOException $e) {
            error_log("Inspections Fetch Error: " . $e->getMessage());
            $inspections = [];
        }

        require_once __DIR__ . '/../view/public/restaurant-detail.php';
    }
}

$detailController = new RestaurantDetailController($pdo);
$detailController->handleRequest();
?>
