<?php
/**
 * API Endpoint: Save Individual Resume Sections
 * Handles saving each section separately with AJAX
 */

// Start session
session_start();

// Include configuration
require_once __DIR__ . '/../config/constants.php';

// Set JSON response header
header('Content-Type: application/json');

// Check if session has resume data
if (!isset($_SESSION['resume_data'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'No resume data found. Please start creating your resume first.'
    ]);
    exit;
}

// Get request data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['section'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request. Section name required.'
    ]);
    exit;
}

$section = $input['section'];
$data = $input['data'] ?? [];

try {
    // Ensure arrays exist
    if (!isset($_SESSION['resume_data']['workExperience'])) {
        $_SESSION['resume_data']['workExperience'] = [];
    }
    if (!isset($_SESSION['resume_data']['education'])) {
        $_SESSION['resume_data']['education'] = [];
    }
    if (!isset($_SESSION['resume_data']['skills'])) {
        $_SESSION['resume_data']['skills'] = [];
    }
    if (!isset($_SESSION['resume_data']['projects'])) {
        $_SESSION['resume_data']['projects'] = [];
    }
    if (!isset($_SESSION['resume_data']['certifications'])) {
        $_SESSION['resume_data']['certifications'] = [];
    }
    if (!isset($_SESSION['resume_data']['languages'])) {
        $_SESSION['resume_data']['languages'] = [];
    }
    
    // Save section data
    switch ($section) {
        case 'personal':
            $_SESSION['resume_data']['personal'] = array_merge(
                $_SESSION['resume_data']['personal'] ?? [],
                $data
            );
            break;
            
        case 'work_experience':
            // Handle both array and single object
            if (is_array($data) && !empty($data)) {
                if (isset($data[0]) && is_array($data[0])) {
                    $_SESSION['resume_data']['workExperience'] = $data;
                } else if (isset($data['company'])) {
                    $_SESSION['resume_data']['workExperience'][] = $data;
                } else {
                    $_SESSION['resume_data']['workExperience'] = $data;
                }
            }
            break;
            
        case 'education':
            if (is_array($data) && !empty($data)) {
                if (isset($data[0]) && is_array($data[0])) {
                    $_SESSION['resume_data']['education'] = $data;
                } else if (isset($data['school'])) {
                    $_SESSION['resume_data']['education'][] = $data;
                } else {
                    $_SESSION['resume_data']['education'] = $data;
                }
            }
            break;
            
        case 'skills':
            if (is_array($data) && !empty($data)) {
                if (isset($data[0]) && is_array($data[0])) {
                    $_SESSION['resume_data']['skills'] = $data;
                } else if (isset($data['skill_name'])) {
                    $_SESSION['resume_data']['skills'][] = $data;
                } else {
                    $_SESSION['resume_data']['skills'] = $data;
                }
            }
            break;
            
        case 'projects':
            if (is_array($data) && !empty($data)) {
                if (isset($data[0]) && is_array($data[0])) {
                    $_SESSION['resume_data']['projects'] = $data;
                } else if (isset($data['project_name'])) {
                    $_SESSION['resume_data']['projects'][] = $data;
                } else {
                    $_SESSION['resume_data']['projects'] = $data;
                }
            }
            break;
            
        case 'certifications':
            if (is_array($data) && !empty($data)) {
                if (isset($data[0]) && is_array($data[0])) {
                    $_SESSION['resume_data']['certifications'] = $data;
                } else if (isset($data['certification_name'])) {
                    $_SESSION['resume_data']['certifications'][] = $data;
                } else {
                    $_SESSION['resume_data']['certifications'] = $data;
                }
            }
            break;
            
        case 'languages':
            if (is_array($data) && !empty($data)) {
                if (isset($data[0]) && is_array($data[0])) {
                    $_SESSION['resume_data']['languages'] = $data;
                } else if (isset($data['language_name'])) {
                    $_SESSION['resume_data']['languages'][] = $data;
                } else {
                    $_SESSION['resume_data']['languages'] = $data;
                }
            }
            break;
            
        case 'interests':
            if (is_array($data)) {
                $_SESSION['resume_data']['interests'] = $data['interests'] ?? '';
            } else {
                $_SESSION['resume_data']['interests'] = $data;
            }
            break;
            
        default:
            throw new Exception("Unknown section: $section");
    }
    
    // Success response
    echo json_encode([
        'success' => true,
        'message' => ucfirst(str_replace('_', ' ', $section)) . ' saved successfully!',
        'section' => $section,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error saving section: ' . $e->getMessage()
    ]);
}
?>
