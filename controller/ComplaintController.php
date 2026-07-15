<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../model/FoodBusiness.php';
require_once __DIR__ . '/../model/ComplaintModel.php';

class ComplaintController {
    private $foodBusinessModel;
    private $complaintModel;

    public function __construct($pdo) {
        $this->foodBusinessModel = new FoodBusiness($pdo);
        $this->complaintModel = new ComplaintModel($pdo);
    }

    public function getRestaurants() {
        return $this->foodBusinessModel->getAllIdName();
    }

    public function submitComplaint($restoID, $complainantName, $complainantEmail, $details) {
        return $this->complaintModel->createComplaint($restoID, $complainantName, $complainantEmail, $details);
    }
}
?>
