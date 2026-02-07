// Modal Open/Close
function openAddAdModal() {
    const modal = new bootstrap.Modal(document.getElementById('addAdModal'));
    modal.show();
}

function openEditAdModal() { document.getElementById('editAdModal').style.display = 'block'; }
function closeEditAdModal() { document.getElementById('editAdModal').style.display = 'none'; }

// Image Preview for Add Modal
document.getElementById('addAdFile').addEventListener('change', function (e) {
    const preview = document.getElementById('addAdFilePreview');
    const file = e.target.files[0];

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    } else {
        preview.classList.add('d-none');
    }
});

let adsDataTable;

document.addEventListener('DOMContentLoaded', () => {
    adsDataTable = $('#adsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [10, 20, 50, 100],
        dom: `<'row mb-3'
                <'col-md-6'l>
                <'col-md-6'f>
             >
             rt
             <'row mt-3'
                <'col-md-5'i>
                <'col-md-7'p>
             >`,
        columnDefs: [
            { orderable: false, targets: [0, 4] }
        ]
    });

    fetchAds();
});
function fetchAds() {
    fetch('../api/fetch_ads.php')
        .then(res => res.json())
        .then(data => {

            // Clear DataTable rows (NOT tbody.innerHTML)
            adsDataTable.clear();

            if (!data.success || data.data.length === 0) {
                adsDataTable.draw();
                return;
            }

            data.data.forEach(ad => {
                const statusBadge = ad.status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-secondary">Inactive</span>';

                adsDataTable.row.add([
                    `
                    <img src="${ad.image}" alt="Banner Image"
                         class="img-thumbnail"
                         style="max-width:80px; cursor: zoom-in;"
                         onclick="openImageZoom(this.src)">
                    `,
                    escapeHtml(ad.title),
                    escapeHtml(ad.description),
                    statusBadge,
                    `
                    <button class="btn btn-sm btn-warning"
                        onclick="openEditAdModal(${ad.id})">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger"
                        onclick="deleteAd(${ad.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                    `
                ]);
            });

            adsDataTable.draw();
        })
        .catch(err => {
            console.error('Fetch ads error:', err);
        });
}


/* Prevent XSS / broken layout */
function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
}


// add new ads 
document.getElementById('addAdForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append('title', document.getElementById('addAdTitle').value);
    formData.append('description', document.getElementById('addAdDescription').value);
    formData.append('status', document.getElementById('addAdStatus').value);

    const fileInput = document.getElementById('addAdFile');
    if (fileInput.files.length > 0) {
        formData.append('image', fileInput.files[0]);
    }

    fetch('../processes/insert_new_ads.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showAdsAlert('success', 'Ad successfully added!');

                //hide/close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addAdModal'));
                modal.hide();

                document.getElementById('addAdForm').reset();
                document.getElementById('addAdFilePreview').style.display = 'none';
                // reload datatable
                fetchAds();
            } else {
                showAdsAlert('danger', data.message || 'Failed to add ad.');
            }
        })
        .catch(err => {
            console.error(err);
            showAdsAlert('danger', 'Something went wrong. Please try again.');
        });
});

// Bootstrap alert helper
function showAdsAlert(type, message) {
    const container = document.getElementById('adsAlertContainer');

    container.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    // Auto-dismiss after 4 seconds
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) alert.classList.remove('show');
    }, 4000);
}




// edit ads
let editAdModalInstance;

function openEditAdModal(adId) {
    // Fetch single ad info from API
    fetch(`../api/fetch_single_ad.php?id=${adId}`)
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Failed to fetch ad');
                return;
            }

            const ad = data.data;

            document.getElementById('editAdId').value = ad.id;
            document.getElementById('editAdTitle').value = ad.title;
            document.getElementById('editAdDescription').value = ad.description;
            document.getElementById('editAdStatus').value = ad.status;

            const preview = document.getElementById('editAdFilePreview');
            if (ad.image) {
                preview.src = ad.image;
                preview.classList.remove('d-none');
            } else {
                preview.classList.add('d-none');
            }

            // Show Bootstrap modal
            editAdModalInstance = new bootstrap.Modal(document.getElementById('editAdModal'));
            editAdModalInstance.show();
        })
        .catch(err => console.error(err));
}

// Image preview for Edit modal
document.getElementById('editAdFile').addEventListener('change', function (e) {
    const preview = document.getElementById('editAdFilePreview');
    const file = e.target.files[0];

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    } else {
        preview.classList.add('d-none');
    }
});

// Submit Edit Ad form
document.getElementById('editAdForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append('id', document.getElementById('editAdId').value);
    formData.append('title', document.getElementById('editAdTitle').value);
    formData.append('description', document.getElementById('editAdDescription').value);
    formData.append('status', document.getElementById('editAdStatus').value);

    const fileInput = document.getElementById('editAdFile');
    if (fileInput.files.length > 0) {
        formData.append('image', fileInput.files[0]);
    }

    fetch('../processes/edit_ad.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showAdsAlert('success', 'Ad updated successfully!');
                // Close modal and refresh table
                editAdModalInstance.hide();
                fetchAds(); // reload table
            } else {
                alert(data.message || 'Failed to update ad');
            }
        })
        .catch(err => console.error(err));
});



// zoom ad image 
const imageZoomModal = new bootstrap.Modal(
    document.getElementById('imageZoomModal')
);

function openImageZoom(src) {
    const zoomedImg = document.getElementById('zoomedImage');
    zoomedImg.src = src;
    imageZoomModal.show();
}



// delete ads
let deleteModal = new bootstrap.Modal(document.getElementById('deleteAdModal'));

function deleteAd(adId) {
    document.getElementById('deleteAdId').value = adId;
    document.getElementById('deleteAlert').innerHTML = '';
    deleteModal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    const adId = document.getElementById('deleteAdId').value;

    fetch('../processes/delete_ad.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: adId })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showAdsAlert('success', data.message || 'Ad deleted successfully!');
                // Close modal and refresh table
                deleteModal.hide();
                fetchAds(); // refresh table

            } else {
                showAdsAlert('danger', data.message || 'Failed to delete ad.');
                // Close modal and refresh table
                deleteModal.hide();
            }
        })
        .catch(() => {

        });
});

