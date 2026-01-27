<?php
require_once __DIR__ . '/../config/database.php';
include 'includes/header.php';
include 'includes/sidebar.php';

// Fetch Themes with all columns
$stmt = $pdo->query("SELECT * FROM themes ORDER BY is_premium DESC, is_active DESC, name ASC");
$themes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle bulk actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_action'])) {
    if (isset($_POST['selected_themes']) && !empty($_POST['selected_themes'])) {
        $theme_ids = $_POST['selected_themes'];
        $placeholders = implode(',', array_fill(0, count($theme_ids), '?'));
        
        switch ($_POST['bulk_action']) {
            case 'activate':
                $stmt = $pdo->prepare("UPDATE themes SET is_active = 1 WHERE id IN ($placeholders)");
                $stmt->execute($theme_ids);
                break;
            case 'deactivate':
                $stmt = $pdo->prepare("UPDATE themes SET is_active = 0 WHERE id IN ($placeholders)");
                $stmt->execute($theme_ids);
                break;
            case 'delete':
                // Delete theme files first (if they exist in themes directory)
                $stmt = $pdo->prepare("SELECT file_name FROM themes WHERE id IN ($placeholders)");
                $stmt->execute($theme_ids);
                $files_to_delete = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                foreach ($files_to_delete as $file) {
                    $file_path = __DIR__ . "/../themes/" . $file;
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                
                $stmt = $pdo->prepare("DELETE FROM themes WHERE id IN ($placeholders)");
                $stmt->execute($theme_ids);
                break;
        }
        
        // Refresh page
        header("Location: themes.php");
        exit();
    }
}
?>

<div class="admin-content" style="flex:1;">
    <?php include 'includes/topbar.php'; ?>
    
    <style>
        /* Enhanced Professional Styles */
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #4338ca, #6d28d9);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        
        .btn-secondary {
            background: #f8fafc;
            color: #475569;
            padding: 10px 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-secondary:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        
        .btn-danger {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        
        .btn-danger:hover {
            background: #dc2626;
        }
        
        .btn-success {
            background: #10b981;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        
        .btn-success:hover {
            background: #059669;
        }
        
        .btn-warning {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        
        .btn-warning:hover {
            background: #d97706;
        }
        
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }
        
        .modal-box {
            background: #fff;
            padding: 32px;
            border-radius: 16px;
            width: 480px;
            max-width: 90vw;
            display: flex;
            flex-direction: column;
            gap: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,.1);
        }
        
        .modal-box input,
        .modal-box textarea,
        .modal-box select {
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            font-size: 14px;
            transition: border-color 0.2s ease;
        }
        
        .modal-box input:focus,
        .modal-box textarea:focus,
        .modal-box select:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 8px;
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .badge.active {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge.inactive {
            background: #f3f4f6;
            color: #6b7280;
        }
        
        .badge.premium {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #78350f;
        }
        
        .badge.free {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .theme-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .theme-info .icon {
            font-size: 24px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border-radius: 8px;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .bulk-actions {
            background: #f8fafc;
            padding: 16px 24px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .bulk-select {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .bulk-select input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        .preview-thumbnail {
            width: 60px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 12px;
        }
        
        .preview-thumbnail.has-thumb {
            background-size: cover;
            background-position: center;
        }
        
        .status-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .3s;
            border-radius: 34px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: #10b981;
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(20px);
        }
    </style>

    <main class="themes-page">
        <div class="page-header">
            <div>
                <h1>Theme Management</h1>
                <p>Design and customize resume templates</p>
            </div>
            <button onclick="document.getElementById('addThemeModal').style.display='flex'"
                    class="btn-primary">
                <i class="fas fa-plus"></i> Add New Theme
            </button>
        </div>

        <!-- BULK ACTIONS -->
        <form method="post" class="bulk-actions" id="bulkActionForm">
            <div class="bulk-select" onclick="toggleAllCheckboxes()">
                <input type="checkbox" id="selectAll">
                <span>Select All</span>
            </div>
            
            <select name="bulk_action" class="btn-secondary" style="padding: 8px 16px;">
                <option value="">Bulk Actions</option>
                <option value="activate">Activate Selected</option>
                <option value="deactivate">Deactivate Selected</option>
                <option value="delete">Delete Selected</option>
            </select>
            
            <button type="submit" class="btn-primary" name="apply_bulk_action" 
                    onclick="return confirmBulkAction()">
                Apply
            </button>
        </form>

        <!-- THEMES TABLE -->
        <div class="themes-table-wrapper">
            <table class="themes-table">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" onclick="toggleAllCheckboxes()">
                        </th>
                        <th>Theme</th>
                        <th>Slug</th>
                        <th>Key</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($themes as $theme): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_themes[]" 
                                   value="<?= $theme['id'] ?>" 
                                   class="theme-checkbox">
                        </td>
                        
                        <td>
                            <div class="theme-info">
                                <span class="icon"><?= htmlspecialchars($theme['icon']) ?></span>
                                <div>
                                    <strong><?= htmlspecialchars($theme['name']) ?></strong>
                                    <small><?= htmlspecialchars($theme['description']) ?></small>
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <code><?= htmlspecialchars($theme['slug']) ?></code>
                        </td>
                        
                        <td>
                            <code><?= htmlspecialchars($theme['theme_key']) ?></code>
                        </td>
                        
                        <td>
                            <small><?= htmlspecialchars($theme['file_name']) ?></small>
                        </td>
                        
                        <td>
                            <form method="post" action="theme-toggle.php" class="status-toggle">
                                <input type="hidden" name="id" value="<?= $theme['id'] ?>">
                                <label class="toggle-switch">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           value="1"
                                           <?= $theme['is_active'] ? 'checked' : '' ?>
                                           onchange="this.form.submit()">
                                    <span class="toggle-slider"></span>
                                </label>
                                <span class="badge <?= $theme['is_active'] ? 'active' : 'inactive' ?>">
                                    <?= $theme['is_active'] ? 'Active' : 'Disabled' ?>
                                </span>
                            </form>
                        </td>
                        
                        <td>
                            <span class="badge <?= $theme['is_premium'] ? 'premium' : 'free' ?>">
                                <?= $theme['is_premium'] ? 'Premium' : 'Free' ?>
                            </span>
                        </td>
                        
                        <td>
                            <small><?= date('M d, Y', strtotime($theme['created_at'])) ?></small>
                        </td>
                        
                        <td>
                            <div class="action-buttons">
                                <!-- Edit Button -->
                                <button onclick="openEditModal(
                                    <?= $theme['id'] ?>,
                                    '<?= htmlspecialchars($theme['name'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($theme['slug'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($theme['theme_key'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($theme['description'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($theme['icon'], ENT_QUOTES) ?>',
                                    <?= $theme['is_premium'] ?>,
                                    '<?= htmlspecialchars($theme['thumbnail'] ?? '', ENT_QUOTES) ?>'
                                )" class="btn-secondary">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <!-- Delete Button -->
                                <form method="post" action="theme-delete.php" 
                                      onsubmit="return confirm('Delete this theme?')" 
                                      style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $theme['id'] ?>">
                                    <button type="submit" class="btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
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
        
        <label>Theme Name *</label>
        <input type="text" name="name" required placeholder="Modern Minimal">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div>
                <label>Slug *</label>
                <input type="text" name="slug" required placeholder="modern-minimal">
            </div>
            <div>
                <label>Theme Key *</label>
                <input type="text" name="theme_key" required placeholder="modern_minimal">
            </div>
        </div>
        
        <label>Description</label>
        <textarea name="description" rows="3" placeholder="Clean and minimal design for modern professionals"></textarea>
        
        <label>Icon (emoji)</label>
        <input type="text" name="icon" placeholder="✨">
        
        <label>Thumbnail Image</label>
        <input type="file" name="thumbnail" accept="image/*">
        
        <label>Theme PHP File *</label>
        <input type="file" name="theme_file" accept=".php" required>
        
        <div style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" name="is_premium" id="is_premium">
            <label for="is_premium">Premium Theme</label>
        </div>
        
        <div class="modal-actions">
            <button type="submit" class="btn-primary">Upload Theme</button>
            <button type="button" class="btn-secondary"
                onclick="document.getElementById('addThemeModal').style.display='none'">
                Cancel
            </button>
        </div>
    </form>
</div>

<!-- EDIT THEME MODAL -->
<div class="modal" id="editThemeModal">
    <form class="modal-box" method="post" action="theme-edit.php" enctype="multipart/form-data">
        <h2>Edit Theme</h2>
        <input type="hidden" name="id" id="edit_id">
        
        <label>Theme Name *</label>
        <input type="text" name="name" id="edit_name" required>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div>
                <label>Slug *</label>
                <input type="text" name="slug" id="edit_slug" required>
            </div>
            <div>
                <label>Theme Key *</label>
                <input type="text" name="theme_key" id="edit_theme_key" required>
            </div>
        </div>
        
        <label>Description</label>
        <textarea name="description" id="edit_description" rows="3"></textarea>
        
        <label>Icon (emoji)</label>
        <input type="text" name="icon" id="edit_icon">
        
        <label>Thumbnail Image</label>
        <input type="file" name="thumbnail" accept="image/*">
        <small>Current: <span id="current_thumbnail"></span></small>
        
        <div style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" name="is_premium" id="edit_is_premium">
            <label for="edit_is_premium">Premium Theme</label>
        </div>
        
        <div class="modal-actions">
            <button type="submit" class="btn-primary">Save Changes</button>
            <button type="button" class="btn-secondary"
                onclick="document.getElementById('editThemeModal').style.display='none'">
                Cancel
            </button>
        </div>
    </form>
</div>

<script>
// Toggle all checkboxes
function toggleAllCheckboxes() {
    const checkboxes = document.querySelectorAll('.theme-checkbox');
    const selectAll = document.getElementById('selectAll');
    const isChecked = selectAll.checked;
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = !isChecked;
    });
    selectAll.checked = !isChecked;
}

// Confirm bulk action
function confirmBulkAction() {
    const form = document.getElementById('bulkActionForm');
    const action = form.bulk_action.value;
    const checkboxes = document.querySelectorAll('.theme-checkbox:checked');
    
    if (checkboxes.length === 0) {
        alert('Please select at least one theme');
        return false;
    }
    
    if (!action) {
        alert('Please select a bulk action');
        return false;
    }
    
    if (action === 'delete') {
        return confirm(`Are you sure you want to delete ${checkboxes.length} theme(s)? This action cannot be undone.`);
    }
    
    return true;
}

// Open edit modal with current values
function openEditModal(id, name, slug, themeKey, description, icon, isPremium, thumbnail) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_theme_key').value = themeKey;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_icon').value = icon;
    document.getElementById('edit_is_premium').checked = isPremium == 1;
    document.getElementById('current_thumbnail').textContent = thumbnail || 'No thumbnail';
    
    document.getElementById('editThemeModal').style.display = 'flex';
}

// Close modals on outside click
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?>