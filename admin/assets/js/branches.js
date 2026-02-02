$(document).ready(function () {

    // Edit button
    $(document).on('click', '.editBranchBtn', function () {
        const id = $(this).data('id');
        $('#editBranchId').val(id);
        $('#editBranchModal').modal('show');
    });

    // Delete button
    $(document).on('click', '.deleteBranchBtn', function () {
        const id = $(this).data('id');
        $('#deleteBranchId').val(id);
        $('#deleteBranchModal').modal('show');
    });


    function showAlert(message, type = 'success') {
        const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
        $('#adsAlertContainer').html(alertHtml);

        // Auto-dismiss after 4 seconds
        setTimeout(() => {
            $('.alert').alert('close');
        }, 4000);
    }


    // add branch
    $('#addBranchForm').on('submit', function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: '../processes/insert_branch.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function () {
                $('#addBranchForm button[type="submit"]').prop('disabled', true);
            },
            success: function (response) {
                if (response.status === 'success') {
                    showAlert(response.message, 'success');

                    // Close modal the correct way
                    const modalEl = document.getElementById('addBranchModal');

                    // Get the modal instance, or create if missing
                    const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);

                    // Hide the modal
                    modalInstance.hide();

                    // Remove any leftover backdrop manually (Bootstrap 5.3 sometimes leaves it)
                    const backdrops = document.getElementsByClassName('modal-backdrop');
                    while (backdrops[0]) {
                        backdrops[0].parentNode.removeChild(backdrops[0]);
                    }

                    // Remove modal-open class from body if still present
                    document.body.classList.remove('modal-open');

                    // Reset form
                    $('#addBranchForm')[0].reset();
                    //    reload ajax table
                    $('#branchesTable').DataTable().ajax.reload(null, false);

                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function () {
                showAlert('Something went wrong. Please try again.', 'danger');
            },
            complete: function () {
                $('#addBranchForm button[type="submit"]').prop('disabled', false);
            }
        });
    });


    // Initialize DataTable
    const table = $('#branchesTable').DataTable({
        responsive: true,
        ajax: {
            url: '../api/fetch_branches.php',
            dataSrc: '' // expects array of JSON objects
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'address' },
            { data: 'schedule' },
            { data: 'contact_no' },
            { data: 'email' },
            {
                data: 'status',
                render: function (data, type, row) {
                    if (data === 'Active') {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-secondary">Inactive</span>';
                    }
                }
            },
            { data: 'created_at' },
            {
                data: 'id',
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning editBranchBtn" data-id="${data}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteBranchBtn" data-id="${data}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                }
            }
        ],
        order: [[0, 'desc']],
        pageLength: 10
    });

    // Optional: refresh table after adding/editing/deleting
    // window.refreshBranchesTable = function () {
    //     table.ajax.reload(null, false); // reload without resetting paging
    // }


    // edit branch
    // When clicking edit button
    $(document).on('click', '.editBranchBtn', function () {
        const branchId = $(this).data('id');

        $.ajax({
            url: '../api/fetch_single_branch.php',
            type: 'GET',
            data: { id: branchId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const branch = response.data;

                    // Populate modal fields
                    $('#editBranchId').val(branch.id);
                    $('#editBranchName').val(branch.name);
                    $('#editBranchAddress').val(branch.address);
                    $('#editBranchSchedule').val(branch.schedule);
                    $('#editBranchContact').val(branch.contact_no);
                    $('#editBranchEmail').val(branch.email);
                    $('#editBranchStatus').val(branch.status);

                    // Show the modal
                    const editModalEl = document.getElementById('editBranchModal');
                    const editModal = bootstrap.Modal.getOrCreateInstance(editModalEl);
                    editModal.show();

                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function () {
                showAlert('Failed to fetch branch details.', 'danger');
            }
        });
    });


    $('#editBranchForm').on('submit', function (e) {
        e.preventDefault();

        const formData = $(this).serialize(); // make sure inputs have 'name' attributes

        $.ajax({
            url: '../processes/update_branch.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function () {
                $('#editBranchForm button[type="submit"]').prop('disabled', true);
            },
            success: function (response) {
                if (response.status === 'success') {
                    showAlert(response.message, 'success');

                    // Close modal properly
                    const editModalEl = document.getElementById('editBranchModal');
                    const editModal = bootstrap.Modal.getInstance(editModalEl) || new bootstrap.Modal(editModalEl);
                    editModal.hide();

                    // Reset form
                    $('#editBranchForm')[0].reset();

                    // Refresh table
                    $('#branchesTable').DataTable().ajax.reload(null, false);
                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function () {
                showAlert('Something went wrong. Please try again.', 'danger');
            },
            complete: function () {
                $('#editBranchForm button[type="submit"]').prop('disabled', false);
            }
        });
    });


    // delete branch
    // When clicking delete button
    $(document).on('click', '.deleteBranchBtn', function () {
        const branchId = $(this).data('id');
        $('#deleteBranchId').val(branchId);

        // Show delete modal
        const deleteModalEl = document.getElementById('deleteBranchModal');
        const deleteModal = bootstrap.Modal.getOrCreateInstance(deleteModalEl);
        deleteModal.show();
    });

    $('#confirmDeleteBranch').on('click', function () {
        const branchId = $('#deleteBranchId').val();

        if (!branchId) {
            showAlert('Branch ID not found', 'danger');
            return;
        }

        $.ajax({
            url: '../processes/delete_branch.php',
            type: 'POST',
            data: { id: branchId },
            dataType: 'json',
            beforeSend: function () {
                $('#confirmDeleteBranch').prop('disabled', true);
            },
            success: function (response) {
                if (response.status === 'success') {
                    showAlert(response.message, 'success');

                    // Close modal properly
                    const deleteModalEl = document.getElementById('deleteBranchModal');
                    const deleteModal = bootstrap.Modal.getInstance(deleteModalEl) || new bootstrap.Modal(deleteModalEl);
                    deleteModal.hide();

                    // Refresh DataTable
                    $('#branchesTable').DataTable().ajax.reload(null, false);

                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function () {
                showAlert('Something went wrong. Please try again.', 'danger');
            },
            complete: function () {
                $('#confirmDeleteBranch').prop('disabled', false);
            }
        });
    });



});