<?php
/**
 * Footer Component
 * 
 * Renders the footer section with links and copyright
 */

require_once __DIR__ . '/../config/constants.php';
?>
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <!-- Brand Column -->
            <div class="footer-column">
                <div class="footer-logo">
                    <i class="fas fa-file-alt"></i> ResumeCraft
                </div>
                <p class="footer-description">
                    ResumeCraft helps job seekers create professional, ATS-friendly resumes for free. 
                    No sign-up required. No hidden fees.
                </p>
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
            </div>
            
            <!-- Product Links -->
            <div class="footer-column">
                <h4 class="footer-title">Product</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo BASE_URL; ?>?page=builder">Resume Builder</a></li>
                    <li><a href="#templates">Templates</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?page=examples">Examples</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?page=faq">FAQ</a></li>
                </ul>
            </div>
            
            <!-- Company Links -->
            <div class="footer-column">
                <h4 class="footer-title">Company</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo BASE_URL; ?>?page=about">About Us</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?page=contact">Contact</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?page=privacy">Privacy Policy</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?page=terms">Terms of Service</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div class="footer-column">
                <h4 class="footer-title">Contact</h4>
                <ul class="footer-links">
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:<?php echo CONTACT_EMAIL; ?>"><?php echo CONTACT_EMAIL; ?></a>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <a href="tel:<?php echo str_replace(' ', '', CONTACT_PHONE); ?>"><?php echo CONTACT_PHONE; ?></a>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo CONTACT_ADDRESS; ?>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> ResumeCraft. All rights reserved.</p>
            <p>Made with <span class="heart">❤️</span> for professionals worldwide</p>
        </div>
    </div>
</footer>

<?php if (isset($page_js)): ?>
    <script src="<?php echo JS_URL . $page_js; ?>"></script>
<?php endif; ?>

</body>
</html>

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

/* Footer */
.footer {
    background-color: var(--dark);
    color: white;
    padding: 70px 0 30px;
    margin-top: auto;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-bottom: 50px;
}

.footer-column {
    display: flex;
    flex-direction: column;
}

.footer-logo {
    font-size: 1.8rem;
    font-weight: 700;
    color: white;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.footer-logo i {
    margin-right: 8px;
    color: var(--secondary);
}

.footer-description {
    color: var(--medium-gray);
    line-height: 1.6;
    margin-bottom: 20px;
}

.footer-title {
    color: white;
    margin-bottom: 20px;
    font-size: 1.2rem;
    font-weight: 600;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.footer-links a {
    color: var(--light-gray);
    text-decoration: none;
    transition: var(--transition);
    font-size: 0.95rem;
}

.footer-links a:hover {
    color: white;
    padding-left: 5px;
}

.footer-links i {
    color: var(--secondary);
    font-size: 0.9rem;
    width: 20px;
}

/* Social Links */
.social-links {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    text-decoration: none;
    transition: var(--transition);
    font-size: 1.1rem;
}

.social-link:hover {
    background: var(--primary);
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Footer Bottom */
.footer-bottom {
    text-align: center;
    padding-top: 30px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    color: var(--medium-gray);
    font-size: 0.9rem;
}

.footer-bottom p {
    margin-bottom: 8px;
}

.footer-bottom .heart {
    color: var(--danger);
    animation: heartbeat 1.5s ease-in-out infinite;
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Container */
.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .footer {
        padding: 50px 0 20px;
    }
    
    .footer-content {
        gap: 30px;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    
    .footer-logo {
        font-size: 1.5rem;
    }
    
    .social-links {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .footer-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .footer-links li {
        justify-content: center;
    }
    
    .social-links {
        justify-content: center;
    }
}
</style>