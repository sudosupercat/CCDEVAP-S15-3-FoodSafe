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

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function insertRow($inspection){
        header('Content-Type: application/json');    
        $error = [
            "type" => "Error",
            "message" => "Unknown Error"
        ];
        try{
            $stmt = $this->pdo->prepare("INSERT INTO inspections (inspectionDate, grade, remarks, userID, restoID)
                                        VALUES (:inspectionDate, :grade, :remarks, :userID, :restoID)");
            $stmt->execute([
                ':inspectionDate' => $inspection->inspectionDate,
                ':grade' => $inspection->grade,
                ':remarks' => $inspection->remarks,
                ':userID' => $inspection->userId,
                ':restoID' => $inspection->restoId
            ]);
            $error['type'] = "Success";
            $error['message'] = "Inspection entry added successfully!";
            echo json_encode($error);
        }
        catch(PDOException $e) {
            $error['message'] = "Error adding inspection: " . "<br>" . $e->getMessage();
            echo json_encode($error);
        }
    }

    public function getInspectionId($userId, $restoId){
        $stmt = $this->pdo->prepare("SELECT inspectionID FROM inspections
                                    WHERE userID = :userId AND restoID = :restoId
                                    ORDER BY inspectionID DESC
                                    LIMIT 1");
        $stmt->execute([
            ':userId' => $userId,
            ':restoId' => $restoId
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['inspectionID'];
    }

    public function checkDuplicate($restoId, $userId, $inspectionDate){
        $stmt = $this->pdo->prepare("SELECT 1 FROM inspections
                                    WHERE userID = :userId
                                    AND restoID = :restoId AND inspectionDate = :inspectionDate
                                    LIMIT 1");
        $stmt->execute([
            ':userId' => $userId,
            ':restoId' => $restoId,
            ':inspectionDate' => $inspectionDate
        ]);
        $row = $stmt->fetch();

        return $row;
    }
}
?>