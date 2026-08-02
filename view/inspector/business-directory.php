<?php
require __DIR__ . '/../theme-cookie.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FoodSafe - Business Directory</title>
        <link rel="icon" type="image/x-icon" href="../../src/images/logo-tab.png">
        <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../styles/css/global.css">
        <link rel="stylesheet" href="../../styles/css/dataTables.dataTables.min.css">
        <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
        <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
        <script type="module" src="../../styles/js/nav-bar.js"></script>
        <script src="../../styles/js/jquery-3.7.1.min.js"></script>
        <script src="../../styles/js/dataTables.min.js"></script>
        <script src="../../styles/js/inspector/business-directory.js"></script>
    </head>
    <body>
        <?php include __DIR__ . '/../navbar.php';?>
        <div class="page-header">
            <h1 class="fw-bold">Food Business Directory</h1>
        </div>
        <div class="float-right me-5">
        </div>
        <div class="table-custom table-responsive">
            <button type="button" class="btn button-option float-start me-2 mb-2" id="button-add-business">+ Add business</button>
            <table id="business-directory" class="display table table-striped">
                <thead>
                    <tr>
                        <th>License #</th>
                        <th>Business Name</th>
                        <th>Address</th>
                        <th>District</th>
                        <th data-dt-order="disable">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($foodBusinesses as $foodBusiness): 
                        if ($foodBusiness->status == 1){?>
                    <tr>
                        <td><?= htmlspecialchars($foodBusiness->licenseNo) ?></td>
                        <td><?= htmlspecialchars($foodBusiness->name) ?></td>
                        <td><?= htmlspecialchars($foodBusiness->address) ?></td>
                        <td><?= $districts[$foodBusiness->district - 1]['name']; ?></td>
                        <td>
                            <button type="button" class="button-option button-edit-business"
                                data-foodBusinessId="<?= htmlspecialchars($foodBusiness->foodBusinessId) ?>"
                                data-licNo="<?= htmlspecialchars($foodBusiness->licenseNo) ?>"
                                data-name="<?= htmlspecialchars($foodBusiness->name) ?>"
                                data-address="<?= htmlspecialchars($foodBusiness->address) ?>"
                                data-contact="<?= htmlspecialchars($foodBusiness->contactNo) ?>"
                                data-maps="<?= !empty($foodBusiness->mapsLink) ? htmlspecialchars($foodBusiness->mapsLink) : '' ?>"
                                data-image="<?= !empty($foodBusiness->imageLink) ? htmlspecialchars($foodBusiness->imageLink) : 'N/A' ?>"
                                data-district="<?= htmlspecialchars($foodBusiness->district) ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <?php if ($_SESSION['role'] == "Admin") {
                                echo '<button type="button" class="button-option button-delete-business"
                                    data-foodBusinessId="' . htmlspecialchars($foodBusiness->foodBusinessId) . '"
                                    data-name="' . htmlspecialchars($foodBusiness->name) . '">
                                    <i class="bi bi-trash"></i>
                                </button>';
                            } ?>
                        </td>
                    </tr>
                    <?php } endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>License #</th>
                        <th>Business Name</th>
                        <th>Address</th>
                        <th>District</th>
                        <th>Options</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- Add and edit modal -->
        <div class="modal fade" tabindex="-1" id="add-edit-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title-modal-edit-add">Add business</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-add-edit">
                            <div class="mb-3">
                                <label for="business-name">Business Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="business-name" name="business-name" placeholder="Add branch name when applicable" required>
                            </div>
                            <div class="mb-3">
                                <label for="business-address">Business Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="business-address" name="business-address" required>
                            </div>
                            <div class="mb-3">
                                <label for="business-license-no">License No. <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="business-license-no" name="business-license-no" required>
                            </div>
                            <div class="mb-3">
                                <label for="business-contact-no">Business Contact No. <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="contact-number" name="contact-number"
                    pattern="[0-9]{10}" placeholder="Philippine cellphone#" required>
                            </div>
                            <div class="mb-3">
                                <label for="business-establishment-image">Image of establishment <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="business-establishment-image" name="business-establishment-image" accept="image/*">
                                <div class="container object-fit-contain">
                                    <img class="img-fluid" id="image-preview" src="">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="business-maps-url">Link to Google Maps</label>
                                <input type="link" class="form-control" id="business-maps-url" name="business-maps-url" placeholder="https://maps.app.goo.gl/...">
                            </div>
                            <div class="mb-3">
                                <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                                <select class="form-select" id="district" name="business-district" required>
                                    <?php foreach($districts as $district): ?>
                                    <option value="<?= htmlspecialchars($district['districtID'])?>"><?= htmlspecialchars($district['name'])?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="hidden" id="business-id" name="business-id" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="cancel-button-modal-edit-add" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="confirm-button-modal-edit-add">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete modal -->
        <div class="modal fade" tabindex="-1" id="delete-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete business</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p id="text-delete-question"></p>
                        <p class="text-danger fw-bold">This action cannot be undone!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="button-delete-business-final">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <?php require __DIR__ . '/../../view/footer.php' ?>
    </body>
</html>