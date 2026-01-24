<?php
/**
 * Resume Builder Pro - Main Router
 *
 * Public application entry point.
 * Admin panel is handled separately under /admin
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

// Get requested page
$page = isset($_GET['page']) ? sanitize_input($_GET['page']) : 'home';

/**
 * SECURITY: Block admin access via public router
 * Admin panel must be accessed via /admin/*
 */
if ($page === 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit('Access denied.');
}

// List of valid public pages
$valid_pages = [
    'home',
    'about',
    'builder',
    'preview',
    'contact',
    'faq',
    'privacy',
    'terms',
    'download',
    'new',
    'ui'
];

/**
 * Handle PDF download separately
 */
if ($page === 'download') {
    require_once __DIR__ . '/utils/pdf-generator.php';

    if (!isset($_SESSION['resume_data'])) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Error: No resume data found.';
        exit;
    }

    $data = $_SESSION['resume_data'];
    $theme = isset($_GET['theme']) ? sanitize_input($_GET['theme']) : 'classic';

    $validThemes = [
        'classic', 'modern', 'corporate', 'creative', 'dark',
        'elegant', 'tech', 'minimal', 'vibrant', 'executive'
    ];

    if (!in_array($theme, $validThemes)) {
        $theme = 'classic';
    }

    $themeFiles = [
        'classic'   => 'theme1-classic.php',
        'modern'    => 'theme2-modern.php',
        'corporate' => 'theme3-corporate.php',
        'creative'  => 'theme4-creative.php',
        'dark'      => 'theme5-dark.php',
        'elegant'   => 'theme6-elegant.php',
        'tech'      => 'theme7-tech.php',
        'minimal'   => 'theme8-minimal.php',
        'vibrant'   => 'theme9-vibrant.php',
        'executive' => 'theme10-executive.php'
    ];

    ob_start();
    include THEMES_PATH . $themeFiles[$theme];
    $html = ob_get_clean();

    $html = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; }
            .resume-wrapper { max-width: 8.5in; margin: auto; }
        </style>
    </head>
    <body>' . $html . '</body>
    </html>';

    $fullName = $data['personal']['fullName'] ?? 'resume';
    $filename = 'resume_' . str_replace(' ', '_', $fullName) . '.pdf';

    $pdf = new PDFGenerator();
    $pdf->generatePDF($html, $filename);
    exit;
}

// Validate page
if (!in_array($page, $valid_pages)) {
    $page = 'home';
}

// Page metadata
switch ($page) {
    case 'home':
        $page_title = 'Home';
        break;
    case 'about':
        $page_title = 'About';
        break;
    case 'builder':
        $page_title = 'Resume Builder';
        $page_js = 'builder.js';
        break;
    case 'preview':
        $page_title = 'Preview Resume';
        break;
    case 'contact':
        $page_title = 'Contact';
        break;
    case 'faq':
        $page_title = 'FAQ';
        break;
    case 'privacy':
        $page_title = 'Privacy Policy';
        break;
    case 'terms':
        $page_title = 'Terms of Service';
        break;
    case 'new':
        $page_title = 'New';
        break;
    case 'ui':
        $page_title = 'UI';
        break;
    default:
        $page_title = 'Resume Builder';
}

// Header
require_once COMPONENTS_PATH . 'header.php';
?>

<!-- Navbar -->
<?php require_once COMPONENTS_PATH . 'navbar.php'; ?>

<!-- Main Content -->
<main>
<?php
$page_file = PAGES_PATH . $page . '.php';

if (file_exists($page_file)) {
    require_once $page_file;
} else {
    echo '<h1>404 - Page Not Found</h1>';
}
?>
</main>

<!-- Footer -->
<?php require_once COMPONENTS_PATH . 'footer.php'; ?>

<?php
/**
 * ======================
 * Utility Functions
 * ======================
 */

function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Admin helpers
 */
function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}
?>
