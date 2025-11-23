<?php
/**
 * 500 Error Page
 */

http_response_code(500);
$page_title = '500 - Server Error';
$page_description = 'An error occurred on the server.';
?>

<section class="hero" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 100px 20px; text-align: center;">
    <div class="container">
        <h1 style="font-size: 72px; margin-bottom: 20px;">500</h1>
        <h2 style="font-size: 32px; margin-bottom: 20px;">Server Error</h2>
        <p style="font-size: 18px; margin-bottom: 30px;">Something went wrong on our end. Please try again later.</p>
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
