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

            <main class="content container-fluid">
                <div id="adsAlertContainer"></div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="mb-0">Subasta Items Section</h1>
                        <p class="subtitle text-muted">Manage all subasta items</p>
                    </div>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                        <i class="bi bi-plus-lg"></i> Add Item
                    </button>
                </div>

                <!-- Items Table -->
                <div class="card">
                    <div class="card-body">
                        <table id="itemsTable" class="table table-bordered table-striped align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Preview</th>
                                    <th>Item</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Populated by Datatable JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- preview images modal -->
                <div class="modal fade" id="itemImageModal" tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Item Images</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="image-preview-wrapper mx-auto mb-3">
                                    <img id="modalMainImage" alt="Item Image">
                                </div>
                                <div id="modalThumbnails" class="d-flex justify-content-center gap-2 flex-wrap"></div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Insert Modal -->
                <div class="modal fade" id="addItemModal" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Add New Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <form id="addItemForm">

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Item Name</label>
                                            <input type="text" class="form-control" id="addItemName" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Category</label>
                                            <select class="form-select" id="addItemCategory" required>
                                                <option value="" disabled selected>Select category</option>
                                                <option value="Cellphone">Cellphone</option>
                                                <option value="Gadget">Gadget</option>
                                                <option value="Camera">Camera</option>
                                                <option value="Tablet">Tablet</option>
                                                <option value="Laptop">Laptop</option>
                                                <option value="Vehicle">Vehicle</option>
                                            </select>
                                        </div>


                                        <div class="col-md-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" id="addItemDescription" rows="3"></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Price</label>
                                            <input type="number" class="form-control" id="addItemPrice" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" id="addItemStatus">
                                                <option value="Available">Available</option>
                                                <option value="Sold">Sold</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Item Images</label>
                                            <input type="file" class="form-control" id="addItemImages" multiple>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit" form="addItemForm">
                                    Save Item
                                </button>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Edit Item Modal -->
                <div class="modal fade" id="editItemModal" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <form id="editItemForm">

                                    <input type="hidden" id="editItemId">

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Item Name</label>
                                            <input type="text" class="form-control" id="editItemName">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Category</label>
                                            <select class="form-select" id="editItemCategory" required>
                                                <option value="">Select Category</option>
                                                <option value="Cellphone">Cellphone</option>
                                                <option value="Gadget">Gadget</option>
                                                <option value="Camera">Camera</option>
                                                <option value="Tablet">Tablet</option>
                                                <option value="Laptop">Laptop</option>
                                                <option value="Vehicle">Vehicle</option>
                                            </select>
                                        </div>


                                        <div class="col-md-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="3" id="editItemDescription"></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Price</label>
                                            <input type="number" class="form-control" id="editItemPrice">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" id="editItemStatus">
                                                <option value="Available">Available</option>
                                                <option value="Sold">Sold</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Item Images</label>
                                            <input type="file" class="form-control" id="editItemImages" multiple>
                                            <small class="text-muted" id="currentImagesList"></small>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-warning" form="editItemForm">Update Item</button>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Delete Item Modal -->
                <div class="modal fade" id="deleteItemModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title text-danger">Delete Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <p>Are you sure you want to delete this item?</p>
                                <p class="text-muted mb-0">This action cannot be undone.</p>
                                <input type="hidden" id="deleteItemId">
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger">Delete</button>
                            </div>

                        </div>
                    </div>
                </div>

            </main>



            <?php include("../views/footer.php"); ?>

        </div>
    </div>

    <script src="../assets/js/items.js?v=<?= filemtime(__DIR__ . '/../assets/js/items.js') ?>"></script>



</body>

</html>