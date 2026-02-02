function showAlert(message, type = 'success') {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    $('#adsAlertContainer').html(alertHtml);

    setTimeout(() => {
        $('.alert').alert('close');
    }, 4000);
}

// Initialize FAQs DataTable with ajax source
let faqsTable = $('#faqsTable').DataTable({
    ajax: {
        url: '../api/fetch_faqs.php',
        dataSrc: ''
    },
    columns: [
        //   auto increment no
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: 'question' },
        { data: 'answer' },
        { data: 'created_at' },
        {
            data: null,
            render: function (data, type, row) {
                return `
                    <button class="btn btn-sm btn-warning editFaqBtn" data-id="${row.id}"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-danger deleteFaqBtn" data-id="${row.id}"><i class="bi bi-trash"></i></button>
                `;
            }
        }
    ],
    order: [[0, 'asc']],
    lengthMenu: [10, 20, 50, 100] // optional, defaults to [10, 25, 50, 100]
});


// Add FAQ
$('#addFaqForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: '../processes/insert_faq.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('#addFaqForm button[type="submit"]').prop('disabled', true);
        },
        success: function (response) {
            if (response.status === 'success') {
                showAlert(response.message, 'success');

                // Close the modal safely
                const addModalEl = document.getElementById('addFaqModal');
                const addModal = bootstrap.Modal.getInstance(addModalEl);
                if (addModal) {
                    addModal.hide();
                }

                // Reset form
                $('#addFaqForm')[0].reset();

                // Reload DataTable
                faqsTable.ajax.reload(null, false);

                // Ensure scroll is restored after modal is hidden
                setTimeout(() => {
                    $('body').css('overflow', '');
                    $('.modal-backdrop').remove();
                }, 200); // slight delay to ensure modal transition finishes

            } else {
                showAlert(response.message, 'danger');
            }
        },
        error: function () {
            showAlert('Something went wrong. Please try again.', 'danger');
        },
        complete: function () {
            $('#addFaqForm button[type="submit"]').prop('disabled', false);
        }
    });
});


// edit faq
// Open Edit FAQ modal and populate fields
$('#faqsTable').on('click', '.editFaqBtn', function () {
    const faqId = $(this).data('id');

    $.ajax({
        url: '../api/fetch_single_faq.php',
        type: 'GET',
        data: { id: faqId },
        dataType: 'json',
        success: function (faq) {
            $('#editFaqId').val(faq.id);
            $('#editFaqQuestion').val(faq.question);
            $('#editFaqAnswer').val(faq.answer);

            // Open modal
            const editModalEl = document.getElementById('editFaqModal');
            const editModal = bootstrap.Modal.getOrCreateInstance(editModalEl);
            editModal.show();
        },
        error: function () {
            showAlert('Failed to fetch FAQ details.', 'danger');
        }
    });
});
$('#editFaqForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: '../processes/update_faq.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('#editFaqForm button[type="submit"]').prop('disabled', true);
        },
        success: function (response) {
            if (response.status === 'success') {
                showAlert(response.message, 'success');

                // Close modal safely
                const editModalEl = document.getElementById('editFaqModal');
                const editModal = bootstrap.Modal.getInstance(editModalEl);
                if (editModal) editModal.hide();

                // Ensure scroll is restored and backdrop removed
                setTimeout(() => {
                    $('body').css('overflow', '');
                    $('.modal-backdrop').remove();
                }, 200);

                // Reload DataTable
                faqsTable.ajax.reload(null, false);
            } else {
                showAlert(response.message, 'danger');
            }
        },
        error: function () {
            showAlert('Something went wrong. Please try again.', 'danger');
        },
        complete: function () {
            $('#editFaqForm button[type="submit"]').prop('disabled', false);
        }
    });
});


// delete FAQ
// Open Delete FAQ modal
$('#faqsTable').on('click', '.deleteFaqBtn', function () {
    const faqId = $(this).data('id');
    $('#deleteFaqId').val(faqId);

    // Show modal
    const deleteModalEl = document.getElementById('deleteFaqModal');
    const deleteModal = bootstrap.Modal.getOrCreateInstance(deleteModalEl);
    deleteModal.show();
});
$('#confirmDeleteFaq').on('click', function () {
    const faqId = $('#deleteFaqId').val();

    if (!faqId) return;

    $.ajax({
        url: '../processes/delete_faq.php',
        type: 'POST',
        data: { id: faqId },
        dataType: 'json',
        beforeSend: function () {
            $('#confirmDeleteFaq').prop('disabled', true);
        },
        success: function (response) {
            if (response.status === 'success') {
                showAlert(response.message, 'success');

                // Close modal safely
                const deleteModalEl = document.getElementById('deleteFaqModal');
                const deleteModal = bootstrap.Modal.getInstance(deleteModalEl);
                if (deleteModal) deleteModal.hide();

                // Ensure scroll restored and backdrop removed
                setTimeout(() => {
                    $('body').css('overflow', '');
                    $('.modal-backdrop').remove();
                }, 200);

                // Reload DataTable
                faqsTable.ajax.reload(null, false);
            } else {
                showAlert(response.message, 'danger');
            }
        },
        error: function () {
            showAlert('Something went wrong. Please try again.', 'danger');
        },
        complete: function () {
            $('#confirmDeleteFaq').prop('disabled', false);
        }
    });
});
