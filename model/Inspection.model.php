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

    }
}

?>