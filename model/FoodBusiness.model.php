<?php
class FoodBusiness {
    private $pdo;

    public $restaurantId;
    public $licenseNo;
    public $name;
    public $address;
    public $contactNo;
    public $mapsLink;
    public $imageLink;
    public $status;
    public $districtId;
    
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function mapRowToObj($row){
        $foodBusiness = new self($this->pdo);
        $foodBusiness->licenseNo = $row['restoID'];
        $foodBusiness->name = $row['name'];
        $foodBusiness->address = $row['address'];
        $foodBusiness->contactNo = $row['contactNo'];
        $foodBusiness->mapsLink = $row['maps'];
        $foodBusiness->imageLink = $row['image'];
        $foodBusiness->status = $row['status'];
        $foodBusiness->districtId = $row['districtID'];
        return $foodBusiness;
    }

    public function getSingleRowInfo($id){
        $stmt = $this->pdo->prepare("SELECT * FROM restaurants WHERE restoID = :id");
        $stmt->execute(['restoID' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToObj($row) : null;
    }

    public function getAllRowInfo() {
        $stmt = $this->pdo->query("SELECT * FROM restaurants");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $restaurants = [];
        foreach ($rows as $row) {
            $restaurants[] = $this->mapRowToObj($row);
        }
        
        return $restaurants;
    }
    
}
?>