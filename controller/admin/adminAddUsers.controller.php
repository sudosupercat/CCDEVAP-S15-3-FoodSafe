<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Admin') {
    header('Location: /login');
    exit();
}

require __DIR__ . '/../../model/admin.model.php';

$success_msg = "";
$error_msg = "";

// Fetch districts to populate the dropdown in add-user.php
$districts = getDistricts($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_user'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? '';
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $districtID = !empty($_POST['districtID']) ? $_POST['districtID'] : null;

    if (empty($email) || empty($password) || empty($role) || empty($firstName) || empty($lastName)) {
        $error_msg = "Please fill in all the required input fields.";
    } elseif ($password !== $confirm_password) {
        $error_msg = "Form input mismatch: Passwords do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Form entry error: Please input a valid email address.";
    } elseif ($role === 'Inspector' && empty($districtID)) {
        $error_msg = "Please assign a district for the inspector.";
    } elseif (checkEmailExists($pdo, $email)) {
        $error_msg = "Account configuration conflict: Email is already registered.";
    } else {
        $registered = registerNewUser($pdo, $email, $password, $role, $firstName, $lastName, $districtID);

        if ($registered) {
            $success_msg = "User profile for <strong>" . htmlspecialchars($firstName . " " . $lastName) . "</strong> has been created successfully!";
        } else {
            $error_msg = "System error: could not create the user. Please try again.";
        }
    }
}

require_once __DIR__ . '/../../view/admin/add-user.php';
?>
