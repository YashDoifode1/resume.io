<?php
/**
 * PDF Generator Utility - Enhanced Version with Fixed A4 Sizing
 * Handles PDF generation using DOMPDF with proper A4 dimensions
 */

declare(strict_types=1);

use Dompdf\Dompdf;
use Dompdf\Options;
use Mpdf\Mpdf;
use Exception;

class PDFGenerator {
    
    private $dompdf;
    private $config = [];
    private $debugMode = false;
    private $tempDir;
    private $library = 'dompdf';
    
    public function __construct($config = []) {
        $this->tempDir = sys_get_temp_dir() . '/resume_pdf/';
        
        // Default configuration with PROPER A4 dimensions
        // A4 size: 210mm × 297mm (8.27in × 11.69in)
        $this->config = array_merge([
            'default_font' => 'DejaVu Sans',
            'paper_size' => 'A4',
            'orientation' => 'portrait',
            'margin_top' => 10,      // Reduced from 15mm
            'margin_bottom' => 10,   // Reduced from 15mm
            'margin_left' => 10,     // Reduced from 15mm
            'margin_right' => 10,    // Reduced from 15mm
            'dpi' => 96,
            'enable_remote' => true,
            'enable_font_subsetting' => true,
            'debug' => false,
            'temp_dir' => $this->tempDir,
            'compress' => true,
            'html5_parser' => true,
            'is_php_enabled' => false,
            'chroot' => ROOT_PATH
        ], $config);
        
        $this->debugMode = $this->config['debug'];
        
        // Create temp directory if it doesn't exist
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0755, true);
        }
        
        $this->detectLibrary();
    }

    /**
     * Detect which PDF library is available
     */
    private function detectLibrary(): void {
        // Check for Composer autoload
        $composerPath = ROOT_PATH . 'vendor/autoload.php';
        
        if (file_exists($composerPath)) {
            require_once $composerPath;
        }
        
        // Check for DOMPDF
        if (class_exists('Dompdf\Dompdf')) {
            $this->library = 'dompdf';
            $this->log('Using DOMPDF library');
            return;
        }
        
        // Check for mPDF
        if (class_exists('Mpdf\Mpdf')) {
            $this->library = 'mpdf';
            $this->log('Using mPDF library');
            return;
        }
        
        // Check if DOMPDF is in include path
        $dompdfPath = ROOT_PATH . 'vendor/dompdf/dompdf/autoload.inc.php';
        if (file_exists($dompdfPath)) {
            require_once $dompdfPath;
            if (class_exists('Dompdf\Dompdf')) {
                $this->library = 'dompdf';
                $this->log('Using DOMPDF library (manual load)');
                return;
            }
        }
        
        // Fallback to HTML if no library found
        $this->library = 'html';
        $this->log('No PDF library found, using HTML fallback');
    }

    /**
     * Initialize DOMPDF instance with A4 optimization
     */
    private function initDompdf(): Dompdf {
        $options = new Options();
        
        // DOMPDF safe options with A4 optimization
        $options->set('defaultFont', $this->config['default_font']);
        $options->set('isRemoteEnabled', $this->config['enable_remote']);
        $options->set('isHtml5ParserEnabled', $this->config['html5_parser']);
        $options->set('isPhpEnabled', $this->config['is_php_enabled']);
        $options->set('dpi', $this->config['dpi']);
        $options->set('isFontSubsettingEnabled', $this->config['enable_font_subsetting']);
        $options->set('tempDir', $this->tempDir);
        $options->set('fontDir', $this->tempDir . 'fonts/');
        $options->set('fontCache', $this->tempDir . 'fonts/');
        $options->set('chroot', [ROOT_PATH, $this->tempDir]);
        $options->set('logOutputFile', $this->tempDir . 'dompdf_log.htm');
        
        // Set default paper size explicitly
        $options->set('defaultPaperSize', 'a4');
        $options->set('defaultPaperOrientation', 'portrait');
        
        // Debug options
        if ($this->debugMode) {
            $options->set('debugPng', true);
            $options->set('debugKeepTemp', true);
            $options->set('debugCss', true);
            $options->set('debugLayout', true);
        }
        
        $dompdf = new Dompdf($options);
        
        return $dompdf;
    }

    /**
     * Generate PDF binary safely (no output)
     */
    public function generate(string $html, string $paper = 'A4', string $orientation = 'portrait'): string {
        if (trim($html) === '') {
            throw new Exception('PDF HTML content is empty');
        }
        
        $this->log('Starting PDF generation...');
        
        try {
            // Preprocess HTML for better PDF rendering
            $html = $this->preprocessHtml($html);
            
            if ($this->library === 'dompdf') {
                $dompdf = $this->initDompdf();
                $dompdf->loadHtml($html, 'UTF-8');
                
                // Set paper size with minimal margins for A4
                $paper = $paper ?: 'a4';
                $orientation = $orientation ?: 'portrait';
                
                // For A4 portrait, we want minimal margins
                if (strtolower($paper) === 'a4' && strtolower($orientation) === 'portrait') {
                    // Override with tighter margins for A4 portrait
                    $dompdf->setPaper($paper, $orientation);
                    
                    // Set custom margins through HTML/CSS instead
                    $html = $this->addMinimalMargins($html);
                    $dompdf->loadHtml($html, 'UTF-8');
                    $dompdf->setPaper($paper, $orientation);
                } else {
                    $dompdf->setPaper($paper, $orientation);
                }
                
                $dompdf->render();
                
                $this->log('PDF generated successfully with DOMPDF');
                return $dompdf->output();
                
            } elseif ($this->library === 'mpdf') {
                return $this->generateWithMpdf($html, $paper, $orientation);
                
            } else {
                // HTML fallback - return HTML as string
                return $this->generateHtmlFallback($html);
            }
            
        } catch (Exception $e) {
            $this->log('PDF Generation Failed: ' . $e->getMessage(), 'ERROR');
            throw new Exception('PDF generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Add minimal margins for A4 paper
     */
    private function addMinimalMargins(string $html): string {
        // A4 dimensions: 210mm × 297mm (8.27in × 11.69in)
        // Standard margins: 1.27cm (0.5in) on each side
        // We'll use 0.5in (12.7mm) which is standard for resumes
        
        $marginCss = '
        <style>
            /* A4 paper size with standard resume margins */
            @page {
                size: A4 portrait;
                margin: 12.7mm 12.7mm 12.7mm 12.7mm; /* 0.5 inch margins */
                padding: 0;
            }
            
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                font-family: "' . $this->config['default_font'] . '", Arial, sans-serif;
                font-size: 11pt;
                line-height: 1.4;
                color: #000;
                background: none;
            }
            
            /* Container should fit within page margins */
            .resume-container {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            /* Full A4 page dimensions */
            .a4-page {
                width: 210mm;
                min-height: 297mm;
                margin: 0 auto;
                padding: 0;
                background: white;
                box-sizing: border-box;
            }
            
            /* Content area within A4 page */
            .a4-content {
                width: 100%;
                height: 100%;
                padding: 12.7mm; /* Match page margins */
                box-sizing: border-box;
            }
            
            /* Utility classes for spacing control */
            .no-margin { margin: 0 !important; }
            .no-padding { padding: 0 !important; }
            .tight-margin { margin: 2mm !important; }
            .tight-padding { padding: 2mm !important; }
            
            /* Better text rendering */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
                box-sizing: border-box;
            }
            
            /* Image handling */
            img {
                max-width: 100%;
                height: auto;
                page-break-inside: avoid;
            }
            
            /* Prevent page breaks in critical sections */
            .keep-together {
                page-break-inside: avoid;
                break-inside: avoid;
            }
            
            .page-break {
                page-break-before: always;
                break-before: page;
            }
            
            /* Hide non-printable elements */
            .no-print {
                display: none !important;
            }
            
            /* Optimize for PDF */
            a {
                color: inherit;
                text-decoration: none;
            }
            
            @media print {
                body {
                    margin: 0 !important;
                    padding: 0 !important;
                }
                
                .a4-page {
                    width: 100%;
                    height: 100%;
                    margin: 0;
                    padding: 0;
                    box-shadow: none;
                    border: none;
                }
                
                /* Ensure proper page breaks */
                h1, h2, h3 {
                    page-break-after: avoid;
                }
                
                /* Fix for list items */
                li {
                    page-break-inside: avoid;
                }
                
                /* Table handling */
                table {
                    page-break-inside: avoid;
                }
            }
        </style>';
        
        // Inject CSS into head
        if (strpos($html, '</head>') !== false) {
            $html = str_replace('</head>', $marginCss . '</head>', $html);
        } elseif (strpos($html, '<head>') !== false) {
            $html = str_replace('<head>', '<head>' . $marginCss, $html);
        } else {
            // If no head tag, wrap in minimal structure
            if (!preg_match('/<!DOCTYPE\s+html>/i', $html)) {
                $html = '<!DOCTYPE html><html><head><meta charset="UTF-8">' . $marginCss . '</head><body>' . $html . '</body></html>';
            }
        }
        
        return $html;
    }

    /**
     * Stream PDF download safely (sets headers and outputs)
     */
    public function stream(string $html, string $filename): void {
        try {
            $pdf = $this->generate($html);
            
            // Clean any existing output buffers
            while (ob_get_level()) {
                ob_end_clean();
            }
            
            // Set headers
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $this->sanitizeFilename($filename) . '"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($pdf));
            
            echo $pdf;
            exit;
            
        } catch (Exception $e) {
            // Clean buffers before error output
            while (ob_get_level()) {
                ob_end_clean();
            }
            
            $this->showErrorPage($e->getMessage());
            exit;
        }
    }

    /**
     * Legacy method for backward compatibility
     */
    public function generatePDF(string $html, string $filename = 'resume.pdf'): void {
        $this->stream($html, $filename);
    }

    /**
     * Set configuration
     */
    public function setOptions(array $config): void {
        $this->config = array_merge($this->config, $config);
        $this->debugMode = $this->config['debug'] ?? false;
    }

    /**
     * Get available library
     */
    public function getLibrary(): string {
        return $this->library;
    }

    /**
     * Check if PDF library is available
     */
    public function isAvailable(): bool {
        return $this->library !== 'html';
    }

    /**
     * Generate PDF using mPDF with A4 optimization
     */
    private function generateWithMpdf(string $html, string $paper, string $orientation): string {
        try {
            // Configure mPDF with A4 optimization
            $mpdfConfig = [
                'mode' => 'utf-8',
                'format' => strtoupper($paper ?: 'A4'),
                'orientation' => $orientation === 'landscape' ? 'L' : 'P',
                'margin_left' => 12.7,  // 0.5 inch = 12.7mm
                'margin_right' => 12.7,
                'margin_top' => 12.7,
                'margin_bottom' => 12.7,
                'margin_header' => 5,
                'margin_footer' => 5,
                'tempDir' => $this->tempDir,
                'default_font' => $this->config['default_font'],
                'allow_charset_conversion' => true,
                'autoLangToFont' => true,
                'autoScriptToLang' => true,
                'useSubstitutions' => true,
                'showImageErrors' => $this->debugMode,
                'debug' => $this->debugMode,
                'collapseBlockMargins' => true,
                'useSubstitutions' => false,
                'biDirectional' => false,
            ];
            
            $mpdf = new Mpdf($mpdfConfig);
            
            // Set compression
            if ($this->config['compress']) {
                $mpdf->SetCompression(true);
            }
            
            // Set metadata
            if (isset($_SESSION['resume_data']['personal']['fullName'])) {
                $mpdf->SetTitle('Resume - ' . $_SESSION['resume_data']['personal']['fullName']);
                $mpdf->SetAuthor($_SESSION['resume_data']['personal']['fullName']);
            } else {
                $mpdf->SetTitle('Resume');
                $mpdf->SetAuthor('Resume Builder');
            }
            
            $mpdf->SetCreator('ResumeCraft v1.0');
            $mpdf->SetSubject('Professional Resume');
            
            // Preprocess HTML
            $html = $this->preprocessHtml($html);
            
            // Add A4 specific styles for mPDF
            $html = $this->addA4Styles($html);
            
            // Write HTML
            $mpdf->WriteHTML($html);
            
            $this->log('PDF generated successfully with mPDF');
            return $mpdf->Output('', 'S'); // Return as string
            
        } catch (Exception $e) {
            $this->log('mPDF Error: ' . $e->getMessage(), 'ERROR');
            throw new Exception('mPDF generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Add A4 specific styles for mPDF
     */
    private function addA4Styles(string $html): string {
        $a4Styles = '
        <style>
            body {
                font-family: "' . $this->config['default_font'] . '", Arial, sans-serif;
                font-size: 11pt;
                line-height: 1.4;
                color: #000000;
                margin: 0;
                padding: 0;
            }
            
            .resume-page {
                width: 210mm;
                min-height: 297mm;
                padding: 12.7mm;
                margin: 0 auto;
                box-sizing: border-box;
            }
            
            /* Content optimization */
            p, li, td {
                font-size: 10.5pt;
                line-height: 1.4;
            }
            
            h1 { font-size: 16pt; margin: 8mm 0 4mm 0; }
            h2 { font-size: 14pt; margin: 6mm 0 3mm 0; }
            h3 { font-size: 12pt; margin: 5mm 0 2.5mm 0; }
            
            /* Space optimization */
            .section {
                margin-bottom: 8mm;
            }
            
            /* Avoid widows and orphans */
            p, li {
                widows: 2;
                orphans: 2;
            }
            
            /* Better spacing for compact resume */
            .compact-spacing * {
                margin-top: 1mm;
                margin-bottom: 1mm;
            }
        </style>';
        
        // Inject CSS into head
        if (strpos($html, '</head>') !== false) {
            $html = str_replace('</head>', $a4Styles . '</head>', $html);
        } elseif (strpos($html, '<head>') !== false) {
            $html = str_replace('<head>', '<head>' . $a4Styles, $html);
        }
        
        return $html;
    }

    /**
     * Preprocess HTML for better PDF rendering
     */
    private function preprocessHtml(string $html): string {
        // Convert relative URLs to absolute for images and CSS
        $baseUrl = BASE_URL;
        $html = preg_replace_callback('/(src|href)=["\']([^"\']+)["\']/i', function($matches) use ($baseUrl) {
            $attr = $matches[1];
            $url = $matches[2];
            
            // Skip if already absolute or data URI
            if (preg_match('/^(https?:|\/\/|data:)/i', $url)) {
                return $matches[0];
            }
            
            // Convert relative to absolute
            if (strpos($url, '/') === 0) {
                $url = rtrim($baseUrl, '/') . $url;
            } else {
                $url = rtrim($baseUrl, '/') . '/' . ltrim($url, '/');
            }
            
            return $attr . '="' . $url . '"';
        }, $html);
        
        // Add base tag for relative URLs
        if (strpos($html, '<base') === false && strpos($html, '<head>') !== false) {
            $html = str_replace('<head>', '<head><base href="' . $baseUrl . '">', $html);
        }
        
        // Ensure proper DOCTYPE
        if (!preg_match('/<!DOCTYPE\s+html>/i', $html)) {
            $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $html . '</body></html>';
        }
        
        return $html;
    }

    /**
     * Generate HTML fallback (returns HTML string)
     */
    private function generateHtmlFallback(string $html): string {
        $this->log('Using HTML fallback method');
        
        $fallbackHtml = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Resume - Print Version</title>
            <style>
                /* A4 paper simulation for browser print */
                @media print {
                    @page {
                        size: A4;
                        margin: 12.7mm;
                    }
                    
                    body {
                        width: 210mm;
                        min-height: 297mm;
                        margin: 0 auto;
                        padding: 12.7mm;
                        background: white;
                        font-family: Arial, sans-serif;
                        font-size: 11pt;
                        line-height: 1.4;
                    }
                    
                    .print-notice,
                    .print-tips {
                        display: none !important;
                    }
                }
                
                /* Screen view */
                @media screen {
                    body { 
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
                        margin: 0; 
                        padding: 20px; 
                        background: #f5f5f5;
                    }
                    
                    .print-container {
                        max-width: 210mm;
                        margin: 0 auto;
                        background: white;
                        padding: 12.7mm;
                        box-shadow: 0 0 20px rgba(0,0,0,0.1);
                        min-height: 297mm;
                    }
                    
                    .print-notice {
                        background: #fff3cd;
                        border: 1px solid #ffc107;
                        padding: 16px;
                        border-radius: 6px;
                        margin-bottom: 20px;
                        color: #856404;
                        font-size: 14px;
                    }
                    
                    .print-tips {
                        background: #f8f9fa;
                        padding: 15px;
                        border-radius: 6px;
                        margin-top: 20px;
                        font-size: 13px;
                        color: #666;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-container">
                <div class="print-notice">
                    <strong>📄 Note:</strong> PDF library is not installed on the server.<br>
                    Press <kbd>Ctrl+P</kbd> (Windows) or <kbd>Cmd+P</kbd> (Mac) → Select "Save as PDF" → Set margins to 12.7mm (0.5in).
                </div>
                
                ' . $html . '
                
                <div class="print-tips">
                    <strong>💡 A4 Printing Tips:</strong>
                    <ul>
                        <li>Set paper size to "A4"</li>
                        <li>Set margins to 12.7mm (0.5 inch)</li>
                        <li>Check "Background graphics" in print settings</li>
                        <li>Scale: 100% (not "Fit to page")</li>
                    </ul>
                </div>
            </div>
        </body>
        </html>';
        
        return $fallbackHtml;
    }

    /**
     * Sanitize filename
     */
    private function sanitizeFilename(string $filename): string {
        // Remove directory traversal attempts
        $filename = basename($filename);
        
        // Replace spaces with underscores
        $filename = str_replace(' ', '_', $filename);
        
        // Remove invalid characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
        
        // Ensure .pdf extension
        if (substr($filename, -4) !== '.pdf') {
            $filename .= '.pdf';
        }
        
        // If filename is empty or too short
        if (strlen($filename) < 5) {
            $filename = 'Resume_' . date('Y-m-d') . '.pdf';
        }
        
        return $filename;
    }

    /**
     * Show error page
     */
    private function showErrorPage(string $errorMessage): void {
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
                    max-width: 700px;
                    width: 100%;
                    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                }
                
                .error-header {
                    color: #dc3545;
                    margin-bottom: 24px;
                    text-align: center;
                }
                
                .error-header h1 {
                    font-size: 28px;
                    margin-bottom: 10px;
                }
                
                .error-content {
                    background: #f8f9fa;
                    border-radius: 8px;
                    padding: 24px;
                    margin-bottom: 24px;
                }
                
                .error-message {
                    color: #721c24;
                    background: #f8d7da;
                    border: 1px solid #f5c6cb;
                    padding: 16px;
                    border-radius: 6px;
                    margin-bottom: 20px;
                    font-family: monospace;
                    font-size: 14px;
                    line-height: 1.5;
                }
                
                .action-buttons {
                    display: flex;
                    gap: 12px;
                    flex-wrap: wrap;
                    justify-content: center;
                }
                
                .btn {
                    padding: 14px 28px;
                    border-radius: 8px;
                    text-decoration: none;
                    font-weight: 600;
                    transition: all 0.3s ease;
                    border: none;
                    cursor: pointer;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    font-size: 15px;
                }
                
                .btn-primary {
                    background: #3498db;
                    color: white;
                }
                
                .btn-primary:hover {
                    background: #2980b9;
                }
                
                .btn-secondary {
                    background: #6c757d;
                    color: white;
                }
                
                .btn-secondary:hover {
                    background: #5a6268;
                }
                
                @media (max-width: 768px) {
                    .error-container {
                        padding: 24px;
                    }
                    
                    .action-buttons {
                        flex-direction: column;
                    }
                    
                    .btn {
                        width: 100%;
                        justify-content: center;
                    }
                }
            </style>
        </head>
        <body>
            <div class="error-container">
                <div class="error-header">
                    <h1>⚠️ PDF Generation Error</h1>
                </div>
                
                <div class="error-content">
                    <div class="error-message">
                        <strong>Error Details:</strong><br>
                        ' . htmlspecialchars($errorMessage) . '
                    </div>
                    
                    <div style="text-align: center; margin: 20px 0;">
                        <strong>Manual A4 PDF Creation:</strong>
                        <p style="margin-top: 10px; color: #666;">
                            1. Press Ctrl+P<br>
                            2. Printer: "Save as PDF"<br>
                            3. Paper size: A4<br>
                            4. Margins: 12.7mm (0.5 inch)<br>
                            5. Scale: 100%
                        </p>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="' . BASE_URL . '?page=preview" class="btn btn-primary">
                        ← Back to Preview
                    </a>
                    <button onclick="window.print()" class="btn btn-secondary">
                        🖨️ Print/Save as PDF
                    </button>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Clean temporary files
     */
    private function cleanTempFiles(): void {
        try {
            $files = glob($this->tempDir . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
            $this->log('Cleaned temp files');
        } catch (Exception $e) {
            $this->log('Error cleaning temp files: ' . $e->getMessage(), 'WARNING');
        }
    }

    /**
     * Log messages
     */
    private function log(string $message, string $level = 'INFO'): void {
        if ($this->debugMode) {
            $timestamp = date('Y-m-d H:i:s');
            $logEntry = "[$timestamp] [$level] $message\n";
            
            // Log to file
            $logFile = $this->tempDir . 'pdf_generator.log';
            file_put_contents($logFile, $logEntry, FILE_APPEND);
            
            // Also log to PHP error log for errors
            if ($level === 'ERROR') {
                error_log("PDF Generator ERROR: $message");
            }
        }
    }

    /**
     * Get optimal A4 resume settings
     */
    public static function getA4Settings(): array {
        return [
            'paper_size' => 'A4',
            'orientation' => 'portrait',
            'margins' => [
                'top' => '12.7mm (0.5in)',
                'right' => '12.7mm (0.5in)',
                'bottom' => '12.7mm (0.5in)',
                'left' => '12.7mm (0.5in)'
            ],
            'dimensions' => [
                'width' => '210mm (8.27in)',
                'height' => '297mm (11.69in)',
                'content_width' => '184.6mm (7.27in)',
                'content_height' => '271.6mm (10.69in)'
            ],
            'font_sizes' => [
                'body' => '11pt',
                'headings' => [
                    'h1' => '16pt',
                    'h2' => '14pt',
                    'h3' => '12pt'
                ],
                'small' => '10pt'
            ],
            'line_height' => '1.4',
            'recommended_content' => 'Keep content within 1-2 pages for best results'
        ];
    }

    /**
     * Get installation instructions
     */
    public static function getInstallationInstructions(): array {
        return [
            'dompdf' => [
                'name' => 'DOMPDF',
                'composer' => 'composer require dompdf/dompdf',
                'description' => 'Fast and feature-rich PDF generation',
                'requirements' => ['PHP >= 7.1', 'GD extension', 'DOM extension', 'MBString extension'],
                'notes' => 'Better for simple to moderate PDFs'
            ],
            'mpdf' => [
                'name' => 'mPDF',
                'composer' => 'composer require mpdf/mpdf',
                'description' => 'Comprehensive PDF generation with advanced features',
                'requirements' => ['PHP >= 7.0', 'GD extension', 'MBString extension', 'XML extension'],
                'notes' => 'Better for complex PDFs with advanced features'
            ]
        ];
    }

    /**
     * Check system requirements
     */
    public static function checkSystemRequirements(): array {
        return [
            'PHP Version' => [
                'required' => '7.1+',
                'actual' => PHP_VERSION,
                'status' => version_compare(PHP_VERSION, '7.1.0') >= 0
            ],
            'GD Extension' => [
                'required' => 'Enabled',
                'actual' => extension_loaded('gd') ? 'Enabled' : 'Disabled',
                'status' => extension_loaded('gd')
            ],
            'DOM Extension' => [
                'required' => 'Enabled',
                'actual' => extension_loaded('dom') ? 'Enabled' : 'Disabled',
                'status' => extension_loaded('dom')
            ],
            'MBString Extension' => [
                'required' => 'Enabled',
                'actual' => extension_loaded('mbstring') ? 'Enabled' : 'Disabled',
                'status' => extension_loaded('mbstring')
            ],
            'Write Permissions' => [
                'required' => 'Writable',
                'actual' => is_writable(sys_get_temp_dir()) ? 'Writable' : 'Not Writable',
                'status' => is_writable(sys_get_temp_dir())
            ]
        ];
    }
}