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

                <h1>Dashboard Overview</h1>
                <p class="subtitle">Quick summary of pawnshop website</p>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="bi bi-megaphone"></i>
                        <div>
                            <h3>Active Ads</h3>
                            <span></span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <i class="bi bi-tag"></i>
                        <div>
                            <h3>Subasta Items</h3>
                            <span></span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <i class="bi bi-shop"></i>
                        <div>
                            <h3>Branches</h3>
                            <span></span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <i class="bi bi-question-circle"></i>
                        <div>
                            <h3>FAQs</h3>
                            <span></span>
                        </div>
                    </div>


                </div>


            </main>


            <?php include("../views/footer.php"); ?>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('../api/fetch_dashboard_stats.php')
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const stats = data.data;
                        document.querySelector('.stat-card:nth-child(1) span').textContent = stats.ads;
                        document.querySelector('.stat-card:nth-child(2) span').textContent = stats.items;
                        document.querySelector('.stat-card:nth-child(3) span').textContent = stats.branches;
                        document.querySelector('.stat-card:nth-child(4) span').textContent = stats.faqs;
                    } else {
                        console.error('Failed to fetch stats:', data.message);
                    }
                })
                .catch(err => console.error('Error:', err));
        });
    </script>


</body>

</html>