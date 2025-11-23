<?php
/**
 * PDF Installation Verification
 * Check if DOMPDF is properly installed
 */

require_once __DIR__ . '/config/constants.php';

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>PDF Installation Verification</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 30px; }
        .check { margin: 15px 0; padding: 12px; border-radius: 4px; display: flex; align-items: center; }
        .check-pass { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .check-fail { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .check-icon { font-size: 20px; margin-right: 10px; }
        .status { font-weight: bold; }
        .details { margin-top: 30px; padding: 15px; background: #f9f9f9; border-left: 4px solid #3498db; border-radius: 4px; }
        .details h3 { margin-top: 0; color: #3498db; }
        .details p { margin: 8px 0; font-size: 14px; }
        code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>📋 PDF Installation Verification</h1>";

// Check 1: Composer autoloader
echo "<div class='check ";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "check-pass'><span class='check-icon'>✅</span><span>Composer autoloader found</span>";
    $autoloader_ok = true;
} else {
    echo "check-fail'><span class='check-icon'>❌</span><span>Composer autoloader NOT found</span>";
    $autoloader_ok = false;
}
echo "</div>";

// Check 2: DOMPDF installation
echo "<div class='check ";
if (file_exists(__DIR__ . '/vendor/dompdf/dompdf/src/Dompdf.php')) {
    echo "check-pass'><span class='check-icon'>✅</span><span>DOMPDF library installed</span>";
    $dompdf_ok = true;
} else {
    echo "check-fail'><span class='check-icon'>❌</span><span>DOMPDF library NOT found</span>";
    $dompdf_ok = false;
}
echo "</div>";

// Check 3: PDF Generator utility
echo "<div class='check ";
if (file_exists(__DIR__ . '/utils/pdf-generator.php')) {
    echo "check-pass'><span class='check-icon'>✅</span><span>PDF Generator utility found</span>";
    $generator_ok = true;
} else {
    echo "check-fail'><span class='check-icon'>❌</span><span>PDF Generator utility NOT found</span>";
    $generator_ok = false;
}
echo "</div>";

// Check 4: Try to load DOMPDF
echo "<div class='check ";
try {
    require_once __DIR__ . '/vendor/autoload.php';
    if (class_exists('Dompdf\Dompdf')) {
        echo "check-pass'><span class='check-icon'>✅</span><span>DOMPDF class can be loaded</span>";
        $class_ok = true;
    } else {
        echo "check-fail'><span class='check-icon'>❌</span><span>DOMPDF class cannot be loaded</span>";
        $class_ok = false;
    }
} catch (Exception $e) {
    echo "check-fail'><span class='check-icon'>❌</span><span>Error loading DOMPDF: " . htmlspecialchars($e->getMessage()) . "</span>";
    $class_ok = false;
}
echo "</div>";

// Check 5: PHP version
echo "<div class='check ";
$php_version = phpversion();
if (version_compare($php_version, '8.0', '>=')) {
    echo "check-pass'><span class='check-icon'>✅</span><span>PHP version " . $php_version . " (OK)</span>";
    $php_ok = true;
} else {
    echo "check-fail'><span class='check-icon'>❌</span><span>PHP version " . $php_version . " (requires 8.0+)</span>";
    $php_ok = false;
}
echo "</div>";

// Overall status
echo "<div class='details'>";
if ($autoloader_ok && $dompdf_ok && $generator_ok && $class_ok && $php_ok) {
    echo "<h3 style='color: #27ae60;'>✅ All Checks Passed!</h3>";
    echo "<p><strong>Your resume.io is ready to generate PDFs!</strong></p>";
    echo "<p>Next steps:</p>";
    echo "<ol>";
    echo "<li>Go to <a href='" . BASE_URL . "?page=builder'>Resume Builder</a></li>";
    echo "<li>Fill in your information</li>";
    echo "<li>Click 'Preview Resume'</li>";
    echo "<li>Click '📥 Download PDF'</li>";
    echo "<li>Your PDF will download!</li>";
    echo "</ol>";
} else {
    echo "<h3 style='color: #e74c3c;'>⚠️ Some Checks Failed</h3>";
    echo "<p>Please fix the issues above and try again.</p>";
    if (!$autoloader_ok) {
        echo "<p><strong>Issue:</strong> Composer autoloader not found</p>";
        echo "<p><strong>Solution:</strong> Run <code>composer install</code></p>";
    }
    if (!$dompdf_ok) {
        echo "<p><strong>Issue:</strong> DOMPDF not installed</p>";
        echo "<p><strong>Solution:</strong> Run <code>composer require dompdf/dompdf</code></p>";
    }
}
echo "</div>";

echo "    </div>
</body>
</html>";

?>
