<?php
/**
 * Placeholder Image Generator
 * Generates Instagram-style placeholder profile images
 */

function generatePlaceholderImage($name = 'User', $size = 200) {
    // Generate a consistent color based on the name
    $hash = md5(strtolower($name));
    $hue = (hexdec(substr($hash, 0, 6)) % 360);
    
    // Generate initials
    $parts = explode(' ', trim($name));
    $initials = '';
    foreach ($parts as $part) {
        if (!empty($part)) {
            $initials .= strtoupper($part[0]);
        }
    }
    if (empty($initials)) {
        $initials = 'U';
    }
    
    // Create SVG
    $svg = '<?xml version="1.0" encoding="UTF-8"?>
    <svg width="' . $size . '" height="' . $size . '" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:hsl(' . $hue . ',70%,60%);stop-opacity:1" />
                <stop offset="100%" style="stop-color:hsl(' . (($hue + 60) % 360) . ',70%,50%);stop-opacity:1" />
            </linearGradient>
        </defs>
        <rect width="' . $size . '" height="' . $size . '" fill="url(#grad)"/>
        <circle cx="' . ($size / 2) . '" cy="' . ($size / 2.5) . '" r="' . ($size / 3.5) . '" fill="rgba(255,255,255,0.3)"/>
        <text x="50%" y="50%" font-size="' . ($size / 2.5) . '" font-weight="bold" text-anchor="middle" dy="0.3em" fill="white" font-family="Arial, sans-serif">' . htmlspecialchars($initials) . '</text>
    </svg>';
    
    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}

/**
 * Get profile image or placeholder
 */
function getProfileImage($imageUrl = '', $name = 'User') {
    // Check if it's a URL
    if (!empty($imageUrl)) {
        // If it's a full URL, use it
        if (strpos($imageUrl, 'http') === 0) {
            return $imageUrl;
        }
        // If it's a relative path, convert to absolute
        if (defined('BASE_URL')) {
            return BASE_URL . ltrim($imageUrl, '/');
        }
    }
    return generatePlaceholderImage($name);
}
?>
