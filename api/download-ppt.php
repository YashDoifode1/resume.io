<?php
/**
 * API Endpoint: Download PowerPoint Presentation
 * Generates and downloads resume as PowerPoint
 */

// Start session
session_start();

// Include configuration
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../utils/ppt-generator.php';

// Check if session has resume data
if (!isset($_SESSION['resume_data'])) {
    http_response_code(400);
    die('No resume data found');
}

try {
    $resumeData = $_SESSION['resume_data'];
    
    // Generate PowerPoint
    $fileName = generatePowerPoint($resumeData);
    
    if (!$fileName || !file_exists(UPLOADS_PATH . $fileName)) {
        throw new Exception('Failed to generate PowerPoint file');
    }
    
    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Content-Length: ' . filesize(UPLOADS_PATH . $fileName));
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Read and output file
    readfile(UPLOADS_PATH . $fileName);
    
    // Delete file after download
    unlink(UPLOADS_PATH . $fileName);
    
} catch (Exception $e) {
    http_response_code(500);
    echo 'Error: ' . $e->getMessage();
    error_log('PPT Download Error: ' . $e->getMessage());
}
?>
