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
require_once __DIR__ . '/../model/Requirement.model.php';

class InspectionController{
    private $inspectionModel;
    private $foodBusinessModel;
    private $requirementModel;

    public function __construct($pdo) {
        $this->inspectionModel = new Inspection($pdo);
    }

    public function showPage($pdo){
        $this->inspectionModel = new Inspection($pdo);
        $this->foodBusinessModel = new FoodBusiness($pdo);
        $this->requirementModel = new Requirement($pdo);
        $requirements = $this->requirementModel->getRequirements();
        $businessIdNames = $this->foodBusinessModel->getAllIdName();
        include __DIR__ . '/../view/inspector/inspection-entry.php';
    }

    public function addInspection($date, $score, $grade, $remarks, $userId, $restoId, $violations){
        $this->inspectionModel->inspectionDate = $date;
        $this->inspectionModel->score = $score;
        $this->inspectionModel->grade = $grade;
        $this->inspectionModel->remarks = $remarks;
        $this->inspectionModel->userId = $userId;
        $this->inspectionModel->restoId = $restoId;
        $this->inspectionModel->violations = $violations;
        $this->inspectionModel->addInspection($this->inspectionModel);
    }

    public function getViolationTypes(){
        return $this->requirementModel->getRequirements();
    }
}

$controller = new InspectionController($pdo);

// Router

if (isset($_POST['food-business-id'])){
        $violations = [];
        $remarks = [];

        foreach ($_POST as $key => $value){
            if (preg_match('/^violation-(\d+)$/', $key, $matches)) {
                $index = (int)$matches[1];
                $violations[$index]['violation'] = $value;
            }

            if (preg_match('/^remarks-(\d+)$/', $key, $matches)) {
                $index = (int)$matches[1];
                $remarks[$index]['remarks'] = $value;
            }
        }
    $controller->addInspection(
        $_POST['inspection-date'],
        $_POST['score'],
        $_POST['grade'],
        $remarks,
        $_POST['user-id'],
        $_POST['food-business-id'],
        $violations);
}

?>