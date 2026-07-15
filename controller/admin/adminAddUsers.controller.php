<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Admin') {
    header('Location: /login');
    exit();
}

$dbConnection = isset($pdo) ? $pdo : (isset($conn) ? $conn : $db);
$success_msg = "";
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_user'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $error_msg = "Please fill in all the required input fields.";
    } elseif ($password !== $confirm_password) {
        $error_msg = "Form input mismatch: Passwords do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Form entry error: Please input a valid email address.";
    } else {
        try {
            $checkStmt = $dbConnection->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $checkStmt->execute([$username, $email]);
            
            if ($checkStmt->rowCount() > 0) {
                $error_msg = "Account configuration conflict: Username or Email is already registered.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                
                $insertStmt = $dbConnection->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
                $insertStmt->execute([$username, $email, $hashed_password, $role]);
                
                $success_msg = "User configuration profile for <strong>" . htmlspecialchars($username) . "</strong> has been compiled successfully!";
            }
        } catch (PDOException $e) {
            $error_msg = "System Processing Failure: " . $e->getMessage();
        }
    }
}

require_once __DIR__ . '/../../view/admin/add-user.php';
?>
