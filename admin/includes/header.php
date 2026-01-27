<?php
// Safety: ensure auth + constants already loaded in layout.php
$page_title = $page_title ?? 'Admin Panel';
?>

<header class="header">
    <div class="header-left">
        <h1><?= htmlspecialchars($page_title) ?></h1>
    </div>

    <div class="header-actions">
        <a href="#" class="icon-link" title="Notifications">
            <i class="fas fa-bell"></i>
        </a>

        <a href="#" class="icon-link" title="Profile">
            <i class="fas fa-user-circle"></i>
        </a>
    </div>
</header>
<style></style>