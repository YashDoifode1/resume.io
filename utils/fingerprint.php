<?php
/**
 * Device Fingerprinting Utility
 * Collects device and browser information for contact form logging
 */

class DeviceFingerprint {
    
    /**
     * Get client IP address
     */
    public static function getClientIP() {
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
     * Get user agent
     */
    public static function getUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    }

    /**
     * Get browser information
     */
    public static function getBrowserInfo() {
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $browser = 'Unknown';
        $version = 'Unknown';

        if (preg_match('/MSIE (\d+)/i', $ua, $matches)) {
            $browser = 'Internet Explorer';
            $version = $matches[1];
        } elseif (preg_match('/Trident.*rv:(\d+)/i', $ua, $matches)) {
            $browser = 'Internet Explorer';
            $version = $matches[1];
        } elseif (preg_match('/Edge\/(\d+)/i', $ua, $matches)) {
            $browser = 'Edge';
            $version = $matches[1];
        } elseif (preg_match('/Chrome\/(\d+)/i', $ua, $matches)) {
            $browser = 'Chrome';
            $version = $matches[1];
        } elseif (preg_match('/Safari\/(\d+)/i', $ua, $matches)) {
            $browser = 'Safari';
            $version = $matches[1];
        } elseif (preg_match('/Firefox\/(\d+)/i', $ua, $matches)) {
            $browser = 'Firefox';
            $version = $matches[1];
        } elseif (preg_match('/Opera\/(\d+)/i', $ua, $matches)) {
            $browser = 'Opera';
            $version = $matches[1];
        }

        return [
            'browser' => $browser,
            'version' => $version
        ];
    }

    /**
     * Get operating system
     */
    public static function getOperatingSystem() {
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $os = 'Unknown';

        if (preg_match('/Windows NT 10.0/i', $ua)) {
            $os = 'Windows 10';
        } elseif (preg_match('/Windows NT 6.3/i', $ua)) {
            $os = 'Windows 8.1';
        } elseif (preg_match('/Windows NT 6.2/i', $ua)) {
            $os = 'Windows 8';
        } elseif (preg_match('/Windows NT 6.1/i', $ua)) {
            $os = 'Windows 7';
        } elseif (preg_match('/Mac OS X/i', $ua)) {
            $os = 'Mac OS X';
        } elseif (preg_match('/Linux/i', $ua)) {
            $os = 'Linux';
        } elseif (preg_match('/iPhone/i', $ua)) {
            $os = 'iOS (iPhone)';
        } elseif (preg_match('/iPad/i', $ua)) {
            $os = 'iOS (iPad)';
        } elseif (preg_match('/Android/i', $ua)) {
            $os = 'Android';
        }

        return $os;
    }

    /**
     * Get device type
     */
    public static function getDeviceType() {
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
     * Get screen resolution (from JavaScript, fallback to unknown)
     */
    public static function getScreenResolution() {
        return $_POST['screen_resolution'] ?? 'Unknown';
    }

    /**
     * Get timezone
     */
    public static function getTimezone() {
        return $_POST['timezone'] ?? date_default_timezone_get();
    }

    /**
     * Get language
     */
    public static function getLanguage() {
        return $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'Unknown';
    }

    /**
     * Generate device fingerprint hash
     */
    public static function generateFingerprint() {
        $fingerprint_data = [
            self::getUserAgent(),
            self::getOperatingSystem(),
            self::getDeviceType(),
            $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '',
            $_SERVER['HTTP_ACCEPT_ENCODING'] ?? ''
        ];
        
        return hash('sha256', implode('|', $fingerprint_data));
    }

    /**
     * Get complete fingerprint data
     */
    public static function getCompleteFingerprint() {
        $browser = self::getBrowserInfo();
        
        return [
            'ip_address' => self::getClientIP(),
            'user_agent' => self::getUserAgent(),
            'browser' => $browser['browser'],
            'browser_version' => $browser['version'],
            'operating_system' => self::getOperatingSystem(),
            'device_type' => self::getDeviceType(),
            'screen_resolution' => self::getScreenResolution(),
            'timezone' => self::getTimezone(),
            'language' => self::getLanguage(),
            'fingerprint_hash' => self::generateFingerprint(),
            'timestamp' => date('Y-m-d H:i:s'),
            'referrer' => $_SERVER['HTTP_REFERER'] ?? 'Direct'
        ];
    }
}

?>
