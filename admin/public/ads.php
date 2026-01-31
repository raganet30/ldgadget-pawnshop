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

                <div class="page-header">
                    <div>
                        <h1>Ads Section</h1>
                        <p class="subtitle">Manage homepage hero advertisements</p>
                    </div>

                    <button class="btn-primary" onclick="openAddAdModal()">
                        <i class="bi bi-plus-circle"></i> Add New Ads
                    </button>

                </div>

                <!-- Ads Table -->
                <div class="card">
                    <table class="ads-table">
                        <thead>
                            <tr>
                                <th>Preview</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Sample Row -->
                            <tr>
                                <td>
                                    <img src="../assets/sample-ad.jpg" class="ad-preview">
                                </td>
                                <td>Fast Gadget Loans</td>
                                <td>Low interest rates with fast approval</td>
                                <td>
                                    <span class="badge active">Active</span>
                                </td>
                                <td class="actions">
                                    <button class="icon-btn edit" onclick="openEditAdModal()">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button class="icon-btn delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>



                <!-- Add Ad Modal -->
                <div id="addAdModal" class="modal">
                    <div class="modal-content large-modal">
                        <span class="close" onclick="closeAddAdModal()">&times;</span>
                        <h2>Add New Ad</h2>
                        <form>
                            <div class="form-group">
                                <label for="addAdTitle">Title</label>
                                <input type="text" id="addAdTitle" required>
                            </div>

                            <div class="form-group">
                                <label for="addAdDescription">Description</label>
                                <textarea id="addAdDescription" rows="3" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="addAdStatus">Status</label>
                                <select id="addAdStatus" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="addAdFile">Upload Photo</label>
                                <input type="file" id="addAdFile" accept="image/*">
                                <img id="addAdFilePreview" class="image-preview" src="#" alt="Preview"
                                    style="display:none;">
                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Ad Modal -->
                <div id="editAdModal" class="modal">
                    <div class="modal-content large-modal">
                        <span class="close" onclick="closeEditAdModal()">&times;</span>
                        <h2>Edit Ad</h2>
                        <form>
                            <div class="form-group">
                                <label for="editAdTitle">Title</label>
                                <input type="text" id="editAdTitle" required>
                            </div>

                            <div class="form-group">
                                <label for="editAdDescription">Description</label>
                                <textarea id="editAdDescription" rows="3" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="editAdStatus">Status</label>
                                <select id="editAdStatus" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="editAdFile">Upload Photo</label>
                                <input type="file" id="editAdFile" accept="image/*">
                                <img id="editAdFilePreview" class="image-preview" src="#" alt="Preview"
                                    style="display:none;">
                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

            </main>



            <?php include("../views/footer.php"); ?>

        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
    </script>

    <script>
        // Modal Open/Close
        function openAddAdModal() { document.getElementById('addAdModal').style.display = 'block'; }
        function closeAddAdModal() { document.getElementById('addAdModal').style.display = 'none'; }

        function openEditAdModal() { document.getElementById('editAdModal').style.display = 'block'; }
        function closeEditAdModal() { document.getElementById('editAdModal').style.display = 'none'; }

        // Image Preview for Add Modal
        document.getElementById('addAdFile').addEventListener('change', function (event) {
            const preview = document.getElementById('addAdFilePreview');
            const file = event.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        });

        // Image Preview for Edit Modal
        document.getElementById('editAdFile').addEventListener('change', function (event) {
            const preview = document.getElementById('editAdFilePreview');
            const file = event.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        });

        // Close modals when clicking outside
        window.onclick = function (event) {
            if (event.target == document.getElementById('addAdModal')) closeAddAdModal();
            if (event.target == document.getElementById('editAdModal')) closeEditAdModal();
        }
    </script>

</body>

</html>