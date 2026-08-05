<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

if (isset(parse_url($_SERVER['REQUEST_URI'])['query'])){
    $query = '?' . parse_url($_SERVER['REQUEST_URI'])['query'];
}
else{
    $query = '';
}

switch ($uri){
    case '/':
        require __DIR__ . '/view/public/homepage.php';
        break;
    case '/search':
        require __DIR__ . '/view/public/search.php';
        break;
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
    case '/inspectorReports':
        require __DIR__ . '/controller/inspector/authReports.controller.php';
        break;
    case '/logout':
        require __DIR__ . '/controller/userLogout.controller.php';
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
        require __DIR__ . '/controller/authRestaurantDetail.controller.php';
        break;
    case '/businessDirectory':
        require __DIR__ . '/controller/authFoodBusiness.controller.php';
        $controller = new FoodBusinessController($pdo);
        $controller->showPage($pdo);
        break;
    default:
        http_response_code(404);

        // Provide visual feedback for the user
        echo "<h1>404 Not Found</h1>";
        echo "The page you requested does not exist.";

        // Stop script execution
        break;
}

?>
