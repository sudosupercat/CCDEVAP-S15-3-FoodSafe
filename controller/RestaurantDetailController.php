<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../model/FoodBusiness.php';

class RestaurantDetailController {
    private $pdo;
    private $foodBusinessModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->foodBusinessModel = new FoodBusiness($pdo);
    }

    public function handleRequest() {
        $restoID = isset($_GET['restoID']) ? intval($_GET['restoID']) : (isset($_GET['id']) ? intval($_GET['id']) : 1);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
            $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
            $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

            if ($rating >= 1 && $rating <= 5 && !empty($comment)) {
                try {
                    $stmt = $this->pdo->prepare("INSERT INTO reviews (restoID, rating, comment, created_at) VALUES (?, ?, ?, NOW())");
                    $stmt->execute([$restoID, $rating, $comment]);

                    $avgStmt = $this->pdo->prepare("SELECT AVG(rating) as avg_rating FROM reviews WHERE restoID = ?");
                    $avgStmt->execute([$restoID]);
                    $avgRow = $avgStmt->fetch(PDO::FETCH_ASSOC);
                    $avgRating = $avgRow['avg_rating'] ?? 0.0;

                    $updateStmt = $this->pdo->prepare("UPDATE restaurants SET avg_rating = ? WHERE restoID = ?");
                    $updateStmt->execute([$avgRating, $restoID]);

                    header("Location: restaurant-detail.php?id=" . $restoID);
                    exit();
                } catch (PDOException $e) {
                    error_log("Review Submit Error: " . $e->getMessage());
                }
            }
        }

        $restaurantObj = $this->foodBusinessModel->getSingleRowInfo($restoID);
        if (!$restaurantObj) {
            header("Location: /index");
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
            'district' => $restaurantObj->district,
            'avg_rating' => $restaurantObj->avg_rating
        ];

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM reviews WHERE restoID = ? ORDER BY created_at DESC");
            $stmt->execute([$restoID]);
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Reviews Fetch Error: " . $e->getMessage());
            $reviews = [];
        }

        require_once __DIR__ . '/../view/public/restaurant-detail.php';
    }
}

$detailController = new RestaurantDetailController($pdo);
$detailController->handleRequest();
?>
