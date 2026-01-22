<?php
/**
 * Resume Preview Page
 */

// session_start();

if (!isset($_SESSION['resume_data'])) {
    header('Location: ' . BASE_URL . '?page=builder');
    exit;
}

$data = $_SESSION['resume_data'];
$theme = $_GET['theme'] ?? 'classic';

$page_title = 'Preview Resume';
$page_description = 'Preview your resume and download as PDF';
$page_css = 'preview.css';

/* ===============================
   THEME CONFIG (SINGLE SOURCE)
================================ */
$themeFiles = [
    'classic'     => 'theme1-classic.php',
    'modern'      => 'theme2-modern.php',
    'corporate'   => 'theme3-corporate.php',
    'creative'    => 'theme4-creative.php',
    'dark'        => 'theme5-dark.php',
    'elegant'     => 'theme6-elegant.php',
    'tech'        => 'theme7-tech.php',
    'minimal'     => 'theme8-minimal.php',
    'vibrant'     => 'theme9-vibrant.php',
    'executive'   => 'theme10-executive.php',

    /* NEW THEMES */
    'gradient'    => 'theme11-gradient.php',
    'sidebar'     => 'theme12-sidebar.php',
    'minimalist'  => 'theme13-minimalist.php',
    'colorful'    => 'theme14-colorful.php',
    'timeline'    => 'theme15-timeline.php'
];

$validThemes = array_keys($themeFiles);

/* Validate selected theme */
if (!in_array($theme, $validThemes)) {
    $theme = 'classic';
}

/* Theme UI metadata (icons + labels only) */
$themeMeta = [
    'classic'     => ['📄', 'Classic Professional'],
    'modern'      => ['✨', 'Modern Minimal'],
    'corporate'   => ['💼', 'Corporate Blue'],
    'creative'    => ['🎨', 'Creative Portfolio'],
    'dark'        => ['🌙', 'Dark Mode'],
    'elegant'     => ['✨', 'Elegant Gold'],
    'tech'        => ['💻', 'Tech Startup'],
    'minimal'     => ['⚪', 'Ultra Minimal'],
    'vibrant'     => ['🌈', 'Vibrant Colors'],
    'executive'   => ['👔', 'Executive Premium'],

    /* NEW THEMES */
    'gradient'    => ['🌅', 'Gradient Style'],
    'sidebar'     => ['📌', 'Sidebar Layout'],
    'minimalist'  => ['⬜', 'Minimalist Clean'],
    'colorful'    => ['🎯', 'Colorful Creative'],
    'timeline'    => ['🕒', 'Timeline Resume']
];
?>

<!-- Preview Container -->
<div class="preview-container">

    <!-- Sidebar -->
    <aside class="preview-sidebar">
        <div class="sidebar-content">
            <h2>🎨 Theme Selection</h2>
            <p style="font-size:12px;color:#666;margin-bottom:16px;">
                Choose from <?= count($themeFiles); ?> professional templates
            </p>

            <div class="theme-buttons">
                <?php foreach ($themeFiles as $key => $file): 
                    [$icon, $label] = $themeMeta[$key];
                ?>
                    <a href="<?= BASE_URL; ?>?page=preview&theme=<?= $key; ?>"
                       class="theme-btn <?= $theme === $key ? 'active' : ''; ?>">
                        <?= $icon; ?> <?= $label; ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="sidebar-actions">
                <a href="<?= BASE_URL; ?>?page=builder" class="btn btn-secondary btn-block">
                    ← Back to Form
                </a>
                <a href="<?= BASE_URL; ?>?page=download&theme=<?= $theme; ?>"
                   class="btn btn-primary btn-block">
                    📥 Download PDF
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Preview -->
    <main class="preview-main">
        <div class="resume-wrapper theme-<?= $theme; ?>">
            <?php
                $themeFile = THEMES_PATH . $themeFiles[$theme];
                if (file_exists($themeFile)) {
                    include $themeFile;
                } else {
                    echo '<p style="padding:20px">Theme not found</p>';
                }
            ?>
        </div>
    </main>

</div>

<style>
.preview-container {
    display: flex;
    gap: 24px;
    min-height: calc(100vh - 200px);
}

.preview-sidebar {
    width: 280px;
    background: var(--color-bg-secondary);
    padding: 24px;
    border-radius: 12px;
    height: fit-content;
    position: sticky;
    top: 100px;
}

.sidebar-content h2 {
    margin-bottom: 16px;
    color: var(--color-primary);
}

.theme-buttons {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 32px;
}

.theme-btn {
    padding: 12px 16px;
    background: var(--color-bg-primary);
    border: 2px solid var(--color-border);
    border-radius: 8px;
    color: var(--color-text-primary);
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
    text-align: left;
}

.theme-btn:hover {
    border-color: var(--color-primary);
    background: var(--color-primary);
    color: white;
}

.theme-btn.active {
    background: var(--color-primary);
    color: white;
    border-color: var(--color-primary);
}

.sidebar-actions {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.preview-main {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    background: var(--color-bg-secondary);
    border-radius: 12px;
}

.resume-wrapper {
    background: white;
    max-width: 8.5in;
    margin: 0 auto;
    box-shadow: var(--shadow-lg);
    border-radius: 8px;
    overflow: hidden;
}

@media (max-width: 1024px) {
    .preview-container {
        flex-direction: column;
    }

    .preview-sidebar {
        width: 100%;
        position: static;
    }

    .theme-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .preview-main {
        padding: 12px;
    }
}

@media print {
    .preview-sidebar,
    .preview-main {
        display: none;
    }

    .resume-wrapper {
        max-width: 100%;
        box-shadow: none;
        margin: 0;
    }
}
</style>
