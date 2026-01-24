<?php
require_once __DIR__ . '/../config/database.php';

include 'includes/header.php';
include 'includes/sidebar.php';

/* ===============================
   Dashboard Stats (SAFE QUERIES)
================================ */

// Total themes
$totalThemes = $pdo->query("SELECT COUNT(*) FROM themes")->fetchColumn();

// Active themes
$activeThemes = $pdo->query(
    "SELECT COUNT(*) FROM themes WHERE is_active = 1"
)->fetchColumn();

/* ===============================
   Premium Themes (Safe Check)
================================ */
$premiumThemes = 0;

// Check if is_premium column exists
$columnCheck = $pdo->query("
    SHOW COLUMNS FROM themes LIKE 'is_premium'
")->rowCount();

if ($columnCheck > 0) {
    $premiumThemes = $pdo->query(
        "SELECT COUNT(*) FROM themes WHERE is_premium = 1"
    )->fetchColumn();
}
?>

<div class="admin-content" style="flex:1;">
    <?php include 'includes/topbar.php'; ?>

    <main class="dashboard">

        <!-- Header -->
        <div class="dashboard-header">
            <h1>Dashboard</h1>
            <p>Overview of your resume builder system</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">

            <div class="stat-card">
                <i class="fas fa-palette"></i>
                <div>
                    <h3><?= $totalThemes ?></h3>
                    <span>Total Themes</span>
                </div>
            </div>

            <div class="stat-card success">
                <i class="fas fa-check-circle"></i>
                <div>
                    <h3><?= $activeThemes ?></h3>
                    <span>Active Themes</span>
                </div>
            </div>

            <div class="stat-card premium">
                <i class="fas fa-crown"></i>
                <div>
                    <h3><?= $premiumThemes ?></h3>
                    <span>Premium Themes</span>
                </div>
            </div>

        </div>

        <!-- Quick Actions -->
        <section class="quick-actions">
            <h2>Quick Actions</h2>

            <div class="actions-grid">
                <a href="themes.php" class="action-card">
                    <i class="fas fa-palette"></i>
                    <span>Manage Themes</span>
                </a>

                <a href="../pages/themes.php" target="_blank" class="action-card">
                    <i class="fas fa-eye"></i>
                    <span>View Public Themes</span>
                </a>
            </div>
        </section>

    </main>
</div>

<?php include 'includes/footer.php'; ?>


<style>
.dashboard {
    padding: 24px;
}

.dashboard-header h1 {
    margin: 0;
    font-size: 26px;
}

.dashboard-header p {
    color: #64748b;
    margin-top: 4px;
}

/* Stats */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin: 30px 0;
}

.stat-card {
    background: #ffffff;
    padding: 20px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 18px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.04);
}

.stat-card i {
    font-size: 32px;
    color: #6366f1;
}

.stat-card h3 {
    margin: 0;
    font-size: 28px;
}

.stat-card span {
    color: #64748b;
    font-size: 14px;
}

.stat-card.success i { color: #22c55e; }
.stat-card.premium i { color: #f59e0b; }

/* Quick Actions */
.quick-actions h2 {
    margin-bottom: 16px;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
}

.action-card {
    background: #ffffff;
    padding: 18px;
    border-radius: 12px;
    display: flex;
    gap: 14px;
    align-items: center;
    font-weight: 500;
    transition: .2s;
    box-shadow: 0 6px 14px rgba(0,0,0,0.04);
}

.action-card i {
    font-size: 22px;
    color: #4f46e5;
}

.action-card:hover {
    transform: translateY(-2px);
}

.action-card.disabled {
    opacity: .5;
    pointer-events: none;
}
</style>
