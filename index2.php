<?php
require 'functions.php';
$uri = $_SERVER['REQUEST_URI'];

switch ($uri){
    case '/':
        require 'view/public/index.php';
        break;
    case '/business-directory':
        require 'controller/FoodBusiness.Controller.php';
        $controller = new FoodBusinessController($pdo);
        $controller->showPage($pdo);
        break;
}
?>