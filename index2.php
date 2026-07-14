<?php
require 'config/db.php';


$action = $_GET['action'] ?? 'index'; // default to "index"

switch ($action) {
    case 'business-directory':
        require 'controller/FoodBusiness.Controller.php';
        $controller = new FoodBusinessController($pdo);
        $controller->showPage($pdo);
        break;
        // case 'index':
        //     $controller->index($pdo); // runs when page loads
        // break;
    // case 'show':
    //     $id = $_GET['id'] ?? null;
    //     if ($id) {
    //         $controller->show($pdo, $id);
    //     } else {
    //         echo "No ID provided.";
    //     }
    //     break;
    default:
        echo "Unknown action.";
}
