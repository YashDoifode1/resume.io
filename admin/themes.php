<?php
require_once __DIR__ . '/../config/database.php';

include 'includes/header.php';
include 'includes/sidebar.php';

/* ==========================
   Fetch Themes
========================== */
$stmt = $pdo->query("SELECT * FROM themes ORDER BY id DESC");
$themes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-content" style="flex:1;">
    <?php include 'includes/topbar.php'; ?>
    <style>.btn-primary {
    background: #4f46e5;
    color: #fff;
    border: none;
    padding: 10px 16px;
    border-radius: 10px;
    cursor: pointer;
}

.btn-secondary {
    background: #e5e7eb;
    padding: 10px 16px;
    border-radius: 10px;
    border: none;
}

.modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.4);
    display: none;
    align-items: center;
    justify-content: center;
}

.modal-box {
    background: #fff;
    padding: 24px;
    border-radius: 16px;
    width: 420px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.modal-box input,
.modal-box textarea {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
</style>

    <main class="themes-page">

        <div class="page-header">
            <div>
                <h1>Manage Themes</h1>
                <p>Add, enable, disable or manage resume themes</p>
            </div>

            <!-- Add Theme Button -->
            <button onclick="document.getElementById('addThemeModal').style.display='flex'"
                    class="btn-primary">
                <i class="fas fa-plus"></i> Add Theme
            </button>
        </div>

        <!-- THEMES TABLE -->
        <div class="themes-table-wrapper">
            <table class="themes-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Theme</th>
                        <th>Key</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Premium</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($themes as $i => $theme): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>

                        <td>
                            <div class="theme-info">
                                <span class="icon"><?= htmlspecialchars($theme['icon']) ?></span>
                                <div>
                                    <strong><?= htmlspecialchars($theme['name']) ?></strong>
                                    <small><?= htmlspecialchars($theme['description']) ?></small>
                                </div>
                            </div>
                        </td>

                        <td><?= htmlspecialchars($theme['theme_key']) ?></td>
                        <td><?= htmlspecialchars($theme['file_name']) ?></td>

                        <td>
                            <span class="badge <?= $theme['is_active'] ? 'active' : 'inactive' ?>">
                                <?= $theme['is_active'] ? 'Active' : 'Disabled' ?>
                            </span>
                        </td>

                        <td>
                            <?php
                            $isPremium = $theme['is_premium'] ?? 0;
                            ?>
                            <span class="badge <?= $isPremium ? 'premium' : 'free' ?>">
                                <?= $isPremium ? 'Premium' : 'Free' ?>
                            </span>
                        </td>

                        <td>
                            <form method="post" action="theme-toggle.php">
                                <input type="hidden" name="id" value="<?= $theme['id'] ?>">
                                <button class="btn-toggle <?= $theme['is_active'] ? 'disable' : 'enable' ?>">
                                    <?= $theme['is_active'] ? 'Disable' : 'Enable' ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </main>
</div>

<!-- ADD THEME MODAL -->
<div class="modal" id="addThemeModal">
    <form class="modal-box" method="post" action="theme-add.php" enctype="multipart/form-data">
        <h2>Add New Theme</h2>

        <label>Theme Name</label>
        <input type="text" name="name" required>

        <label>Theme Key (unique)</label>
        <input type="text" name="theme_key" required placeholder="e.g. modern_plus">

        <label>Description</label>
        <textarea name="description"></textarea>

        <label>Icon (emoji)</label>
        <input type="text" name="icon" placeholder="🎨">

        <label>Theme PHP File</label>
        <input type="file" name="theme_file" accept=".php" required>

        <label>
            <input type="checkbox" name="is_premium"> Premium Theme
        </label>

        <div class="modal-actions">
            <button type="submit" class="btn-primary">Upload</button>
            <button type="button" class="btn-secondary"
                onclick="document.getElementById('addThemeModal').style.display='none'">
                Cancel
            </button>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
