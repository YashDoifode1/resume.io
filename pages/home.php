<?php
/**
 * Home Page – Professional Resume Builder (2026 Edition)
 */

require_once __DIR__ . '/../config/database.php';

$page_title = 'Professional Resume Builder – ATS-Friendly & Recruiter-Approved';
$page_description = 'Create modern, ATS-optimized resumes with professional templates used by 50,000+ professionals.';
$page_keywords = 'resume builder, ATS resume, professional CV, career tools, job application';
$canonical_url = BASE_URL;

/* ---------------- PAGINATION CONFIG ---------------- */
$perPage = 6;
$currentPage = isset($_GET['tp']) && is_numeric($_GET['tp']) ? (int)$_GET['tp'] : 1;
$currentPage = max(1, $currentPage);
$offset = ($currentPage - 1) * $perPage;

/* ---------------- TOTAL THEMES ---------------- */
$countStmt = $pdo->query("SELECT COUNT(*) FROM themes WHERE is_active = 1");
$totalThemes = (int)$countStmt->fetchColumn();
$totalPages  = (int)ceil($totalThemes / $perPage);

/* ---------------- FETCH THEMES ---------------- */
$stmt = $pdo->prepare("
    SELECT id, slug, name, description, icon, is_premium
    FROM themes
    WHERE is_active = 1
    ORDER BY is_premium DESC, created_at DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$themes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
</head>
<body>

<!-- ================= HERO – Professional & Confident ================= -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Resumes That Get Interviews</h1>
            <p class="hero-subtitle">
                Create ATS-compliant, recruiter-approved resumes in minutes using 
                premium templates trusted by professionals worldwide.
            </p>

            <div class="hero-stats">
                <div><strong>50,000+</strong> resumes created</div>
                <div><strong>4.8/5</strong> user rating</div>
                <div><strong>ATS success</strong> rate > 97%</div>
            </div>

            <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-xl">
                Create My Professional Resume →
            </a>
            <p class="hero-small">No sign-up required • Instant PDF download</p>
        </div>

        <div class="hero-visual">
            <div class="mockup">
                <div class="mockup-header"></div>
                <div class="mockup-content"></div>
            </div>
        </div>
    </div>
</section>

<!-- ================= TEMPLATES – Premium Look ================= -->
<section class="section templates-section" id="templates">
    <div class="container">
        <div class="section-header">
            <h2>Professional Templates</h2>
            <p>Designed for modern hiring processes – clean, structured, and effective.</p>
        </div>

        <div class="template-grid">
            <?php if ($themes): ?>
                <?php foreach ($themes as $theme): ?>
                    <div class="template-card <?php echo $theme['is_premium'] ? 'premium' : ''; ?>">
                        <div class="template-preview">
                            <span class="icon"><?php echo htmlspecialchars($theme['icon'] ?: '📄'); ?></span>
                        </div>
                        <div class="template-info">
                            <h3 class="template-name">
                                <?php echo htmlspecialchars($theme['name']); ?>
                                <?php if ($theme['is_premium']): ?>
                                    <span class="badge premium">Premium</span>
                                <?php endif; ?>
                            </h3>
                            <p class="template-desc"><?php echo htmlspecialchars($theme['description']); ?></p>
                            <a href="<?php echo BASE_URL; ?>?page=builder&theme=<?php echo urlencode($theme['slug']); ?>"
                               class="btn btn-outline btn-sm">
                                Use Template
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">No templates available at the moment.</div>
            <?php endif; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?tp=<?php echo $i; ?>#templates"
                       class="<?php echo $i === $currentPage ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </nav>
        <?php endif; ?>
    </div>
</section>

<!-- ================= TRUST BAR ================= -->
<section class="trust-bar">
    <div class="container">
        <div class="trust-items">
            <div>ATS-Optimized Layouts</div>
            <div>Recruiter-Tested Design</div>
            <div>One-Click PDF Export</div>
            <div>100% Free Starter Plan</div>
        </div>
    </div>
</section>

<!-- ================= FINAL CTA – Strong & Direct ================= -->
<section class="cta-section">
    <div class="container">
        <h2>Ready to Land Your Next Role?</h2>
        <p>Join thousands of professionals who turned applications into interviews.</p>
        <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-xl">
            Build Professional Resume Now
        </a>
    </div>
</section>

<!-- ================= MODERN PROFESSIONAL STYLES ================= -->
<style>
:root {
    --primary: #2563eb;
    --primary-dark: #1d4ed8;
    --dark: #0f172a;
    --gray: #64748b;
    --light-gray: #f1f5f9;
    --border: #e2e8f0;
    --radius: 12px;
    --shadow-sm: 0 4px 12px rgba(0,0,0,0.06);
    --shadow-md: 0 10px 30px rgba(0,0,0,0.08);
}

* { box-sizing: border-box; margin:0; padding:0; }
body {
    font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
    color: var(--dark);
    background: white;
    line-height: 1.6;
}

.container {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Hero */
.hero {
    background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
    padding: 140px 0 100px;
    position: relative;
    overflow: hidden;
}
.hero .container {
    display: grid;
    grid-template-columns: 1.15fr 0.95fr;
    gap: 80px;
    align-items: center;
}
h1 { font-size: 3.4rem; font-weight: 800; letter-spacing: -0.03em; color: var(--dark); }
.hero-subtitle {
    font-size: 1.32rem;
    color: var(--gray);
    margin: 1.5rem 0 2rem;
    max-width: 520px;
}
.hero-stats {
    display: flex;
    gap: 32px;
    margin-bottom: 2.5rem;
    font-size: 0.95rem;
    color: var(--gray);
}
.hero-stats strong { color: var(--primary); display: block; font-size: 1.4rem; }

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.9rem 2.1rem;
    border-radius: var(--radius);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}
.btn-primary {
    background: var(--primary);
    color: white;
    border: none;
}
.btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
.btn-xl { font-size: 1.18rem; padding: 1.1rem 2.4rem; }
.btn-outline {
    border: 2px solid var(--primary);
    color: var(--primary);
    background: transparent;
}
.btn-sm { padding: 0.65rem 1.4rem; font-size: 0.95rem; }

.mockup {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-md), 0 0 0 1px rgba(0,0,0,0.04);
    overflow: hidden;
}
.mockup-header { height: 54px; background: #f8fafc; border-bottom: 1px solid var(--border); }
.mockup-content { height: 340px; background: linear-gradient(to bottom, #f9fafb, #ffffff); }

.hero-small { margin-top: 1.2rem; color: var(--gray); font-size: 0.95rem; }

/* Templates */
.templates-section { padding: 120px 0; background: white; }
.section-header { text-align: center; margin-bottom: 4rem; }
.section-header h2 { font-size: 2.6rem; margin-bottom: 1rem; }
.section-header p { color: var(--gray); font-size: 1.15rem; max-width: 620px; margin: 0 auto; }

.template-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 28px;
}
.template-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    transition: all 0.25s ease;
}
.template-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-md);
    border-color: #cbd5e1;
}
.template-preview {
    height: 180px;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4.5rem;
    color: #94a3b8;
}
.template-info { padding: 24px; }
.template-name {
    font-size: 1.32rem;
    margin-bottom: 0.6rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.badge.premium {
    background: #fef08a;
    color: #854d0e;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.78rem;
    font-weight: 600;
}
.template-desc { color: var(--gray); margin-bottom: 1.4rem; min-height: 2.8em; }

/* Pagination */
.pagination {
    margin-top: 3rem;
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}
.pagination a {
    padding: 10px 16px;
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--dark);
    text-decoration: none;
    transition: 0.2s;
}
.pagination a:hover { background: #f1f5f9; }
.pagination a.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

/* Trust bar */
.trust-bar {
    background: var(--light-gray);
    padding: 60px 0;
    text-align: center;
}
.trust-items {
    display: flex;
    justify-content: center;
    gap: 60px;
    flex-wrap: wrap;
    font-size: 1.1rem;
    font-weight: 500;
    color: var(--gray);
}

/* Final CTA */
.cta-section {
    background: var(--primary);
    color: white;
    text-align: center;
    padding: 120px 0;
}
.cta-section h2 { font-size: 2.8rem; margin-bottom: 1.2rem; }
.cta-section p { font-size: 1.25rem; opacity: 0.92; margin-bottom: 2.5rem; }

/* Responsive */
@media (max-width: 1024px) {
    .hero .container { grid-template-columns: 1fr; text-align: center; }
    .hero-visual { display: none; }
    h1 { font-size: 2.8rem; }
}

@media (max-width: 640px) {
    .hero { padding: 100px 0 80px; }
    h1 { font-size: 2.4rem; }
    .hero-stats { flex-direction: column; gap: 16px; }
    .trust-items { flex-direction: column; gap: 24px; }
}
</style>

</body>
</html>