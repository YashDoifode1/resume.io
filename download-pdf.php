<?php
/**
 * Direct PDF Download Handler
 * 
 * This file handles direct PDF downloads without going through the router.
 * Call this directly: download-pdf.php?theme=classic
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/utils/pdf-generator.php';

// Ensure session data exists
if (!isset($_SESSION['resume_data'])) {
    header('HTTP/1.1 400 Bad Request');
    header('Content-Type: text/plain');
    echo 'Error: No resume data found. Please fill out the resume form first.';
    exit;
}

$data = $_SESSION['resume_data'];
$theme = isset($_GET['theme']) ? sanitize_input($_GET['theme']) : 'classic';

// Validate theme - all 10 themes
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
    // Check if theme file exists
    $themeFile = THEMES_PATH . $themeFiles[$theme];
    if (!file_exists($themeFile)) {
        throw new Exception('Theme file not found: ' . $themeFile);
    }

    // Generate HTML content
    ob_start();
    include $themeFile;
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

    // Check if PDF library is available
    if (!$pdfGenerator->isAvailable()) {
        throw new Exception('PDF library not installed. Please install DOMPDF using: composer require dompdf/dompdf');
    }

    // Generate and download PDF
    $pdfGenerator->generatePDF($html, $filename);
    exit;
    
} catch (Exception $e) {
    // Log error
    error_log('PDF Generation Error: ' . $e->getMessage());
    
    // Set error headers
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: text/html; charset=utf-8');
    
    // Show error message
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>PDF Generation Error</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
            .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .error { background: #f8d7da; border: 1px solid #f5c6cb; padding: 16px; border-radius: 4px; color: #721c24; }
            .error h2 { margin-top: 0; margin-bottom: 12px; }
            .error p { margin: 8px 0; }
            .back-link { margin-top: 20px; }
            .back-link a { color: #3498db; text-decoration: none; padding: 10px 20px; background: #e8f4f8; border-radius: 4px; display: inline-block; }
            .back-link a:hover { background: #d0e8f0; }
            code { background: #f0f0f0; padding: 4px 8px; border-radius: 3px; font-family: monospace; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="error">
                <h2>⚠️ PDF Generation Error</h2>
                <p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>
                <p>Please try one of the following:</p>
                <ul>
                    <li>Make sure you have filled out the resume form</li>
                    <li>Check that DOMPDF is installed: <code>composer require dompdf/dompdf</code></li>
                    <li>Try a different theme</li>
                    <li>Use your browser\'s print function (Ctrl+P) to save as PDF</li>
                </ul>
                <div class="back-link">
                    <a href="' . BASE_URL . '">← Back to Home</a>
                </div>
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

?>
