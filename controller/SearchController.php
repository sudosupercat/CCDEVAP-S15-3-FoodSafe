<?php
require_once __DIR__ . '/../config/db.php'; 
require_once __DIR__ . '/../model/RestaurantModel.php'; 

class SearchController {
    public function getData() {
        global $pdo;

        $searchQuery = $_GET['query'] ?? '';
        $sortOrder = $_GET['sort'] ?? 'az';

        $model = new RestaurantModel($pdo);
        return $model->getSearchResults($searchQuery, $sortOrder);
    }
}
?>