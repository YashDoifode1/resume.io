<?php
/**
 * Footer Component
 * 
 * Renders the footer section with links and copyright
 */

require_once __DIR__ . '/../config/constants.php';
?>
<footer class="footer">
    <div class="footer-container">
        <!-- Footer Content -->
        <div class="footer-content">
            <!-- About Section -->
            <div class="footer-section">
                <h3><?php echo SITE_NAME; ?></h3>
                <p><?php echo SITE_DESCRIPTION; ?></p>
                <div class="social-links">
                    <a href="<?php echo SOCIAL_TWITTER; ?>" target="_blank" rel="noopener noreferrer" title="Twitter">
                        <svg class="social-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7"/>
                        </svg>
                    </a>
                    <a href="<?php echo SOCIAL_LINKEDIN; ?>" target="_blank" rel="noopener noreferrer" title="LinkedIn">
                        <svg class="social-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/>
                        </svg>
                    </a>
                    <a href="<?php echo SOCIAL_GITHUB; ?>" target="_blank" rel="noopener noreferrer" title="GitHub">
                        <svg class="social-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v 3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Product Links -->
            <div class="footer-section">
                <h4>Product</h4>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>?page=builder">Resume Builder</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?page=about">How It Works</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?page=faq">FAQ</a></li>
                </ul>
            </div>

            <!-- Company Links -->
            <div class="footer-section">
                <h4>Company</h4>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>?page=about">About Us</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?page=contact">Contact</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?page=privacy">Privacy Policy</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?page=terms">Terms of Service</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-section">
                <h4>Contact</h4>
                <ul>
                    <li><a href="mailto:<?php echo CONTACT_EMAIL; ?>"><?php echo CONTACT_EMAIL; ?></a></li>
                    <li><a href="tel:<?php echo str_replace(' ', '', CONTACT_PHONE); ?>"><?php echo CONTACT_PHONE; ?></a></li>
                    <li><?php echo CONTACT_ADDRESS; ?></li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
            <p>Made with <span class="heart">❤</span> for professionals worldwide</p>
        </div>
    </div>
</footer>

<!-- JavaScript Files -->
<script src="<?php echo JS_URL; ?>main.js"></script>
<?php if (isset($page_js)): ?>
    <script src="<?php echo JS_URL . $page_js; ?>"></script>
<?php endif; ?>

</body>
</html>
