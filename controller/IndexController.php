<?php
require 'config/db.php'; 
require 'model/RestaurantModel.php'; 

class IndexController {
    public function getData() {
        global $pdo;

        $model = new RestaurantModel($pdo);
        return $model->getHomepageData();
    }
}
?>