<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * PDF Download Handler - Fixed Version
 * 
 * Generates and downloads resume as PDF using DOMPDF or mPDF
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../utils/pdf-generator.php';

// Ensure session data exists
if (!isset($_SESSION['resume_data'])) {
    header('Location: ' . BASE_URL . '?page=builder');
    exit;
}

$data = $_SESSION['resume_data'];
$theme = isset($_GET['theme']) ? sanitize_input($_GET['theme']) : 'classic';

// Validate theme - all themes
$validThemes = ['classic', 'modern', 'corporate', 'creative', 'dark', 'elegant', 'tech', 'minimal', 'vibrant', 'executive', 'gradient', 'sidebar', 'minimalist', 'colorful', 'timeline'];
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
    'executive' => 'theme10-executive.php',
    'gradient' => 'theme11-gradient.php',
    'sidebar' => 'theme12-sidebar.php',
    'minimalist' => 'theme13-minimalist.php',
    'colorful' => 'theme14-colorful.php',
    'timeline' => 'theme15-timeline.php'
];

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

try {
    // Generate HTML content from theme
    $themeFile = THEMES_PATH . $themeFiles[$theme];
    
    if (!file_exists($themeFile)) {
        throw new Exception("Theme file not found: " . $themeFile);
    }
    
    ob_start();
    include $themeFile;
    $themeHtml = ob_get_clean();
    
    // Create complete HTML document with proper styling
    $html = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>' . htmlspecialchars($data['personal']['fullName'] ?? 'Resume') . ' - Resume</title>
        <style>
            /* Reset and base styles */
            * { 
                margin: 0; 
                padding: 0; 
                box-sizing: border-box; 
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            body { 
                font-family: "Segoe UI", "Roboto", "Helvetica Neue", Arial, sans-serif; 
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
                max-width: 8.5in;
                min-height: 11in;
                margin: 0 auto;
                background: white;
                position: relative;
            }
            
            /* Utility classes */
            .page-break {
                page-break-before: always;
            }
            
            .no-break {
                page-break-inside: avoid;
            }
            
            /* Table styling for contact info */
            .contact-table {
                width: 100%;
                border-collapse: collapse;
                margin: 5px 0;
            }
            
            .contact-table td {
                padding: 2px 0;
                vertical-align: top;
            }
            
            /* Section styling */
            .section {
                margin-bottom: 15px;
                page-break-inside: avoid;
            }
            
            .section-title {
                font-size: 16pt;
                font-weight: bold;
                color: #2c3e50;
                border-bottom: 2px solid #3498db;
                padding-bottom: 5px;
                margin-bottom: 10px;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
            
            /* Profile image */
            .profile-image-container {
                text-align: center;
                margin-bottom: 15px;
            }
            
            .profile-image {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid #3498db;
                display: block;
                margin: 0 auto;
            }
            
            /* Name and title */
            .resume-header {
                text-align: center;
                margin-bottom: 20px;
            }
            
            .full-name {
                font-size: 24pt;
                font-weight: bold;
                color: #2c3e50;
                margin-bottom: 5px;
            }
            
            .job-title {
                font-size: 14pt;
                color: #3498db;
                font-weight: 600;
                margin-bottom: 15px;
            }
            
            /* Contact info */
            .contact-info {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                justify-content: center;
                margin-bottom: 20px;
                font-size: 10pt;
            }
            
            .contact-item {
                display: flex;
                align-items: center;
                gap: 5px;
                color: #555;
            }
            
            /* Experience and Education items */
            .experience-item,
            .education-item {
                margin-bottom: 12px;
                page-break-inside: avoid;
            }
            
            .item-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 5px;
            }
            
            .item-title {
                font-weight: bold;
                color: #2c3e50;
                font-size: 11pt;
            }
            
            .item-subtitle {
                color: #3498db;
                font-weight: 600;
                font-size: 10pt;
            }
            
            .item-dates {
                color: #666;
                font-size: 10pt;
                white-space: nowrap;
            }
            
            .item-description {
                color: #555;
                font-size: 10pt;
                line-height: 1.4;
            }
            
            /* Skills */
            .skills-list {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }
            
            .skill-item {
                background: #f8f9fa;
                padding: 4px 10px;
                border-radius: 4px;
                font-size: 10pt;
                border-left: 3px solid #3498db;
            }
            
            /* Lists */
            ul, ol {
                margin-left: 20px;
                margin-bottom: 10px;
            }
            
            li {
                margin-bottom: 3px;
                font-size: 10pt;
            }
            
            /* Links - remove underline in PDF */
            a {
                color: #3498db;
                text-decoration: none;
            }
            
            /* Print-specific styles */
            @media print {
                body {
                    margin: 0 !important;
                    padding: 0 !important;
                    width: 8.5in;
                }
                
                .resume-container {
                    width: 100%;
                    max-width: 100%;
                    margin: 0;
                    padding: 20px;
                    box-shadow: none;
                }
                
                .page-break {
                    page-break-before: always;
                }
                
                .avoid-break {
                    page-break-inside: avoid;
                }
                
                * {
                    -webkit-print-color-adjust: exact !important;
                    color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
            }
            
            /* Fix for DomPDF image handling */
            img {
                max-width: 100%;
                height: auto;
            }
            
            /* Ensure background colors print */
            .bg-colored {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        </style>
    </head>
    <body>
        <div class="resume-container">' . $themeHtml . '</div>
    </body>
    </html>';

    // Debug: Save HTML for testing (optional)
    // file_put_contents('debug_pdf.html', $html);

    // Generate filename
    $fullName = $data['personal']['fullName'] ?? 'resume';
    $filename = 'Resume_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $fullName) . '_' . date('Y-m-d') . '.pdf';
    
    // Clean filename
    $filename = str_replace(' ', '_', $filename);
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);

    // Initialize PDF generator
    $pdfGenerator = new PDFGenerator();
    
    // Set PDF options
    $pdfOptions = [
        'defaultFont' => 'DejaVu Sans',
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true, // Allow loading images from URLs
        'isPhpEnabled' => false,
        'dpi' => 96,
        'marginTop' => 15,
        'marginBottom' => 15,
        'marginLeft' => 15,
        'marginRight' => 15,
        'paperSize' => 'A4',
        'orientation' => 'portrait'
    ];
    
    $pdfGenerator->setOptions($pdfOptions);

    // Generate PDF
    $pdfGenerator->generatePDF($html, $filename);
    
} catch (Exception $e) {
    // Log error
    error_log('PDF Generation Error: ' . $e->getMessage());
    error_log('Stack trace: ' . $e->getTraceAsString());
    
    // Show detailed error message
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDF Generation Error</title>
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
                max-width: 600px;
                width: 100%;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
            
            .error-header {
                color: #dc3545;
                margin-bottom: 24px;
                text-align: center;
            }
            
            .error-header h1 {
                font-size: 24px;
                margin-bottom: 8px;
            }
            
            .error-content {
                background: #f8f9fa;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 24px;
            }
            
            .error-message {
                color: #721c24;
                background: #f8d7da;
                border: 1px solid #f5c6cb;
                padding: 12px;
                border-radius: 6px;
                margin-bottom: 16px;
            }
            
            .debug-info {
                background: #e9ecef;
                padding: 12px;
                border-radius: 6px;
                font-size: 12px;
                margin-top: 16px;
            }
            
            .action-buttons {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
            }
            
            .btn {
                padding: 12px 24px;
                border-radius: 6px;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
                border: none;
                cursor: pointer;
                display: inline-block;
            }
            
            .btn-primary {
                background: #3498db;
                color: white;
            }
            
            .btn-primary:hover {
                background: #2980b9;
                transform: translateY(-2px);
            }
            
            .btn-secondary {
                background: #6c757d;
                color: white;
            }
            
            .btn-secondary:hover {
                background: #5a6268;
                transform: translateY(-2px);
            }
            
            .print-fallback {
                margin-top: 24px;
                padding-top: 24px;
                border-top: 1px solid #dee2e6;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-header">
                <h1>⚠️ PDF Generation Failed</h1>
                <p>We couldn\'t generate your PDF resume. Here are some solutions:</p>
            </div>
            
            <div class="error-content">
                <div class="error-message">
                    <strong>Error Details:</strong><br>
                    ' . htmlspecialchars($e->getMessage()) . '
                </div>
                
                <h3>Try These Solutions:</h3>
                <ol>
                    <li>Use your browser\'s print function (Ctrl+P) and select "Save as PDF"</li>
                    <li>Go back to the builder and save your changes first</li>
                    <li>Try a different theme template</li>
                    <li>Clear your browser cache and try again</li>
                </ol>
                
                ' . (strpos($e->getMessage(), 'DOMPDF') !== false ? '
                <div class="debug-info">
                    <strong>DOMPDF Issue Detected:</strong><br>
                    This usually means the PDF library needs configuration. Contact the administrator.
                </div>' : '') . '
                
                ' . (strpos($e->getMessage(), 'theme') !== false ? '
                <div class="debug-info">
                    <strong>Theme Issue:</strong><br>
                    Selected theme: ' . htmlspecialchars($theme) . '<br>
                    Theme file: ' . htmlspecialchars($themeFile ?? 'Not found') . '
                </div>' : '') . '
            </div>
            
            <div class="action-buttons">
                <a href="' . BASE_URL . '?page=preview&theme=' . htmlspecialchars($theme) . '" class="btn btn-primary">
                    ← Back to Preview
                </a>
                <a href="' . BASE_URL . '?page=builder" class="btn btn-secondary">
                    Edit Resume
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    🖨️ Print Instead
                </button>
            </div>
            
            <div class="print-fallback">
                <p><strong>Alternative:</strong> Press <kbd>Ctrl+P</kbd> and choose "Save as PDF" for best quality.</p>
            </div>
        </div>
    </body>
    </html>';
    exit;
}

/**
 * Sanitize input
 */
function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}