<?php
/**
 * ==========================================================
 * Resume Builder - Global Constants Configuration
 * ==========================================================
 * Loads environment variables and defines all global constants
 * used throughout the application.
 */

// ==========================================================
// Session (must be first)
// ==========================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==========================================================
// Load Environment & DB
// ==========================================================
require_once __DIR__ . '/env.php';
require_once __DIR__ . '/db.php';

// ==========================================================
// Application Core
// ==========================================================
define('APP_NAME', env('APP_NAME', 'Resume Builder'));
define('APP_ENV', env('APP_ENV', 'local'));
define('APP_DEBUG', filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN));

define('BASE_URL', rtrim(env('BASE_URL'), '/') . '/');
define('ADMIN_REGISTRATION_ENABLED', filter_var(env('ADMIN_REGISTRATION_ENABLED'), FILTER_VALIDATE_BOOLEAN));
define('DEFAULT_THEME', env('DEFAULT_THEME', 'modern'));
// define('BASE_PATH', realpath(__DIR__ . '/../'));
// ==========================================================
// Root Paths
// ==========================================================
define('ROOT_PATH', dirname(__DIR__) . '/');
define('CONFIG_PATH', ROOT_PATH . 'config/');
define('ASSETS_PATH', ROOT_PATH . 'assets/');
define('UPLOADS_PATH', ROOT_PATH . 'uploads/');
define('THEMES_PATH', ROOT_PATH . 'themes/');
define('PAGES_PATH', ROOT_PATH . 'pages/');
define('COMPONENTS_PATH', ROOT_PATH . 'components/');
define('LOGS_PATH', ROOT_PATH . 'logs/');

// ==========================================================
// URLs
// ==========================================================
define('ASSETS_URL', BASE_URL . 'assets/');
define('CSS_URL', ASSETS_URL . 'css/');
define('JS_URL', ASSETS_URL . 'js/');
define('IMAGES_URL', ASSETS_URL . 'images/');
define('UPLOADS_URL', BASE_URL . 'uploads/');

// ==========================================================
// Database
// ==========================================================
define('DB_HOST', env('DB_HOST'));
define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASS', env('DB_PASS'));
define('DB_CHARSET', 'utf8mb4');

// ==========================================================
// Site Information
// ==========================================================
define('SITE_NAME', env('SITE_NAME'));
define('SITE_DESCRIPTION', env('SITE_DESCRIPTION'));
define('SITE_AUTHOR', env('SITE_AUTHOR'));
define('SITE_KEYWORDS', env('SITE_KEYWORDS'));

// ==========================================================
// Contact Information
// ==========================================================
define('CONTACT_EMAIL', env('CONTACT_EMAIL'));
define('CONTACT_PHONE', env('CONTACT_PHONE'));
define('CONTACT_ADDRESS', env('CONTACT_ADDRESS'));
define('CONTACT_BUSINESS_HOURS', 'Monday – Friday, 9:00 AM – 6:00 PM IST');

// ==========================================================
// Owner Information
// ==========================================================
define('OWNER_NAME', 'Yash Doifode');
define('OWNER_TITLE', 'Founder & Developer');
define('OWNER_LOCATION', 'Nagpur, Maharashtra');
define('OWNER_BIO', 'Passionate about creating tools that help professionals build their careers');

// ==========================================================
// Upload Configuration
// ==========================================================
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('MAX_IMAGE_SIZE', 2 * 1024 * 1024); // 2MB
define('UPLOAD_DIRECTORY', 'uploads/');
define('ALLOWED_IMAGE_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_DOC_EXTENSIONS', ['pdf', 'doc', 'docx']);

// ==========================================================
// Session Configuration
// ==========================================================
define('SESSION_NAME', 'resume_builder_session');
define('SESSION_TIMEOUT', 3600); // 1 hour
define('SESSION_REGENERATE_TIME', 300);

// ==========================================================
// PDF Configuration
// ==========================================================
define('PDF_LIBRARY', 'dompdf'); // dompdf | mpdf
define('PDF_FONT', 'DejaVu Sans');
define('PDF_FONT_SIZE', 11);
define('PDF_DPI', 96);
define('PDF_PAPER_SIZE', 'A4');
define('PDF_ORIENTATION', 'portrait');
define('PDF_MARGIN_TOP', 10);
define('PDF_MARGIN_BOTTOM', 10);
define('PDF_MARGIN_LEFT', 10);
define('PDF_MARGIN_RIGHT', 10);

// ==========================================================
// Feature Flags
// ==========================================================
define('ENABLE_ANALYTICS', filter_var(env('ENABLE_ANALYTICS'), FILTER_VALIDATE_BOOLEAN));
define('ENABLE_SOCIAL_SHARE', filter_var(env('ENABLE_SOCIAL_SHARE'), FILTER_VALIDATE_BOOLEAN));
define('ENABLE_DOWNLOAD_TRACKING', filter_var(env('ENABLE_DOWNLOAD_TRACKING'), FILTER_VALIDATE_BOOLEAN));
define('ENABLE_CONTACT_CSV_LOG', true);

// ==========================================================
// Security
// ==========================================================
define('CSRF_TOKEN_LENGTH', 32);
define('HASH_ALGORITHM', 'sha256');
define('PASSWORD_MIN_LENGTH', 8);
define('LOGIN_ATTEMPT_LIMIT', 5);

// ==========================================================
// Validation Rules
// ==========================================================
define('MIN_NAME_LENGTH', 2);
define('MAX_NAME_LENGTH', 100);
define('MIN_PHONE_LENGTH', 7);
define('MAX_PHONE_LENGTH', 20);
define('MAX_BIO_LENGTH', 1000);

// ==========================================================
// Logging
// ==========================================================
define('LOG_IP_ADDRESS', true);
define('LOG_USER_AGENT', true);
define('LOG_FINGERPRINT', true);

// ==========================================================
// Social Media
// ==========================================================
define('SOCIAL_TWITTER', 'https://twitter.com');
define('SOCIAL_LINKEDIN', 'https://linkedin.com');
define('SOCIAL_GITHUB', 'https://github.com');
define('SOCIAL_FACEBOOK', 'https://facebook.com');

// ==========================================================
// Theme Configuration
// ==========================================================
define('THEMES_AVAILABLE', [
    'classic' => [
        'name' => 'Classic Professional',
        'description' => 'Traditional and clean professional layout',
        'file' => 'theme1-classic.php'
    ],
    'modern' => [
        'name' => 'Modern Minimal',
        'description' => 'Minimalist design with elegant typography',
        'file' => 'theme2-modern.php'
    ],
    'corporate' => [
        'name' => 'Corporate Blue',
        'description' => 'Professional corporate-style theme',
        'file' => 'theme3-corporate.php'
    ],
    'creative' => [
        'name' => 'Creative Portfolio',
        'description' => 'Stylish layout for creative professionals',
        'file' => 'theme4-creative.php'
    ],
    'dark' => [
        'name' => 'Dark Mode',
        'description' => 'Modern dark theme with bold typography',
        'file' => 'theme5-dark.php'
    ],
    'elegant' => [
        'name' => 'Elegant Gold',
        'description' => 'Luxury-inspired resume design',
        'file' => 'theme6-elegant.php'
    ],
    'tech' => [
        'name' => 'Tech Startup',
        'description' => 'Clean and modern tech-focused design',
        'file' => 'theme7-tech.php'
    ],
    'minimal' => [
        'name' => 'Ultra Minimal',
        'description' => 'Extreme minimalism with focus on content',
        'file' => 'theme8-minimal.php'
    ],
    'vibrant' => [
        'name' => 'Vibrant Colors',
        'description' => 'Colorful and energetic resume layout',
        'file' => 'theme9-vibrant.php'
    ],
    'executive' => [
        'name' => 'Executive Premium',
        'description' => 'Premium layout for senior executives',
        'file' => 'theme10-executive.php'
    ],
]);

// ==========================================================
// End of Configuration
// ==========================================================
// <?php
// define('SITE_NAME', 'Resume Builder');
// define('SITE_NAME', env('SITE_NAME', 'Resume Builder'));
define('ADMIN_URL', '/resume-builder/admin/');
