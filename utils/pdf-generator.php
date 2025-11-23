<?php
/**
 * PDF Generator Utility
 * Handles PDF generation using DOMPDF or mPDF
 */

class PDFGenerator {
    
    private $library = 'dompdf';
    private $dompdf = null;
    private $mpdf = null;
    
    public function __construct() {
        $this->detectLibrary();
    }

    /**
     * Detect which PDF library is available
     */
    private function detectLibrary() {
        // Check for DOMPDF
        if (file_exists(ROOT_PATH . 'vendor/autoload.php')) {
            require_once ROOT_PATH . 'vendor/autoload.php';
            
            if (class_exists('Dompdf\Dompdf')) {
                $this->library = 'dompdf';
                return;
            } elseif (class_exists('Mpdf\Mpdf')) {
                $this->library = 'mpdf';
                return;
            }
        }
        
        // Fallback to HTML if no library found
        $this->library = 'html';
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
     * Generate PDF using DOMPDF
     */
    private function generateWithDompdf($html, $filename) {
        try {
            $dompdf = new \Dompdf\Dompdf();
            
            // Set options
            $options = $dompdf->getOptions();
            $options->set([
                'defaultFont' => 'Segoe UI',
                'isPhpEnabled' => false,
                'isRemoteEnabled' => true,
                'isFontSubsettingEnabled' => true,
                'fontDir' => sys_get_temp_dir(),
                'fontCache' => sys_get_temp_dir(),
            ]);
            $dompdf->setOptions($options);
            
            // Load HTML
            $dompdf->loadHtml($html);
            
            // Set paper size
            $dompdf->setPaper('A4', 'portrait');
            
            // Render
            $dompdf->render();
            
            // Output
            $dompdf->stream($filename, ['Attachment' => false]);
            
            return true;
        } catch (Exception $e) {
            error_log('DOMPDF Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate PDF using mPDF
     */
    private function generateWithMpdf($html, $filename) {
        try {
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_header' => 5,
                'margin_footer' => 5,
            ]);
            
            // Write HTML
            $mpdf->WriteHTML($html);
            
            // Output
            $mpdf->Output($filename, 'D');
            
            return true;
        } catch (Exception $e) {
            error_log('mPDF Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate PDF from HTML
     */
    public function generatePDF($html, $filename = 'resume.pdf') {
        // Sanitize filename
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        if (empty($filename)) {
            $filename = 'resume.pdf';
        }
        if (substr($filename, -4) !== '.pdf') {
            $filename .= '.pdf';
        }

        // Set headers
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Generate based on available library
        switch ($this->library) {
            case 'dompdf':
                return $this->generateWithDompdf($html, $filename);
            case 'mpdf':
                return $this->generateWithMpdf($html, $filename);
            default:
                return $this->generateHtmlFallback($html, $filename);
        }
    }

    /**
     * Fallback: Return HTML for browser printing
     */
    private function generateHtmlFallback($html, $filename) {
        header('Content-Type: text/html; charset=utf-8');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        
        echo '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>' . htmlspecialchars($filename) . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
                @media print {
                    body { margin: 0; padding: 0; }
                }
                .print-notice {
                    background: #fff3cd;
                    border: 1px solid #ffc107;
                    padding: 12px;
                    border-radius: 4px;
                    margin-bottom: 20px;
                    color: #856404;
                }
            </style>
        </head>
        <body>
            <div class="print-notice">
                <strong>Note:</strong> PDF library not installed. Use your browser\'s print function (Ctrl+P or Cmd+P) to save as PDF.
            </div>
            ' . $html . '
            <script>
                window.print();
            </script>
        </body>
        </html>';
        
        return true;
    }

    /**
     * Get installation instructions
     */
    public static function getInstallationInstructions() {
        return [
            'dompdf' => [
                'name' => 'DOMPDF',
                'composer' => 'composer require dompdf/dompdf',
                'description' => 'Fast and feature-rich PDF generation'
            ],
            'mpdf' => [
                'name' => 'mPDF',
                'composer' => 'composer require mpdf/mpdf',
                'description' => 'Comprehensive PDF generation with advanced features'
            ]
        ];
    }
}

?>
