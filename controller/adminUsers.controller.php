<?php
require '../model/admin.model.php';

// USER MANAGEMENT -- EDIT USER
$districts = getDistricts($pdo);
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    editUser($pdo, $_GET['id']);
}

// USER MANAGEMENT -- UPDATE STATUS
if (isset($_POST['action']) && $_POST['action'] === 'update' && isset($_POST['id'])) {

    updateStatus($pdo, $_POST['id']);

    header('Location: /CCDEVAP-S15-3-FoodSafe/controller/adminUsers.controller.php');
    exit();
}

// USER MANAGEMENT -- DELETE USER
if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {

    deleteUser($pdo, $_POST['id']);

    header('Location: /CCDEVAP-S15-3-FoodSafe/controller/adminUsers.controller.php');
    exit();
}

// USER MANAGEMENT -- READ
$users = getUsers($pdo);

require '../users/admin/user-management.php';

?>