<?php
require_once '../../controller/admin/adminAddUsers.controller.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodSafe - Provision User Profile</title>
    <link rel="icon" type="image/png" href="../../src/images/logo-tab.png">
    <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../styles/css/global.css">
    <script src="../../styles/js/jquery-3.7.1.min.js"></script>
    <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <script src="../../styles/js/nav-bar.js"></script>
</head>
<body class="bg-light">
    <div id="navBar"><?php include __DIR__ . '/../navbar.php';?></div>

    <div class="container my-5" style="max-width: 550px;">
        <?php if (!empty($success_msg)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $success_msg ?>
                <button type="button" class="btn-close" data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-octagon-fill me-2"></i><?= $error_msg ?>
                <button type="button" class="btn-close" data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-lg">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0"><i class="bi bi-person-badge-fill me-2"></i> Register System User</h5>
            </div>
            <div class="card-body p-4">
                <form action="" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Active Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

         
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" name="firstName" id="firstName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" name="lastName" id="lastName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">System Role / Permissions</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="">-- Select Role --</option>
                            <option value="Inspector">Safety Health Inspector</option>
                            <option value="Admin">System Administrator</option>
                        </select>
                    </div>

                    <div class="mb-3" id="district-container" style="display: none;">
                        <label for="districtID" class="form-label">Assigned Inspector District</label>
                        <select name="districtID" id="districtID" class="form-select">
                            <option value="">None / Select District</option>
                            <?php foreach ($districts as $district): ?>
                                <option value="<?= htmlspecialchars($district['districtID']) ?>">
                                    <?= htmlspecialchars($district['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <hr class="my-4">
                    <div class="mb-3">
                        <label for="password" class="form-label">Access Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" name="register_user" class="btn btn-primary w-100 py-2 mt-3">
                        <i class="bi bi-shield-lock-fill me-2"></i> Provision Account
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const roleSelect = $('#role');
            const districtContainer = $('#district-container');
            const districtSelect = $('#districtID');

            roleSelect.on('change', function() {
                if ($(this).val() === 'Inspector') {
                    districtContainer.slideDown(200);
                    districtSelect.prop('required', true);
                } else {
                    districtContainer.slideUp(200);
                    districtSelect.prop('required', false).val('');
                }
            });
        });
    </script>
</body>
</html>
