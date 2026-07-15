<?php
require_once __DIR__ . '/../config/db.php';

class ComplaintController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function handleComplaintSubmit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $restaurantId = $_POST['restaurant_id'] ?? null;
            $complainantName = trim($_POST['name'] ?? '');
            $complainantEmail = trim($_POST['email'] ?? '');
            $details = trim($_POST['details'] ?? '');

            if (empty($restaurantId) || empty($details)) {
                $error = "Restaurant and complaint details are required.";
                include __DIR__ . '/../view/complaint.php';
                return;
            }

            try {
                $stmt = $this->pdo->prepare("
                    INSERT INTO complaints (restaurant_id, complainant_name, complainant_email, details, created_at) 
                    VALUES (?, ?, ?, ?, NOW())
                ");
                $stmt->execute([$restaurantId, $complainantName, $complainantEmail, $details]);
                
                header("Location: /complaint?status=success");
                exit();
            } catch (PDOException $e) {
                $error = "Database Error: " . $e->getMessage();
                include __DIR__ . '/../view/complaint.php';
            }
        } else {
            // Render the complaint submission page (GET)
            include __DIR__ . '/../view/complaint.php';
        }
    }
}

$complaintController = new ComplaintController($pdo);
$complaintController->handleComplaintSubmit();
?>