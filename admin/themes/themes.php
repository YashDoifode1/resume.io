<?php
// ===============================
// Bootstrap & Dependencies
// ===============================
require_once __DIR__ . '/../../config/path.php';
require_once BASE_PATH . '/config/database.php';

// Page meta
$page_title = 'Theme Management';
$page_subtitle = 'Manage, activate, and organize resume themes';

// ===============================
// Handle Bulk Actions FIRST
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_action'])) {

    if (!empty($_POST['selected_themes']) && is_array($_POST['selected_themes'])) {

        $themeIds = array_map('intval', $_POST['selected_themes']);
        $placeholders = implode(',', array_fill(0, count($themeIds), '?'));

        switch ($_POST['bulk_action']) {

            case 'activate':
                $stmt = $pdo->prepare("UPDATE themes SET is_active = 1 WHERE id IN ($placeholders)");
                $stmt->execute($themeIds);
                break;

            case 'deactivate':
                $stmt = $pdo->prepare("UPDATE themes SET is_active = 0 WHERE id IN ($placeholders)");
                $stmt->execute($themeIds);
                break;

            case 'delete':
                // Remove theme files
                $stmt = $pdo->prepare("SELECT file_name FROM themes WHERE id IN ($placeholders)");
                $stmt->execute($themeIds);
                $files = $stmt->fetchAll(PDO::FETCH_COLUMN);

                foreach ($files as $file) {
                    $path = BASE_PATH . '/themes/' . $file;
                    if ($file && file_exists($path)) {
                        unlink($path);
                    }
                }

                $stmt = $pdo->prepare("DELETE FROM themes WHERE id IN ($placeholders)");
                $stmt->execute($themeIds);
                break;
        }

        header('Location: themes.php');
        exit;
    }
}

// ===============================
// Fetch Themes
// ===============================
$stmt = $pdo->query("
    SELECT *
    FROM themes
    ORDER BY is_premium DESC, is_active DESC, name ASC
");
$themes = $stmt->fetchAll();

// ===============================
// Layout Includes
// ===============================
require_once '../includes/layout.php';
require_once '../includes/sidebar.php';
?>

<div class="main">
    <?php require_once '../includes/header.php'; ?>

    <main class="content">

        <!-- PAGE HEADER -->
        <div class="page-head page-head-actions">
            <div>
                <h2><?= htmlspecialchars($page_title) ?></h2>
                <p><?= htmlspecialchars($page_subtitle) ?></p>
            </div>

            <button class="btn-primary" onclick="openModal('addThemeModal')">
                <i class="fas fa-plus"></i>
                Add Theme
            </button>
        </div>

        <!-- BULK ACTIONS -->
        <form method="post" class="bulk-actions" id="bulkActionForm">

            <label class="bulk-select">
                <input type="checkbox" id="selectAll">
                Select All
            </label>

            <select name="bulk_action" class="btn-secondary">
                <option value="">Bulk Actions</option>
                <option value="activate">Activate</option>
                <option value="deactivate">Deactivate</option>
                <option value="delete">Delete</option>
            </select>

            <button class="btn-primary" onclick="return confirmBulkAction()">Apply</button>
        </form>

        <!-- THEMES TABLE -->
        <div class="themes-table-wrapper">
            <table class="themes-table">
                <thead>
                    <tr>
                        <th width="40"></th>
                        <th>Theme</th>
                        <th>Slug</th>
                        <th>Key</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Created</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($themes as $theme): ?>
                    <tr>

                        <td>
                            <input type="checkbox"
                                   class="theme-checkbox"
                                   name="selected_themes[]"
                                   value="<?= (int)$theme['id'] ?>">
                        </td>

                        <td>
                            <strong><?= htmlspecialchars($theme['name']) ?></strong>
                            <div class="muted"><?= htmlspecialchars($theme['description']) ?></div>
                        </td>

                        <td><code><?= htmlspecialchars($theme['slug']) ?></code></td>
                        <td><code><?= htmlspecialchars($theme['theme_key']) ?></code></td>
                        <td><?= htmlspecialchars($theme['file_name']) ?></td>

                        <td>
                            <span class="badge <?= $theme['is_active'] ? 'active' : 'inactive' ?>">
                                <?= $theme['is_active'] ? 'Active' : 'Disabled' ?>
                            </span>
                        </td>

                        <td>
                            <span class="badge <?= $theme['is_premium'] ? 'premium' : 'free' ?>">
                                <?= $theme['is_premium'] ? 'Premium' : 'Free' ?>
                            </span>
                        </td>

                        <td>
                            <?= date('M d, Y', strtotime($theme['created_at'])) ?>
                        </td>

                        <td class="action-buttons">

                            <button class="btn-secondary"
    onclick="openEditTheme(
        <?= (int)$theme['id'] ?>,
        '<?= htmlspecialchars($theme['name'], ENT_QUOTES) ?>',
        '<?= htmlspecialchars($theme['slug'], ENT_QUOTES) ?>',
        '<?= htmlspecialchars($theme['theme_key'], ENT_QUOTES) ?>',
        '<?= htmlspecialchars($theme['description'], ENT_QUOTES) ?>',
        '<?= htmlspecialchars($theme['icon'], ENT_QUOTES) ?>',
        <?= (int)$theme['is_premium'] ?>
    )">
    <i class="fas fa-edit"></i>
</button>


                            <form method="post" action="theme-delete.php"
                                  onsubmit="return confirm('Delete this theme?')">
                                <input type="hidden" name="id" value="<?= (int)$theme['id'] ?>">
                                <button class="btn-danger">
                                    <i class="fas fa-trash"></i>
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
        <h2>Add Theme</h2>

        <input name="name" placeholder="Theme name" required>
        <input name="slug" placeholder="Slug" required>
        <input name="theme_key" placeholder="Key" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input name="icon" placeholder="✨">

        <label class="checkbox">
            <input type="checkbox" name="is_premium">
            Premium
        </label>

        <input type="file" name="theme_file" accept=".php" required>

        <div class="modal-actions">
            <button class="btn-primary">Save</button>
            <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
        </div>
    </form>
</div>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}

function closeModal() {
    document.querySelectorAll('.modal').forEach(m => m.style.display = 'none');
}

function confirmBulkAction() {
    const checked = document.querySelectorAll('.theme-checkbox:checked');
    const action = document.querySelector('[name="bulk_action"]').value;

    if (!checked.length) {
        alert('Select at least one theme');
        return false;
    }

    if (!action) {
        alert('Select a bulk action');
        return false;
    }

    return action !== 'delete' || confirm('This cannot be undone. Continue?');
}

document.getElementById('selectAll')?.addEventListener('change', e => {
    document.querySelectorAll('.theme-checkbox')
        .forEach(cb => cb.checked = e.target.checked);
});
</script>

<?php require_once '../includes/footer.php'; ?>
<style>/* ===============================
   ROOT VARIABLES
=============================== */
:root {
    --sidebar-width: 260px;
    --bg-main: #f4f6fb;
    --bg-panel: #ffffff;
    --bg-sidebar: #0f172a;

    --primary: #2563eb;
    --success: #16a34a;
    --danger: #dc2626;
    --warning: #f59e0b;

    --text-main: #1f2937;
    --text-muted: #6b7280;
    --text-light: #cbd5f5;

    --border: #e5e7eb;
    --radius: 10px;
}

/* ===============================
   RESET & BASE
=============================== */
*,
*::before,
*::after {
    box-sizing: border-box;
}

html, body {
    margin: 0;
    height: 100%;
    font-family: 'Inter', system-ui, sans-serif;
    background: var(--bg-main);
    color: var(--text-main);
}

/* ===============================
   MAIN LAYOUT
=============================== */
.admin-wrapper,
.admin {
    display: flex;
    min-height: 100vh;
}

/* ===============================
   SIDEBAR
=============================== */
.sidebar {
    width: var(--sidebar-width);
    background: var(--bg-sidebar);
    color: var(--text-light);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

.sidebar h2,
.sidebar-header {
    padding: 20px;
    font-size: 18px;
    font-weight: 600;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.sidebar a {
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--text-light);
    text-decoration: none;
    transition: background 0.2s ease;
}

.sidebar a:hover {
    background: rgba(255,255,255,0.08);
}

.sidebar a.active {
    background: var(--primary);
    color: #fff;
}

/* ===============================
   MAIN AREA
=============================== */
.main {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
}

/* ===============================
   HEADER (TOP BAR)
=============================== */
.header,
.topbar {
    height: 72px;
    background: var(--bg-panel);
    border-bottom: 1px solid var(--border);
    padding: 0 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header h1,
.topbar h1 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.header .actions,
.header-actions {
    display: flex;
    align-items: center;
    gap: 18px;
}

.header i {
    font-size: 18px;
    color: var(--text-muted);
    cursor: pointer;
}

/* ===============================
   CONTENT
=============================== */
.content,
.main-content {
    padding: 28px;
    flex: 1;
}

/* ===============================
   PAGE HEADER
=============================== */
.page-head,
.page-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.page-head h2,
.page-bar h2 {
    margin: 0;
    font-size: 22px;
    font-weight: 600;
}

.page-head p {
    margin: 4px 0 0;
    color: var(--text-muted);
}

/* ===============================
   BUTTONS
=============================== */
button {
    font-family: inherit;
    border: none;
    border-radius: 8px;
    padding: 9px 14px;
    font-size: 14px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-primary,
.primary {
    background: var(--primary);
    color: #fff;
}

.btn-secondary,
.secondary {
    background: #e5e7eb;
    color: #111827;
}

.btn-danger,
.danger {
    background: var(--danger);
    color: #fff;
}

/* ===============================
   BULK ACTION BAR
=============================== */
.bulk-actions,
.bulk {
    background: var(--bg-panel);
    border: 1px solid var(--border);
    padding: 14px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
}

.bulk-actions select,
.bulk select {
    padding: 8px;
    border-radius: 6px;
    border: 1px solid var(--border);
}

/* ===============================
   TABLE
=============================== */
.themes-table-wrapper,
.table-wrap {
    background: var(--bg-panel);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow-x: auto;
}

.themes-table,
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
}

.themes-table th,
.themes-table td,
table th,
table td {
    padding: 14px;
    border-bottom: 1px solid var(--border);
    vertical-align: top;
}

.themes-table th,
table th {
    background: #f9fafb;
    font-size: 12px;
    text-transform: uppercase;
    color: var(--text-muted);
}

.muted {
    font-size: 13px;
    color: var(--text-muted);
}

.action-buttons,
.actions {
    display: flex;
    gap: 8px;
}

/* ===============================
   BADGES
=============================== */
.badge {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 500;
}

.badge.active {
    background: #dcfce7;
    color: var(--success);
}

.badge.inactive {
    background: #fee2e2;
    color: var(--danger);
}

.badge.premium {
    background: #fff7ed;
    color: var(--warning);
}

.badge.free {
    background: #e5e7eb;
    color: #374151;
}

/* ===============================
   MODAL
=============================== */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-box {
    background: var(--bg-panel);
    padding: 24px;
    border-radius: var(--radius);
    width: 100%;
    max-width: 420px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.modal-box input,
.modal-box textarea {
    padding: 10px;
    border-radius: 6px;
    border: 1px solid var(--border);
    font-family: inherit;
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* ===============================
   RESPONSIVE SAFETY
=============================== */
@media (max-width: 1024px) {
    .sidebar {
        width: 220px;
    }
}

@media (max-width: 768px) {
    .page-head,
    .page-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .content,
    .main-content {
        padding: 20px;
    }
}
</style>
<div class="modal" id="editThemeModal">
    <form class="modal-box" method="post" action="theme-update.php">
        <h2>Edit Theme</h2>

        <input type="hidden" name="id" id="edit_id">

        <input name="name" id="edit_name" placeholder="Theme name" required>
        <input name="slug" id="edit_slug" placeholder="Slug" required>
        <input name="theme_key" id="edit_key" placeholder="Key" required>
        <textarea name="description" id="edit_desc" placeholder="Description"></textarea>
        <input name="icon" id="edit_icon" placeholder="Icon">

        <label>
            <input type="checkbox" name="is_premium" id="edit_premium">
            Premium
        </label>

        <div class="modal-actions">
            <button class="btn-primary">Update</button>
            <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
        </div>
    </form>
</div>
<script>
function openEditTheme(id, name, slug, key, desc, icon, premium) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_key').value = key;
    document.getElementById('edit_desc').value = desc;
    document.getElementById('edit_icon').value = icon;
    document.getElementById('edit_premium').checked = premium === 1;

    document.getElementById('editThemeModal').style.display = 'flex';
}

function closeModal() {
    document.querySelectorAll('.modal').forEach(m => m.style.display = 'none');
}
</script>
