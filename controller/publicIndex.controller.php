<?php
require 'config/db.php'; 
require 'model/restaurant.model.php'; 

class IndexController {
    public function getData() {
        global $pdo;

        $model = new RestaurantModel($pdo);
        return $model->getHomepageData();
    }
}
?>