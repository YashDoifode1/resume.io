<?php
/**
 * Resume Preview Page - Updated with proper image handling
 */

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

// ========================================
// IMAGE HANDLING FOR PREVIEW
// ========================================
function getProfilePictureUrl($profilePicture) {
    if (empty($profilePicture)) {
        return BASE_URL . 'assets/images/default-profile.png';
    }
    
    // Check if it's already a full URL
    if (filter_var($profilePicture, FILTER_VALIDATE_URL)) {
        return $profilePicture;
    }
    
    // Check if it's a relative path starting with uploads/
    if (strpos($profilePicture, 'uploads/') === 0) {
        return BASE_URL . $profilePicture;
    }
    
    // If it's a filename without path, assume it's in uploads
    if (strpos($profilePicture, '/') === false && strpos($profilePicture, '\\') === false) {
        return BASE_URL . 'uploads/' . $profilePicture;
    }
    
    // Default fallback
    return BASE_URL . 'assets/images/default-profile.png';
}

// Get processed profile picture URL
$profilePictureUrl = getProfilePictureUrl($data['personal']['profilePicture'] ?? '');
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
            
            <!-- Image Info (for debugging) -->
            <div style="margin-top: 24px; padding: 12px; background: #f8f9fa; border-radius: 6px; font-size: 12px;">
                <strong>Image Status:</strong><br>
                <?php 
                $imagePath = $data['personal']['profilePicture'] ?? '';
                if (empty($imagePath) || strpos($imagePath, 'default-profile.png') !== false) {
                    echo 'Using default profile picture';
                } else {
                    echo 'Custom image loaded<br>';
                    echo '<small>' . htmlspecialchars(substr($imagePath, 0, 50)) . '...</small>';
                }
                ?>
            </div>
        </div>
    </aside>

    <!-- Main Preview -->
    <main class="preview-main">
        <div class="preview-controls">
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 16px;">
                <button onclick="window.print()" class="btn btn-primary btn-sm">
                    🖨️ Print Preview
                </button>
                <a href="<?= BASE_URL; ?>?page=download&theme=<?= $theme; ?>" 
                   class="btn btn-success btn-sm">
                    📥 Download PDF
                </a>
                <span style="font-size: 14px; color: #666; margin-left: auto;">
                    Theme: <strong><?= htmlspecialchars($themeMeta[$theme][1]); ?></strong>
                </span>
            </div>
        </div>
        
        <div class="resume-wrapper theme-<?= $theme; ?>" id="resume-preview">
            <?php
                // Pass the processed profile picture URL to the theme
                $data['personal']['processedProfilePicture'] = $profilePictureUrl;
                
                $themeFile = THEMES_PATH . $themeFiles[$theme];
                if (file_exists($themeFile)) {
                    // Include theme with data
                    include $themeFile;
                } else {
                    echo '<div style="padding: 40px; text-align: center; color: #666;">';
                    echo '<h3>Theme not found</h3>';
                    echo '<p>The selected theme template could not be loaded.</p>';
                    echo '<a href="' . BASE_URL . '?page=preview&theme=classic" class="btn btn-primary">';
                    echo 'Use Classic Theme';
                    echo '</a>';
                    echo '</div>';
                }
            ?>
        </div>
        
        <!-- Image Preview Test -->
        <div style="margin-top: 24px; padding: 16px; background: #f8f9fa; border-radius: 8px; font-size: 14px;">
            <strong>Profile Picture Test:</strong>
            <div style="display: flex; align-items: center; gap: 16px; margin-top: 12px;">
                <img src="<?= $profilePictureUrl; ?>" 
                     alt="Profile Preview" 
                     style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;"
                     onerror="this.onerror=null; this.src='<?= BASE_URL; ?>assets/images/default-profile.png';">
                <div>
                    <div><strong>URL:</strong> <?= htmlspecialchars(substr($profilePictureUrl, 0, 80)); ?>...</div>
                    <div><strong>Status:</strong> <span id="image-status">Loading...</span></div>
                </div>
            </div>
        </div>
    </main>

</div>

<script>
// Check if profile image loads successfully
document.addEventListener('DOMContentLoaded', function() {
    const profileImg = document.querySelector('#resume-preview img[alt*="Profile"], #resume-preview img[alt*="profile"]');
    const imageStatus = document.getElementById('image-status');
    
    if (profileImg) {
        profileImg.onload = function() {
            imageStatus.textContent = '✓ Loaded successfully';
            imageStatus.style.color = '#28a745';
        };
        
        profileImg.onerror = function() {
            imageStatus.textContent = '✗ Failed to load, using default';
            imageStatus.style.color = '#dc3545';
            
            // Try to set default image
            const defaultImg = '<?= BASE_URL; ?>assets/images/default-profile.png';
            if (profileImg.src !== defaultImg) {
                profileImg.src = defaultImg;
            }
        };
    } else {
        imageStatus.textContent = 'No profile image found in resume';
        imageStatus.style.color = '#ffc107';
    }
});

// Print optimization
function optimizeForPrint() {
    const resumeWrapper = document.getElementById('resume-preview');
    if (resumeWrapper) {
        // Ensure images are fully loaded before print
        const images = resumeWrapper.getElementsByTagName('img');
        Array.from(images).forEach(img => {
            if (!img.complete) {
                img.onload = function() {
                    window.print();
                };
            }
        });
    }
}
</script>

<style>
.preview-container {
    display: flex;
    gap: 24px;
    min-height: calc(100vh - 200px);
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

.preview-sidebar {
    width: 300px;
    background: var(--color-bg-secondary);
    padding: 24px;
    border-radius: 12px;
    height: fit-content;
    position: sticky;
    top: 100px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.sidebar-content h2 {
    margin-bottom: 16px;
    color: var(--color-primary);
    font-size: 20px;
    font-weight: 600;
}

.theme-buttons {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 32px;
    max-height: 400px;
    overflow-y: auto;
    padding-right: 8px;
}

.theme-buttons::-webkit-scrollbar {
    width: 6px;
}

.theme-buttons::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.theme-buttons::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.theme-buttons::-webkit-scrollbar-thumb:hover {
    background: #555;
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
    font-size: 14px;
}

.theme-btn:hover {
    border-color: var(--color-primary);
    background: var(--color-primary);
    color: white;
    transform: translateX(4px);
}

.theme-btn.active {
    background: var(--color-primary);
    color: white;
    border-color: var(--color-primary);
    box-shadow: 0 2px 8px rgba(var(--color-primary-rgb), 0.3);
}

.sidebar-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.btn {
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
    text-decoration: none;
    text-align: center;
    display: inline-block;
}

.btn-primary {
    background: var(--color-primary);
    color: white;
}

.btn-primary:hover {
    background: var(--color-primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(var(--color-primary-rgb), 0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-success:hover {
    background: #218838;
    transform: translateY(-2px);
}

.btn-sm {
    padding: 8px 16px;
    font-size: 14px;
}

.btn-block {
    width: 100%;
    display: block;
}

.preview-main {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    background: var(--color-bg-secondary);
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.preview-controls {
    background: white;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.resume-wrapper {
    background: white;
    max-width: 8.5in;
    min-height: 11in;
    margin: 0 auto;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    border-radius: 8px;
    overflow: hidden;
    position: relative;
}

/* Ensure images in resume print properly */
.resume-wrapper img {
    max-width: 100%;
    height: auto;
}

@media (max-width: 1200px) {
    .preview-container {
        flex-direction: column;
        padding: 16px;
    }
    
    .preview-sidebar {
        width: 100%;
        position: static;
        margin-bottom: 24px;
    }
    
    .theme-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        max-height: none;
    }
}

@media (max-width: 768px) {
    .preview-container {
        padding: 12px;
    }
    
    .preview-main {
        padding: 16px;
    }
    
    .theme-buttons {
        grid-template-columns: 1fr;
    }
    
    .resume-wrapper {
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
}

@media print {
    .preview-sidebar,
    .preview-main > .preview-controls,
    .preview-main > div:last-child {
        display: none !important;
    }
    
    .preview-container {
        display: block;
        padding: 0;
        margin: 0;
    }
    
    .preview-main {
        padding: 0;
        margin: 0;
        background: none;
        box-shadow: none;
    }
    
    .resume-wrapper {
        max-width: 100%;
        min-height: auto;
        box-shadow: none;
        border-radius: 0;
        margin: 0;
        page-break-inside: avoid;
        break-inside: avoid;
    }
    
    /* Ensure images print properly */
    .resume-wrapper img {
        max-width: 100% !important;
        height: auto !important;
    }
    
    /* Force background colors for print */
    @media print and (color) {
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
}
</style>