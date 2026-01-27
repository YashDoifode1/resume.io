<?php
/**
 * Resume Builder - Global Constants Configuration
 * 
 * This file contains all global constants used throughout the application.
 * Modify these values to customize the application behavior.
 */

// START SESSION FIRST — NOTHING BEFORE THIS
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', 'http://localhost/resume-builder/');
define('ADMIN_REGISTRATION_ENABLED', true);

require_once __DIR__ . '/db.php';


// config/constants.php

// Base URLs and paths
// define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/');
 define('BASE_PATH', dirname(__DIR__) . '/');
// define('THEMES_PATH', dirname(__DIR__) . '/themes/');
// define('ASSETS_PATH', BASE_PATH . 'assets/');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'resume_builder');
define('DB_USER', 'root');
define('DB_PASS', '');

// Default theme
define('DEFAULT_THEME', 'modern');

// Session configuration
// define('SESSION_TIMEOUT', 3600); // 1 hour

// File upload configuration
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);
// define('UPLOADS_PATH', BASE_PATH . 'uploads/');

// PDF configuration
define('PDF_DEFAULT_FONT', 'DejaVu Sans');
define('PDF_DPI', 96);
define('PDF_PAPER_SIZE', 'A4');
define('PDF_ORIENTATION', 'portrait');


// Application Settings
// ============================================
// Site Information
define('SITE_NAME', 'resume-builder.gt.tc');
define('SITE_DESCRIPTION', 'Create professional resumes in minutes with our easy-to-use resume builder');
define('SITE_AUTHOR', 'Yash Doifode');
define('SITE_KEYWORDS', 'resume, cv, builder, job, career');

// ============================================
// URL Configuration
// ============================================
// define('BASE_URL', 'http://localhost/resume-builder/');
// define('ADMIN_REGISTRATION_ENABLED', true);


define('ASSETS_URL', BASE_URL . 'assets/');
define('CSS_URL', ASSETS_URL . 'css/');
define('JS_URL', ASSETS_URL . 'js/');
define('IMAGES_URL', ASSETS_URL . 'images/');

// ============================================
// File Paths
// ============================================
define('ROOT_PATH', __DIR__ . '/../');
define('ASSETS_PATH', ROOT_PATH . 'assets/');
define('COMPONENTS_PATH', ROOT_PATH . 'components/');
define('PAGES_PATH', ROOT_PATH . 'pages/');
define('THEMES_PATH', ROOT_PATH . 'themes/');
define('UPLOADS_PATH', ROOT_PATH . 'uploads/');
define('CONFIG_PATH', __DIR__ . '/');

// ============================================
// Upload Configuration
// ============================================
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('UPLOAD_DIRECTORY', 'uploads/');

// ============================================
// Session Configuration
// ============================================
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds
define('SESSION_NAME', 'resume_builder_session');

// ============================================
// PDF Configuration
// ============================================
define('PDF_LIBRARY', 'dompdf'); // 'dompdf' or 'mpdf'
define('PDF_FONT_SIZE', 11);
define('PDF_MARGIN_TOP', 10);
define('PDF_MARGIN_BOTTOM', 10);
define('PDF_MARGIN_LEFT', 10);
define('PDF_MARGIN_RIGHT', 10);

// ============================================
// Theme Configuration
// ============================================
$THEMES = [
    'classic' => [
        'name' => 'Classic Professional',
        'description' => 'Traditional, clean, and professional',
        'file' => 'theme1-classic.php'
    ],
    'modern' => [
        'name' => 'Modern Minimal',
        'description' => 'Minimalist design with elegant typography',
        'file' => 'theme2-modern.php'
    ],
    'corporate' => [
        'name' => 'Corporate Blue',
        'description' => 'Professional blue-themed layout',
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
        'description' => 'Luxury design with gold accents',
        'file' => 'theme6-elegant.php'
    ],
    'tech' => [
        'name' => 'Tech Startup',
        'description' => 'Modern tech industry focused',
        'file' => 'theme7-tech.php'
    ],
    'minimal' => [
        'name' => 'Ultra Minimal',
        'description' => 'Extreme minimalism with focus on content',
        'file' => 'theme8-minimal.php'
    ],
    'vibrant' => [
        'name' => 'Vibrant Colors',
        'description' => 'Colorful and energetic design',
        'file' => 'theme9-vibrant.php'
    ],
    'executive' => [
        'name' => 'Executive Premium',
        'description' => 'Premium design for executives',
        'file' => 'theme10-executive.php'
    ]
];

define('THEMES_AVAILABLE', $THEMES);

// ============================================
// Social Media Links
// ============================================
define('SOCIAL_TWITTER', 'https://twitter.com');
define('SOCIAL_LINKEDIN', 'https://linkedin.com');
define('SOCIAL_GITHUB', 'https://github.com');
define('SOCIAL_FACEBOOK', 'https://facebook.com');

// ============================================
// Contact Information (Editable)
// ============================================
define('CONTACT_EMAIL', 'yashdoifode1439@gmail.com');
define('CONTACT_PHONE', '+91 (XXX) XXX-XXXX');
define('CONTACT_ADDRESS', ' Nagpur, Maharashtra');
define('CONTACT_BUSINESS_HOURS', 'Monday - Friday, 9:00 AM - 6:00 PM IST');

// ============================================
// Owner Information
// ============================================
define('OWNER_NAME', 'Yash Doifode');
define('OWNER_TITLE', 'Founder & Developer');
define('OWNER_COLLEGE', '');
define('OWNER_LOCATION', 'Nagpur, Maharashtra');
define('OWNER_BIO', 'Passionate about creating tools that help professionals build their careers');

// ============================================
// Contact Form Settings
// ============================================
define('ENABLE_CONTACT_CSV_LOG', true);
define('CONTACT_CSV_PATH', ROOT_PATH . 'logs/');
define('LOG_IP_ADDRESS', true);
define('LOG_USER_AGENT', true);
define('LOG_FINGERPRINT', true);

// ============================================
// Feature Flags
// ============================================
define('ENABLE_ANALYTICS', false);
define('ENABLE_SOCIAL_SHARE', true);
define('ENABLE_DOWNLOAD_TRACKING', false);

// ============================================
// Security
// ============================================
define('CSRF_TOKEN_LENGTH', 32);
define('HASH_ALGORITHM', 'sha256');

// ============================================
// Validation Rules
// ============================================
define('MIN_NAME_LENGTH', 2);
define('MAX_NAME_LENGTH', 100);
define('MIN_PHONE_LENGTH', 7);
define('MAX_PHONE_LENGTH', 20);

?>
