<?php
require_once __DIR__ . '/../config/db.php';

class ComplaintModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getRequirementTypes() {
        try {
            $stmt = $this->pdo->query("SELECT requirementCode, title FROM requirements ORDER BY title ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Requirement Types Error: " . $e->getMessage());
            return [];
        }
    }

    public function createComplaint($restoID, $firstName, $lastName, $email, $contactNo, $requirementCode, $description) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO reports (email, firstName, lastName, contactNo, description, status, restoID, requirementCode)
                                        VALUES (?, ?, ?, ?, ?, 'Pending', ?, ?)");
            return $stmt->execute([$email, $firstName, $lastName, $contactNo, $description, $restoID, $requirementCode]);
        } catch (PDOException $e) {
            error_log("Create Complaint Error: " . $e->getMessage());
            return false;
        }
    }
}
?>
