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
                                    <th>Item</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Sample Data -->
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <strong>iPhone 13 Pro</strong><br>
                                        <small class="text-muted">256GB, Graphite</small>
                                    </td>
                                    <td>Electronics</td>
                                    <td>₱45,000</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>2026-01-25</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning editBtn">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger deleteBtn">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>
                                        <strong>Samsung Galaxy S22</strong><br>
                                        <small class="text-muted">128GB, Black</small>
                                    </td>
                                    <td>Electronics</td>
                                    <td>₱32,000</td>
                                    <td><span class="badge bg-secondary">Inactive</span></td>
                                    <td>2026-01-28</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning editBtn">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger deleteBtn">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                                            <input type="text" class="form-control" placeholder="Enter item name">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Category</label>
                                            <input type="text" class="form-control"
                                                placeholder="Electronics, Jewelry, etc.">
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="3"></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Price</label>
                                            <input type="number" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Status</label>
                                            <select class="form-select">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Item Images</label>
                                            <input type="file" class="form-control" multiple>
                                            <small class="text-muted">Primary image will be set later</small>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary">Save Item</button>
                            </div>

                        </div>
                    </div>
                </div>
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
                                            <input type="text" class="form-control" id="editItemCategory">
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
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-warning">Update Item</button>
                            </div>

                        </div>
                    </div>
                </div>
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

    <script>
        $(document).ready(function () {

            $('#itemsTable').DataTable({
                responsive: true,
                pageLength: 10
            });

            // Edit button
            $('.editBtn').on('click', function () {
                $('#editItemModal').modal('show');
            });

            // Delete button
            $('.deleteBtn').on('click', function () {
                $('#deleteItemModal').modal('show');
            });

        });
    </script>



</body>

</html>