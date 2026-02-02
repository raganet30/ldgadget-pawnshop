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
                        <h1>FAQs Section</h1>
                        <p class="subtitle">Manage all frequently asked questions</p>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                        <i class="bi bi-plus-circle"></i> Add FAQ
                    </button>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table id="faqsTable" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add FAQ Modal -->
                <div class="modal fade" id="addFaqModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="addFaqForm">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add FAQ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Question</label>
                                            <textarea class="form-control" name="question" rows="2" required></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Answer</label>
                                            <textarea class="form-control" name="answer" rows="4" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save FAQ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit FAQ Modal -->
                <div class="modal fade" id="editFaqModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="editFaqForm">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit FAQ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" name="id" id="editFaqId">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Question</label>
                                            <textarea class="form-control" name="question" id="editFaqQuestion" rows="2"
                                                required></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Answer</label>
                                            <textarea class="form-control" name="answer" id="editFaqAnswer" rows="4"
                                                required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-warning">Update FAQ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete FAQ Modal -->
                <div class="modal fade" id="deleteFaqModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger">Delete FAQ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" id="deleteFaqId">
                                <p>Are you sure you want to delete this FAQ?</p>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="confirmDeleteFaq">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

            </main>



            <?php include("../views/footer.php"); ?>

        </div>
    </div>


    <script src="../assets/js/faq.js?v=<?= filemtime(__DIR__ . '/../assets/js/faq.js') ?>" defer></script>
</body>

</html>