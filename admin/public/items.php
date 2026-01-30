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

                <h1>Subasta Items Section</h1>
                <p class="subtitle">Manage all subasta items</p>


            </main>


            <?php include("../views/footer.php"); ?>

        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
    </script>

</body>

</html>