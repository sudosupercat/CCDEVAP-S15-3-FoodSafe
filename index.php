<?php
require __DIR__ . '/view/functions.php';
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

if (isset(parse_url($_SERVER['REQUEST_URI'])['query'])){
    $query = '?' . parse_url($_SERVER['REQUEST_URI'])['query'];
}
else{
    $query = '';
}

switch ($uri){
    case '/login':
        require 'view/login.php';
        break;
    case '/report':
        require 'view/public/complaint.php';
        break;
    case '/adminDashboard':
        require 'controller/admin/adminDashboard.controller.php';
        break;
    case '/adminUsers':
        require 'controller/admin/adminUsers.controller.php';
        break;
    case '/adminAddUsers':
        require 'controller/admin/adminAddUsers.controller.php';
        break;
    case '/exportData':
        require 'controller/admin/exportData.controller.php';
        break;
    case '/inspectorReports':
        require 'controller/inspector/inspectorReports.controller.php';
        break;
    case '/logout':
        require 'controller/logoutPage.controller.php';
        break;
    case '/inspectorDashboard':
        require 'controller/inspector/inspectorDashboard.controller.php';
        break;
    case '/inspectionEntry':
        require 'controller/Inspection.controller.php';
        $controller = new InspectionController($pdo);
        $controller->showPage($pdo);
        break;
    case '/restaurant-detail':
        require 'controller/RestaurantDetailController.php';
        break;
    case '/businessDirectory':
        require 'controller/FoodBusiness.Controller.php';
        $controller = new FoodBusinessController($pdo);
        $controller->showPage($pdo);
        break;
    default:
        require 'view/public/homepage.php';
        break;
}

?>