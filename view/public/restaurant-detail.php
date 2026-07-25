<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodSafe - <?= htmlspecialchars($restaurant['name']) ?></title>
    <link rel="icon" type="image/png" href="../../src/images/logo-tab.png">
    <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../styles/css/global.css">
    <link rel="stylesheet" href="../../styles/css/public/resto-style.css">
    <script src="../../styles/js/jquery-3.7.1.min.js"></script>
    <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <script src="../../styles/js/nav-bar.js"></script>
</head>
<body class="resto-rating-page">
    <?php include __DIR__ . '/../navbar.php';?>

    <?php $inspections = $inspections ?? []; ?>

    <div class="container mt-3" style="max-width: 1300px;">
        <?php if (isset($_GET['success'])): ?>
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <i class='bi bi-check-circle-fill me-2'></i>Thank you! Your feedback has been published.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>
    </div>

    <div class="hero-section">
        <div class="hero-left-img">
            <img src="/img/<?= htmlspecialchars($restaurant['image']) ?>" alt="<?= htmlspecialchars($restaurant['name']) ?>" onerror="this.onerror=null; this.src='data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22450%22%3E%3Crect width=%22100%25%22 height=%22100%25%22 fill=%22%23ddd%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2224%22 fill=%22%23888%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image Available%3C/text%3E%3C/svg%3E';">
        </div>
        <div class="hero-right-content">
            <div class="brand-panel">
                <div class="high-standard-tag">
                    <?php
                        $tag = 'Standard';
                        if ($restaurant['avg_rating'] >= 4.5) $tag = 'High Standard';
                        elseif ($restaurant['avg_rating'] >= 3.5) $tag = 'Good Standard';
                        elseif ($restaurant['avg_rating'] > 0) $tag = 'Needs Improvement';
                    ?>
                    <?= htmlspecialchars($tag) ?>
                </div>
                <h1 class="resto-title"><?= htmlspecialchars($restaurant['name']) ?></h1>
                <?php
                    $mapsUrl = !empty($restaurant['maps'])
                        ? $restaurant['maps']
                        : 'https://www.google.com/maps/search/?api=1&query=' . urlencode($restaurant['name'] . ', ' . $restaurant['address']);
                ?>
                <a href="<?= htmlspecialchars($mapsUrl) ?>" target="_blank" rel="noopener" class="gmaps-link">
                    <i class="bi bi-geo-alt-fill me-1"></i><?= htmlspecialchars($restaurant['address']) ?>
                </a>
            </div>
            <div class="hero-right-bottom-rating">
                <div class="rating-title">Inspection Rating</div>
                <div class="rating-circle"><?= number_format($restaurant['avg_rating'], 1) ?></div>
                <button type="button" class="btn btn-link mt-3" id="openReviewModalBtn" style="color: var(--bg-purple); text-decoration: underline;">
                    <i class="bi bi-pencil-square me-1"></i> Submit a Review (<?= count($reviews) ?> total)
                </button>
            </div>
        </div>
    </div>

    <div class="inspections-bar">
        <h2>Inspections</h2>
    </div>

    <div class="inspections-container">
        <?php if (empty($inspections)): ?>
            <p class="text-white text-center">No inspections recorded for this restaurant yet.</p>
        <?php else: ?>
            <div class="inspections-grid">
                <?php foreach ($inspections as $inspection): ?>
                    <div class="inspection-block" onclick="openInspectionModal(<?= (int)$inspection['inspectionID'] ?>)">
                        <div class="inspect-date"><?= date('F j, Y', strtotime($inspection['date'])) ?></div>
                        <div class="inspect-meta">
                            <span>Number of violations: <span class="stat-num"><?= $inspection['violationCount'] ?></span></span>
                            <span>Overall Rating: <span class="stat-letter grade-<?= strtolower($inspection['grade']) ?>"><?= $inspection['grade'] ?></span></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Inspection detail modal (custom, matches resto-style.css) -->
    <div class="modal-overlay" id="inspectionModalOverlay">
        <div class="modal-window">
            <button type="button" class="close-modal-btn" onclick="closeInspectionModal()">&times;</button>
            <div class="modal-header">
                <div class="modal-date" id="modalDate"></div>
                <div class="modal-scores">
                    <span>Violations: <strong id="modalViolationCount"></strong></span>
                    <span>Grade: <strong id="modalGrade"></strong></span>
                </div>
            </div>
            <div class="modal-body">
                <h4>Violations Recorded</h4>
                <ul id="modalViolationList"></ul>
            </div>
        </div>
    </div>

    <!-- Submit a review modal (custom, matches resto-style.css) -->
    <div class="modal-overlay" id="reviewModalOverlay">
        <div class="modal-window">
            <button type="button" class="close-modal-btn" onclick="closeReviewModal()">&times;</button>
            <div class="modal-header">
                <div class="modal-date">Share Your Assessment</div>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
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
                    <button type="submit" name="submit_review" class="btn btn-success w-100">Upload Review</button>
                </form>

                <?php if (!empty($reviews)): ?>
                    <hr class="my-4">
                    <h4>Recent Reviews</h4>
                    <?php foreach (array_slice($reviews, 0, 5) as $review): ?>
                        <div class="mb-3">
                            <div>
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi bi-star-fill <?= $i <= $review['rating'] ? 'text-warning' : 'text-secondary' ?>"></i>
                                <?php endfor; ?>
                                <small class="text-muted ms-2"><?= date('M d, Y', strtotime($review['created_at'])) ?></small>
                            </div>
                            <p class="mb-0"><?= htmlspecialchars($review['comment']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        const inspectionsData = <?= json_encode($inspections) ?>;

        function openInspectionModal(inspectionID) {
            const inspection = inspectionsData.find(i => i.inspectionID == inspectionID);
            if (!inspection) return;

            document.getElementById('modalDate').textContent = new Date(inspection.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            document.getElementById('modalViolationCount').textContent = inspection.violationCount;
            document.getElementById('modalGrade').textContent = inspection.grade;

            const list = document.getElementById('modalViolationList');
            list.innerHTML = '';
            if (inspection.violationTitles.length === 0) {
                list.innerHTML = '<li>No violations recorded for this inspection.</li>';
            } else {
                inspection.violationTitles.forEach(title => {
                    const li = document.createElement('li');
                    li.textContent = title;
                    list.appendChild(li);
                });
            }

            document.getElementById('inspectionModalOverlay').classList.add('active');
        }

        function closeInspectionModal() {
            document.getElementById('inspectionModalOverlay').classList.remove('active');
        }

        document.getElementById('openReviewModalBtn').addEventListener('click', function() {
            document.getElementById('reviewModalOverlay').classList.add('active');
        });

        function closeReviewModal() {
            document.getElementById('reviewModalOverlay').classList.remove('active');
        }

        document.getElementById('inspectionModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeInspectionModal();
        });
        document.getElementById('reviewModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeReviewModal();
        });
    </script>
</body>
</html>
