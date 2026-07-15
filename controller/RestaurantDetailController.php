<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../model/RestaurantModel.php';

class RestaurantDetailController {
    private $restaurantModel;

    public function __construct($pdo) {
        $this->restaurantModel = new RestaurantModel($pdo);
    }

    public function handleRequest() {
        $restaurantId = $_GET['id'] ?? null;

        if (!$restaurantId) {
            header("Location: /index");
            exit();
        }

        // Handle POST submission from rating modal
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_rating'])) {
            $ratingValue = $_POST['rating_value'];
            $reviewText = trim($_POST['review'] ?? '');

            $this->restaurantModel->addRestaurantRating($restaurantId, $ratingValue, $reviewText);
            
            header("Location: /restaurant-detail?id=" . $restaurantId . "&rating_success=1");
            exit();
        }

        // Fetch details using your groupmate's existing model or by adding a custom detail fetch function
        $restaurant = $this->restaurantModel->getRestaurantDetails($restaurantId); 

        require_once __DIR__ . '/../view/restaurant-detail.php';
    }
}

$detailController = new RestaurantDetailController($pdo);
$detailController->handleRequest();
?>