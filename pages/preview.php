<?php
/**
 * Resume Preview Page - Professional UI with Database-Driven Theme Loading
 */

if (!isset($_SESSION['resume_data'])) {
    header('Location: ' . BASE_URL . '?page=builder');
    exit;
}

$data = $_SESSION['resume_data'];
$selectedThemeSlug = $_GET['theme'] ?? 'modern';

$page_title = 'Preview Resume | ResumeCraft';
$page_description = 'Preview and customize your resume before downloading';

// Initialize database connection
require_once __DIR__ . '/../config/database.php';

// ================= DATABASE-DRIVEN THEME LOADING =================
$activeTheme = null;
$allActiveThemes = [];
$themeErrorMessage = '';

try {
    // Fetch all active themes from database
    $stmt = $pdo->query("
        SELECT id, slug, name, description, icon, file_name, is_active, is_premium 
        FROM themes 
        WHERE is_active = 1 
        ORDER BY id ASC
    ");
    $allActiveThemes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($allActiveThemes)) {
        throw new Exception("No active themes available in database.");
    }
    
    // Find the selected theme
    $selectedTheme = null;
    foreach ($allActiveThemes as $theme) {
        if ($theme['slug'] === $selectedThemeSlug) {
            $selectedTheme = $theme;
            break;
        }
    }
    
    // If selected theme not found, use first available theme
    if (!$selectedTheme) {
        $selectedTheme = $allActiveThemes[0];
        $themeErrorMessage = "Requested theme not available. Using default theme.";
    }
    
    $activeTheme = $selectedTheme;
    
    // Validate and sanitize the file_name
    $templateFile = $activeTheme['file_name'] ?? '';
    
    // Security: Only allow alphanumeric, hyphens, underscores, and dots
    if (!preg_match('/^[a-zA-Z0-9_\-\.]+\.php$/', $templateFile)) {
        throw new Exception("Invalid template file name format.");
    }
    
    // Build theme file path
    $themePath = THEMES_PATH . basename($templateFile);
    
    // Verify the template file exists
    if (!file_exists($themePath)) {
        throw new Exception("Template file not found: " . basename($templateFile));
    }
    
} catch (Exception $e) {
    // Log error in production
    error_log("Theme Error in preview.php: " . $e->getMessage());
    $themeErrorMessage = "Theme configuration issue. Using basic layout.";
    
    // Ultimate fallback
    $activeTheme = [
        'slug' => 'fallback',
        'name' => 'Basic Template',
        'description' => 'Fallback template',
        'icon' => '📄',
        'file_name' => 'theme2-modern.php',
        'is_premium' => 0
    ];
    
    // Ensure file exists
    $themePath = THEMES_PATH . 'theme2-modern.php';
    if (!file_exists($themePath)) {
        // Create minimal fallback
        $fallbackContent = '<div style="padding: 40px; text-align: center; background: white;">';
        $fallbackContent .= '<h2>Resume Preview</h2>';
        $fallbackContent .= '<p>Basic resume layout</p>';
        $fallbackContent .= '</div>';
        $themeContent = $fallbackContent;
    }
}

// Get profile picture URL
function getProfilePictureUrl($profilePicture) {
    if (empty($profilePicture)) {
        return BASE_URL . 'assets/images/default-profile.png';
    }
    
    if (filter_var($profilePicture, FILTER_VALIDATE_URL)) {
        return $profilePicture;
    }
    
    if (strpos($profilePicture, 'uploads/') === 0) {
        return BASE_URL . $profilePicture;
    }
    
    if (strpos($profilePicture, '/') === false && strpos($profilePicture, '\\') === false) {
        return BASE_URL . 'uploads/' . $profilePicture;
    }
    
    return BASE_URL . 'assets/images/default-profile.png';
}

$profilePictureUrl = getProfilePictureUrl($data['personal']['profilePicture'] ?? '');

// Calculate completion percentage
function calculateCompletion($data) {
    $totalSections = 8;
    $completed = 0;
    
    if (!empty($data['personal']['fullName'])) $completed++;
    if (!empty($data['personal']['profileSummary'])) $completed++;
    if (!empty($data['workExperience'])) $completed++;
    if (!empty($data['education'])) $completed++;
    if (!empty($data['skills'])) $completed++;
    if (!empty($data['projects'])) $completed++;
    if (!empty($data['certifications'])) $completed++;
    if (!empty($data['languages'])) $completed++;
    
    return round(($completed / $totalSections) * 100);
}

$completionPercentage = calculateCompletion($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title; ?></title>
    <meta name="description" content="<?= $page_description; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<!-- Preview Page Container -->
<div class="rc-preview-container" id="rcPreviewContainer">

    <!-- Fixed Top Navigation -->
    <div class="rc-preview-nav">
        <div class="rc-container">
            <div class="rc-nav-content">
                <div class="rc-nav-brand">
                    <i class="fas fa-file-alt rc-nav-icon"></i>
                    <span class="rc-nav-title">ResumeCraft Preview</span>
                    <span class="rc-nav-subtitle">/ Theme: <?= htmlspecialchars($activeTheme['name']); ?></span>
                </div>
                <div class="rc-nav-actions">
                    <a href="<?= BASE_URL; ?>?page=builder&theme=<?= urlencode($activeTheme['slug']); ?>" class="rc-btn rc-btn-outline rc-btn-sm">
                        <i class="fas fa-edit"></i> Edit Resume
                    </a>
                    <a href="<?= BASE_URL; ?>?page=download&theme=<?= urlencode($activeTheme['slug']); ?>" class="rc-btn rc-btn-primary rc-btn-sm">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                    <button onclick="window.print()" class="rc-btn rc-btn-secondary rc-btn-sm">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="rc-preview-main">
        <div class="rc-container">
            <div class="rc-preview-grid">
                
                <!-- Left Sidebar -->
                <aside class="rc-preview-sidebar">
                    
                    <!-- Completion Card -->
                    <div class="rc-sidebar-card">
                        <div class="rc-card-header">
                            <i class="fas fa-chart-line rc-card-icon"></i>
                            <h3 class="rc-card-title">Resume Status</h3>
                        </div>
                        <div class="rc-completion-progress">
                            <div class="rc-progress-circle">
                                <svg width="120" height="120" viewBox="0 0 120 120">
                                    <circle class="rc-progress-bg" cx="60" cy="60" r="54"></circle>
                                    <circle class="rc-progress-fill" cx="60" cy="60" r="54" 
                                            style="stroke-dasharray: <?= $completionPercentage * 3.4; ?> 340;"></circle>
                                </svg>
                                <div class="rc-progress-text"><?= $completionPercentage; ?>%</div>
                            </div>
                            <p class="rc-completion-text">Complete your resume for better results</p>
                        </div>
                    </div>
                    
                    <!-- Theme Selection -->
                    <div class="rc-sidebar-card">
                        <div class="rc-card-header">
                            <i class="fas fa-palette rc-card-icon"></i>
                            <h3 class="rc-card-title">Choose Template</h3>
                        </div>
                        <?php if (!empty($themeErrorMessage)): ?>
                        <div class="rc-theme-warning">
                            <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($themeErrorMessage); ?>
                        </div>
                        <?php endif; ?>
                        <div class="rc-theme-grid">
                            <?php foreach ($allActiveThemes as $theme): ?>
                                <a href="<?= BASE_URL; ?>?page=preview&theme=<?= urlencode($theme['slug']); ?>" 
                                   class="rc-theme-card <?= $activeTheme['slug'] === $theme['slug'] ? 'rc-theme-active' : ''; ?>">
                                    <div class="rc-theme-icon"><?= htmlspecialchars($theme['icon']); ?></div>
                                    <div class="rc-theme-info">
                                        <h4 class="rc-theme-name"><?= htmlspecialchars($theme['name']); ?></h4>
                                        <p class="rc-theme-desc"><?= htmlspecialchars($theme['description']); ?></p>
                                    </div>
                                    <?php if ($theme['is_premium']): ?>
                                        <div class="rc-premium-badge">
                                            <i class="fas fa-crown"></i> Premium
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($activeTheme['slug'] === $theme['slug']): ?>
                                        <div class="rc-theme-badge">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="rc-sidebar-card">
                        <div class="rc-card-header">
                            <i class="fas fa-chart-bar rc-card-icon"></i>
                            <h3 class="rc-card-title">Resume Stats</h3>
                        </div>
                        <div class="rc-stats-grid">
                            <div class="rc-stat-item">
                                <div class="rc-stat-value"><?= strlen($data['personal']['fullName'] ?? '') > 0 ? '✓' : '✗'; ?></div>
                                <div class="rc-stat-label">Personal Info</div>
                            </div>
                            <div class="rc-stat-item">
                                <div class="rc-stat-value"><?= count($data['workExperience'] ?? []); ?></div>
                                <div class="rc-stat-label">Experience</div>
                            </div>
                            <div class="rc-stat-item">
                                <div class="rc-stat-value"><?= count($data['education'] ?? []); ?></div>
                                <div class="rc-stat-label">Education</div>
                            </div>
                            <div class="rc-stat-item">
                                <div class="rc-stat-value"><?= count($data['skills'] ?? []); ?></div>
                                <div class="rc-stat-label">Skills</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tips & Guidance -->
                    <div class="rc-sidebar-card rc-tips-card">
                        <div class="rc-card-header">
                            <i class="fas fa-lightbulb rc-card-icon"></i>
                            <h3 class="rc-card-title">Pro Tips</h3>
                        </div>
                        <ul class="rc-tips-list">
                            <li class="rc-tip-item">
                                <i class="fas fa-check-circle rc-tip-icon"></i>
                                <span>Keep resume to 1-2 pages maximum</span>
                            </li>
                            <li class="rc-tip-item">
                                <i class="fas fa-check-circle rc-tip-icon"></i>
                                <span>Use action verbs in experience section</span>
                            </li>
                            <li class="rc-tip-item">
                                <i class="fas fa-check-circle rc-tip-icon"></i>
                                <span>Quantify achievements with numbers</span>
                            </li>
                            <li class="rc-tip-item">
                                <i class="fas fa-check-circle rc-tip-icon"></i>
                                <span>Tailor resume for each job application</span>
                            </li>
                        </ul>
                    </div>
                    
                </aside>
                
                <!-- Main Preview Area -->
                <main class="rc-preview-content">
                    
                    <!-- Preview Controls -->
                    <div class="rc-preview-controls">
                        <div class="rc-controls-left">
                            <div class="rc-theme-indicator">
                                <span class="rc-theme-preview"><?= htmlspecialchars($activeTheme['icon']); ?></span>
                                <div>
                                    <h4 class="rc-current-theme"><?= htmlspecialchars($activeTheme['name']); ?></h4>
                                    <p class="rc-theme-preview-desc"><?= htmlspecialchars($activeTheme['description']); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="rc-controls-right">
                            <div class="rc-btn-group">
                                <button onclick="zoomOut()" class="rc-btn rc-btn-ghost rc-btn-sm">
                                    <i class="fas fa-search-minus"></i>
                                </button>
                                <button onclick="zoomIn()" class="rc-btn rc-btn-ghost rc-btn-sm">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <button onclick="resetZoom()" class="rc-btn rc-btn-ghost rc-btn-sm">
                                    <i class="fas fa-expand-alt"></i>
                                </button>
                                <button onclick="toggleFullscreen()" class="rc-btn rc-btn-ghost rc-btn-sm">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                            <span class="rc-zoom-text" id="rcZoomText">100%</span>
                        </div>
                    </div>
                    
                    <!-- Resume Preview - SIMPLE THEME LOADING -->
                    <div class="rc-preview-wrapper">
                        <div class="rc-preview-frame" id="rcPreviewFrame">
                            <?php
                                // Pass data to theme
                                $data['personal']['processedProfilePicture'] = $profilePictureUrl;
                                $themeFile = THEMES_PATH . $activeTheme['file_name'];
                                
                                // Simple direct inclusion
                                if (isset($themePath) && file_exists($themePath)) {
                                    // Use output buffering to capture
                                    ob_start();
                                    include $themePath;
                                    $themeContent = ob_get_clean();
                                    
                                    // Output theme content directly
                                    echo '<div class="rc-theme-content">';
                                    echo $themeContent;
                                    echo '</div>';
                                } else {
                                    // Graceful fallback UI
                                    echo '<div class="rc-theme-error">';
                                    echo '<div class="rc-error-content">';
                                    echo '<i class="fas fa-exclamation-triangle rc-error-icon"></i>';
                                    echo '<h3>Theme Not Found</h3>';
                                    echo '<p>The selected theme template could not be loaded.</p>';
                                    echo '<p><small>Template file: ' . htmlspecialchars($activeTheme['file_name']) . '</small></p>';
                                    if (!empty($allActiveThemes)) {
                                        echo '<div class="rc-fallback-options">';
                                        echo '<p>Try one of these available themes:</p>';
                                        foreach ($allActiveThemes as $fallbackTheme) {
                                            echo '<a href="' . BASE_URL . '?page=preview&theme=' . urlencode($fallbackTheme['slug']) . '" class="rc-btn rc-btn-sm rc-btn-outline">';
                                            echo htmlspecialchars($fallbackTheme['name']);
                                            echo '</a> ';
                                        }
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                }
                            ?>
                        </div>
                        
                        <!-- Page Indicator -->
                        <div class="rc-page-indicator">
                            <div class="rc-page-dots">
                                <span class="rc-page-dot active"></span>
                                <span class="rc-page-dot"></span>
                                <span class="rc-page-dot"></span>
                            </div>
                            <span class="rc-page-text">Page 1 of 1</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="rc-preview-actions">
                        <div class="rc-action-grid">
                            <a href="<?= BASE_URL; ?>?page=builder&theme=<?= urlencode($activeTheme['slug']); ?>" class="rc-action-card rc-action-edit">
                                <i class="fas fa-edit rc-action-icon"></i>
                                <div class="rc-action-content">
                                    <h4 class="rc-action-title">Edit Resume</h4>
                                    <p class="rc-action-desc">Make changes to your content</p>
                                </div>
                            </a>
                            
                            <a href="<?= BASE_URL; ?>?page=download&theme=<?= urlencode($activeTheme['slug']); ?>" class="rc-action-card rc-action-download">
                                <i class="fas fa-file-pdf rc-action-icon"></i>
                                <div class="rc-action-content">
                                    <h4 class="rc-action-title">Download PDF</h4>
                                    <p class="rc-action-desc">High-quality printable format</p>
                                </div>
                            </a>
                            
                            <button onclick="shareResume()" class="rc-action-card rc-action-share">
                                <i class="fas fa-share-alt rc-action-icon"></i>
                                <div class="rc-action-content">
                                    <h4 class="rc-action-title">Share Resume</h4>
                                    <p class="rc-action-desc">Share via link or social media</p>
                                </div>
                            </button>
                            
                            <a href="<?= BASE_URL; ?>?page=builder" class="rc-action-card rc-action-templates">
                                <i class="fas fa-layer-group rc-action-icon"></i>
                                <div class="rc-action-content">
                                    <h4 class="rc-action-title">More Templates</h4>
                                    <p class="rc-action-desc">Explore other designs</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                </main>
                
            </div>
        </div>
    </div>
    
    <!-- Floating Action Button -->
    <div class="rc-fab-container">
        <button class="rc-fab rc-fab-primary" onclick="downloadResume()">
            <i class="fas fa-download"></i>
            <span class="rc-fab-text">Download PDF</span>
        </button>
    </div>
    
</div>

<!-- ============================================
     PROFESSIONAL PREVIEW UI STYLES
     Themes will use their own CSS
============================================= -->
<style>
/* Reset and base styles ONLY for preview page */
.rc-preview-container {
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
    background: #f8fafc;
}

.rc-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Navigation */
.rc-preview-nav {
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    padding: 16px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.rc-nav-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.rc-nav-brand {
    display: flex;
    align-items: center;
    gap: 12px;
}

.rc-nav-icon {
    color: #4361ee;
    font-size: 24px;
}

.rc-nav-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 18px;
    color: #1e293b;
}

.rc-nav-subtitle {
    color: #64748b;
    font-size: 14px;
}

.rc-nav-actions {
    display: flex;
    gap: 8px;
}

/* Buttons */
.rc-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    background: none;
    text-decoration: none;
    font-family: 'Inter', sans-serif;
}

.rc-btn-sm {
    padding: 8px 16px;
    font-size: 13px;
}

.rc-btn-primary {
    background: #4361ee;
    color: white;
    border-color: #4361ee;
}

.rc-btn-primary:hover {
    background: #3a56d4;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
}

.rc-btn-secondary {
    background: #f1f5f9;
    color: #475569;
    border-color: #e2e8f0;
}

.rc-btn-secondary:hover {
    background: #e2e8f0;
}

.rc-btn-outline {
    background: transparent;
    color: #4361ee;
    border-color: #4361ee;
}

.rc-btn-outline:hover {
    background: rgba(67, 97, 238, 0.05);
}

.rc-btn-ghost {
    background: transparent;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.rc-btn-ghost:hover {
    background: #f8fafc;
    color: #4361ee;
}

.rc-btn-group {
    display: flex;
    gap: 4px;
}

/* Main Content Layout */
.rc-preview-main {
    padding: 24px 0 60px 0;
}

.rc-preview-grid {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 24px;
}

@media (max-width: 992px) {
    .rc-preview-grid {
        grid-template-columns: 1fr;
    }
}

/* Sidebar Cards */
.rc-sidebar-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.rc-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.rc-card-icon {
    color: #4361ee;
    font-size: 18px;
}

.rc-card-title {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

/* Progress Circle */
.rc-completion-progress {
    text-align: center;
}

.rc-progress-circle {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 16px auto;
}

.rc-progress-circle svg {
    transform: rotate(-90deg);
}

.rc-progress-bg {
    fill: none;
    stroke: #e2e8f0;
    stroke-width: 8;
}

.rc-progress-fill {
    fill: none;
    stroke: #4361ee;
    stroke-width: 8;
    stroke-linecap: round;
    transition: stroke-dasharray 0.6s ease;
}

.rc-progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: 600;
    color: #1e293b;
}

.rc-completion-text {
    color: #64748b;
    font-size: 14px;
    margin: 0;
}

/* Theme Cards */
.rc-theme-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 12px;
    max-height: 400px;
    overflow-y: auto;
    padding-right: 8px;
}

.rc-theme-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s ease;
    position: relative;
}

.rc-theme-card:hover {
    background: white;
    border-color: #cbd5e1;
    transform: translateX(4px);
}

.rc-theme-active {
    background: #f0f7ff;
    border-color: #4361ee;
    box-shadow: 0 2px 8px rgba(67, 97, 238, 0.1);
}

.rc-theme-icon {
    font-size: 24px;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.rc-theme-active .rc-theme-icon {
    background: #4361ee;
    color: white;
    border-color: #4361ee;
}

.rc-theme-info {
    flex: 1;
}

.rc-theme-name {
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 4px 0;
}

.rc-theme-desc {
    font-size: 12px;
    color: #64748b;
    margin: 0;
    line-height: 1.4;
}

.rc-premium-badge {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
    position: absolute;
    top: 8px;
    right: 8px;
}

.rc-premium-badge i {
    font-size: 8px;
}

.rc-theme-badge {
    position: absolute;
    bottom: -6px;
    right: -6px;
    width: 24px;
    height: 24px;
    background: #4361ee;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.rc-theme-warning {
    margin-bottom: 16px;
    padding: 12px;
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 8px;
    color: #856404;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.rc-theme-warning i {
    color: #f59e0b;
}

/* Stats Grid */
.rc-stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.rc-stat-item {
    text-align: center;
    padding: 16px;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.rc-stat-value {
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: 600;
    color: #4361ee;
    margin-bottom: 4px;
}

.rc-stat-label {
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Tips Card */
.rc-tips-card {
    background: linear-gradient(135deg, #f0f7ff, #f8fafc);
    border-color: #dbeafe;
}

.rc-tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.rc-tip-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
}

.rc-tip-item:last-child {
    border-bottom: none;
}

.rc-tip-icon {
    color: #10b981;
    font-size: 14px;
    margin-top: 2px;
    flex-shrink: 0;
}

.rc-tip-item span {
    font-size: 14px;
    color: #475569;
    line-height: 1.5;
}

/* Preview Controls */
.rc-preview-controls {
    background: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 16px;
    border: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.rc-controls-left, .rc-controls-right {
    display: flex;
    align-items: center;
    gap: 16px;
}

.rc-theme-indicator {
    display: flex;
    align-items: center;
    gap: 12px;
}

.rc-theme-preview {
    font-size: 32px;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border-radius: 10px;
    border: 2px solid #e2e8f0;
}

.rc-current-theme {
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 4px 0;
}

.rc-theme-preview-desc {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}

.rc-zoom-text {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    color: #1e293b;
    min-width: 50px;
    text-align: center;
}

/* Preview Frame - MINIMAL styling to not interfere with themes */
.rc-preview-wrapper {
    position: relative;
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 16px;
}

.rc-preview-frame {
    width: 100%;
    min-height: 11in;
    overflow: auto;
    padding: 40px;
    background: #f8fafc;
    position: relative;
}

/* Theme Content - Let theme use its own styles */
.rc-theme-content {
    width: 100%;
    height: 100%;
    background: white;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
}

/* Theme Error */
.rc-theme-error {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    padding: 40px;
}

.rc-error-content {
    text-align: center;
    max-width: 400px;
}

.rc-error-icon {
    font-size: 48px;
    color: #f59e0b;
    margin-bottom: 20px;
}

.rc-theme-error h3 {
    font-family: 'Poppins', sans-serif;
    color: #1e293b;
    margin: 0 0 12px 0;
}

.rc-theme-error p {
    color: #64748b;
    margin: 0 0 24px 0;
    line-height: 1.6;
}

.rc-fallback-options {
    margin-top: 20px;
}

.rc-fallback-options p {
    margin-bottom: 12px;
    font-size: 14px;
}

.rc-fallback-options .rc-btn {
    margin: 4px;
}

/* Page Indicator */
.rc-page-indicator {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 24px;
    background: white;
    border-top: 1px solid #e2e8f0;
}

.rc-page-dots {
    display: flex;
    gap: 8px;
}

.rc-page-dot {
    width: 8px;
    height: 8px;
    background: #cbd5e1;
    border-radius: 50%;
}

.rc-page-dot.active {
    background: #4361ee;
}

.rc-page-text {
    font-size: 14px;
    color: #64748b;
}

/* Action Cards */
.rc-preview-actions {
    margin-top: 24px;
}

.rc-action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.rc-action-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}

.rc-action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    border-color: #cbd5e1;
}

.rc-action-edit:hover {
    border-color: #4361ee;
}

.rc-action-download:hover {
    border-color: #10b981;
}

.rc-action-share:hover {
    border-color: #8b5cf6;
}

.rc-action-templates:hover {
    border-color: #f59e0b;
}

.rc-action-icon {
    font-size: 24px;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    color: #64748b;
    transition: all 0.2s ease;
}

.rc-action-edit .rc-action-icon {
    color: #4361ee;
}

.rc-action-download .rc-action-icon {
    color: #10b981;
}

.rc-action-share .rc-action-icon {
    color: #8b5cf6;
}

.rc-action-templates .rc-action-icon {
    color: #f59e0b;
}

.rc-action-card:hover .rc-action-icon {
    transform: scale(1.1);
}

.rc-action-content {
    flex: 1;
}

.rc-action-title {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 4px 0;
}

.rc-action-desc {
    font-size: 13px;
    color: #64748b;
    margin: 0;
    line-height: 1.4;
}

/* FAB */
.rc-fab-container {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 1000;
}

.rc-fab {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 24px;
    background: #4361ee;
    color: white;
    border: none;
    border-radius: 50px;
    box-shadow: 0 8px 24px rgba(67, 97, 238, 0.3);
    cursor: pointer;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    font-size: 16px;
    transition: all 0.3s ease;
}

.rc-fab:hover {
    background: #3a56d4;
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(67, 97, 238, 0.4);
}

.rc-fab .rc-fab-text {
    max-width: 0;
    overflow: hidden;
    white-space: nowrap;
    transition: max-width 0.3s ease;
}

.rc-fab:hover .rc-fab-text {
    max-width: 200px;
}

/* Scrollbar Styling */
.rc-preview-frame::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.rc-preview-frame::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.rc-preview-frame::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.rc-preview-frame::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .rc-preview-nav {
        padding: 12px 0;
    }
    
    .rc-nav-content {
        flex-direction: column;
        gap: 16px;
        align-items: stretch;
    }
    
    .rc-nav-actions {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .rc-preview-controls {
        flex-direction: column;
        gap: 16px;
        align-items: stretch;
    }
    
    .rc-controls-left, .rc-controls-right {
        justify-content: center;
    }
    
    .rc-action-grid {
        grid-template-columns: 1fr;
    }
    
    .rc-preview-frame {
        padding: 20px;
        min-height: auto;
    }
    
    .rc-fab {
        padding: 16px;
    }
    
    .rc-fab .rc-fab-text {
        display: none;
    }
}

/* Print Styles */
@media print {
    .rc-preview-container {
        background: white;
    }
    
    .rc-preview-nav,
    .rc-preview-sidebar,
    .rc-preview-controls,
    .rc-preview-actions,
    .rc-fab-container {
        display: none;
    }
    
    .rc-preview-grid {
        display: block;
        margin: 0;
    }
    
    .rc-preview-wrapper {
        border: none;
        box-shadow: none;
        margin: 0;
    }
    
    .rc-preview-frame {
        padding: 0;
        min-height: auto;
        background: white;
        overflow: visible;
    }
    
    .rc-theme-content {
        box-shadow: none;
        margin: 0;
        width: 100%;
        page-break-inside: avoid;
    }
    
    @page {
        margin: 0.5in;
        size: A4;
    }
    
    body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        background: white;
        margin: 0;
    }
}
</style>

<script>
// Zoom functionality
let currentZoom = 100;
const zoomStep = 10;
const minZoom = 50;
const maxZoom = 200;
const zoomText = document.getElementById('rcZoomText');
const previewFrame = document.getElementById('rcPreviewFrame');
const themeContent = document.querySelector('.rc-theme-content');

function zoomIn() {
    if (currentZoom < maxZoom) {
        currentZoom += zoomStep;
        updateZoom();
    }
}

function zoomOut() {
    if (currentZoom > minZoom) {
        currentZoom -= zoomStep;
        updateZoom();
    }
}

function resetZoom() {
    currentZoom = 100;
    updateZoom();
}

function updateZoom() {
    const scale = currentZoom / 100;
    if (themeContent) {
        themeContent.style.transform = `scale(${scale})`;
        themeContent.style.transformOrigin = 'top center';
        themeContent.style.width = `${100/scale}%`;
        themeContent.style.height = `${100/scale}%`;
    }
    zoomText.textContent = `${currentZoom}%`;
    
    // Adjust frame height based on zoom
    const baseHeight = 11 * 96; // 11 inches to pixels
    previewFrame.style.minHeight = `${baseHeight * scale}px`;
}

// Fullscreen functionality
function toggleFullscreen() {
    const previewWrapper = document.querySelector('.rc-preview-wrapper');
    if (!document.fullscreenElement) {
        previewWrapper.requestFullscreen().catch(err => {
            console.error(`Error attempting to enable fullscreen: ${err.message}`);
        });
    } else {
        document.exitFullscreen();
    }
}

// Share functionality
function shareResume() {
    if (navigator.share) {
        navigator.share({
            title: 'My Resume - <?= htmlspecialchars($data['personal']['fullName'] ?: 'Resume'); ?>',
            text: 'Check out my professional resume created with ResumeCraft',
            url: window.location.href
        })
        .then(() => console.log('Shared successfully'))
        .catch(error => console.log('Error sharing:', error));
    } else {
        navigator.clipboard.writeText(window.location.href)
            .then(() => {
                alert('Link copied to clipboard!');
            })
            .catch(err => {
                console.error('Failed to copy: ', err);
                alert('Please copy the URL manually: ' + window.location.href);
            });
    }
}

// Download shortcut
function downloadResume() {
    window.location.href = `<?= BASE_URL; ?>?page=download&theme=<?= urlencode($activeTheme['slug']); ?>`;
}

// Theme switching with smooth transition
document.addEventListener('DOMContentLoaded', function() {
    // Initialize zoom
    updateZoom();
    
    // Fullscreen change handler
    document.addEventListener('fullscreenchange', function() {
        const wrapper = document.querySelector('.rc-preview-wrapper');
        if (document.fullscreenElement) {
            wrapper.classList.add('rc-fullscreen');
            resetZoom();
        } else {
            wrapper.classList.remove('rc-fullscreen');
        }
    });
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + + to zoom in
    if ((e.ctrlKey || e.metaKey) && e.key === '=') {
        e.preventDefault();
        zoomIn();
    }
    // Ctrl/Cmd + - to zoom out
    if ((e.ctrlKey || e.metaKey) && e.key === '-') {
        e.preventDefault();
        zoomOut();
    }
    // Ctrl/Cmd + 0 to reset zoom
    if ((e.ctrlKey || e.metaKey) && e.key === '0') {
        e.preventDefault();
        resetZoom();
    }
    // Ctrl/Cmd + P to print
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        window.print();
    }
    // Ctrl/Cmd + D to download
    if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
        e.preventDefault();
        downloadResume();
    }
});
</script>
</body>
</html>