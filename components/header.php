<?php
/**
 * Header Component
 * 
 * Renders the HTML head section with meta tags, SEO, and CSS includes
 */

require_once __DIR__ . '/../config/constants.php';

/* Page meta fallbacks */
$page_title        = isset($page_title) ? $page_title . ' | ' . SITE_NAME : SITE_NAME;
$page_description  = isset($page_description) ? $page_description : SITE_DESCRIPTION;
$page_keywords     = isset($page_keywords) ? $page_keywords : SITE_KEYWORDS;
$canonical_url     = isset($canonical_url) ? $canonical_url : BASE_URL;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords); ?>">
    <meta name="author" content="<?php echo SITE_AUTHOR; ?>">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">

    <!-- Theme -->
    <meta name="theme-color" content="#4f46e5">

    <!-- Security -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy"
          content="default-src 'self' https: 'unsafe-inline' 'unsafe-eval' fonts.googleapis.com fonts.gstatic.com">

    <!-- Canonical -->
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url); ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url); ?>">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:image" content="<?php echo ASSETS_URL; ?>images/og-resume-builder.png">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="twitter:image" content="<?php echo ASSETS_URL; ?>images/og-resume-builder.png">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?php echo SITE_NAME; ?>",
        "description": "<?php echo SITE_DESCRIPTION; ?>",
        "url": "<?php echo BASE_URL; ?>",
        "logo": "<?php echo ASSETS_URL; ?>images/logo.png",
        "contactPoint": {
            "@type": "ContactPoint",
            "contactType": "Customer Support",
            "email": "<?php echo CONTACT_EMAIL; ?>"
        }
    }
    </script>

    <!-- Title -->
    <title><?php echo htmlspecialchars($page_title); ?></title>

    <!-- Favicons (favicon.io) -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo ASSETS_URL; ?>favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo ASSETS_URL; ?>favicons/favicon-16x16.png">
    <link rel="icon" type="image/x-icon" href="<?php echo ASSETS_URL; ?>favicons/favicon.ico">

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo ASSETS_URL; ?>favicons/apple-touch-icon.png">
    <link rel="manifest" href="<?php echo ASSETS_URL; ?>favicons/site.webmanifest">

    <meta name="msapplication-TileColor" content="#4f46e5">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>reset.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>variables.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>global.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>layout.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>components.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>responsive.css">

    <?php if (isset($page_slug) && $page_slug === 'builder'): ?>
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>builder.css">
    <?php elseif (isset($page_slug) && $page_slug === 'preview'): ?>
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>preview.css">
    <?php endif; ?>
</head>
<body>
