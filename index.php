<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

if (isset(parse_url($_SERVER['REQUEST_URI'])['query'])){
    $query = '?' . parse_url($_SERVER['REQUEST_URI'])['query'];
}
else{
    $query = '';
}

switch ($uri){
    case '/login':
        require __DIR__ . '/view/login.php';
        break;
    case '/report':
        require __DIR__ . '/view/public/complaint.php';
        break;
    case '/adminDashboard':
        require __DIR__ . '/controller/admin/adminDashboard.controller.php';
        break;
    case '/adminUsers':
        require __DIR__ . '/controller/admin/adminUsers.controller.php';
        break;
    case '/adminAddUsers':
        require __DIR__ . '/controller/admin/adminAddUsers.controller.php';
        break;
    case '/exportData':
        require __DIR__ . '/controller/admin/exportData.controller.php';
        break;
    case '/inspectorReports':
        require __DIR__ . '/controller/inspector/inspectorReports.controller.php';
        break;
    case '/logout':
        require __DIR__ . '/controller/logoutPage.controller.php';
        break;
    case '/inspectorDashboard':
        require __DIR__ . '/controller/inspector/inspectorDashboard.controller.php';
        break;
    case '/inspectionEntry':
        require __DIR__ . '/controller/Inspection.controller.php';
        $controller = new InspectionController($pdo);
        $controller->showPage($pdo);
        break;
    case '/restaurant-detail':
        require __DIR__ . '/controller/RestaurantDetailController.php';
        break;
    case '/businessDirectory':
        require __DIR__ . '/controller/FoodBusiness.controller.php';
        $controller = new FoodBusinessController($pdo);
        $controller->showPage($pdo);
        break;
    default:
        require __DIR__ . '/view/public/homepage.php';
        break;
}

?>