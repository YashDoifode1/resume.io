<?php
/**
 * Resume Builder Pro - Main Router
 * 
 * This is the main entry point for the application.
 * All requests are routed through this file.
 */

// Start session
session_start();

// Include configuration
require_once __DIR__ . '/config/constants.php';

// Include logger
require_once __DIR__ . '/utils/logger.php';

// Log visitor
$logger = new Logger();
$logger->logVisitor();

// Get the requested page
$page = isset($_GET['page']) ? sanitize_input($_GET['page']) : 'home';

// List of valid pages
$valid_pages = ['home', 'about', 'builder', 'preview', 'contact', 'faq', 'privacy', 'terms', 'download'];

// Handle PDF download separately (before header inclusion)
if ($page === 'download') {
    require_once __DIR__ . '/utils/pdf-generator.php';
    
    if (!isset($_SESSION['resume_data'])) {
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: text/plain');
        echo 'Error: No resume data found. Please fill out the resume form first.';
        exit;
    }
    
    $data = $_SESSION['resume_data'];
    $theme = isset($_GET['theme']) ? sanitize_input($_GET['theme']) : 'classic';
    
    // Validate theme
    $validThemes = ['classic', 'modern', 'corporate', 'creative', 'dark', 'elegant', 'tech', 'minimal', 'vibrant', 'executive'];
    if (!in_array($theme, $validThemes)) {
        $theme = 'classic';
    }
    
    // Map theme names to files
    $themeFiles = [
        'classic' => 'theme1-classic.php',
        'modern' => 'theme2-modern.php',
        'corporate' => 'theme3-corporate.php',
        'creative' => 'theme4-creative.php',
        'dark' => 'theme5-dark.php',
        'elegant' => 'theme6-elegant.php',
        'tech' => 'theme7-tech.php',
        'minimal' => 'theme8-minimal.php',
        'vibrant' => 'theme9-vibrant.php',
        'executive' => 'theme10-executive.php'
    ];
    
    try {
        // Generate HTML content
        ob_start();
        include THEMES_PATH . $themeFiles[$theme];
        $html = ob_get_clean();
        
        // Wrap with proper HTML structure for PDF
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; }
                @media print { 
                    body { margin: 0; padding: 0; } 
                    .resume-wrapper { page-break-after: avoid; }
                }
                .resume-wrapper { max-width: 8.5in; margin: 0 auto; }
            </style>
        </head>
        <body>' . $html . '</body>
        </html>';
        
        // Generate filename
        $fullName = $data['personal']['fullName'] ?? 'resume';
        $filename = 'resume_' . str_replace(' ', '_', $fullName) . '_' . $theme . '.pdf';
        
        // Initialize PDF generator
        $pdfGenerator = new PDFGenerator();
        
        // Generate and download PDF
        $pdfGenerator->generatePDF($html, $filename);
        exit;
        
    } catch (Exception $e) {
        error_log('PDF Generation Error: ' . $e->getMessage());
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: text/html; charset=utf-8');
        echo 'Error: ' . htmlspecialchars($e->getMessage());
        exit;
    }
}

// Validate page
if (!in_array($page, $valid_pages)) {
    $page = 'home';
}

// Set page-specific variables
switch ($page) {
    case 'home':
        $page_title = 'Home';
        $page_description = 'Create professional resumes in minutes with our AI-powered resume builder.';
        break;
    case 'about':
        $page_title = 'About';
        $page_description = 'Learn about ResumeBuilder Pro and how we help professionals create stunning resumes.';
        break;
    case 'builder':
        $page_title = 'Resume Builder';
        $page_description = 'Create your professional resume with our easy-to-use resume builder.';
        $page_js = 'builder.js';
        break;
    case 'preview':
        $page_title = 'Preview Resume';
        $page_description = 'Preview your resume and download as PDF.';
        break;
    case 'contact':
        $page_title = 'Contact Us';
        $page_description = 'Get in touch with ResumeBuilder Pro.';
        break;
    case 'faq':
        $page_title = 'FAQ';
        $page_description = 'Frequently asked questions about ResumeBuilder Pro.';
        break;
    case 'privacy':
        $page_title = 'Privacy Policy';
        $page_description = 'Privacy Policy for ResumeBuilder Pro.';
        break;
    case 'terms':
        $page_title = 'Terms of Service';
        $page_description = 'Terms of Service for ResumeBuilder Pro.';
        break;
}

// Include header
require_once COMPONENTS_PATH . 'header.php';
?>

<!-- Navigation -->
<?php require_once COMPONENTS_PATH . 'navbar.php'; ?>

<!-- Main Content -->
<main>
    <?php
    // Include the requested page
    $page_file = PAGES_PATH . $page . '.php';
    if (file_exists($page_file)) {
        require_once $page_file;
    } else {
        // 404 page
        echo '<section class="section"><div class="container"><h1>Page Not Found</h1><p>The page you are looking for does not exist.</p></div></section>';
    }
    ?>
</main>

<!-- Footer -->
<?php require_once COMPONENTS_PATH . 'footer.php'; ?>

<?php
/**
 * Utility Functions
 */

/**
 * Sanitize input
 */
function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate URL
 */
function validate_url($url) {
    return filter_var($url, FILTER_VALIDATE_URL);
}

/**
 * Generate CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(CSRF_TOKEN_LENGTH));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get CSRF token field
 */
function csrf_field() {
    echo '<input type="hidden" name="csrf_token" value="' . generate_csrf_token() . '">';
}

/**
 * Redirect
 */
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

/**
 * Get file size in human readable format
 */
function format_bytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, $precision) . ' ' . $units[$pow];
}

/**
 * Get current URL
 */
function current_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Check if current page
 */
function is_current_page($page_name) {
    return isset($_GET['page']) && $_GET['page'] === $page_name;
}
?>
