<?php
$current = basename($_SERVER['PHP_SELF']);
$adminName = $_SESSION['admin_name'] ?? 'Administrator';
?>

<aside class="sidebar">

    <div class="sidebar-header">
        <i class="fas fa-layer-group"></i>
        <span>Admin Panel</span>
    </div>

    <nav class="sidebar-nav">
        <a href="dashboard.php" class="<?= $current === 'dashboard.php' ? 'active' : '' ?>">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        <a href="themes/themes.php" class="<?= $current === 'themes.php' ? 'active' : '' ?>">
            <i class="fas fa-palette"></i>
            <span>Themes</span>
        </a>

        <a href="settings.php" class="<?= $current === 'settings.php' ? 'active' : '' ?>">
            <i class="fas fa-settings"></i>
            <span>settings</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user">
            <strong><?= htmlspecialchars($adminName) ?></strong>
            <small>Administrator</small>
        </div>

        <a href="logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </div>

</aside>
