<div class="topbar">
    <div class="topbar-left">
        <h2>Admin Dashboard</h2>
    </div>

    <div class="topbar-center">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search themes, pages...">
        </div>
    </div>

    <div class="topbar-right">
        <div class="admin-profile">
            <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff" alt="Admin">
            <span>Admin</span>
            <a href="logout.php" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</div>

<style>
.topbar {
    height: 64px;
    background: #ffffff;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #e5e7eb;
}

.topbar-left h2 {
    font-size: 20px;
    font-weight: 600;
}

.topbar-center {
    flex: 1;
    display: flex;
    justify-content: center;
}

.search-box {
    background: #f1f5f9;
    padding: 8px 14px;
    border-radius: 999px;
    display: flex;
    align-items: center;
    gap: 8px;
    width: 320px;
}

.search-box input {
    border: none;
    background: transparent;
    outline: none;
    width: 100%;
    font-size: 14px;
}

.search-box i {
    color: #64748b;
    font-size: 14px;
}

.topbar-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.admin-profile {
    display: flex;
    align-items: center;
    gap: 10px;
}

.admin-profile img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
}

.admin-profile span {
    font-weight: 500;
    font-size: 14px;
}

.admin-profile a i {
    color: #ef4444;
    font-size: 16px;
}
</style>
