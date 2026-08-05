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
        <link rel="stylesheet" href="../../styles/select2-4.1.0-dist/css/select2.min.css">
        <link rel="stylesheet" href="../../styles/select2-bs5-theme-dist/select2-bootstrap-5-theme.min.css">
        <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
        <script src="../../styles/js/jquery-3.7.1.min.js"></script>
        <script src="../../styles/select2-4.1.0-dist/js/select2.min.js"></script>
        <script type="module" src="../../styles/js/nav-bar.js"></script>
        <script src="../../styles/js/inspector/inspection-entry.js"></script>
    </head>
    <body>
        <?php include __DIR__ . '/../navbar.php';?>
        <div class="page-header">
            <h1 class="fw-bold">Log Inspection Entry</h1>
        </div>
        <div class="form-container w-50">
            <form id="form-add-inspection">
                <div class="form-group mb-3">
                    <label for="food-business">Food Business <span class="text-danger">*</span></label>
                    <select class="form-select" id="food-business" name="food-business-id" required>
                        <option value="" selected disabled hidden></option>
                        <?php foreach($businessIdNames as $businessIdName): ?>
                        <option value="<?= $businessIdName['restoID']; ?>"><?= $businessIdName['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="food-business-help" class="form-text text-muted">If a result does not show up, please add it first <a href="/businessDirectory">here</a>.</small>
                </div>
                <div class="form-row container mb-3 p-0" id="container-score-grade">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="inspection-date">Inspection Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="inspection-date" id="inspection-date" min="2000-01-01" max="" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="grade">Grade <span class="text-danger">*</span></label><br>
                            <select class="form-select" id="grade" name="grade" required>
                                <option value="" selected disabled hidden>Select Grade</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="remarks">Overall Remarks <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Overall review of the inspection" required>
                </div>
                <div class="form-group mb-3">
                    <label for="violations">Violations</label>
                    <select class="form-select" id="violations" name="violations[]" multiple="multiple">
                        <?php foreach($requirements as $requirement): ?>
                        <option value="<?= $requirement->reqCode; ?>"><?= $requirement->reqTitle; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" id="add-inspection-final" class="btn button-option">Submit</button>
            </form>
        </div>
        <div id="toast" class="custom-toast hidden">
            <div class="toast-text">
                <strong id="toast-title">Toast Title</strong>
                <p id="toast-message">Toast Message</p>
            </div>
            <span id="toast-close" class="toast-close" onclick="hideToast()">&times;</span>
        </div>
        <?php require __DIR__ . '/../../view/footer.php' ?>
    </body>
</html>