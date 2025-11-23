<?php
/**
 * Visitor and Error Logger
 * Logs all visitors and errors to the logs folder
 */

class Logger {
    
    private $logsPath;
    private $visitorLogFile;
    private $errorLogFile;
    
    public function __construct() {
        $this->logsPath = __DIR__ . '/../logs/';
        $this->visitorLogFile = $this->logsPath . 'visitors.log';
        $this->errorLogFile = $this->logsPath . 'errors.log';
        
        // Ensure logs directory exists
        $this->ensureLogsDirectory();
    }
    
    /**
     * Ensure logs directory exists
     */
    private function ensureLogsDirectory() {
        if (!is_dir($this->logsPath)) {
            mkdir($this->logsPath, 0755, true);
        }
    }
    
    /**
     * Get visitor information
     */
    private function getVisitorInfo() {
        return [
            'timestamp' => date('Y-m-d H:i:s'),
            'ip_address' => $this->getClientIP(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'page' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'Unknown',
            'referer' => $_SERVER['HTTP_REFERER'] ?? 'Direct',
            'device' => $this->getDeviceType(),
            'browser' => $this->getBrowserInfo()
        ];
    }
    
    /**
     * Get client IP address
     */
    private function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        }
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : 'Unknown';
    }
    
    /**
     * Get device type
     */
    private function getDeviceType() {
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        if (preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $ua)) {
            if (preg_match('/Tablet|iPad|Nexus 7|Nexus 10|Kindle Fire|Playbook/i', $ua)) {
                return 'Tablet';
            }
            return 'Mobile';
        }
        return 'Desktop';
    }
    
    /**
     * Get browser information
     */
    private function getBrowserInfo() {
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        if (preg_match('/Chrome/i', $ua)) {
            return 'Chrome';
        } elseif (preg_match('/Firefox/i', $ua)) {
            return 'Firefox';
        } elseif (preg_match('/Safari/i', $ua)) {
            return 'Safari';
        } elseif (preg_match('/Edge/i', $ua)) {
            return 'Edge';
        } elseif (preg_match('/Opera/i', $ua)) {
            return 'Opera';
        }
        return 'Unknown';
    }
    
    /**
     * Log visitor
     */
    public function logVisitor() {
        try {
            $info = $this->getVisitorInfo();
            
            $logEntry = json_encode($info) . "\n";
            
            file_put_contents($this->visitorLogFile, $logEntry, FILE_APPEND | LOCK_EX);
            
            return true;
        } catch (Exception $e) {
            error_log('Logger Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Log error
     */
    public function logError($errorCode, $errorMessage, $errorFile = '', $errorLine = '') {
        try {
            $errorInfo = [
                'timestamp' => date('Y-m-d H:i:s'),
                'error_code' => $errorCode,
                'error_message' => $errorMessage,
                'error_file' => $errorFile,
                'error_line' => $errorLine,
                'ip_address' => $this->getClientIP(),
                'page' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
            ];
            
            $logEntry = json_encode($errorInfo) . "\n";
            
            file_put_contents($this->errorLogFile, $logEntry, FILE_APPEND | LOCK_EX);
            
            return true;
        } catch (Exception $e) {
            error_log('Logger Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get visitor count
     */
    public function getVisitorCount() {
        if (!file_exists($this->visitorLogFile)) {
            return 0;
        }
        return count(file($this->visitorLogFile));
    }
    
    /**
     * Get error count
     */
    public function getErrorCount() {
        if (!file_exists($this->errorLogFile)) {
            return 0;
        }
        return count(file($this->errorLogFile));
    }
    
    /**
     * Get recent visitors
     */
    public function getRecentVisitors($limit = 10) {
        if (!file_exists($this->visitorLogFile)) {
            return [];
        }
        
        $lines = file($this->visitorLogFile);
        $recent = array_slice($lines, -$limit);
        
        $visitors = [];
        foreach ($recent as $line) {
            $visitors[] = json_decode(trim($line), true);
        }
        
        return array_reverse($visitors);
    }
    
    /**
     * Get recent errors
     */
    public function getRecentErrors($limit = 10) {
        if (!file_exists($this->errorLogFile)) {
            return [];
        }
        
        $lines = file($this->errorLogFile);
        $recent = array_slice($lines, -$limit);
        
        $errors = [];
        foreach ($recent as $line) {
            $errors[] = json_decode(trim($line), true);
        }
        
        return array_reverse($errors);
    }
}

?>
