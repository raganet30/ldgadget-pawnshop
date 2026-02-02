$(document).ready(function () {

    // $('#itemsTable').DataTable({
    //     responsive: true,
    //     pageLength: 10
    // });

    // INSERT ITEM
    document.getElementById('addItemForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('name', addItemName.value);
        formData.append('category', addItemCategory.value);
        formData.append('description', addItemDescription.value);
        formData.append('price', addItemPrice.value);
        formData.append('status', addItemStatus.value);

        const images = addItemImages.files;
        for (let i = 0; i < images.length; i++) {
            formData.append('images[]', images[i]);
        }

        fetch('../processes/insert_item.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showItemAlert('success', 'Item successfully added!');

                    const modalEl = document.getElementById('addItemModal');
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

                    // Reset form AFTER modal is fully hidden
                    modalEl.addEventListener('hidden.bs.modal', () => {
                        this.reset();

                        // failsafe cleanup
                        document.body.classList.remove('modal-open');
                        document.body.style.paddingRight = '';
                        document
                            .querySelectorAll('.modal-backdrop')
                            .forEach(b => b.remove());
                    }, { once: true });

                    modal.hide();

                    // reload datatable
                    $('#itemsTable').DataTable().ajax.reload();

                } else {
                    showItemAlert('danger', data.message || 'Failed to add item.');
                }
            })
            .catch(err => {
                console.error(err);
                showItemAlert('danger', 'Something went wrong. Please try again.');
            });
    });



    // populate datatable
    $('#itemsTable').DataTable({
        processing: true,
        responsive: true,
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        ajax: {
            url: '../api/fetch_items.php',
            type: 'GET',
            dataSrc: function (json) {
                if (!json.success) return [];
                return json.data;
            }
        },
        columns: [
            {
                data: null,
                render: (data, type, row, meta) => meta.row + 1
            },
            {
                data: 'images',
                orderable: false,
                render: function (images) {
                    if (!images || images.length === 0) {
                        return `<span class="text-muted">No image</span>`;
                    }

                    const primary = images.find(img => img.is_primary == 1) || images[0];

                    return `
            <img 
                src="${primary.image_path}"
                class="img-thumbnail item-preview-img"
                width="50"
                style="cursor:pointer"
                data-images='${JSON.stringify(images)}'
                title="${images.length} image(s)"
            >
            <span class="badge bg-info ms-1">${images.length}</span>
        `;
                }
            },
            {
                data: null,
                render: row => `
                    <strong>${escapeHtml(row.name)}</strong><br>
                    <small class="text-muted">${escapeHtml(row.description || '')}</small>
                `
            },
            { data: 'category' },
            {
                data: 'price',
                render: price => `₱${Number(price).toLocaleString()}`
            },
            {
                data: 'status',
                render: status =>
                    status == 'available'
                        ? `<span class="badge bg-success">Available</span>`
                        : `<span class="badge bg-secondary">Sold</span>`
            },
            { data: 'created_at' },
            {
                data: 'id',
                orderable: false,
                className: 'text-center',
                render: id => `
                    <button class="btn btn-sm btn-warning editBtn" data-id="${id}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="${id}">
                        <i class="bi bi-trash"></i>
                    </button>
                `
            }
        ]
    });

    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }



    // edit item
    let editItemModalInstance;

    $(document).on('click', '.editBtn', function () {
        const itemId = $(this).data('id');

        fetch(`../api/fetch_single_item.php?id=${itemId}`)
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message || 'Failed to fetch item data');
                    return;
                }

                const item = data.data;

                // Populate form fields
                $('#editItemId').val(item.id);
                $('#editItemName').val(item.name);
                $('#editItemDescription').val(item.description);
                $('#editItemPrice').val(item.price);

                // Category select
                $('#editItemCategory').val(item.category);

                // Status select
                $('#editItemStatus').val(item.status == 'available' ? 'Available' : 'Sold');

                // Show current image filenames
                let currentImagesText = '';
                if (item.images && item.images.length > 0) {
                    currentImagesText = item.images.map(img => img.image_path.split('/').pop()).join(', ');
                } else {
                    currentImagesText = 'No images uploaded';
                }
                $('#currentImagesList').text(currentImagesText);

                // Clear file input
                $('#editItemImages').val('');

                // Show modal
                const modalEl = document.getElementById('editItemModal');
                editItemModalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                editItemModalInstance.show();
            })
            .catch(err => console.error('Fetch single item error:', err));
    });

    // Submit edit form (existing code)
    $('#editItemForm').on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('id', $('#editItemId').val());
        formData.append('name', $('#editItemName').val());
        formData.append('category', $('#editItemCategory').val());
        formData.append('description', $('#editItemDescription').val());
        formData.append('price', $('#editItemPrice').val());
        formData.append('status', $('#editItemStatus').val() === 'Available' ? 'available' : 'sold');

        // Append new images if any
        const files = $('#editItemImages')[0].files;
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }

        fetch('../processes/edit_item.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showItemAlert('success', 'Item updated successfully!');
                    editItemModalInstance.hide();
                    $('#itemsTable').DataTable().ajax.reload(null, false);
                } else {
                    showItemAlert('danger', data.message || 'Failed to update item.');
                }
            })
            .catch(err => {
                console.error(err);
                showItemAlert('danger', 'Something went wrong. Please try again.');
            });
    });



    // delete item
    let deleteItemModal = new bootstrap.Modal(document.getElementById('deleteItemModal'));

    // Open modal
    $(document).on('click', '.deleteBtn', function () {
        const itemId = $(this).data('id');
        $('#deleteItemId').val(itemId);
        deleteItemModal.show();
    });

    // Confirm delete
    $('#deleteItemModal .btn-danger').on('click', function () {
        const itemId = $('#deleteItemId').val();

        fetch('../processes/delete_item.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: itemId })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showItemAlert('success', data.message);
                    deleteItemModal.hide();
                    $('#itemsTable').DataTable().ajax.reload(null, false); // reload table
                } else {
                    showItemAlert('danger', data.message || 'Failed to delete item');
                }
            })
            .catch(err => {
                console.error(err);
                showItemAlert('danger', 'Something went wrong. Please try again.');
            });
    });


});

/* Bootstrap alert helper */
function showItemAlert(type, message) {
    const container = document.getElementById('adsAlertContainer');

    container.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) alert.remove();
    }, 4000);
}

let itemImageModal = new bootstrap.Modal(
    document.getElementById('itemImageModal')
);

$(document).on('click', '.item-preview-img', function () {
    const images = JSON.parse(this.dataset.images);

    if (!images.length) return;

    const mainImg = document.getElementById('modalMainImage');
    const thumbs = document.getElementById('modalThumbnails');

    thumbs.innerHTML = '';

    // show primary first
    const primary = images.find(img => img.is_primary == 1) || images[0];
    mainImg.src = primary.image_path;

    images.forEach(img => {
        const thumb = document.createElement('img');
        thumb.src = img.image_path;
        thumb.className = 'img-thumbnail';
        thumb.style.width = '60px';
        thumb.style.cursor = 'pointer';

        thumb.addEventListener('click', () => {
            mainImg.src = img.image_path;
        });

        thumbs.appendChild(thumb);
    });

    itemImageModal.show();
});
