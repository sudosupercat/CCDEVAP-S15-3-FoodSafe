<?php
require __DIR__ . '/../config/db.php';

class Requirement{
    private $pdo;

    public $reqCode;
    public $reqTitle;
    public $reqDesc;
    public $reqCateg;
    public $reqSeverityLvl;
    public $reqStdFine;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function mapRowToObj($row){
        $requirement = new self($this->pdo);
        $requirement->reqCode = $row['requirementCode'];
        $requirement->reqTitle = $row['title'];
        $requirement->reqDesc = $row['description'];
        $requirement->reqCateg = $row['category'];
        $requirement->reqSeverityLvl = $row['severityLvl'];
        $requirement->reqStdFine = $row['standardFine'];

        return $requirement;
    }

    public function getRequirements(){
        $stmt = $this->pdo->query("SELECT * FROM requirements");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $requirementsArr = [];
        foreach ($rows as $row){
            $requirementsArr[] = $this->mapRowToObj($row);
        }

        return $requirementsArr;
    }
}
?>