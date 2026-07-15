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
    case '/adminDashboard':
        require 'controller/admin/adminDashboard.controller.php';
        break;
    case '/adminUsers':
        require 'controller/admin/adminUsers.controller.php';
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
        require 'view/inspector/inspection-entry.php';
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