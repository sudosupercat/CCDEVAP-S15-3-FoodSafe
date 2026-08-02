<?php
require __DIR__ . '/../theme-cookie.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FoodSafe - Inspection Entry</title>
        <link rel="icon" type="image/x-icon" href="../../src/images/logo-tab.png">
        <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../styles/css/global.css">
        <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
        <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
        <script type="module" src="../../styles/js/nav-bar.js"></script>
        <script src="../../styles/js/inspector/inspection-entry.js"></script>
    </head>
    <body>
        <?php include __DIR__ . '/../navbar.php';?>
        <div class="page-header">
            <h1 class="fw-bold">Log Inspection Entry</h1>
        </div>
        <div class="form-container">
            <form id="form-add-inspection">
                <div class="form-group">
                    <label for="food-business">Food Business</label>
                    <select class="form-control" id="food-business" name="food-business-id" required>
                        <?php foreach($businessIdNames as $businessIdName): ?>
                        <option value="<?= $businessIdName['restoID']; ?>"><?= $businessIdName['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="food-business-help" class="form-text text-muted">If a result does not show up, please add it first.</small>
                </div>
                <div class="form-group">
                    <label for="inspection-date">Inspection Date</label>
                    <input type="date" class="form-control" name="inspection-date" id="inspection-date" min="2000-01-01" max="" required>
                </div>
                <div class="custom-control custom-switch mb-2">
                    <input type="checkbox" class="custom-control-input" id="autoRatingSwitch">
                    <label class="custom-control-label" for="autoRatingSwitch">Automatically compute score and grade</label>
                </div>
                <div class="form-row" id="container-score-grade">
                    <div class="form-group col">
                        <label for="score">Score</label>
                        <input type="number" class="form-control" name="score" id="score" min="0" max="100" placeholder="0-100" required>
                    </div>
                    <div class="col">
                        <span>Grade:</span><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="grade" id="grade-pass" value="Pass" required>
                            <label class="form-check-label" for="grade-pass">Pass</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="grade" id="grade-fail" value="Fail" required>
                            <label class="form-check-label" for="grade-fail">Fail</label>
                        </div>
                    </div>
                </div>
                <div class="my-3 d-flex justify-content-end">
                    <a href="#" class="button-option" id="button-add-violation">+ Add violation</a>
                </div>
                <div id="violation-form-container"></div>
                <input type="hidden" value="<?= $_SESSION['userID']?>" name="user-id" id="user-id">
                <button type="submit" id="add-inspection-final" class="btn btn-primary">Submit</button>

            </form>
        </div>
        <?php require __DIR__ . '/../../view/footer.php' ?>
    </body>
</html>