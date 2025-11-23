<?php
/**
 * 404 Error Page
 */

http_response_code(404);
$page_title = '404 - Page Not Found';
$page_description = 'The page you are looking for does not exist.';
?>

<section class="hero" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 100px 20px; text-align: center;">
    <div class="container">
        <h1 style="font-size: 72px; margin-bottom: 20px;">404</h1>
        <h2 style="font-size: 32px; margin-bottom: 20px;">Page Not Found</h2>
        <p style="font-size: 18px; margin-bottom: 30px;">The page you are looking for doesn't exist or has been moved.</p>
        <a href="<?php echo BASE_URL; ?>" class="btn btn-outline" style="border-color: white; color: white; padding: 12px 30px; font-size: 16px;">← Back to Home</a>
    </div>
</section>

<style>
    .hero {
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .container {
        max-width: 600px;
    }
    
    .btn {
        display: inline-block;
        padding: 12px 30px;
        background: transparent;
        border: 2px solid;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 600;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
</style>
