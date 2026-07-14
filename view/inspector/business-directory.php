<!DOCTYPE html>
<html>
    <head>
        <title>FoodSafe - Business Directory</title>
        <link rel="stylesheet" href="business-directory.css">
        <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../styles/css/global.css">
        <link rel="stylesheet" href="../../styles/css/dataTables.dataTables.min.css">
        <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
        <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
        <script src="../../styles/js/nav-bar.js"></script>
        <script src="../../styles/js/jquery-3.7.1.min.js"></script>
        <script src="../../styles/js/dataTables.min.js"></script>
        <script src="../../styles/js/inspector/business-directory.js"></script>
    </head>
    <body>
        <div id="navBar"></div>
        <h1 class="mt-4 mb-4 fw-bold">Food Business Directory</h1>
        <div class="float-right me-5">
        </div>
        <div class="table-custom">
            <button type="button" class="btn button-option float-end me-2 mb-2" data-bs-toggle="modal" data-bs-target="#add-modal">+ Add business</button>
            <table id="business-directory" class="display table table-striped">
                <thead>
                    <tr>
                        <th>License No.</th>
                        <th>Business Name</th>
                        <th>Contact</th>
                        <th>Map Link</th>
                        <th data-dt-order="disable">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1938</td>
                        <td>The Fowler Fine Diner</td>
                        <td>+639564438421</td>
                        <td>https://example.com</td>
                        <td>
                            <button type="button" class="button-option" data-bs-toggle="modal" data-bs-target="#edit-modal"><i class="bi bi-pencil"></i>  Edit</button>
                            <button type="button" class="button-option" data-bs-toggle="modal" data-bs-target="#delete-modal">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>1938</td>
                        <td>The Fowler Fine Diner</td>
                        <td>+639564438421</td>
                        <td>https://example.com</td>
                        <td>
                            <button type="button" class="button-option" data-bs-toggle="modal" data-bs-target="#edit-modal">Edit</button>
                            <button type="button" class="button-option" data-bs-toggle="modal" data-bs-target="#delete-modal">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>1945</td>
                        <td>Jollibee</td>
                        <td>+639775864432</td>
                        <td>https://example.com</td>
                        <td>
                            <button type="button" class="button-option" data-bs-toggle="modal" data-bs-target="#edit-modal">Edit</button>
                            <button type="button" class="button-option" data-bs-toggle="modal" data-bs-target="#delete-modal">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>1973</td>
                        <td>McDonalds</td>
                        <td>+63965445819</td>
                        <td>https://example.com</td>
                        <td>
                            <button type="button" class="button-option" data-bs-toggle="modal" data-bs-target="#edit-modal">Edit</button>
                            <button type="button" class="button-option" data-bs-toggle="modal" data-bs-target="#delete-modal">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Add modal -->
        <div class="modal fade" tabindex="-1" id="add-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add business</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="business-name">Food Business Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="business-name" name="business-name" required>
                            </div>
                            <div class="mb-3">
                                <label for="business-address">Business address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="business-address" name="business-address" required>
                            </div>
                            <div class="mb-3">
                                <label for="business-license-no">License number <span class="text-danger">*</span></label>
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
                            </div>
                            <div class="mb-3">
                                <label for="business-maps-url">Link to Google Maps</label>
                                <input type="link" class="form-control" id="business-maps-url" name="business-maps-url" placeholder="https://maps.google.com/...">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit modal -->
        <div class="modal fade" tabindex="-1" id="edit-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add business</h5>
                        <button type="button" class="close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="business-name">Business name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="business-name" name="business-name" required>
                            </div>
                            <div class="mb-3">
                                <label for="business-address">Business address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="business-address" name="business-address" required>
                            </div>
                            <div class="mb-3">
                                <label for="business-license-no">License number <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="business-license-no" name="business-license-no" required>
                            </div>
                            <div class="mb-3">
                                <label for="business-contact-no">Business Contact No. <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="business-contact-no" name="business-contact-no" placeholder="Philippine telephone or cellphone #" required>
                            </div>
                            <div class="mb-3">
                                <label for="business-establishment-image">Image of establishment <span class="text-danger">*</span></label>
                                <input type="file" class="form-control-file" id="business-establishment-image" name="business-establishment-image">
                            </div>
                            <div class="mb-3">
                                <label for="business-maps-url">Link to Google Maps</label>
                                <input type="link" class="form-control" id="business-maps-url" name="business-maps-url" placeholder="https://maps.google.com/...">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-info">Edit</button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Do you want to delete this business?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>