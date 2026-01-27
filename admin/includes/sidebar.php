<aside class="admin-sidebar">
    <div class="admin-brand">
        <div class="brand-logo">
            <i class="fas fa-file-contract"></i>
        </div>
        <div class="brand-info">
            <h1>Resume Builder</h1>
            <span class="brand-subtitle">Admin Panel</span>
        </div>
    </div>

    <div class="sidebar-divider"></div>

    <nav class="admin-nav">
        <div class="nav-section">
            <span class="nav-label">DASHBOARD</span>
            <a href="dashboard.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-pie"></i>
                <span>Overview</span>
                <span class="nav-badge" id="dashboard-badge"></span>
            </a>
        </div>

        <div class="nav-section">
            <span class="nav-label">CONTENT</span>
            <a href="themes.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'themes.php' ? 'active' : ''; ?>">
                <i class="fas fa-palette"></i>
                <span>Themes</span>
                <span class="nav-badge" id="themes-count"><?php 
                    // You can add theme count here if needed
                ?></span>
            </a>
            
            <a href="resumes.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'resumes.php' ? 'active' : ''; ?>">
                <i class="fas fa-file-alt"></i>
                <span>Resumes</span>
                <span class="nav-badge" id="resumes-count"></span>
            </a>
        </div>

        <div class="nav-section">
            <span class="nav-label">USERS</span>
            <a href="users.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                <span>User Management</span>
                <span class="nav-badge" id="users-count"></span>
            </a>
            
            <a href="subscriptions.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'subscriptions.php' ? 'active' : ''; ?>">
                <i class="fas fa-crown"></i>
                <span>Subscriptions</span>
                <span class="nav-badge" id="premium-count"></span>
            </a>
        </div>

        <div class="nav-section">
            <span class="nav-label">SETTINGS</span>
            <a href="settings.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i>
                <span>System Settings</span>
            </a>
            
            <a href="logs.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'logs.php' ? 'active' : ''; ?>">
                <i class="fas fa-clipboard-list"></i>
                <span>Activity Logs</span>
            </a>
        </div>

        <div class="nav-footer">
            <a href="profile.php" class="nav-item profile">
                <div class="profile-avatar">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($admin_name); ?>&background=6366f1&color=fff&bold=true" alt="Admin">
                </div>
                <div class="profile-info">
                    <strong><?php echo htmlspecialchars($admin_name); ?></strong>
                    <span>Administrator</span>
                </div>
            </a>
            
            <a href="logout.php" class="nav-item logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </nav>

    <style>
        .admin-sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #0d1323 100%);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            z-index: 100;
            position: relative;
        }
        
        .admin-brand {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .brand-logo {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-color), #7c3aed);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .brand-info h1 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        
        .brand-subtitle {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
        }
        
        .sidebar-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0 20px;
        }
        
        .admin-nav {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }
        
        .nav-section {
            margin-bottom: 24px;
        }
        
        .nav-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 12px;
            padding: 0 8px;
        }
        
        .nav-item {
            padding: 12px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            transition: all 0.2s ease;
            color: #cbd5e1;
            position: relative;
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
        }
        
        .nav-item.active {
            background: rgba(79, 70, 229, 0.2);
            color: white;
            border-left: 3px solid var(--primary-color);
        }
        
        .nav-item.active i {
            color: var(--primary-color);
        }
        
        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }
        
        .nav-badge {
            background: var(--primary-color);
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: auto;
        }
        
        .nav-footer {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 16px;
        }
        
        .nav-item.profile {
            padding: 16px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            margin-bottom: 12px;
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
            flex: 1;
        }
        
        .profile-info strong {
            display: block;
            font-size: 14px;
        }
        
        .profile-info span {
            font-size: 12px;
            color: #94a3b8;
        }
        
        .nav-item.logout {
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
        }
        
        .nav-item.logout:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #fecaca;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                width: 80px;
            }
            
            .admin-brand {
                justify-content: center;
                padding: 20px 0;
            }
            
            .brand-info, .nav-label, .nav-item span, .profile-info {
                display: none;
            }
            
            .nav-item {
                justify-content: center;
                padding: 16px;
            }
            
            .nav-badge {
                position: absolute;
                top: 8px;
                right: 8px;
                font-size: 9px;
                padding: 2px 5px;
            }
        }
    </style>
</aside>