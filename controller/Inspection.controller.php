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

    public function addInspectionEntry($restoId, $date, $grade, $remarks, $violations = []){
        $this->inspectionModel->inspectionDate = $date;
        $this->inspectionModel->grade = $grade;
        $this->inspectionModel->remarks = $remarks;
        $this->inspectionModel->userId = $_SESSION['userID'];
        $this->inspectionModel->restoId = $restoId;
        $this->inspectionModel->remarks = $remarks;
        $this->inspectionModel->insertRow($this->inspectionModel);
        $inspectionId = $this->inspectionModel->getInspectionId($_SESSION['userID'], $restoId);
        if(!empty($violations)){
            $this->violationModel->inspectionId = $inspectionId;
            $this->violationModel->reqCode = $violations;
            $this->violationModel->insertRow($this->violationModel);
        }
    }

    public function getViolationTypes(){
        return $this->requirementModel->getRequirements();
    }

    public function verifyData($restoId, $inspectionDate, $grade, $remarks, $violations){
        header('Content-Type: application/json');
        $error = [
            "type" => "Error",
            "message" => "Unknown Error"
        ];

        if(!preg_match('/^\d+$/', $restoId) || $restoId === null || $restoId === "" ){
            $error['message'] = "Missing or invalid business ID!";
            echo json_encode($error);
            die();
        }
        else if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $inspectionDate) ||
                new DateTime($inspectionDate) < new DateTime("2000-01-01") ||
                new DateTime($inspectionDate) > new DateTime(date("Y-m-d"))){
            $error['message'] = "Missing or invalid inspection date!";
            echo json_encode($error);
            die();
        }
        else if($grade == null || $grade == "" || !in_array($grade, ["A", "B", "C", "F"])){
            $error['message'] = "Missing or invalid grade!";
            echo json_encode($error);
            die();
        }
        else if(!isset($_SESSION['userID'])){
            $error['message'] = "Invalid user ID!";
            echo json_encode($error);
            die();
        }
        else if($remarks == "" || $remarks == null){
            $error['message'] = "Missing remarks!";
            echo json_encode($error);
            die();
        }
        else if($this->inspectionModel->checkDuplicate($restoId, $_SESSION['userID'], $inspectionDate)){
            $error['message'] = "Duplicate! Only one inspection entry per restaurant per day!";
            echo json_encode($error);
            die();
        }
        else if(!empty($violations)){
            foreach ($violations as $violation){
                if(!preg_match('/^\d+$/', $violation)){
                    $error['message'] = "Invalid violation data!";
                    echo json_encode($error);
                    die();
                }
            }

            $this->addInspectionEntry($restoId, $inspectionDate, $grade, $remarks, $violations);
        }
        else{
            $this->addInspectionEntry($restoId, $inspectionDate, $grade, $remarks, $violations);
        }
    }
}

$controller = new InspectionController($pdo);

// Router

if (isset($_POST['food-business-id'])){
    $controller->verifyData(
        $_POST['food-business-id'] ?? "",
        $_POST['inspection-date'] ?? "",
        $_POST['grade'] ?? "",
        $_POST['remarks'] ?? "",
        $_POST['violations'] ?? []);
}

?>