<div class="admin-topbar">
    <!-- Left Section: Page Title and Breadcrumb -->
    <div class="topbar-left">
        <div class="page-title">
            <h1 id="pageTitle"><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></h1>
            <?php if (isset($page_subtitle)): ?>
                <p class="page-subtitle"><?php echo $page_subtitle; ?></p>
            <?php endif; ?>
        </div>
        
        <nav class="breadcrumb">
            <a href="dashboard.php" class="breadcrumb-item">
                <i class="fas fa-home"></i>
            </a>
            <span class="breadcrumb-divider">/</span>
            <?php 
            $current_page = basename($_SERVER['PHP_SELF'], '.php');
            $page_names = [
                'dashboard' => 'Dashboard',
                'themes' => 'Themes',
                'users' => 'Users',
                'resumes' => 'Resumes',
                'settings' => 'Settings',
                'profile' => 'Profile'
            ];
            ?>
            <span class="breadcrumb-current"><?php echo $page_names[$current_page] ?? ucfirst($current_page); ?></span>
        </nav>
    </div>

    <!-- Center Section: Search and Quick Actions -->
    <div class="topbar-center">
        <div class="search-container">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="globalSearch" placeholder="Search themes, users, resumes...">
                <div class="search-shortcut">Ctrl + K</div>
            </div>
            
            <div class="quick-actions">
                <button class="quick-action-btn" onclick="showHelp()" title="Help">
                    <i class="fas fa-question-circle"></i>
                </button>
                <button class="quick-action-btn" onclick="toggleNotifications()" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Right Section: Admin Profile and Controls -->
    <div class="topbar-right">
        <div class="admin-controls">
            <!-- Theme Toggle -->
            <div class="theme-toggle">
                <button onclick="toggleTheme()" class="theme-btn" title="Toggle Theme">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
            
            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-item">
                    <i class="fas fa-users"></i>
                    <span>1.2k</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-file-alt"></i>
                    <span>3.4k</span>
                </div>
            </div>
            
            <!-- Admin Profile Dropdown -->
            <div class="admin-profile-dropdown">
                <div class="profile-trigger" onclick="toggleProfileDropdown()">
                    <div class="profile-avatar">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($admin_name); ?>&background=6366f1&color=fff&bold=true" alt="Admin">
                    </div>
                    <div class="profile-info">
                        <strong><?php echo htmlspecialchars($admin_name); ?></strong>
                        <span>Administrator</span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>
                
                <div class="dropdown-menu" id="profileDropdown">
                    <a href="profile.php" class="dropdown-item">
                        <i class="fas fa-user"></i>
                        <span>My Profile</span>
                    </a>
                    <a href="settings.php" class="dropdown-item">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notifications Panel -->
<div class="notifications-panel" id="notificationsPanel">
    <div class="notifications-header">
        <h3>Notifications</h3>
        <button onclick="toggleNotifications()" class="close-btn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="notifications-list">
        <!-- Notifications will be loaded here -->
        <div class="notification-item">
            <div class="notification-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="notification-content">
                <strong>New user registered</strong>
                <p>John Doe just signed up</p>
                <span class="notification-time">2 min ago</span>
            </div>
        </div>
        <div class="notification-item">
            <div class="notification-icon warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="notification-content">
                <strong>System update available</strong>
                <p>Update to version 2.1.0</p>
                <span class="notification-time">1 hour ago</span>
            </div>
        </div>
    </div>
</div>

<style>
.admin-topbar {
    height: 72px;
    background: var(--card-bg);
    padding: 0 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--border-color);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 0;
    z-index: 99;
}

.topbar-left {
    min-width: 300px;
}

.page-title h1 {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.page-subtitle {
    color: var(--text-secondary);
    font-size: 14px;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-secondary);
    margin-top: 8px;
}

.breadcrumb-item {
    color: var(--text-secondary);
    transition: color 0.2s ease;
}

.breadcrumb-item:hover {
    color: var(--primary-color);
}

.breadcrumb-divider {
    opacity: 0.5;
}

.breadcrumb-current {
    color: var(--text-primary);
    font-weight: 500;
}

.topbar-center {
    flex: 1;
    max-width: 600px;
    margin: 0 40px;
}

.search-container {
    display: flex;
    align-items: center;
    gap: 16px;
}

.search-box {
    flex: 1;
    background: var(--hover-bg);
    padding: 8px 16px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    border: 2px solid transparent;
    transition: all 0.2s ease;
}

.search-box:focus-within {
    border-color: var(--primary-color);
    background: white;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.search-box i {
    color: var(--text-secondary);
    font-size: 16px;
}

.search-box input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-size: 14px;
    color: var(--text-primary);
}

.search-shortcut {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary-color);
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: 500;
}

.quick-actions {
    display: flex;
    gap: 8px;
}

.quick-action-btn {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    border: 1px solid var(--border-color);
    background: var(--card-bg);
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    position: relative;
}

.quick-action-btn:hover {
    background: var(--hover-bg);
    color: var(--primary-color);
    border-color: var(--primary-color);
}

.notification-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: var(--danger-color);
    color: white;
    font-size: 10px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.topbar-right {
    min-width: 300px;
}

.admin-controls {
    display: flex;
    align-items: center;
    gap: 20px;
    justify-content: flex-end;
}

.theme-toggle {
    margin-right: 10px;
}

.theme-btn {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    border: 1px solid var(--border-color);
    background: var(--card-bg);
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.theme-btn:hover {
    background: var(--hover-bg);
    color: var(--primary-color);
    transform: rotate(15deg);
}

.quick-stats {
    display: flex;
    gap: 16px;
    padding: 0 16px;
    border-left: 1px solid var(--border-color);
    border-right: 1px solid var(--border-color);
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-secondary);
    font-size: 14px;
}

.stat-item i {
    font-size: 16px;
}

.stat-item span {
    font-weight: 600;
    color: var(--text-primary);
}

.admin-profile-dropdown {
    position: relative;
}

.profile-trigger {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px;
    border-radius: 12px;
    cursor: pointer;
    transition: background 0.2s ease;
}

.profile-trigger:hover {
    background: var(--hover-bg);
}

.profile-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    overflow: hidden;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-info {
    text-align: left;
}

.profile-info strong {
    display: block;
    font-size: 14px;
    font-weight: 600;
}

.profile-info span {
    font-size: 12px;
    color: var(--text-secondary);
}

.profile-trigger i.fa-chevron-down {
    font-size: 12px;
    color: var(--text-secondary);
    transition: transform 0.2s ease;
}

.dropdown-menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: var(--card-bg);
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    min-width: 220px;
    display: none;
    z-index: 1000;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: var(--text-primary);
    transition: background 0.2s ease;
}

.dropdown-item:hover {
    background: var(--hover-bg);
}

.dropdown-item i {
    width: 20px;
    color: var(--text-secondary);
}

.dropdown-item.logout {
    color: var(--danger-color);
}

.dropdown-item.logout i {
    color: var(--danger-color);
}

.dropdown-divider {
    height: 1px;
    background: var(--border-color);
    margin: 8px 0;
}

.notifications-panel {
    position: fixed;
    top: 72px;
    right: 32px;
    background: var(--card-bg);
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    width: 380px;
    max-height: 80vh;
    overflow: hidden;
    display: none;
    z-index: 1000;
    border: 1px solid var(--border-color);
}

.notifications-header {
    padding: 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.notifications-header h3 {
    font-size: 18px;
    font-weight: 600;
}

.close-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    background: var(--hover-bg);
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.close-btn:hover {
    background: var(--danger-color);
    color: white;
}

.notifications-list {
    max-height: 400px;
    overflow-y: auto;
    padding: 16px;
}

.notification-item {
    display: flex;
    gap: 12px;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 8px;
    transition: background 0.2s ease;
}

.notification-item:hover {
    background: var(--hover-bg);
}

.notification-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.notification-icon.success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
}

.notification-icon.warning {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning-color);
}

.notification-content {
    flex: 1;
}

.notification-content strong {
    display: block;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.notification-content p {
    font-size: 13px;
    color: var(--text-secondary);
    margin-bottom: 4px;
}

.notification-time {
    font-size: 11px;
    color: var(--text-secondary);
}

/* Mobile Responsive */
@media (max-width: 1024px) {
    .admin-topbar {
        padding: 0 20px;
    }
    
    .topbar-left,
    .topbar-right {
        min-width: auto;
    }
    
    .topbar-center {
        display: none;
    }
    
    .quick-stats {
        display: none;
    }
    
    .profile-info {
        display: none;
    }
}

@media (max-width: 768px) {
    .admin-topbar {
        height: 60px;
        padding: 0 16px;
    }
    
    .page-title h1 {
        font-size: 20px;
    }
    
    .breadcrumb {
        display: none;
    }
}
</style>

<script>
// Theme toggle functionality
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('admin-theme', newTheme);
    
    const icon = document.querySelector('.theme-btn i');
    icon.className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    
    showToast(`Switched to ${newTheme} mode`);
}

// Load saved theme
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('admin-theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    const icon = document.querySelector('.theme-btn i');
    if (icon) {
        icon.className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    }
    
    // Add dark theme styles
    const darkThemeCSS = `
        [data-theme="dark"] {
            --primary-color: #8b5cf6;
            --primary-dark: #7c3aed;
            --secondary-color: #0f172a;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border-color: #334155;
            --card-bg: #1e293b;
            --hover-bg: #334155;
            --sidebar-bg: #020617;
        }
    `;
    
    const style = document.createElement('style');
    style.textContent = darkThemeCSS;
    document.head.appendChild(style);
});

// Profile dropdown toggle
function toggleProfileDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function closeDropdown(e) {
        if (!e.target.closest('.admin-profile-dropdown')) {
            dropdown.style.display = 'none';
            document.removeEventListener('click', closeDropdown);
        }
    });
}

// Notifications panel toggle
function toggleNotifications() {
    const panel = document.getElementById('notificationsPanel');
    panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
}

// Global search functionality
document.getElementById('globalSearch')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        const query = this.value.trim();
        if (query) {
            window.location.href = `search.php?q=${encodeURIComponent(query)}`;
        }
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + K for search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('globalSearch')?.focus();
    }
    
    // Esc to close panels
    if (e.key === 'Escape') {
        document.getElementById('notificationsPanel').style.display = 'none';
        document.getElementById('profileDropdown').style.display = 'none';
    }
});

// Help function
function showHelp() {
    showToast('Help documentation will open in a new window', 'info');
    // window.open('help.php', '_blank');
}
</script>