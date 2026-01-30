<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        Admin Panel
    </div>

    <ul class="sidebar-menu">
        <li data-page="dashboard.php" onclick="location.href='dashboard.php'">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </li>
        <li data-page="ads.php" onclick="location.href='ads.php'">
            <i class="bi bi-megaphone"></i>
            <span>Ads Section</span>
        </li>
        <li data-page="items.php" onclick="location.href='items.php'">
            <i class="bi bi-gem"></i>
            <span>Subasta Items</span>
        </li>
        <li data-page="branches.php" onclick="location.href='branches.php'">
            <i class="bi bi-shop"></i>
            <span>Branches</span>
        </li>
        <li data-page="contact.php" onclick="location.href='contact.php'">
            <i class="bi bi-envelope"></i>
            <span>Contact Us</span>
        </li>
        <li data-page="faqs.php" onclick="location.href='faqs.php'">
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
</script>
