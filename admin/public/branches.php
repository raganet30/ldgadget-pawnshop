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

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1>Branches Section</h1>
                        <p class="subtitle">Manage all branches to be displayed on website</p>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBranchModal">
                        <i class="bi bi-plus-circle"></i> Add Branch
                    </button>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table id="branchesTable" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Branch Name</th>
                                    <th>Address</th>
                                    <th>Schedule</th>
                                    <th>Contact No.</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- popolate through AJAX -->

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add Branch Modal -->
                <div class="modal fade" id="addBranchModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="addBranchForm">

                                <div class="modal-header">
                                    <h5 class="modal-title">Add Branch</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Branch Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="name" id="branchName"
                                                required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Contact No.</label>
                                            <input type="number" class="form-control" name="contact_no"
                                                id="branchContact">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="branchEmail">
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">
                                                Address <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" name="address" id="branchAddress" rows="2"
                                                required></textarea>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Schedule</label>
                                            <textarea class="form-control" name="schedule" id="branchSchedule" rows="2"
                                                placeholder="e.g. Mon-Sat: 9:00 AM - 6:00 PM"></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status" id="branchStatus">
                                                <option value="Active" selected>Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Save Branch
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                <!-- Edit Branch Modal -->
                <div class="modal fade" id="editBranchModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="editBranchForm">

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Branch</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <!-- Hidden ID for branch -->
                                    <input type="hidden" name="id" id="editBranchId">

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Branch Name</label>
                                            <input type="text" class="form-control" id="editBranchName" name="name"
                                                required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Contact No.</label>
                                            <input type="text" class="form-control" id="editBranchContact"
                                                name="contact_no">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" id="editBranchEmail"
                                                name="email">
                                        </div>


                                        <div class="col-md-12">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" id="editBranchAddress" name="address"
                                                rows="2" required></textarea>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Schedule</label>
                                            <textarea class="form-control" id="editBranchSchedule" name="schedule"
                                                rows="2"></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" id="editBranchStatus" name="status">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-warning">Update Branch</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                <!-- Delete branch modal -->
                <div class="modal fade" id="deleteBranchModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger">Delete Branch</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" id="deleteBranchId">
                                <p>Are you sure you want to delete this branch?</p>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="confirmDeleteBranch">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

            </main>

            <?php include("../views/footer.php"); ?>

        </div>

    </div>


    <script src="../assets/js/branches.js?v=<?= filemtime(__DIR__ . '/../assets/js/branches.js') ?>" defer></script>

</body>

</html>