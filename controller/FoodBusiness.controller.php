<?php
require_once '../model/FoodBusiness.model.php';

class FoodBusinessController {
    private $foodBusinessModel;

    public function __construct($pdo) {
        $this->foodBusinessModel = new FoodBusiness($pdo);
    }

    public function getAllData($pdo){
        $this->foodBusinessModel = new FoodBusiness($pdo);
        $foodBusinesses = $this->foodBusinessModel->getAllRowInfo();
        include 'view/inspector/business-directory.php';
    }
    
    public function addRow(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $licenseNo = trim($_POST['licenseNo'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $contactNo = $_POST['contactNo'] ?? '';
            $mapsLink = trim($_POST['mapsLink'] ?? '');
            $imageLink = trim($_POST['imageLink'] ?? '');
            $status = trim($_POST['status'] ?? '');
            $districtId = trim($_POST['districtId'] ?? '');

            $errors = [];

            if (empty($licenseNo)||empty($name)||empty($address)||empty($contactNo)||empty($imageLink)||empty($districtId)){
                $errors[] = "Required fields are not complete.";
            }
            
            if (!is_numeric($licenseNo)) {
                $errors[] = "License No. must be numeric.";
            }

            // if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            //     $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            //     $fileType = $_FILES['image']['type'];

            //     if (!in_array($fileType, $allowedTypes)) {
            //         $errors[] = "Only JPG, PNG, or GIF images are allowed.";
            //     }

            //     // Move uploaded file to a safe directory
            //     $uploadDir = 'uploads/';
            //     $fileName = uniqid() . "_" . basename($_FILES['image']['name']);
            //     $targetPath = $uploadDir . $fileName;

            //     if (empty($errors)) {
            //         move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
            //     }
            // } else {
            //     $errors[] = "Image upload failed.";
            // }

            if (!empty($errors)) {
                include 'views/restaurant_form.php';
                return;
            }

            // // Save to database (store image path)
            // $this->restaurantModel->create($name, $location, $cuisine, $rating, $description, $targetPath);

            // header("Location: index.php");
            // exit;
        }
    }
}
?>