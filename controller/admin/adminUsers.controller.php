<?php

if (!isset($_SESSION['userID'])) {
    header("Location: /login");
    exit();
}

require __DIR__ . '/../../model/admin.model.php';

// USER MANAGEMENT -- EDIT USER
$districts = getDistricts($pdo);
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $selectedUser = getUserByID($pdo, $_GET['id']);
}

if(isset($_POST['action']) && $_POST['action'] === 'edit') {
    editUser($pdo, $_POST['userID'], $_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['districtID']);

    header('Location: ?toast=edit');
    exit();
}

// USER MANAGEMENT -- UPDATE STATUS
if (isset($_POST['action']) && $_POST['action'] === 'update' && isset($_POST['id'])) {

    updateStatus($pdo, $_POST['id']);

    header('Location: ?toast=update');
    exit();
}

// USER MANAGEMENT -- DELETE USER
if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {

    deleteUser($pdo, $_POST['id']);

    header('Location: ?toast=delete');
    exit();
}

// USER MANAGEMENT -- READ
$users = getUsers($pdo);

require __DIR__ . '/../../view/admin/user-management.php';

?>