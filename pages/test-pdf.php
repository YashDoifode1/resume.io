<?php
declare(strict_types=1);

/**
 * ABSOLUTELY NO OUTPUT BEFORE THIS FILE
 * NO BOM
 * NO SPACES
 */

ob_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!extension_loaded('gd')) {
    ob_end_clean();
    http_response_code(500);
    exit('GD extension missing');
}

$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; }
h1 { color: #2c3e50; }
</style>
</head>
<body>
<h1>ResumeCraft PDF Test</h1>
<p>Generated at: {date('Y-m-d H:i:s')}</p>
</body>
</html>
HTML;

$options = new Options();
$options->set('defaultFont', 'Helvetica');
$options->set('isRemoteEnabled', false);
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->render();

ob_end_clean(); // 🔥 CRITICAL LINE

$dompdf->stream('resume.pdf', ['Attachment' => true]);
exit;
