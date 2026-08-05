<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../model/authFoodBusiness.model.php';
require_once __DIR__ . '/../model/publicComplaint.model.php';

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

    public function getRequirementTypes() {
        return $this->complaintModel->getRequirementTypes();
    }

    public function submitComplaint($restoID, $firstName, $lastName, $email, $contactNo, $requirementCode, $description) {
        return $this->complaintModel->createComplaint($restoID, $firstName, $lastName, $email, $contactNo, $requirementCode, $description);
    }
}
?>
