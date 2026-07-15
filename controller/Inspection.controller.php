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

class InspectionController{
    private $inspectionModel;

    public function __construct($pdo) {
        $this->inspectionModel = new Inspection($pdo);
    }

    public function showPage($pdo){
        $this->inspectionModel = new Inspection($pdo);
        include __DIR__ . '/../view/inspector/inspection-entry.php';
    }

    public function addInspection(){

    }

    public function getViolationTypes(){

    }
}

?>