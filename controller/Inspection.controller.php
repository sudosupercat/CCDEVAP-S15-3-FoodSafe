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
require_once __DIR__ . '/../model/Violation.model.php';

class InspectionController{
    private $inspectionModel;
    private $foodBusinessModel;
    private $requirementModel;
    private $violationModel;

    public function __construct($pdo) {
        $this->inspectionModel = new Inspection($pdo);
        $this->violationModel = new Violation($pdo);
    }

    public function showPage($pdo){
        $this->inspectionModel = new Inspection($pdo);
        $this->foodBusinessModel = new FoodBusiness($pdo);
        $this->requirementModel = new Requirement($pdo);
        $requirements = $this->requirementModel->getRequirements();
        $businessIdNames = $this->foodBusinessModel->getAllIdName();
        include __DIR__ . '/../view/inspector/inspection-entry.php';
    }

    public function addInspectionEntry($date, $grade, $userId, $restoId, $remarks, $violations = []){
        $this->inspectionModel->inspectionDate = $date;
        $this->inspectionModel->grade = $grade;
        $this->inspectionModel->remarks = $remarks;
        $this->inspectionModel->userId = $userId;
        $this->inspectionModel->restoId = $restoId;
        $this->inspectionModel->remarks = $remarks;
        $this->inspectionModel->insertRow($this->inspectionModel);
        $inspectionId = $this->inspectionModel->getInspectionId($userId, $restoId);
        if(!empty($violations)){
            $this->violationModel->inspectionId = $inspectionId;
            $this->violationModel->reqCode = $violations;
            $this->violationModel->insertRow($this->violationModel);
        }
    }

    public function getViolationTypes(){
        return $this->requirementModel->getRequirements();
    }
}

$controller = new InspectionController($pdo);

// Router

if (isset($_POST['food-business-id'])){
    $controller->addInspectionEntry(
        $_POST['inspection-date'],
        $_POST['grade'],
        $_POST['user-id'],
        $_POST['food-business-id'],
        $_POST['remarks'],
        $_POST['violations'] ?? []);
}

?>