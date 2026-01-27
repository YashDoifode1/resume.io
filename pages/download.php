<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * PDF Download Handler - Database Theme Integration
 * 
 * Generates and downloads resume as PDF using DOMPDF or mPDF
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php'; // Add database connection
require_once __DIR__ . '/../utils/pdf-generator.php';

// Ensure session data exists
if (!isset($_SESSION['resume_data'])) {
    header('Location: ' . BASE_URL . '?page=builder');
    exit;
}

$data = $_SESSION['resume_data'];
$requestedThemeSlug = isset($_GET['theme']) ? sanitize_input($_GET['theme']) : '';

// ================= THEME RESOLUTION LOGIC =================
try {
    // Get all available themes from database first
    $allThemesStmt = $pdo->query("
        SELECT id, slug, name, description, icon, file_name, is_active, is_premium 
        FROM themes 
        WHERE is_active = 1 
        ORDER BY is_premium DESC, name ASC
    ");
    $allThemes = $allThemesStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Default fallback theme slug
    $defaultThemeSlug = 'modern';
    $activeTheme = null;
    $themeErrorMessage = '';
    
    // If theme slug provided, use it; otherwise use session theme or default
    if (empty($requestedThemeSlug) && isset($_SESSION['active_theme_slug'])) {
        $requestedThemeSlug = $_SESSION['active_theme_slug'];
    }
    
    // Fetch the matching active theme from database
    if (!empty($requestedThemeSlug)) {
        $stmt = $pdo->prepare("
            SELECT id, slug, name, description, icon, file_name, is_active, is_premium 
            FROM themes 
            WHERE slug = :slug AND is_active = 1
            LIMIT 1
        ");
        $stmt->execute([':slug' => $requestedThemeSlug]);
        $activeTheme = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // If requested theme not found or not active, fallback to default
    if (!$activeTheme) {
        $stmt = $pdo->prepare("
            SELECT id, slug, name, description, icon, file_name, is_active, is_premium 
            FROM themes 
            WHERE slug = :slug AND is_active = 1
            LIMIT 1
        ");
        $stmt->execute([':slug' => $defaultThemeSlug]);
        $activeTheme = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($activeTheme && !empty($requestedThemeSlug)) {
            $themeErrorMessage = "Requested theme not available. Using default theme.";
        }
    }
    
    // If still no theme, fetch first active theme as ultimate fallback
    if (!$activeTheme && !empty($allThemes)) {
        $activeTheme = $allThemes[0];
    }
    
    // Store active theme in session for consistency
    if ($activeTheme) {
        $_SESSION['active_theme_slug'] = $activeTheme['slug'];
    } else {
        // If database is empty or no themes, use hardcoded fallback
        $activeTheme = [
            'slug' => 'modern',
            'name' => 'Modern Template',
            'description' => 'Fallback modern template',
            'file_name' => 'theme2-modern.php',
            'is_premium' => 0
        ];
    }
    
    // ✅ REAL theme → file mapping as fallback if database file not found
    $themeFiles = [
        'modern'     => 'theme2-modern.php',
        'corporate'  => 'theme3-corporate.php',
        'creative'   => 'theme4-creative.php',
        'dark'       => 'theme5-dark.php',
        'elegant'    => 'theme6-elegant.php',
        'tech'       => 'theme7-tech.php',
        'minimal'    => 'theme8-minimal.php',
        'vibrant'    => 'theme9-vibrant.php',
        'executive'  => 'theme10-executive.php',
        'gradient'   => 'theme11-gradient.php',
        'sidebar'    => 'theme12-sidebar.php',
        'minimalist' => 'theme13-minimalist.php',
        'colorful'   => 'theme14-colorful.php',
        'timeline'   => 'theme15-timeline.php'
    ];
    
    // Determine final theme file path
    $themeSlug = $activeTheme['slug'];
    $templateFile = $activeTheme['file_name'] ?? '';
    $themeFilePath = null;
    
    // Security: Only allow alphanumeric, hyphens, underscores, and dots
    if (!empty($templateFile) && preg_match('/^[a-zA-Z0-9_\-\.]+\.php$/', $templateFile)) {
        $templatePath = THEMES_PATH . basename($templateFile);
        
        // Verify the template file exists
        if (file_exists($templatePath)) {
            $themeFilePath = $templatePath;
        } else {
            // Try to find in theme files mapping
            if (isset($themeFiles[$themeSlug]) && file_exists(THEMES_PATH . $themeFiles[$themeSlug])) {
                $themeFilePath = THEMES_PATH . $themeFiles[$themeSlug];
            }
        }
    }
    
    // If still no valid file, use mapping or modern as fallback
    if (!$themeFilePath) {
        // Try mapping based on slug
        if (isset($themeFiles[$themeSlug]) && file_exists(THEMES_PATH . $themeFiles[$themeSlug])) {
            $themeFilePath = THEMES_PATH . $themeFiles[$themeSlug];
        } else {
            // Ultimate fallback
            $themeFilePath = THEMES_PATH . 'theme2-modern.php';
        }
    }
    
    // Final safety check
    if (!file_exists($themeFilePath)) {
        throw new Exception("Theme file not found: " . basename($themeFilePath));
    }
    
} catch (Exception $e) {
    // Log error and use hardcoded fallback
    error_log("Theme Error in PDF Generation: " . $e->getMessage());
    
    // Ultimate fallback
    $activeTheme = [
        'slug' => 'modern',
        'name' => 'Modern Template',
        'description' => 'Fallback modern template',
        'file_name' => 'theme2-modern.php',
        'is_premium' => 0
    ];
    $themeFilePath = THEMES_PATH . 'theme2-modern.php';
    
    if (!file_exists($themeFilePath)) {
        // Emergency: try to find any theme file
        $themeFilesDir = scandir(THEMES_PATH);
        foreach ($themeFilesDir as $file) {
            if (preg_match('/^theme\d+-.+\.php$/', $file)) {
                $themeFilePath = THEMES_PATH . $file;
                break;
            }
        }
    }
}

// Function to get profile picture URL for PDF
function getProfilePictureForPDF($profilePicture) {
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

// Process profile picture for PDF
$profilePictureUrl = getProfilePictureForPDF($data['personal']['profilePicture'] ?? '');
$data['personal']['pdfProfilePicture'] = $profilePictureUrl;

// Clear any buffered output for clean PDF generation
ob_end_clean();

try {
    // Generate HTML content from theme
    ob_start();
    $data['personal']['processedProfilePicture'] = $profilePictureUrl;
    $themeSlug = $activeTheme['slug'];
    $isPremium = $activeTheme['is_premium'];
    include $themeFilePath;
    $themeHtml = ob_get_clean();
    
    if (empty($themeHtml) || trim($themeHtml) === '') {
        throw new Exception("Theme template generated empty content.");
    }
    
    // Create complete HTML document with proper styling
    $fullName = htmlspecialchars($data['personal']['fullName'] ?? 'Resume');
    $jobTitle = htmlspecialchars($data['personal']['jobTitle'] ?? '');
    $themeName = htmlspecialchars($activeTheme['name']);
    
    $html = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>' . $fullName . ' - Resume (' . $themeName . ')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            /* Base PDF styles - will be overridden by theme styles */
            * { 
                margin: 0; 
                padding: 0; 
                box-sizing: border-box; 
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            body { 
                font-family: DejaVu Sans, "Segoe UI", "Roboto", "Helvetica Neue", Arial, sans-serif; 
                line-height: 1.5; 
                color: #333333;
                background: #ffffff;
                font-size: 12pt;
                width: 100%;
                margin: 0;
                padding: 0;
            }
            
            /* Page container */
            .resume-container {
                width: 8.3in;
                min-height: 11.7in;
                padding: 0.5in;
                background: white;
                margin: 0 auto;
            }
            
            /* Utility classes */
            .page-break {
                page-break-before: always;
            }
            
            .no-break {
                page-break-inside: avoid;
                break-inside: avoid;
            }
            
            .avoid-break {
                page-break-inside: avoid;
            }
            
            /* Common section styling */
            .section {
                margin-bottom: 15px;
                page-break-inside: avoid;
                break-inside: avoid;
            }
            
            /* Image handling for PDF */
            img {
                max-width: 100%;
                height: auto;
                display: block;
            }
            
            /* Ensure background colors print */
            .bg-colored,
            [style*="background"] {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            /* Links */
            a {
                color: #3498db;
                text-decoration: none;
            }
            
            a[href^="http"]::after {
                content: " (" attr(href) ")";
                font-size: 90%;
                opacity: 0.8;
            }
            
            /* Print-specific styles */
            @media print {
                body {
                    margin: 0 !important;
                    padding: 0 !important;
                    width: 100%;
                    background: white !important;
                }
                
                .resume-container {
                    width: 100%;
                    max-width: 100%;
                    margin: 0;
                    padding: 0.5in;
                    box-shadow: none !important;
                }
                
                .page-break {
                    page-break-before: always;
                }
                
                .avoid-break {
                    page-break-inside: avoid;
                }
                
                /* Hide interactive elements */
                .no-print,
                button,
                .btn,
                [onclick] {
                    display: none !important;
                }
                
                /* Ensure all colors print */
                * {
                    -webkit-print-color-adjust: exact !important;
                    color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
            }
            
            /* Clear any output buffering artifacts */
            .theme-meta {
                display: none;
            }
            
            .page-count {
                display: none;
            }
        </style>
        
        <!-- Theme-specific styles will be included here -->
        <style>
            /* Additional base styles for PDF compatibility */
            .clearfix::after {
                content: "";
                clear: both;
                display: table;
            }
            
            .text-center { text-align: center; }
            .text-left { text-align: left; }
            .text-right { text-align: right; }
            .font-bold { font-weight: bold; }
            .mt-1 { margin-top: 5px; }
            .mt-2 { margin-top: 10px; }
            .mt-3 { margin-top: 15px; }
            .mb-1 { margin-bottom: 5px; }
            .mb-2 { margin-bottom: 10px; }
            .mb-3 { margin-bottom: 15px; }
            .ml-1 { margin-left: 5px; }
            .ml-2 { margin-left: 10px; }
            .ml-3 { margin-left: 15px; }
            .mr-1 { margin-right: 5px; }
            .mr-2 { margin-right: 10px; }
            .mr-3 { margin-right: 15px; }
            .p-1 { padding: 5px; }
            .p-2 { padding: 10px; }
            .p-3 { padding: 15px; }
        </style>
    </head>
    <body>
        <div class="resume-container">
            <div class="theme-content">
                ' . $themeHtml . '
            </div>
        </div>
    </body>
    </html>';

    // Generate filename
    $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $fullName);
    $cleanName = preg_replace('/_+/', '_', $cleanName);
    $filename = 'Resume_' . $cleanName . '_' . date('Y-m-d') . '.pdf';
    
    // Clean filename further
    $filename = str_replace(' ', '_', $filename);
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);

    // Initialize PDF generator
    $pdfGenerator = new PDFGenerator();
    
    // Set PDF options with better defaults for database themes
    $pdfOptions = [
        'defaultFont' => 'DejaVu Sans', // Supports more characters
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true, // Allow loading images from URLs
        'isPhpEnabled' => false,
        'dpi' => 150, // Higher DPI for better quality
        'marginTop' => 10,
        'marginBottom' => 10,
        'marginLeft' => 10,
        'marginRight' => 10,
        'paperSize' => 'A4',
        'orientation' => 'portrait',
        'defaultPaperSize' => 'A4',
        'fontHeightRatio' => 1.1,
        'isFontSubsettingEnabled' => true, // Reduce file size
        'chroot' => realpath(__DIR__ . '/../'), // Security restriction
        'logOutputFile' => __DIR__ . '/../logs/dompdf.log', // Optional logging
    ];
    
    // Add fonts for better Unicode support if available
    $fontDir = __DIR__ . '/../vendor/dompdf/dompdf/lib/fonts/';
    if (is_dir($fontDir)) {
        $pdfOptions['fontDir'] = $fontDir;
        $pdfOptions['fontCache'] = $fontDir;
    }
    
    $pdfGenerator->setOptions($pdfOptions);

    // Generate PDF with error handling - Use stream() method for clean output
    try {
        $pdfGenerator->stream($html, $filename);
        
        // Log successful generation
        error_log("PDF generated successfully: $filename, Theme: " . $activeTheme['slug']);
        
    } catch (Exception $pdfError) {
        throw new Exception("PDF generation failed: " . $pdfError->getMessage());
    }
    
} catch (Exception $e) {
    // Clean any output buffers
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    // Log error
    $errorDetails = [
        'message' => $e->getMessage(),
        'theme' => $activeTheme['slug'] ?? 'unknown',
        'theme_file' => $activeTheme['file_name'] ?? 'unknown',
        'trace' => $e->getTraceAsString(),
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    error_log('PDF Generation Error: ' . print_r($errorDetails, true));
    
    // Show detailed error message
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDF Generation Error - ResumeCraft</title>
        <style>
            body { 
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
                margin: 0;
                padding: 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .error-container {
                background: white;
                border-radius: 12px;
                padding: 40px;
                max-width: 700px;
                width: 100%;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
            
            .error-header {
                color: #dc3545;
                margin-bottom: 24px;
                text-align: center;
            }
            
            .error-header h1 {
                font-size: 28px;
                margin-bottom: 10px;
            }
            
            .error-content {
                background: #f8f9fa;
                border-radius: 8px;
                padding: 24px;
                margin-bottom: 24px;
            }
            
            .error-message {
                color: #721c24;
                background: #f8d7da;
                border: 1px solid #f5c6cb;
                padding: 16px;
                border-radius: 6px;
                margin-bottom: 20px;
                font-family: monospace;
                font-size: 14px;
                line-height: 1.5;
            }
            
            .solution-list {
                margin: 20px 0;
                padding-left: 20px;
            }
            
            .solution-list li {
                margin-bottom: 10px;
                line-height: 1.6;
            }
            
            .debug-info {
                background: #e9ecef;
                padding: 16px;
                border-radius: 6px;
                font-size: 13px;
                margin-top: 20px;
                font-family: monospace;
                word-wrap: break-word;
            }
            
            .debug-title {
                font-weight: bold;
                color: #495057;
                margin-bottom: 8px;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            
            .action-buttons {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .btn {
                padding: 14px 28px;
                border-radius: 8px;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
                border: none;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-size: 15px;
            }
            
            .btn-primary {
                background: #3498db;
                color: white;
            }
            
            .btn-primary:hover {
                background: #2980b9;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
            }
            
            .btn-secondary {
                background: #6c757d;
                color: white;
            }
            
            .btn-secondary:hover {
                background: #5a6268;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
            }
            
            .btn-warning {
                background: #f39c12;
                color: white;
            }
            
            .btn-warning:hover {
                background: #e67e22;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
            }
            
            .print-fallback {
                margin-top: 30px;
                padding-top: 24px;
                border-top: 1px solid #dee2e6;
                text-align: center;
                color: #6c757d;
            }
            
            .theme-info {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 16px;
                padding: 12px;
                background: #e3f2fd;
                border-radius: 6px;
                border-left: 4px solid #2196f3;
            }
            
            .theme-icon {
                font-size: 24px;
            }
            
            .theme-details h4 {
                margin: 0 0 4px 0;
                color: #1976d2;
            }
            
            .theme-details p {
                margin: 0;
                color: #546e7a;
                font-size: 14px;
            }
            
            @media (max-width: 768px) {
                .error-container {
                    padding: 24px;
                }
                
                .action-buttons {
                    flex-direction: column;
                }
                
                .btn {
                    width: 100%;
                    justify-content: center;
                }
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-header">
                <h1>⚠️ PDF Generation Failed</h1>
                <p>We couldn\'t generate your PDF resume. Here are some solutions:</p>
            </div>
            
            <div class="theme-info">
                <div class="theme-icon">' . ($activeTheme['icon'] ?? '📄') . '</div>
                <div class="theme-details">
                    <h4>' . htmlspecialchars($activeTheme['name'] ?? 'Unknown Theme') . '</h4>
                    <p>' . htmlspecialchars($activeTheme['description'] ?? '') . '</p>
                </div>
            </div>
            
            <div class="error-content">
                <div class="error-message">
                    <strong>Error Details:</strong><br>
                    ' . htmlspecialchars($e->getMessage()) . '
                </div>
                
                <h3>🔧 Try These Solutions:</h3>
                <ol class="solution-list">
                    <li><strong>Use Browser Print:</strong> Press <kbd>Ctrl+P</kbd> (Windows) or <kbd>Cmd+P</kbd> (Mac) and select "Save as PDF"</li>
                    <li><strong>Try Different Theme:</strong> Some themes may have compatibility issues with PDF generation</li>
                    <li><strong>Check Profile Picture:</strong> Ensure your profile picture is accessible (JPG/PNG format recommended)</li>
                    <li><strong>Simplify Content:</strong> Remove complex formatting or very large images</li>
                    <li><strong>Clear Cache:</strong> Clear browser cache and try again</li>
                </ol>
                
                <div class="debug-info">
                    <div class="debug-title">
                        <i class="fas fa-bug"></i> Debug Information:
                    </div>
                    <strong>Selected Theme:</strong> ' . htmlspecialchars($activeTheme['slug'] ?? 'unknown') . '<br>
                    <strong>Theme File:</strong> ' . htmlspecialchars($activeTheme['file_name'] ?? 'Not found') . '<br>
                    <strong>Theme Status:</strong> ' . ($activeTheme['is_premium'] ? 'Premium' : 'Free') . '<br>
                    <strong>Generated:</strong> ' . date('Y-m-d H:i:s') . '<br>
                    <strong>Resume Name:</strong> ' . htmlspecialchars($data['personal']['fullName'] ?? 'Not set') . '
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="' . BASE_URL . '?page=preview&theme=' . htmlspecialchars($activeTheme['slug'] ?? 'modern') . '" class="btn btn-primary">
                    <i class="fas fa-eye"></i> Back to Preview
                </a>
                <a href="' . BASE_URL . '?page=builder&theme=' . htmlspecialchars($activeTheme['slug'] ?? 'modern') . '" class="btn btn-secondary">
                    <i class="fas fa-edit"></i> Edit Resume
                </a>
                <button onclick="window.print()" class="btn btn-warning">
                    <i class="fas fa-print"></i> Print Instead
                </button>
            </div>
            
            <div class="print-fallback">
                <p><strong>💡 Quick Alternative:</strong> Press <kbd>Ctrl+P</kbd> → Choose "Microsoft Print to PDF" or "Save as PDF" for instant results.</p>
                <p style="font-size: 13px; margin-top: 8px; color: #868e96;">
                    <i class="fas fa-info-circle"></i> Browser PDF export often provides better quality than automated generation.
                </p>
            </div>
        </div>
        
        <!-- Font Awesome for icons -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    </body>
    </html>';
    exit;
}

/**
 * Sanitize input
 */
// function sanitize_input($input) {
//     return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
// }
?>