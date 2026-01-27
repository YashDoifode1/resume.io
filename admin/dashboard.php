<?php
require_once __DIR__ . '/../config/path.php';
require_once BASE_PATH . '/config/database.php';

/* Page meta */
$page_title = 'Dashboard';
$page_subtitle = 'Overview of your resume builder system';

/* Dashboard stats */
$totalThemes = $pdo->query("SELECT COUNT(*) FROM themes")->fetchColumn();
$activeThemes = $pdo->query("SELECT COUNT(*) FROM themes WHERE is_active = 1")->fetchColumn();

$premiumThemes = 0;
$hasPremium = $pdo->query("SHOW COLUMNS FROM themes LIKE 'is_premium'")->rowCount();
if ($hasPremium) {
    $premiumThemes = $pdo->query("SELECT COUNT(*) FROM themes WHERE is_premium = 1")->fetchColumn();
}

/* Layout */
require_once 'includes/layout.php';
require_once 'includes/sidebar.php';
?>

<div class="main">
    <?php require_once 'includes/header.php'; ?>

    <main class="content">

        <section class="dashboard">

            <div class="page-head">
                <h2><?= htmlspecialchars($page_title) ?></h2>
                <p><?= htmlspecialchars($page_subtitle) ?></p>
            </div>

            <div class="stats-grid">

                <div class="stat-card">
                    <i class="fas fa-palette"></i>
                    <h3><?= $totalThemes ?></h3>
                    <span>Total Themes</span>
                </div>

                <div class="stat-card success">
                    <i class="fas fa-check-circle"></i>
                    <h3><?= $activeThemes ?></h3>
                    <span>Active Themes</span>
                </div>

                <div class="stat-card premium">
                    <i class="fas fa-crown"></i>
                    <h3><?= $premiumThemes ?></h3>
                    <span>Premium Themes</span>
                </div>

            </div>

        </section>

    </main>
</div>

<?php require_once 'includes/footer.php'; ?>
<style>/* =====================
   Dashboard Layout
===================== */
.dashboard {
    display: flex;
    flex-direction: column;
    gap: 28px;
}

/* Page head */
.page-head h2 {
    margin: 0;
    font-size: 1.45rem;
    font-weight: 600;
    color: #0f172a;
}

.page-head p {
    margin-top: 6px;
    font-size: 0.9rem;
    color: #64748b;
}

/* =====================
   Stats Grid
===================== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}

/* =====================
   Stat Card
===================== */
.stat-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.08);
}

.stat-card i {
    font-size: 1.5rem;
    color: var(--primary);
}

.stat-card h3 {
    margin: 0;
    font-size: 1.75rem;
    font-weight: 700;
    color: #0f172a;
}

.stat-card span {
    font-size: 0.85rem;
    color: #64748b;
}

/* =====================
   Card Variants
===================== */
.stat-card.success i {
    color: #16a34a;
}

.stat-card.premium i {
    color: #f59e0b;
}
</style>