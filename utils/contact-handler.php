<?php
/**
 * Contact Form Handler
 * Processes contact form submissions and logs to CSV
 */

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/fingerprint.php';

class ContactFormHandler {
    
    private $csv_path;
    private $csv_file;
    
    public function __construct() {
        $this->csv_path = CONTACT_CSV_PATH;
        $this->csv_file = $this->csv_path . 'contact_submissions.csv';
        $this->ensureDirectory();
    }

    /**
     * Ensure logs directory exists
     */
    private function ensureDirectory() {
        if (!is_dir($this->csv_path)) {
            mkdir($this->csv_path, 0755, true);
        }
    }

    /**
     * Validate contact form data
     */
    public function validateForm($data) {
        $errors = [];

        if (empty($data['name']) || strlen($data['name']) < 2) {
            $errors[] = 'Name must be at least 2 characters';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required';
        }

        if (empty($data['subject']) || strlen($data['subject']) < 3) {
            $errors[] = 'Subject must be at least 3 characters';
        }

        if (empty($data['message']) || strlen($data['message']) < 10) {
            $errors[] = 'Message must be at least 10 characters';
        }

        return $errors;
    }

    /**
     * Sanitize form data
     */
    public function sanitizeData($data) {
        return [
            'name' => htmlspecialchars(trim($data['name'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'email' => filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL),
            'phone' => htmlspecialchars(trim($data['phone'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'subject' => htmlspecialchars(trim($data['subject'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'message' => htmlspecialchars(trim($data['message'] ?? ''), ENT_QUOTES, 'UTF-8')
        ];
    }

    /**
     * Log contact submission to CSV
     */
    public function logToCSV($form_data) {
        if (!ENABLE_CONTACT_CSV_LOG) {
            return true;
        }

        try {
            $fingerprint = DeviceFingerprint::getCompleteFingerprint();
            
            $row = [
                'submission_id' => uniqid('contact_', true),
                'timestamp' => $fingerprint['timestamp'],
                'name' => $form_data['name'],
                'email' => $form_data['email'],
                'phone' => $form_data['phone'],
                'subject' => $form_data['subject'],
                'message' => $form_data['message'],
                'ip_address' => LOG_IP_ADDRESS ? $fingerprint['ip_address'] : 'Hidden',
                'user_agent' => LOG_USER_AGENT ? substr($fingerprint['user_agent'], 0, 100) : 'Hidden',
                'browser' => $fingerprint['browser'],
                'browser_version' => $fingerprint['browser_version'],
                'operating_system' => $fingerprint['operating_system'],
                'device_type' => $fingerprint['device_type'],
                'screen_resolution' => $fingerprint['screen_resolution'],
                'timezone' => $fingerprint['timezone'],
                'language' => $fingerprint['language'],
                'fingerprint_hash' => LOG_FINGERPRINT ? $fingerprint['fingerprint_hash'] : 'Hidden',
                'referrer' => $fingerprint['referrer']
            ];

            $file_exists = file_exists($this->csv_file);
            $fp = fopen($this->csv_file, 'a');

            if (!$fp) {
                return false;
            }

            // Write header if file is new
            if (!$file_exists) {
                fputcsv($fp, array_keys($row));
            }

            fputcsv($fp, $row);
            fclose($fp);

            return true;
        } catch (Exception $e) {
            error_log('Contact form CSV logging error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send email notification
     */
    public function sendEmailNotification($form_data) {
        $to = CONTACT_EMAIL;
        $subject = 'New Contact Form Submission: ' . $form_data['subject'];
        
        $message = "
        <html>
            <head>
                <title>New Contact Form Submission</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: #3498db; color: white; padding: 20px; border-radius: 5px 5px 0 0; }
                    .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
                    .field { margin-bottom: 15px; }
                    .label { font-weight: bold; color: #3498db; }
                    .footer { background: #333; color: white; padding: 10px; text-align: center; border-radius: 0 0 5px 5px; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>New Contact Form Submission</h2>
                    </div>
                    <div class='content'>
                        <div class='field'>
                            <span class='label'>Name:</span> {$form_data['name']}
                        </div>
                        <div class='field'>
                            <span class='label'>Email:</span> {$form_data['email']}
                        </div>
                        <div class='field'>
                            <span class='label'>Phone:</span> {$form_data['phone']}
                        </div>
                        <div class='field'>
                            <span class='label'>Subject:</span> {$form_data['subject']}
                        </div>
                        <div class='field'>
                            <span class='label'>Message:</span><br>
                            " . nl2br($form_data['message']) . "
                        </div>
                    </div>
                    <div class='footer'>
                        <p>This is an automated message from resume.io contact form</p>
                    </div>
                </div>
            </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: noreply@resume.io\r\n";

        return mail($to, $subject, $message, $headers);
    }

    /**
     * Process contact form submission
     */
    public function processSubmission($post_data) {
        // Validate
        $errors = $this->validateForm($post_data);
        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        // Sanitize
        $form_data = $this->sanitizeData($post_data);

        // Log to CSV
        $csv_logged = $this->logToCSV($form_data);

        // Send email
        $email_sent = $this->sendEmailNotification($form_data);

        return [
            'success' => true,
            'message' => 'Thank you for contacting us! We will get back to you soon.',
            'csv_logged' => $csv_logged,
            'email_sent' => $email_sent
        ];
    }
}

?>
