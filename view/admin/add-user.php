<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodSafe - Provision User Profile</title>
    <link rel="icon" type="image/png" href="../../src/images/logo-tab.png">
    <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../styles/css/global.css">
    <link rel="stylesheet" href="../../styles/css/admin/add-user.css">
    <script src="../../styles/js/jquery-3.7.1.min.js"></script>
    <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <script src="../../styles/js/nav-bar.js"></script>
</head>
<body class="admin-page">
    <div id="navBar"><?php include __DIR__ . '/../navbar.php';?></div>

    <div class="container my-3" style="max-width: 600px;">
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
    </div>

    <div class="form-container-wrapper">
        <div class="form-center-box">
            <div class="form-left">
                <h1 class="page-title-orange">Register System User</h1>

                <form action="" method="POST" autocomplete="off">
                    <div class="custom-fg">
                        <label for="email">Active Email Address</label>
                        <input type="email" name="email" id="email" class="custom-input" required>
                    </div>

                    <div class="custom-fg">
                        <label for="firstName">First Name</label>
                        <input type="text" name="firstName" id="firstName" class="custom-input" required>
                    </div>

                    <div class="custom-fg">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName" id="lastName" class="custom-input" required>
                    </div>

                    <div class="custom-fg">
                        <label for="role">System Role / Permissions</label>
                        <div class="select-wrapper">
                            <select name="role" id="role" class="custom-select-pill" required>
                                <option value="">-- Select Role --</option>
                                <option value="Inspector">Safety Health Inspector</option>
                                <option value="Admin">System Administrator</option>
                            </select>
                        </div>
                    </div>

                    <div class="custom-fg" id="district-container" style="display: none;">
                        <label for="districtID">Assigned Inspector District</label>
                        <div class="select-wrapper">
                            <select name="districtID" id="districtID" class="custom-select-pill">
                                <option value="">None / Select District</option>
                                <?php foreach ($districts as $district): ?>
                                    <option value="<?= htmlspecialchars($district['districtID']) ?>">
                                        <?= htmlspecialchars($district['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="custom-fg">
                        <label for="password">Access Password</label>
                        <input type="password" name="password" id="password" class="custom-input" required>
                    </div>
                    <div class="custom-fg">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="custom-input" required>
                    </div>

                    <div class="btn-center-wrapper">
                        <button type="submit" name="register_user" class="action-btn-submit">
                            <i class="bi bi-shield-lock-fill me-2"></i> Provision Account
                        </button>
                    </div>
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
