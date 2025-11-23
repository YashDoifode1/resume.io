<?php
/**
 * Header Component
 * 
 * Renders the HTML head section with meta tags, SEO, and CSS includes
 */

require_once __DIR__ . '/../config/constants.php';

$page_title = isset($page_title) ? $page_title . ' | ' . SITE_NAME : SITE_NAME;
$page_description = isset($page_description) ? $page_description : SITE_DESCRIPTION;
$page_keywords = isset($page_keywords) ? $page_keywords : SITE_KEYWORDS;
$canonical_url = isset($canonical_url) ? $canonical_url : BASE_URL;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($page_description ?? SITE_DESCRIPTION); ?>">
    <meta name="keywords" content="<?php echo SITE_KEYWORDS; ?>">
    <meta name="author" content="<?php echo SITE_AUTHOR; ?>">
    <meta name="theme-color" content="#3498db">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    
    <!-- Security Headers -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self' https: 'unsafe-inline' 'unsafe-eval' fonts.googleapis.com fonts.gstatic.com">
    
    <!-- Open Graph Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title ?? SITE_NAME); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_description ?? SITE_DESCRIPTION); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url ?? BASE_URL); ?>">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:image" content="<?php echo ASSETS_URL; ?>images/og-image.png">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title ?? SITE_NAME); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_description ?? SITE_DESCRIPTION); ?>">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?php echo SITE_NAME; ?>",
        "description": "<?php echo SITE_DESCRIPTION; ?>",
        "url": "<?php echo BASE_URL; ?>",
        "founder": {
            "@type": "Person",
            "name": "<?php echo OWNER_NAME; ?>",
            "jobTitle": "<?php echo OWNER_TITLE; ?>"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "contactType": "Customer Support",
            "email": "<?php echo CONTACT_EMAIL; ?>"
        }
    }
    </script>
    
    <title><?php echo htmlspecialchars($page_title ? $page_title . ' - ' . SITE_NAME : SITE_NAME); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo ASSETS_URL; ?>favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo ASSETS_URL; ?>apple-touch-icon.png">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>reset.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>variables.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>global.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>layout.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>components.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>responsive.css">
    
    <?php if ($page_title === 'Resume Builder'): ?>
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>builder.css">
    <?php elseif ($page_title === 'Preview'): ?>
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>preview.css">
    <?php endif; ?>
</head>
<body>
