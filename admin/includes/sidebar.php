<aside class="admin-sidebar">
    <div class="admin-brand">
        <i class="fas fa-file-alt"></i>
        <span>Resume Admin</span>
    </div>

    <nav class="admin-nav">
        <a href="dashboard.php" class="nav-item">
            <i class="fas fa-chart-line"></i>
            Dashboard
        </a>

        <a href="themes.php" class="nav-item">
            <i class="fas fa-palette"></i>
            Manage Themes
        </a>

        <a href="#" class="nav-item disabled">
            <i class="fas fa-users"></i>
            Users (Soon)
        </a>

        <a href="#" class="nav-item disabled">
            <i class="fas fa-file"></i>
            Resumes (Soon)
        </a>

        <a href="logout.php" class="nav-item logout">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </nav>

    <style>
        .admin-sidebar {
            width: 260px;
            background: #0f172a;
            color: #e5e7eb;
            display: flex;
            flex-direction: column;
        }

        .admin-brand {
            padding: 24px;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #020617;
        }

        .admin-nav {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-item {
            padding: 12px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            transition: .2s;
        }

        .nav-item:hover {
            background: #1e293b;
        }

        .nav-item.logout {
            margin-top: auto;
            background: #7f1d1d;
        }

        .nav-item.logout:hover {
            background: #991b1b;
        }

        .nav-item.disabled {
            opacity: .5;
            pointer-events: none;
        }
    </style>
</aside>
