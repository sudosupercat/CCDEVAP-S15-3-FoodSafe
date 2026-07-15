<?php
require 'functions.php';
$uri = $_SERVER['REQUEST_URI'];

switch ($uri){
    case '/':
        $controller = new IndexController();
        $homepageData = $controller->getData();
        break;
    case '/business-directory':
        require 'controller/FoodBusiness.Controller.php';
        $controller = new FoodBusinessController($pdo);
        $controller->showPage($pdo);
        break;
}
?>