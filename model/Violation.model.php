<?php
require __DIR__ . '/../config/db.php';

class Violation{
    private $pdo;

    public $violationId;
    public $inspectionId;
    public $reqCode;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function insertRow($violationModel){
        $inspectionId = $violationModel->inspectionId;
        $reqCodeArr = $violationModel->reqCode;
        
        foreach($reqCodeArr as $reqCode){
            try {
            $stmt = $this->pdo->prepare("INSERT INTO violations (inspectionID, requirementCode)
                                        VALUES (:inspectionId, :requirementCode)");
            $stmt->execute([
                ':inspectionId' => $inspectionId,
                ':requirementCode' => $reqCode
                ]);
            }
            catch(PDOException $e) {
                error_log($e->getMessage());
            }
        }
    }
}
?>