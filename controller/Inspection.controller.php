<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userID'])) {
    header("Location: login");
    exit();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../model/Inspection.model.php';
require_once __DIR__ . '/../model/FoodBusiness.model.php';

class InspectionController{
    private $inspectionModel;
    private $foodBusinessModel;

    public function __construct($pdo) {
        $this->inspectionModel = new Inspection($pdo);
    }

    public function showPage($pdo){
        $this->inspectionModel = new Inspection($pdo);
        $this->foodBusinessModel = new FoodBusiness($pdo);
        $businessIdNames = $this->foodBusinessModel->getAllIdName();
        include __DIR__ . '/../view/inspector/inspection-entry.php';
    }

    public function addInspection($id, $date, $score, $grade, $remarks, $userId, $restoId, $violations){
        $this->inspectionModel->inspectionId;
        $this->inspectionModel->inspectionDate;
        $this->inspectionModel->score;
        $this->inspectionModel->grade;
        $this->inspectionModel->remarks;
        $this->inspectionModel->userId;
        $this->inspectionModel->restoId;
        $this->inspectionModel->violations;
        $this->inspectionModel->addInspection($this->inspectionModel);
    }

    public function getViolationTypes(){

    }
}

$controller = new InspectionController($pdo);

// Router

if (isset($_POST['food-business'])){
    $controller->addInspection(
        $_POST['food-business'],
        $_POST['inspection-date'],
        $_POST['autoRatingSwitch'],
        $_POST['score'],
        $_POST['grade'],
        $_POST['business-district']);
}

?>