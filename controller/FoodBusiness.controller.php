<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userID'])) {
    header("Location: login");
    exit();
}
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
    
    public function addRow($licenseNo, $name, $address, $contactNo, $mapsLink, $districtId){
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO: santiize input
            //$errors = [];
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

            $this->foodBusinessModel->licenseNo = $licenseNo;
            $this->foodBusinessModel->name = $name;
            $this->foodBusinessModel->address = $address;
            $this->foodBusinessModel->contactNo = $contactNo;
            $this->foodBusinessModel->mapsLink = $mapsLink;
            $this->foodBusinessModel->imageLink = $this->imageHandler();
            $this->foodBusinessModel->status = 1;
            $this->foodBusinessModel->district = $districtId;
            $this->foodBusinessModel->insertRow($this->foodBusinessModel);

            // header("Location: index.php");
            // exit;
        // }
    }

    public function editRow($id, $licenseNo, $name, $address, $contactNo, $mapsLink, $districtId){
        $this->foodBusinessModel->foodBusinessId = $id;        
        $this->foodBusinessModel->licenseNo = $licenseNo;
        $this->foodBusinessModel->name = $name;
        $this->foodBusinessModel->address = $address;
        $this->foodBusinessModel->contactNo = $contactNo;
        $this->foodBusinessModel->mapsLink = $mapsLink;
        $this->foodBusinessModel->imageLink = $this->imageHandler();
        $this->foodBusinessModel->status = 1;
        $this->foodBusinessModel->district = $districtId;
        $this->foodBusinessModel->updateRow($this->foodBusinessModel);
    }

    public function deleteRow($id){
        if (filter_var($id, FILTER_VALIDATE_INT) !== false) {
            $this->foodBusinessModel->deleteRow($id);
            return "success";
        }
    }

    public function imageHandler(){
        if (isset($_FILES['business-establishment-image']) && $_FILES['business-establishment-image']['error'] === UPLOAD_ERR_OK) {
            $img = $_FILES['business-establishment-image'];
            $imageTmpLoc = $img['tmp_name'];
            $fileName = $img['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;
            $destPath = __DIR__ . "/../img/" . $newFileName;

            if (move_uploaded_file($imageTmpLoc, $destPath)) {
                echo $newFileName;
                return $newFileName;
            }
        }
        else{
            return "";
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
                            $_POST['business-license-no'],
                            $_POST['business-name'],
                            $_POST['business-address'],
                            $_POST['contact-number'],
                            $_POST['business-maps-url'],
                            $_POST['business-district']);
            break;
        case 'edit':
            $controller->editRow(
                            $_POST['business-id'],
                            $_POST['business-license-no'],
                            $_POST['business-name'],
                            $_POST['business-address'],
                            $_POST['contact-number'],
                            $_POST['business-maps-url'],
                            $_POST['business-district']);
            break;
    }

}

// if (isset($_GET['action']) && $_GET['action'] === 'view'){
    // $controller->showPage($pdo);
// }

?>