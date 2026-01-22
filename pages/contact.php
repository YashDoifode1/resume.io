<?php
/**
 * Contact Page with Form Handler - Updated to match our theme
 */

require_once __DIR__ . '/../utils/contact-handler.php';

$page_title = 'Contact Us';
$page_description = 'Get in touch with ResumeCraft. We\'d love to hear from you.';
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
    <div class="container hero-container">
        <div class="hero-content">
            <h1>Contact Us</h1>
            <p>Have questions? We'd love to hear from you. Send us a message and we'll get back to you as soon as possible.</p>
            <div class="hero-cta">
                <a href="#contact-form" class="btn btn-secondary">
                    <i class="fas fa-envelope"></i> Send Message
                </a>
            </div>
        </div>
        <div class="hero-image">
            <div style="background: linear-gradient(135deg, var(--primary), var(--secondary)); height: 200px; width: 100%; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 64px; box-shadow: var(--shadow-lg);">
                <i class="fas fa-headset"></i>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section">
    <div class="container">
        <!-- Response Messages -->
        <?php if ($form_submitted && $response): ?>
            <?php if ($response['success']): ?>
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <h4>Success!</h4>
                        <p><?php echo $response['message']; ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <h4>Please fix the following errors:</h4>
                        <ul>
                            <?php foreach ($response['errors'] as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="contact-wrapper">
            <!-- Contact Form -->
            <div class="contact-form-section">
                <div class="section-header">
                    <h2>Send us a Message</h2>
                    <p>Fill out the form below and we'll get back to you within 24 hours</p>
                </div>
                
                <form id="contact-form" class="contact-form" method="POST" action="<?php echo BASE_URL; ?>?page=contact">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-user"></i> Name *
                            </label>
                            <input type="text" id="name" name="name" required 
                                   placeholder="Your full name"
                                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> Email *
                            </label>
                            <input type="email" id="email" name="email" required 
                                   placeholder="your@email.com"
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">
                                <i class="fas fa-phone"></i> Phone
                            </label>
                            <input type="tel" id="phone" name="phone" 
                                   placeholder="Your phone number"
                                   value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="subject">
                                <i class="fas fa-tag"></i> Subject *
                            </label>
                            <input type="text" id="subject" name="subject" required 
                                   placeholder="What is this about?"
                                   value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">
                            <i class="fas fa-comment-dots"></i> Message *
                        </label>
                        <textarea id="message" name="message" rows="6" required 
                                  placeholder="Tell us more about your inquiry..."><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-large">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                        <p class="form-note">
                            <i class="fas fa-info-circle"></i> We'll respond within 24 hours
                        </p>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="contact-info-section">
                <div class="section-header">
                    <h2>Get in Touch</h2>
                    <p>Other ways to connect with us</p>
                </div>
                
                <div class="contact-info-cards">
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Email</h3>
                            <a href="mailto:<?php echo CONTACT_EMAIL; ?>">
                                <?php echo CONTACT_EMAIL; ?>
                            </a>
                            <p>For general inquiries and support</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Phone</h3>
                            <a href="tel:<?php echo str_replace(' ', '', CONTACT_PHONE); ?>">
                                <?php echo CONTACT_PHONE; ?>
                            </a>
                            <p>Mon-Fri, 9am-6pm your timezone</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Address</h3>
                            <p><?php echo CONTACT_ADDRESS; ?></p>
                            <p>Based in <?php echo OWNER_LOCATION; ?></p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Business Hours</h3>
                            <p><?php echo CONTACT_BUSINESS_HOURS; ?></p>
                            <p>Response time: 24 hours</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Follow Us</h3>
                            <div class="social-links">
                                <a href="<?php echo SOCIAL_TWITTER; ?>" target="_blank" rel="noopener noreferrer" class="social-link">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="<?php echo SOCIAL_LINKEDIN; ?>" target="_blank" rel="noopener noreferrer" class="social-link">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <a href="<?php echo SOCIAL_GITHUB; ?>" target="_blank" rel="noopener noreferrer" class="social-link">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="<?php echo SOCIAL_FACEBOOK; ?>" target="_blank" rel="noopener noreferrer" class="social-link">
                                    <i class="fab fa-facebook"></i>
                                </a>
                            </div>
                            <p>Stay updated with our latest news</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section" style="background-color: #f8f9ff;">
    <div class="container">
        <div class="section-title">
            <h2>Frequently Asked Questions</h2>
            <p>Quick answers to common questions</p>
        </div>
        
        <div class="faq-grid">
            <div class="faq-item">
                <h3><i class="fas fa-question-circle"></i> Is ResumeCraft really free?</h3>
                <p>Yes! ResumeCraft is completely free to use. You can create, edit, and download your resume without any charges or hidden fees.</p>
            </div>
            
            <div class="faq-item">
                <h3><i class="fas fa-question-circle"></i> Do I need to create an account?</h3>
                <p>No account required! Your resume data is stored in your browser session and you can download it immediately.</p>
            </div>
            
            <div class="faq-item">
                <h3><i class="fas fa-question-circle"></i> What file formats do you support?</h3>
                <p>Currently we support PDF export. All templates are optimized for PDF download and printing.</p>
            </div>
            
            <div class="faq-item">
                <h3><i class="fas fa-question-circle"></i> Are the templates ATS-friendly?</h3>
                <p>Yes! All our templates are designed to be compatible with Applicant Tracking Systems used by most companies.</p>
            </div>
        </div>
    </div>
</section>

<script>
// Add fingerprinting data to form
document.getElementById('contact-form').addEventListener('submit', function(e) {
    // Collect device info
    const screenResolution = window.screen.width + 'x' + window.screen.height;
    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    const userAgent = navigator.userAgent;
    
    // Create hidden inputs
    const screenInput = document.createElement('input');
    screenInput.type = 'hidden';
    screenInput.name = 'screen_resolution';
    screenInput.value = screenResolution;
    
    const timezoneInput = document.createElement('input');
    timezoneInput.type = 'hidden';
    timezoneInput.name = 'timezone';
    timezoneInput.value = timezone;
    
    const userAgentInput = document.createElement('input');
    userAgentInput.type = 'hidden';
    userAgentInput.name = 'user_agent';
    userAgentInput.value = userAgent;
    
    this.appendChild(screenInput);
    this.appendChild(timezoneInput);
    this.appendChild(userAgentInput);
    
    // Add loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    submitBtn.disabled = true;
    
    // Re-enable button if there's an error
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});
</script>

<style>
:root {
    --primary: #4361ee;
    --primary-dark: #3a56d4;
    --secondary: #4cc9f0;
    --accent: #7209b7;
    --light: #f8f9fa;
    --light-gray: #e9ecef;
    --medium-gray: #adb5bd;
    --dark-gray: #495057;
    --dark: #212529;
    --success: #4bb543;
    --warning: #f0ad4e;
    --danger: #d9534f;
    --border-radius: 8px;
    --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
    --transition: all 0.3s ease;
}

/* Hero Section */
.hero {
    padding: 100px 0;
    background: linear-gradient(135deg, #f5f7ff 0%, #f0f4ff 100%);
}

.hero-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
}

.hero-content {
    flex: 1;
}

.hero-content h1 {
    font-size: 3rem;
    margin-bottom: 1.5rem;
    color: var(--dark);
    font-weight: 700;
    font-family: 'Poppins', sans-serif;
}

.hero-content p {
    font-size: 1.2rem;
    color: var(--dark-gray);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.hero-cta {
    margin-top: 2rem;
}

.hero-image {
    flex: 1;
    display: flex;
    justify-content: flex-end;
}

/* Section */
.section {
    padding: 80px 0;
}

.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Alerts */
.alert-success, .alert-error {
    padding: 20px;
    border-radius: var(--border-radius);
    margin-bottom: 40px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert-success i {
    color: #28a745;
    font-size: 1.5rem;
    margin-top: 2px;
}

.alert-error {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.alert-error i {
    color: #dc3545;
    font-size: 1.5rem;
    margin-top: 2px;
}

.alert-success h4, .alert-error h4 {
    margin-bottom: 8px;
    font-weight: 600;
}

.alert-success ul, .alert-error ul {
    margin: 8px 0 0;
    padding-left: 20px;
}

.alert-success li, .alert-error li {
    margin-bottom: 4px;
}

/* Contact Wrapper */
.contact-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

@media (max-width: 992px) {
    .contact-wrapper {
        grid-template-columns: 1fr;
    }
}

/* Section Header */
.section-header {
    margin-bottom: 30px;
}

.section-header h2 {
    font-size: 2rem;
    color: var(--dark);
    margin-bottom: 8px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
}

.section-header p {
    color: var(--dark-gray);
    font-size: 1.1rem;
}

/* Contact Form */
.contact-form {
    background: white;
    padding: 30px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--dark);
    font-size: 14px;
}

.form-group label i {
    color: var(--primary);
    font-size: 0.9rem;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 14px;
    border: 1px solid var(--light-gray);
    border-radius: var(--border-radius);
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    transition: var(--transition);
    background: white;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.form-footer {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--light-gray);
}

.form-note {
    margin-top: 12px;
    font-size: 0.9rem;
    color: var(--medium-gray);
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-note i {
    color: var(--primary);
}

/* Contact Info Cards */
.contact-info-cards {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.contact-info-card {
    background: white;
    padding: 24px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    display: flex;
    align-items: flex-start;
    gap: 20px;
    transition: var(--transition);
    border-left: 4px solid transparent;
}

.contact-info-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-left-color: var(--primary);
}

.contact-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.contact-details {
    flex: 1;
}

.contact-details h3 {
    color: var(--dark);
    margin-bottom: 8px;
    font-size: 1.2rem;
    font-weight: 600;
}

.contact-details a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.contact-details a:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

.contact-details p {
    color: var(--dark-gray);
    margin-top: 4px;
    font-size: 0.9rem;
    line-height: 1.5;
}

/* Social Links */
.social-links {
    display: flex;
    gap: 12px;
    margin-top: 8px;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--light);
    color: var(--dark);
    text-decoration: none;
    transition: var(--transition);
    font-size: 1.1rem;
}

.social-link:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
}

/* FAQ Section */
.section-title {
    text-align: center;
    margin-bottom: 3rem;
}

.section-title h2 {
    font-size: 2.2rem;
    color: var(--dark);
    margin-bottom: 1rem;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
}

.section-title p {
    color: var(--dark-gray);
    max-width: 700px;
    margin: 0 auto;
    font-size: 1.1rem;
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

.faq-item {
    background: white;
    padding: 24px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.faq-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.faq-item h3 {
    color: var(--dark);
    margin-bottom: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.faq-item h3 i {
    color: var(--primary);
}

.faq-item p {
    color: var(--dark-gray);
    line-height: 1.6;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    border-radius: var(--border-radius);
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: var(--transition);
    border: none;
    text-decoration: none;
    font-family: 'Inter', sans-serif;
    justify-content: center;
}

.btn-primary {
    background-color: var(--primary);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.btn-secondary {
    background-color: white;
    color: var(--primary);
    border: 2px solid var(--primary);
}

.btn-secondary:hover {
    background-color: var(--light);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.btn-large {
    padding: 15px 35px;
    font-size: 1.1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .hero {
        padding: 60px 0;
    }
    
    .hero-container {
        flex-direction: column;
        text-align: center;
    }
    
    .hero-image {
        justify-content: center;
        order: -1;
    }
    
    .hero-content h1 {
        font-size: 2.2rem;
    }
    
    .section {
        padding: 60px 0;
    }
    
    .section-header h2,
    .section-title h2 {
        font-size: 1.8rem;
    }
    
    .contact-form {
        padding: 20px;
    }
    
    .faq-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .hero-content h1 {
        font-size: 1.8rem;
    }
    
    .hero-content p {
        font-size: 1rem;
    }
    
    .section-header h2,
    .section-title h2 {
        font-size: 1.6rem;
    }
    
    .contact-info-card {
        flex-direction: column;
        text-align: center;
    }
    
    .contact-icon {
        align-self: center;
    }
}
</style>