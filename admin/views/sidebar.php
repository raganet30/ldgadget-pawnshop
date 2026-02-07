<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        Admin Panel
    </div>

    <ul class="sidebar-menu">
        <li data-page="dashboard.php" onclick="location.href='dashboard'">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </li>
        <li data-page="banner.php" onclick="location.href='banner'">
            <i class="bi bi-megaphone"></i>
            <span>Banner Section</span>
        </li>
        <li data-page="items.php" onclick="location.href='items'">
            <i class="bi bi-tag"></i>
            <span>Subasta Items</span>
        </li>
        <li data-page="branches.php" onclick="location.href='branches'">
            <i class="bi bi-shop"></i>
            <span>Branches</span>
        </li>
        <li data-page="faqs.php" onclick="location.href='faqs'">
            <i class="bi bi-question-circle"></i>
            <span>FAQs</span>
        </li>
    </ul>
</aside>
<script>
    (function () {
        const currentPage = "<?php echo basename($_SERVER['PHP_SELF']); ?>";
        const items = document.querySelectorAll('.sidebar-menu li');

        items.forEach(item => {
            if (item.dataset.page === currentPage) {
                item.classList.add('active');
            }
        });
    })();

    // toggle sidebar
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    }
</script>