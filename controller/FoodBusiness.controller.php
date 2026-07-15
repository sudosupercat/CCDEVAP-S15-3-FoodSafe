<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// if (!isset($_SESSION['userID'])) {
//     header("Location: /CCDEVAP-S15-3-FoodSafe/controller/loginPage.controller.php");
//     exit();
// }
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../model/FoodBusiness.model.php';

class FoodBusinessController {
    private $foodBusinessModel;

    public function __construct($pdo) {
        $this->foodBusinessModel = new FoodBusiness($pdo);
    }

    public function showPage($pdo){
        $this->foodBusinessModel = new FoodBusiness($pdo);
        $foodBusinesses = $this->foodBusinessModel->getAllRowInfo();
        $districts = $this->foodBusinessModel->getDistricts();
        include __DIR__ . '/../view/inspector/business-directory.php';
    }
    
    public function addRow($licenseNo, $name, $address, $contactNo, $mapsLink, $imageLink, $districtId){
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO: santiize input
            $errors = [];
            // if (empty($licenseNo)||empty($name)||empty($address)||empty($contactNo)||empty($imageLink)||empty($districtId)){
            //     $errors[] = "Required fields are not complete.";
            // }
            
            // if (!is_numeric($licenseNo)) {
            //     $errors[] = "License No. must be numeric.";
            // }

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

            // if (!empty($errors)) {
            //     include 'views/restaurant_form.php';
            //     return;
            // }

            // // Save to database (store image path)
            $this->foodBusinessModel->licenseNo = $licenseNo;
            $this->foodBusinessModel->name = $name;
            $this->foodBusinessModel->address = $licenseNo;
            $this->foodBusinessModel->contactNo = $licenseNo;
            $this->foodBusinessModel->mapsLink = $licenseNo;
            $this->foodBusinessModel->imageLink = $licenseNo;
            $this->foodBusinessModel->status = 1;
            $this->foodBusinessModel->district = $districtId;
            $this->foodBusinessModel->insertRow($this->foodBusinessModel);

            // header("Location: index.php");
            // exit;
        // }
    }

    public function deleteRow($id){
        if (filter_var($id, FILTER_VALIDATE_INT) !== false) {
            $this->foodBusinessModel->deleteRow($id);
            return "success";
        }
    }
}

$controller = new FoodBusinessController($pdo);

// Router
if (isset($_POST['action'])){
    $action = $_POST['action'];

    switch ($action){
        case 'delete':
            $controller->deleteRow($_POST['foodBusinessId']);
            break;
        case 'add':
            $controller->addRow(
                            $_POST['licenseNo'],
                            $_POST['name'],
                            $_POST['address'],
                            $_POST['contactNo'],
                            $_POST['mapsLink'],
                            $_POST['imageLink'],
                            $_POST['districtId']);
            break;
    }

}

// if (isset($_GET['action']) && $_GET['action'] === 'view'){
    // $controller->showPage($pdo);
// }

?>