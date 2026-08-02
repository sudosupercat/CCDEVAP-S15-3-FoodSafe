<?php
require __DIR__ . '/../config/db.php';

class Inspection{
    private $pdo;

    public $inspectionId;
    public $inspectionDate;
    public $score;
    public $grade;
    public $remarks;
    public $userId;
    public $restoId;
    public $violations;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function addInspection($inspection){
        try{
            $stmt = $this->pdo->prepare("INSERT INTO inspections (date, score, grade, remarks, userID, restoID)
                                        VALUES (:inspectionID, :date, :score, :grade, :remarks, :userID, :restoID)");
            $stmt->execute([
                ':date' => $inspection->inspectionDate,
                ':score' => $inspection->score,
                ':grade' => $inspection->grade,
                ':remarks' => $inspection->remarks,
                ':userID' => $inspection->userID,
                ':restoID' => $inspection->restoID
            ]);
        echo "Inspection entry added successfully!";
        }
        catch(PDOException $e) {
            echo "Error adding inspection: " . "<br>" . $e->getMessage();
            }
    }
}
?>