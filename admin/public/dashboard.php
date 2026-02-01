<?php require_once '../processes/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="en">

<?php include("../views/head.php"); ?>

<body class="admin-body">


    <div class="admin-wrapper">

        <?php   include '../views/sidebar.php'; ?>

        <!-- Main Area -->
        <div class="main">

            <!-- Header -->
            <?php   include '../views/header.php'; ?>

            <main class="content">

                <h1>Dashboard Overview</h1>
                <p class="subtitle">Quick summary of pawnshop website</p>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="bi bi-megaphone"></i>
                        <div>
                            <h3>Active Ads</h3>
                            <span>4</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <i class="bi bi-gem"></i>
                        <div>
                            <h3>Subasta Items</h3>
                            <span>28</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <i class="bi bi-shop"></i>
                        <div>
                            <h3>Branches</h3>
                            <span>3</span>
                        </div>
                    </div>

                    <!-- <div class="stat-card">
                        <i class="bi bi-envelope"></i>
                        <div>
                            <h3>Unread Messages</h3>
                            <span class="alert">6</span>
                        </div>
                    </div> -->
                </div>

                <!-- Recent Activity -->
                <section class="panel">
                    <h2>Recent Activity</h2>
                    <ul class="activity-list">
                        <li>📩 New inquiry received from Contact Us</li>
                        <li>💎 New Subasta item added</li>
                        <li>📢 Ads section updated</li>
                        <li>🏪 Branch information modified</li>
                    </ul>
                </section>

                <!-- Quick Actions -->
                <section class="panel">
                    <h2>Quick Actions</h2>
                    <div class="actions">
                        <button class="btn-action">➕ Add New Ad</button>
                        <button class="btn-action">➕ Add Subasta Item</button>
                        <button class="btn-action">➕ Add Branch</button>
                        <button class="btn-action">📩 View Messages</button>
                    </div>
                </section>

            </main>


          <?php include("../views/footer.php"); ?>

        </div>
    </div>



</body>

</html>