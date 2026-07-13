<?php
require 'db.php';

class FoodBusiness {
    private $pdo;

    public $foodBusinessId;
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
	
	public function insertRow($foodBusiness){
        try {
            $stmt = $this->pdo->prepare("INSERT INTO restaurants (licenseNo, name, address, contactNo, maps, image, status, districtID)
                                        VALUES (:licenseNo, :name, :address, :contactNo, :maps, :image, :status, :districtID)");
            $stmt->execute([
                ':licenseNo' => $foodBusiness->licenseNo,
                ':name' => $foodBusiness->name,
                ':address' => $foodBusiness->address,
                ':contactNo' => $foodBusiness->contactNo,
                ':maps' => $foodBusiness->maps,
                ':image' => $foodBusiness->image,
                ':status' => $foodBusiness->status,
                ':districtID' => $foodBusiness->districtID
                ]);
            echo "Record updated successfully";
            }
        catch(PDOException $e) {
            echo "Error updating record: " .$stmt . "<br>" . $e->getMessage();
            }
	}
	
	// For now, delete will set the delete flag of the row to 1
	public function deleteRow($rowId){
        try {
            $stmt = $this->pdo->prepare("UPDATE restaurants SET status = 1 WHERE restoID = :rowId");
            $stmt->execute(['rowId' => $rowId]);
            echo "Record updated successfully";
            }
        catch(PDOException $e) {
            echo "Error updating record: " .$stmt . "<br>" . $e->getMessage();
            }
    }
                
}
?>