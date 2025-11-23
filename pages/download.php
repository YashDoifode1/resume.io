<?php
/**
 * PDF Download Handler
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

    // Generate PDF
    $pdfGenerator->generatePDF($html, $filename);
    
} catch (Exception $e) {
    // Log error
    error_log('PDF Generation Error: ' . $e->getMessage());
    
    // Show error message
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>PDF Generation Error</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; }
            .error { background: #f8d7da; border: 1px solid #f5c6cb; padding: 12px; border-radius: 4px; color: #721c24; }
            .error h2 { margin-top: 0; }
            .error p { margin: 8px 0; }
            .back-link { margin-top: 20px; }
            .back-link a { color: #3498db; text-decoration: none; }
        </style>
    </head>
    <body>
        <div class="error">
            <h2>⚠️ PDF Generation Error</h2>
            <p>Unable to generate PDF. Please try again or use your browser\'s print function.</p>
            <p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>
            <div class="back-link">
                <a href="' . BASE_URL . '?page=preview&theme=' . htmlspecialchars($theme) . '">← Back to Preview</a>
            </div>
        </div>
    </body>
    </html>';
}

/**
 * Sanitize input
 */
function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

?>

