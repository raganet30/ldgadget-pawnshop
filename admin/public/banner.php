<?php require_once '../processes/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="en">

<?php include("../views/head.php"); ?>

<body class="admin-body">


    <div class="admin-wrapper">

        <?php include '../views/sidebar.php'; ?>

        <!-- Main Area -->
        <div class="main">

            <!-- Header -->
            <?php include '../views/header.php'; ?>

            <main class="content">
                <div id="adsAlertContainer"></div>
                <div class="page-header">

                    <div>
                        <h1>Banner Section</h1>
                        <p class="subtitle">Manage homepage banner on website</p>
                    </div>

                    <button class="btn-primary" onclick="openAddAdModal()">
                        <i class="bi bi-plus-circle"></i> Add New Banner
                    </button>

                </div>

              
                <!-- Ads Table -->
                <div class="card">
                    <div class="card-body">
                        <table id="adsTable" class="table table-bordered table-striped align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>Preview</th>
                                    <th>Title</th>
                                    <th>Short Description</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody id="adsTableBody">
                                <!-- Dynamic Content -->
                            </tbody>
                        </table>
                    </div>
                </div>





                <!-- Bootstrap Add Ad Modal -->
                <div class="modal fade" id="addAdModal" tabindex="-1" aria-labelledby="addAdModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">

                            <form id="addAdForm" enctype="multipart/form-data">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="addAdModalLabel">Add New Banner</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row g-3">

                                        <!-- LEFT COLUMN -->
                                        <div class="col-md-7">

                                            <div class="mb-3">
                                                <label for="addAdTitle" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="addAdTitle" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="addAdDescription" class="form-label">Description</label>
                                                <textarea class="form-control" id="addAdDescription" rows="4"
                                                    required></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="addAdStatus" class="form-label">Status</label>
                                                <select class="form-select" id="addAdStatus" required>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>

                                        </div>

                                        <!-- RIGHT COLUMN -->
                                        <div class="col-md-5">

                                            <div class="mb-3">
                                                <label for="addAdFile" class="form-label">Upload Photo</label>
                                                <input type="file" class="form-control" id="addAdFile" accept="image/*">
                                            </div>

                                            <div class="border rounded p-2 text-center">
                                                <small class="text-muted d-block mb-2">Image Preview</small>
                                                <img id="addAdFilePreview" class="img-fluid rounded d-none"
                                                    alt="Image Preview" style="max-height: 220px; object-fit: contain;">
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>



                <!-- Bootstrap Edit Ad Modal -->
                <div class="modal fade" id="editAdModal" tabindex="-1" aria-labelledby="editAdModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">

                            <form id="editAdForm" enctype="multipart/form-data">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="editAdModalLabel">Edit Banner</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row g-3">

                                        <!-- LEFT COLUMN -->
                                        <div class="col-md-7">
                                            <input type="hidden" id="editAdId">

                                            <div class="mb-3">
                                                <label for="editAdTitle" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="editAdTitle" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="editAdDescription" class="form-label">Description</label>
                                                <textarea class="form-control" id="editAdDescription" rows="4"
                                                    required></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="editAdStatus" class="form-label">Status</label>
                                                <select class="form-select" id="editAdStatus" required>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- RIGHT COLUMN -->
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label for="editAdFile" class="form-label">Upload Photo</label>
                                                <input type="file" class="form-control" id="editAdFile"
                                                    accept="image/*">
                                            </div>

                                            <div class="border rounded p-2 text-center">
                                                <small class="text-muted d-block mb-2">Image Preview</small>
                                                <img id="editAdFilePreview" class="img-fluid rounded d-none"
                                                    alt="Image Preview" style="max-height: 220px; object-fit: contain;">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Save Changes
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>


                <!-- Delete Ad Modal -->
                <div class="modal fade" id="deleteAdModal" tabindex="-1" aria-labelledby="deleteAdModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="deleteAdModalLabel">
                                    Confirm Delete
                                </h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div id="deleteAlert"></div>

                                <p class="mb-0">
                                    Are you sure you want to delete this banner?
                                </p>
                                <small class="text-muted">
                                    This action cannot be undone.
                                </small>

                                <input type="hidden" id="deleteAdId">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                                    Delete
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Image Zoom Modal -->
                <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content bg-transparent border-0">

                            <div class="modal-body text-center p-0 position-relative">
                                <button type="button"
                                    class="btn-close position-absolute top-0 end-0 m-3 bg-white rounded-circle"
                                    data-bs-dismiss="modal" aria-label="Close"></button>

                                <img id="zoomedImage" class="img-fluid rounded shadow" style="max-height: 90vh;">
                            </div>

                        </div>
                    </div>
                </div>


            </main>



            <?php include("../views/footer.php"); ?>

        </div>
    </div>

    <script src="../assets/js/ads.js?v=<?= filemtime(__DIR__ . '/../assets/js/ads.js') ?>" defer></script>


</body>

</html>