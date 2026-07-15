<?php
require_once __DIR__ . '/../config/db.php';

class ComplaintModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Files a public complaint against a restaurant
     */
    public function createComplaint($restoID, $complainantName, $complainantEmail, $details) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO complaints (restoID, complainant_name, complainant_email, details, created_at) 
                                        VALUES (?, ?, ?, ?, NOW())");
            return $stmt->execute([$restoID, $complainantName, $complainantEmail, $details]);
        } catch (PDOException $e) {
            error_log("Create Complaint Error: " . $e->getMessage());
            return false;
        }
    }
}
?>
