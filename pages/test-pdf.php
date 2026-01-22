<?php
// test-pdf.php - Debug script
session_start();

require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/utils/pdf-generator.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>PDF Generator Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .test-result { padding: 20px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow: auto; }
    </style>
</head>
<body>
    <h1>PDF Generator Test</h1>";

// Test 1: Check if PDF Generator class exists
echo "<div class='test-result info'><strong>Test 1:</strong> Checking PDF Generator Class</div>";
try {
    $pdfGen = new PDFGenerator();
    echo "<div class='test-result success'>✓ PDF Generator class loaded successfully</div>";
    echo "<div class='test-result info'>Library detected: " . $pdfGen->getLibrary() . "</div>";
} catch (Exception $e) {
    echo "<div class='test-result error'>✗ Failed to load PDF Generator: " . $e->getMessage() . "</div>";
}

// Test 2: Check system requirements
echo "<div class='test-result info'><strong>Test 2:</strong> System Requirements</div>";
$requirements = PDFGenerator::checkSystemRequirements();
foreach ($requirements as $name => $req) {
    $statusClass = $req['status'] ? 'success' : 'error';
    $icon = $req['status'] ? '✓' : '✗';
    echo "<div class='test-result $statusClass'>$icon $name: {$req['actual']} (Required: {$req['required']})</div>";
}

// Test 3: Test basic HTML to PDF
echo "<div class='test-result info'><strong>Test 3:</strong> Test PDF Generation</div>";
$testHtml = '<!DOCTYPE html><html><body><h1>Test PDF</h1><p>This is a test document.</p></body></html>';

try {
    $pdfGen = new PDFGenerator(['debug' => true]);
    
    if ($pdfGen->isAvailable()) {
        echo "<div class='test-result success'>✓ PDF library is available (" . $pdfGen->getLibrary() . ")</div>";
        
        // Test generation (but don't output)
        ob_start();
        $result = $pdfGen->generatePDF($testHtml, 'test.pdf');
        ob_end_clean();
        
        if ($result) {
            echo "<div class='test-result success'>✓ PDF generation test passed</div>";
        } else {
            echo "<div class='test-result warning'>⚠ PDF generation returned false (might be headers issue)</div>";
        }
    } else {
        echo "<div class='test-result warning'>⚠ No PDF library available, using HTML fallback</div>";
    }
} catch (Exception $e) {
    echo "<div class='test-result error'>✗ PDF Generation Failed: " . $e->getMessage() . "</div>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

// Test 4: Check Composer autoload
echo "<div class='test-result info'><strong>Test 4:</strong> Composer Autoload</div>";
$composerPath = ROOT_PATH . 'vendor/autoload.php';
if (file_exists($composerPath)) {
    echo "<div class='test-result success'>✓ Composer autoload found at: " . $composerPath . "</div>";
    
    // Check for specific libraries
    require_once $composerPath;
    
    if (class_exists('Dompdf\Dompdf')) {
        echo "<div class='test-result success'>✓ DOMPDF library found</div>";
    } else {
        echo "<div class='test-result warning'>⚠ DOMPDF not found in Composer</div>";
    }
    
    if (class_exists('Mpdf\Mpdf')) {
        echo "<div class='test-result success'>✓ mPDF library found</div>";
    } else {
        echo "<div class='test-result warning'>⚠ mPDF not found in Composer</div>";
    }
} else {
    echo "<div class='test-result error'>✗ Composer autoload not found. Install with: composer require dompdf/dompdf</div>";
}

// Test 5: File permissions
echo "<div class='test-result info'><strong>Test 5:</strong> File Permissions</div>";
$paths = [
    'Root' => ROOT_PATH,
    'Uploads' => UPLOADS_PATH,
    'Temp' => sys_get_temp_dir(),
    'Themes' => THEMES_PATH
];

foreach ($paths as $name => $path) {
    if (is_dir($path)) {
        $writable = is_writable($path) ? 'Writable' : 'Not Writable';
        $statusClass = is_writable($path) ? 'success' : 'warning';
        $icon = is_writable($path) ? '✓' : '⚠';
        echo "<div class='test-result $statusClass'>$icon $name: $writable</div>";
    } else {
        echo "<div class='test-result warning'>⚠ $name: Directory does not exist</div>";
    }
}

echo "<hr><h2>Installation Instructions</h2>";

$instructions = PDFGenerator::getInstallationInstructions();
foreach ($instructions as $lib => $info) {
    echo "<div class='test-result info'>";
    echo "<strong>{$info['name']}:</strong><br>";
    echo "Command: <code>{$info['composer']}</code><br>";
    echo "Description: {$info['description']}<br>";
    echo "</div>";
}

echo "<hr>
<div class='test-result info'>
    <strong>Quick Fix:</strong><br>
    1. Open terminal in your project folder<br>
    2. Run: <code>composer require dompdf/dompdf</code><br>
    3. Refresh this page to test again
</div>

<a href='" . BASE_URL . "' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 5px;'>
    ← Back to Resume Builder
</a>

</body>
</html>";