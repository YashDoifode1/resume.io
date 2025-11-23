<?php
/**
 * Privacy Policy Page
 */

$page_title = 'Privacy Policy';
$page_description = 'Privacy Policy for ResumeBuilder Pro.';
$canonical_url = BASE_URL . '?page=privacy';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Privacy Policy</h1>
        <p>Last updated: <?php echo date('F j, Y'); ?></p>
    </div>
</section>

<!-- Content Section -->
<section class="section">
    <div class="container container-md">
        <div class="legal-content">
            <h2>1. Introduction</h2>
            <p>ResumeBuilder Pro ("we," "us," "our," or "Company") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.</p>

            <h2>2. Information We Collect</h2>
            <p>We collect minimal information from our users:</p>
            <ul>
                <li><strong>Resume Data:</strong> Information you voluntarily enter into our resume builder form (name, email, phone, work experience, education, etc.)</li>
                <li><strong>Profile Picture:</strong> If you choose to upload a profile picture</li>
                <li><strong>Browser Data:</strong> Basic information about your browser and device for analytics purposes</li>
            </ul>

            <h2>3. How We Use Your Information</h2>
            <p>We use the information we collect for the following purposes:</p>
            <ul>
                <li>To provide and maintain our resume builder service</li>
                <li>To generate PDF downloads of your resume</li>
                <li>To improve our website and services</li>
                <li>To analyze usage patterns and trends</li>
            </ul>

            <h2>4. Data Storage</h2>
            <p>Your resume data is stored locally in your browser session. We do not store your personal information on our servers. Your data is automatically deleted when you close your browser or clear your session.</p>

            <h2>5. Third-Party Services</h2>
            <p>We may use third-party services for PDF generation and analytics. These services have their own privacy policies, and we encourage you to review them.</p>

            <h2>6. Security</h2>
            <p>We implement appropriate technical and organizational measures to protect your information against unauthorized access, alteration, disclosure, or destruction.</p>

            <h2>7. Cookies</h2>
            <p>Our website may use cookies to enhance your experience. You can control cookie settings through your browser preferences.</p>

            <h2>8. Children's Privacy</h2>
            <p>Our service is not intended for children under the age of 13. We do not knowingly collect information from children under 13.</p>

            <h2>9. Changes to This Privacy Policy</h2>
            <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date.</p>

            <h2>10. Contact Us</h2>
            <p>If you have questions about this Privacy Policy, please contact us at:</p>
            <p>
                <strong>Email:</strong> <a href="mailto:<?php echo CONTACT_EMAIL; ?>"><?php echo CONTACT_EMAIL; ?></a><br>
                <strong>Address:</strong> <?php echo CONTACT_ADDRESS; ?>
            </p>
        </div>
    </div>
</section>

<style>
    .legal-content {
        line-height: 1.8;
    }

    .legal-content h2 {
        margin-top: 32px;
        margin-bottom: 16px;
        color: var(--color-primary);
        font-size: 20px;
    }

    .legal-content h2:first-child {
        margin-top: 0;
    }

    .legal-content p {
        margin-bottom: 16px;
        color: var(--color-text-secondary);
    }

    .legal-content ul {
        margin-left: 24px;
        margin-bottom: 16px;
    }

    .legal-content li {
        margin-bottom: 8px;
        color: var(--color-text-secondary);
    }

    .legal-content strong {
        color: var(--color-text-primary);
    }

    .legal-content a {
        color: var(--color-primary);
    }
</style>
