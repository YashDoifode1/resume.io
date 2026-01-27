<?php
/**
 * ResumeCraft - Main Public Router
 *
 * RULES:
 * - HTML routing ONLY
 * - PDF generation handled separately
 * - NO output before headers
 */

// ======================
// SESSION
// ======================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ======================
// CONFIG & CORE
// ======================
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/utils/logger.php';

// Logger MUST NOT echo
$logger = new Logger();
$logger->logVisitor();

// ======================
// INPUT
// ======================
$page = isset($_GET['page']) ? sanitize_input($_GET['page']) : 'home';

// ======================
// SECURITY
// ======================
if ($page === 'admin') {
    http_response_code(403);
    exit('Access denied');
}

// ======================
// 🔥 PDF DOWNLOAD ROUTE (EARLY EXIT)
// ======================
if ($page === 'download') {
    // IMPORTANT:
    // - No header/footer
    // - No HTML
    // - Direct binary response
    require_once __DIR__ . '/pages/download.php';
    exit;
}

// ======================
// ALLOWED HTML PAGES
// ======================
$valid_pages = [
    'home',
    'about',
    'builder',
    'preview',
    'contact',
    'faq',
    'privacy',
    'terms',
    'new'
];

// Fallback
if (!in_array($page, $valid_pages, true)) {
    $page = 'home';
}

// ======================
// PAGE METADATA
// ======================
$page_title = 'ResumeCraft';
$page_js = null;

switch ($page) {
    case 'home':
        $page_title = 'Home';
        break;

    case 'about':
        $page_title = 'About';
        break;

    case 'builder':
        $page_title = 'Build Resume';
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
}

// ======================
// HTML OUTPUT STARTS
// ======================
require_once COMPONENTS_PATH . 'header.php';
require_once COMPONENTS_PATH . 'navbar.php';
?>

<main>
<?php
$page_file = PAGES_PATH . $page . '.php';

if (file_exists($page_file)) {
    require $page_file;
} else {
    http_response_code(404);
    echo '<h1>404 - Page Not Found</h1>';
}
?>
</main>

<?php
require_once COMPONENTS_PATH . 'footer.php';

// ======================
// UTILITIES
// ======================
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
    return isset($_SESSION['csrf_token']) &&
           hash_equals($_SESSION['csrf_token'], $token);
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}
