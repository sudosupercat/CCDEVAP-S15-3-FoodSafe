<?php
require __DIR__ . '/view/functions.php';
$uri = $_SERVER['REQUEST_URI'];

switch ($uri){
    case '/login':
        require 'view/login.php';
        break;
    case '/report':
        require 'view/public/complaint.php';
        break;
    case '/adminHomepage':
        require 'view/admin/homepage.php';
        break;
    case '/inspectorHomepage':
        require 'controller/inspector/inspectorHomepage.controller.php';
        break;
    case '/business-directory':
        require 'controller/FoodBusiness.Controller.php';
        $controller = new FoodBusinessController($pdo);
        $controller->showPage($pdo);
        break;
    default:
        require 'view/public/homepage.php';
        break;
}
?>