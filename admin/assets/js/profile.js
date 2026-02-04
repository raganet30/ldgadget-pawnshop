  document.addEventListener("DOMContentLoaded", function () {

        const editModal = new bootstrap.Modal(document.getElementById("editProfileModal"));
        const passModal = new bootstrap.Modal(document.getElementById("changePasswordModal"));

        //  Open Modals
        document.getElementById("editProfileBtn").addEventListener("click", function (e) {
            e.preventDefault();
            editModal.show();
        });

        document.getElementById("changePasswordBtn").addEventListener("click", function (e) {
            e.preventDefault();
            passModal.show();
        });

        //  Auto Load User Data
        fetch("../api/fetch_single_user.php")
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("profileName").value = data.user.name;
                    document.getElementById("profileUsername").value = data.user.username;
                    document.getElementById("accountUsername").textContent = data.user.name;
                }
            });

        //  Submit Edit Profile via AJAX
        document.getElementById("editProfileForm").addEventListener("submit", function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch("../processes/edit_profile.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        //    bootsstrap alert for  <div id="AlertContainer"></div>
                        showAlert('success', 'Profile updated successfully!');
                        document.getElementById("accountUsername").textContent = data.new_name;
                        editModal.hide();
                    } else {
                        showAlert('danger', data.message);
                    }
                });
        });

        //  Submit Change Password via AJAX
        document.getElementById("changePasswordForm").addEventListener("submit", function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch("../processes/change_password.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', data.message);
                        this.reset();
                        passModal.hide();
                    } else {
                        showAlert('danger', data.message);
                    }
                });
        });



        // Bootstrap alert helper
        function showAlert(type, message) {
            const container = document.getElementById('AlertContainer');

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

    });
    