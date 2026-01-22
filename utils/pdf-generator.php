<?php
/**
 * PDF Generator Utility - Enhanced Version
 * Handles PDF generation using DOMPDF or mPDF with better error handling
 */

class PDFGenerator {
    
    private $library = 'dompdf';
    private $config = [];
    private $debugMode = false;
    private $tempDir;
    
    public function __construct($config = []) {
        $this->tempDir = sys_get_temp_dir() . '/resume_pdf/';
        
        // Default configuration
        $this->config = array_merge([
            'default_font' => 'Segoe UI',
            'paper_size' => 'A4',
            'orientation' => 'portrait',
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_left' => 15,
            'margin_right' => 15,
            'dpi' => 96,
            'enable_remote' => true,
            'enable_font_subsetting' => true,
            'debug' => false,
            'temp_dir' => $this->tempDir,
            'image_dpi' => 96,
            'compress' => true,
            'watermark' => null,
            'password_protect' => false,
            'password' => null,
            'permissions' => ['print', 'copy', 'modify', 'annot-forms', 'fill-forms', 'extract', 'assemble', 'print-highres'],
            'html5_parser' => true,
            'is_php_enabled' => false,
            'javascript_enabled' => false,
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
    private function detectLibrary() {
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
        
        // Check if libraries are in include path
        if (file_exists(ROOT_PATH . 'vendor/dompdf/dompdf')) {
            require_once ROOT_PATH . 'vendor/dompdf/dompdf/src/Dompdf.php';
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
     * Get available library
     */
    public function getLibrary() {
        return $this->library;
    }

    /**
     * Check if PDF library is available
     */
    public function isAvailable() {
        return $this->library !== 'html';
    }

    /**
     * Set configuration
     */
    public function setConfig($config) {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * Get current configuration
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * Generate PDF using DOMPDF
     */
    private function generateWithDompdf($html, $filename) {
        try {
            // Create DOMPDF instance
            $dompdf = new \Dompdf\Dompdf();
            
            // Configure DOMPDF options
            $options = new \Dompdf\Options();
            
            // Set chroot to application root for security
            $options->setChroot([ROOT_PATH, $this->tempDir]);
            
            // Set various options
            $options->set([
                'defaultFont' => $this->config['default_font'],
                'isPhpEnabled' => $this->config['is_php_enabled'],
                'isRemoteEnabled' => $this->config['enable_remote'],
                'isFontSubsettingEnabled' => $this->config['enable_font_subsetting'],
                'isHtml5ParserEnabled' => $this->config['html5_parser'],
                'fontDir' => $this->tempDir . 'fonts/',
                'fontCache' => $this->tempDir . 'fonts/',
                'tempDir' => $this->tempDir,
                'logOutputFile' => $this->tempDir . 'dompdf_log.htm',
                'defaultPaperSize' => strtolower($this->config['paper_size']),
                'defaultPaperOrientation' => $this->config['orientation'],
                'dpi' => $this->config['dpi'],
                'enableCssFloat' => true,
                'enableInlineCss' => true,
                'enableFontSubsetting' => $this->config['enable_font_subsetting'],
                'pdfBackend' => 'CPDF',
                'debugPng' => $this->debugMode,
                'debugKeepTemp' => $this->debugMode,
                'debugCss' => $this->debugMode,
                'debugLayout' => $this->debugMode,
                'debugLayoutLines' => $this->debugMode,
                'debugLayoutBlocks' => $this->debugMode,
                'debugLayoutInline' => $this->debugMode,
                'debugLayoutPaddingBox' => $this->debugMode,
                'convertEntities' => true,
                'allow_url_fopen' => true
            ]);
            
            $dompdf->setOptions($options);
            
            // Preprocess HTML for better PDF rendering
            $html = $this->preprocessHtml($html);
            
            // Load HTML
            $dompdf->loadHtml($html, 'UTF-8');
            
            // Set paper size and orientation
            $dompdf->setPaper($this->config['paper_size'], $this->config['orientation']);
            
            $this->log('Rendering PDF with DOMPDF...');
            
            // Render PDF
            $dompdf->render();
            
            // Add watermark if specified
            if ($this->config['watermark']) {
                $this->addWatermarkDompdf($dompdf);
            }
            
            // Password protect if specified
            if ($this->config['password_protect'] && $this->config['password']) {
                $this->passwordProtectDompdf($dompdf);
            }
            
            $this->log('PDF rendered successfully');
            
            // Output the PDF
            $dompdf->stream($filename, [
                'Attachment' => true,
                'compress' => $this->config['compress']
            ]);
            
            // Clean up temp files if not debugging
            if (!$this->debugMode) {
                $this->cleanTempFiles();
            }
            
            return true;
            
        } catch (Exception $e) {
            $this->log('DOMPDF Error: ' . $e->getMessage(), 'ERROR');
            $this->log('Stack trace: ' . $e->getTraceAsString(), 'ERROR');
            throw new Exception('DOMPDF Generation Failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF using mPDF
     */
    private function generateWithMpdf($html, $filename) {
        try {
            // Configure mPDF
            $mpdfConfig = [
                'mode' => 'utf-8',
                'format' => $this->config['paper_size'],
                'orientation' => strtoupper(substr($this->config['orientation'], 0, 1)),
                'margin_left' => $this->config['margin_left'],
                'margin_right' => $this->config['margin_right'],
                'margin_top' => $this->config['margin_top'],
                'margin_bottom' => $this->config['margin_bottom'],
                'margin_header' => 5,
                'margin_footer' => 5,
                'tempDir' => $this->tempDir,
                'fontDir' => [$this->tempDir . 'fonts/'],
                'fontdata' => [],
                'default_font' => $this->config['default_font'],
                'allow_charset_conversion' => true,
                'autoLangToFont' => true,
                'autoScriptToLang' => true,
                'useSubstitutions' => true,
                'showImageErrors' => $this->debugMode,
                'debug' => $this->debugMode,
                'collapseBlockMargins' => true,
                'use_kwt' => true,
                'keep_table_proportions' => true,
                'shrink_tables_to_fit' => 1,
                'progressBar' => 2,
                'useSubstitutions' => false,
                'biDirectional' => false,
                'fonttrans' => [
                    'times' => 'Times-Roman',
                    'courier' => 'Courier'
                ],
                'defaultCssFile' => '',
                'fontdata' => [
                    'segoeui' => [
                        'R' => 'https://fonts.gstatic.com/s/segoeui/v16/NKe3H-zYSxs54xZr_6GrVQ.ttf',
                        'B' => 'https://fonts.gstatic.com/s/segoeui/v16/NKemH-zYSxs54xZr_6GrVQ.ttf',
                    ]
                ]
            ];
            
            // Create mPDF instance
            $mpdf = new \Mpdf\Mpdf($mpdfConfig);
            
            // Set metadata
            $mpdf->SetTitle('Resume - ' . ($_SESSION['resume_data']['personal']['fullName'] ?? 'Unknown'));
            $mpdf->SetAuthor('Resume Builder');
            $mpdf->SetCreator('Resume Builder v1.0');
            $mpdf->SetSubject('Professional Resume');
            $mpdf->SetKeywords('resume, cv, professional, employment');
            
            // Set compression
            if ($this->config['compress']) {
                $mpdf->SetCompression(true);
            }
            
            // Preprocess HTML
            $html = $this->preprocessHtml($html);
            
            // Add watermark if specified
            if ($this->config['watermark']) {
                $mpdf->SetWatermarkText($this->config['watermark']);
                $mpdf->showWatermarkText = true;
                $mpdf->watermarkTextAlpha = 0.1;
            }
            
            // Password protect if specified
            if ($this->config['password_protect'] && $this->config['password']) {
                $mpdf->SetProtection($this->config['permissions'], $this->config['password']);
            }
            
            $this->log('Writing HTML to mPDF...');
            
            // Write HTML
            $mpdf->WriteHTML($html);
            
            $this->log('PDF generated successfully with mPDF');
            
            // Output PDF
            $mpdf->Output($filename, 'D');
            
            // Clean up temp files
            if (!$this->debugMode) {
                $this->cleanTempFiles();
            }
            
            return true;
            
        } catch (Exception $e) {
            $this->log('mPDF Error: ' . $e->getMessage(), 'ERROR');
            $this->log('Stack trace: ' . $e->getTraceAsString(), 'ERROR');
            throw new Exception('mPDF Generation Failed: ' . $e->getMessage());
        }
    }

    /**
     * Preprocess HTML for better PDF rendering
     */
    private function preprocessHtml($html) {
        // Convert relative URLs to absolute
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
        if (strpos($html, '<base') === false) {
            $html = str_replace('<head>', '<head><base href="' . $baseUrl . '">', $html);
        }
        
        // Add print-specific CSS
        $printCss = '
        <style>
            @media print {
                @page {
                    margin: ' . $this->config['margin_top'] . 'mm ' . $this->config['margin_right'] . 'mm ' . 
                    $this->config['margin_bottom'] . 'mm ' . $this->config['margin_left'] . 'mm;
                    size: ' . $this->config['paper_size'] . ' ' . $this->config['orientation'] . ';
                }
                
                body {
                    margin: 0 !important;
                    padding: 0 !important;
                    font-family: "' . $this->config['default_font'] . '", Arial, sans-serif;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                    color-adjust: exact !important;
                }
                
                img {
                    max-width: 100% !important;
                    height: auto !important;
                }
                
                .page-break {
                    page-break-before: always;
                }
                
                .avoid-break {
                    page-break-inside: avoid;
                }
                
                .no-print {
                    display: none !important;
                }
                
                a {
                    color: inherit !important;
                    text-decoration: none !important;
                }
                
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                    color-adjust: exact !important;
                }
            }
        </style>';
        
        // Inject CSS into head
        if (strpos($html, '</head>') !== false) {
            $html = str_replace('</head>', $printCss . '</head>', $html);
        } else {
            $html = $printCss . $html;
        }
        
        // Ensure proper document structure
        if (!preg_match('/<!DOCTYPE\s+html>/i', $html)) {
            $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $html . '</body></html>';
        }
        
        return $html;
    }

    /**
     * Add watermark to DOMPDF document
     */
    private function addWatermarkDompdf($dompdf) {
        $canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->getFont("helvetica", "bold");
        
        // Get page dimensions
        $w = $canvas->get_width();
        $h = $canvas->get_height();
        
        // Add watermark text
        $canvas->page_text(
            $w / 2, 
            $h / 2, 
            $this->config['watermark'], 
            $font, 
            48, 
            array(0.95, 0.95, 0.95), 
            0, 
            0, 
            -45
        );
    }

    /**
     * Password protect DOMPDF document
     */
    private function passwordProtectDompdf($dompdf) {
        $canvas = $dompdf->getCanvas();
        
        // Set document permissions
        $canvas->set_info("Keywords", "Resume, CV, Professional");
        $canvas->set_info("Title", "Resume - " . ($_SESSION['resume_data']['personal']['fullName'] ?? ''));
        
        // Note: DOMPDF doesn't natively support password protection
        // This would need custom encryption or use mPDF instead
    }

    /**
     * Generate PDF from HTML
     */
    public function generatePDF($html, $filename = 'resume.pdf') {
        try {
            // Validate and sanitize filename
            $filename = $this->sanitizeFilename($filename);
            
            $this->log('Starting PDF generation...');
            $this->log('Library: ' . $this->library);
            $this->log('Filename: ' . $filename);
            
            // Set output headers
            $this->setOutputHeaders($filename);
            
            // Generate based on available library
            switch ($this->library) {
                case 'dompdf':
                    return $this->generateWithDompdf($html, $filename);
                case 'mpdf':
                    return $this->generateWithMpdf($html, $filename);
                default:
                    return $this->generateHtmlFallback($html, $filename);
            }
            
        } catch (Exception $e) {
            $this->log('PDF Generation Failed: ' . $e->getMessage(), 'ERROR');
            throw $e;
        }
    }

    /**
     * Sanitize filename
     */
    private function sanitizeFilename($filename) {
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
     * Set output headers
     */
    private function setOutputHeaders($filename) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        
        // Prevent caching
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
    }

    /**
     * Fallback: Return HTML for browser printing
     */
    private function generateHtmlFallback($html, $filename) {
        $this->log('Using HTML fallback method');
        
        // Change headers for HTML output
        header('Content-Type: text/html; charset=utf-8');
        header('Content-Disposition: inline; filename="' . str_replace('.pdf', '.html', $filename) . '"');
        
        $fallbackHtml = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Resume - Print Version</title>
            <style>
                body { 
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
                    margin: 0; 
                    padding: 20px; 
                    background: #f5f5f5;
                }
                
                .print-container {
                    max-width: 8.5in;
                    margin: 0 auto;
                    background: white;
                    padding: 40px;
                    box-shadow: 0 0 20px rgba(0,0,0,0.1);
                    border-radius: 8px;
                }
                
                .print-header {
                    text-align: center;
                    margin-bottom: 30px;
                    padding-bottom: 20px;
                    border-bottom: 2px solid #eee;
                }
                
                .print-notice {
                    background: #fff3cd;
                    border: 1px solid #ffc107;
                    padding: 16px;
                    border-radius: 6px;
                    margin-bottom: 30px;
                    color: #856404;
                    font-size: 14px;
                }
                
                .print-actions {
                    display: flex;
                    gap: 12px;
                    margin-top: 30px;
                    padding-top: 20px;
                    border-top: 1px solid #eee;
                    justify-content: center;
                }
                
                .print-btn {
                    padding: 12px 24px;
                    border-radius: 6px;
                    background: #3498db;
                    color: white;
                    border: none;
                    cursor: pointer;
                    font-size: 14px;
                    font-weight: 600;
                    text-decoration: none;
                    display: inline-block;
                }
                
                .print-btn:hover {
                    background: #2980b9;
                }
                
                .print-btn.secondary {
                    background: #6c757d;
                }
                
                .print-btn.secondary:hover {
                    background: #5a6268;
                }
                
                .print-tips {
                    background: #f8f9fa;
                    padding: 15px;
                    border-radius: 6px;
                    margin-top: 30px;
                    font-size: 13px;
                    color: #666;
                }
                
                @media print {
                    body { 
                        background: white; 
                        padding: 0; 
                        margin: 0;
                    }
                    .print-container {
                        box-shadow: none;
                        padding: 0;
                        margin: 0;
                        max-width: 100%;
                    }
                    .print-notice,
                    .print-actions,
                    .print-tips {
                        display: none !important;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-container">
                <div class="print-notice">
                    <strong>📄 Note:</strong> PDF library is not installed on the server.<br>
                    Use your browser\'s print function (Ctrl+P or Cmd+P) and select "Save as PDF" to download.
                </div>
                
                ' . $html . '
                
                <div class="print-tips">
                    <strong>💡 Printing Tips:</strong>
                    <ul>
                        <li>Press <kbd>Ctrl+P</kbd> (Windows) or <kbd>Cmd+P</kbd> (Mac) to open print dialog</li>
                        <li>Select "Save as PDF" or "Microsoft Print to PDF" as printer</li>
                        <li>Check "Background graphics" in print settings</li>
                        <li>Set margins to "Default" or "Minimum"</li>
                        <li>Paper size: ' . $this->config['paper_size'] . '</li>
                    </ul>
                </div>
                
                <div class="print-actions">
                    <button onclick="window.print()" class="print-btn">
                        🖨️ Print / Save as PDF
                    </button>
                    <a href="' . BASE_URL . '?page=preview" class="print-btn secondary">
                        ← Back to Preview
                    </a>
                </div>
            </div>
            
            <script>
                // Auto-trigger print dialog after page loads
                window.addEventListener(\'load\', function() {
                    setTimeout(function() {
                        // Optional: auto-open print dialog
                        // window.print();
                    }, 1000);
                });
            </script>
        </body>
        </html>';
        
        echo $fallbackHtml;
        return true;
    }

    /**
     * Clean temporary files
     */
    private function cleanTempFiles() {
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
    private function log($message, $level = 'INFO') {
        if ($this->debugMode) {
            $timestamp = date('Y-m-d H:i:s');
            $logEntry = "[$timestamp] [$level] $message\n";
            
            // Log to file
            $logFile = $this->tempDir . 'pdf_generator.log';
            file_put_contents($logFile, $logEntry, FILE_APPEND);
            
            // Also log to PHP error log if in debug mode
            if ($this->debugMode && $level === 'ERROR') {
                error_log("PDF Generator $level: $message");
            }
        }
    }

    /**
     * Get installation instructions
     */
    public static function getInstallationInstructions() {
        return [
            'dompdf' => [
                'name' => 'DOMPDF',
                'composer' => 'composer require dompdf/dompdf',
                'description' => 'Fast and feature-rich PDF generation',
                'requirements' => [
                    'PHP >= 7.1',
                    'GD extension',
                    'DOM extension',
                    'MBString extension'
                ],
                'notes' => 'Better for simple to moderate PDFs'
            ],
            'mpdf' => [
                'name' => 'mPDF',
                'composer' => 'composer require mpdf/mpdf',
                'description' => 'Comprehensive PDF generation with advanced features',
                'requirements' => [
                    'PHP >= 7.0',
                    'GD extension',
                    'MBString extension',
                    'XML extension'
                ],
                'notes' => 'Better for complex PDFs with advanced features'
            ]
        ];
    }

    /**
     * Get system requirements check
     */
    public static function checkSystemRequirements() {
        $requirements = [
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
        
        return $requirements;
    }
}