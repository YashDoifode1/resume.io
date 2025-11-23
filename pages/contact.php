<?php
/**
 * Contact Page with Form Handler
 */

require_once __DIR__ . '/../utils/contact-handler.php';

$page_title = 'Contact Us';
$page_description = 'Get in touch with resume.io. We\'d love to hear from you.';
$canonical_url = BASE_URL . '?page=contact';

$response = null;
$form_submitted = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $handler = new ContactFormHandler();
    $response = $handler->processSubmission($_POST);
    $form_submitted = true;
}
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>Have questions? We'd love to hear from you. Send us a message!</p>
    </div>
</section>

<!-- Contact Section -->
<section class="section">
    <div class="container">
        <!-- Response Messages -->
        <?php if ($form_submitted && $response): ?>
            <?php if ($response['success']): ?>
                <div class="alert alert-success" style="margin-bottom: 24px;">
                    <strong>✓ Success!</strong> <?php echo $response['message']; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-danger" style="margin-bottom: 24px;">
                    <strong>✗ Error!</strong>
                    <ul style="margin: 8px 0 0 20px;">
                        <?php foreach ($response['errors'] as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="grid grid-cols-2">
            <!-- Contact Form -->
            <div>
                <h2>Send us a Message</h2>
                <form id="contact-form" class="contact-form" method="POST" action="<?php echo BASE_URL; ?>?page=contact">
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" required placeholder="Your full name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required placeholder="your@email.com">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" placeholder="Your phone number">
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <input type="text" id="subject" name="subject" required placeholder="What is this about?">
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="6" required placeholder="Tell us more..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>

            <!-- Contact Information -->
            <div>
                <h2>Get in Touch</h2>
                <div class="contact-info-card">
                    <h3>📧 Email</h3>
                    <p><a href="mailto:<?php echo CONTACT_EMAIL; ?>"><?php echo CONTACT_EMAIL; ?></a></p>
                </div>

                <div class="contact-info-card">
                    <h3>📱 Phone</h3>
                    <p><a href="tel:<?php echo str_replace(' ', '', CONTACT_PHONE); ?>"><?php echo CONTACT_PHONE; ?></a></p>
                </div>

                <div class="contact-info-card">
                    <h3>📍 Address</h3>
                    <p><?php echo CONTACT_ADDRESS; ?></p>
                </div>

                <div class="contact-info-card">
                    <h3>🕐 Business Hours</h3>
                    <p><?php echo CONTACT_BUSINESS_HOURS; ?></p>
                </div>

                <div class="contact-info-card">
                    <h3>🌐 Follow Us</h3>
                    <div class="social-links" style="gap: 12px;">
                        <a href="<?php echo SOCIAL_TWITTER; ?>" target="_blank" rel="noopener noreferrer">Twitter</a>
                        <a href="<?php echo SOCIAL_LINKEDIN; ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                        <a href="<?php echo SOCIAL_GITHUB; ?>" target="_blank" rel="noopener noreferrer">GitHub</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .contact-form {
        background: var(--color-bg-secondary);
        padding: 24px;
        border-radius: 12px;
    }

    .contact-info-card {
        background: var(--color-bg-secondary);
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 16px;
        border-left: 4px solid var(--color-primary);
        transition: all 0.3s ease;
    }

    .contact-info-card:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.1);
    }

    .contact-info-card h3 {
        margin-bottom: 8px;
        color: var(--color-primary);
    }

    .contact-info-card p {
        margin: 0;
        color: var(--color-text-secondary);
    }

    .contact-info-card a {
        color: var(--color-primary);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .contact-info-card a:hover {
        text-decoration: underline;
        color: var(--color-secondary);
    }

    .alert {
        padding: 16px;
        border-radius: 8px;
        border-left: 4px solid;
    }

    .alert-success {
        background: #d4edda;
        border-color: #28a745;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        border-color: #dc3545;
        color: #721c24;
    }

    .alert ul {
        padding-left: 20px;
    }

    .alert li {
        margin-bottom: 4px;
    }
</style>

<script>
    // Add fingerprinting data to form
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        // Collect device info
        const screenResolution = window.screen.width + 'x' + window.screen.height;
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        
        // Create hidden inputs
        const screenInput = document.createElement('input');
        screenInput.type = 'hidden';
        screenInput.name = 'screen_resolution';
        screenInput.value = screenResolution;
        
        const timezoneInput = document.createElement('input');
        timezoneInput.type = 'hidden';
        timezoneInput.name = 'timezone';
        timezoneInput.value = timezone;
        
        this.appendChild(screenInput);
        this.appendChild(timezoneInput);
    });
</script>
