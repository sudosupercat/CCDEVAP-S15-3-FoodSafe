<?php
require_once '../../controller/RestaurantDetailController.php';

$dbConnection = isset($pdo) ? $pdo : (isset($conn) ? $conn : $db);
$controller = new RestaurantDetailController($dbConnection);

$restoID = isset($_GET['restoID']) ? intval($_GET['restoID']) : (isset($_GET['id']) ? intval($_GET['id']) : 1); 
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    if ($rating >= 1 && $rating <= 5 && !empty($comment)) {
        if ($controller->addReview($restoID, $rating, $comment)) {
            $message = "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <i class='bi bi-check-circle-fill me-2'></i>Thank you! Your feedback has been published.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        } else {
            $message = "<div class='alert alert-danger'>Failed to process your review. Please try again.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Please ensure all form inputs are completed validly.</div>";
    }
}

$restaurant = $controller->getRestaurant($restoID);
if (!$restaurant) {
    die("<div class='container my-5'><div class='alert alert-danger'>Restaurant record not found in system directory.</div></div>");
}
$reviews = $controller->getReviews($restoID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodSafe - <?= htmlspecialchars($restaurant['name']) ?></title>
    <link rel="icon" type="image/png" href="../../src/images/logo-tab.png">
    <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../styles/css/global.css">
    <script src="../../styles/js/jquery-3.7.1.min.js"></script>
    <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <script src="../../styles/js/nav-bar.js"></script>
</head>
<body>
    <div id="navBar"><?php include __DIR__ . '/../navbar.php';?></div>

    <div class="container my-5">
        <?= $message ?>
        
        <div class="card border-0 p-4 shadow-sm mb-4">
            <h2><?= htmlspecialchars($restaurant['name']) ?></h2>
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-warning text-dark fs-5 me-2">
                    <i class="bi bi-star-fill"></i> <?= isset($restaurant['avg_rating']) ? number_format($restaurant['avg_rating'], 1) : '0.0' ?>
                </span>
                <span class="text-muted">Total Ratings: <?= count($reviews) ?></span>
            </div>
            
            <button type="button" class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#ratingModal">
                <i class="bi bi-pencil-square me-2"></i> Submit a Review
            </button>
        </div>

        <h4 class="mb-3">Reviews Log</h4>
        <?php if(empty($reviews)): ?>
            <div class="alert alert-secondary">No customer reports recorded yet. Be the first to add details!</div>
        <?php else: ?>
            <?php foreach($reviews as $review): ?>
                <div class="card p-3 mb-2 border-0 shadow-sm">
                    <div class="d-flex justify-content-between">
                        <div>
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star-fill <?= $i <= $review['rating'] ? 'text-warning' : 'text-secondary' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <small class="text-muted"><?= date('M d, Y g:i A', strtotime($review['created_at'])) ?></small>
                    </div>
                    <p class="mt-2 mb-0"><?= htmlspecialchars($review['comment']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="" method="POST" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ratingModalLabel">Share Your Assessment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <label for="rating" class="form-label">Score (1-5 Scale)</label>
                <select name="rating" id="rating" class="form-select" required>
                    <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
                    <option value="4">⭐⭐⭐⭐ (Satisfactory)</option>
                    <option value="3">⭐⭐⭐ (Average)</option>
                    <option value="2">⭐⭐ (Needs Improvement)</option>
                    <option value="1">⭐ (Unsatisfactory)</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Feedback Comments</label>
                <textarea name="comment" id="comment" rows="4" class="form-control" placeholder="Provide notes regarding food safety, hygiene, structures..." required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="submit_review" class="btn btn-success">Upload Review</button>
          </div>
        </form>
      </div>
    </div>
</body>
</html>
