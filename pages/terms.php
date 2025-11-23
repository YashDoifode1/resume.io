<?php
/**
 * Terms of Service Page
 */

$page_title = 'Terms of Service';
$page_description = 'Terms of Service for ResumeBuilder Pro.';
$canonical_url = BASE_URL . '?page=terms';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Terms of Service</h1>
        <p>Last updated: <?php echo date('F j, Y'); ?></p>
    </div>
</section>

<!-- Content Section -->
<section class="section">
    <div class="container container-md">
        <div class="legal-content">
            <h2>1. Agreement to Terms</h2>
            <p>By accessing and using ResumeBuilder Pro, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>

            <h2>2. Use License</h2>
            <p>Permission is granted to temporarily download one copy of the materials (information or software) on ResumeBuilder Pro for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
            <ul>
                <li>Modify or copy the materials</li>
                <li>Use the materials for any commercial purpose or for any public display</li>
                <li>Attempt to decompile or reverse engineer any software contained on the website</li>
                <li>Remove any copyright or other proprietary notations from the materials</li>
                <li>Transfer the materials to another person or "mirror" the materials on any other server</li>
            </ul>

            <h2>3. Disclaimer</h2>
            <p>The materials on ResumeBuilder Pro are provided on an 'as is' basis. ResumeBuilder Pro makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>

            <h2>4. Limitations</h2>
            <p>In no event shall ResumeBuilder Pro or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on ResumeBuilder Pro.</p>

            <h2>5. Accuracy of Materials</h2>
            <p>The materials appearing on ResumeBuilder Pro could include technical, typographical, or photographic errors. ResumeBuilder Pro does not warrant that any of the materials on its website are accurate, complete, or current. ResumeBuilder Pro may make changes to the materials contained on its website at any time without notice.</p>

            <h2>6. Materials and Content</h2>
            <p>The materials on ResumeBuilder Pro are protected by copyright law and international treaties. You may not reproduce, distribute, transmit, display, or perform any content from this website without prior written permission.</p>

            <h2>7. Limitations on Liability</h2>
            <p>In no case shall ResumeBuilder Pro, its suppliers, or any third parties mentioned on this website be liable for any damages whatsoever (including, without limitation, incidental and consequential damages, lost profits, or damages resulting from lost data or business interruption) resulting from the use of or inability to use the materials on ResumeBuilder Pro or the internet generally.</p>

            <h2>8. Revisions and Errata</h2>
            <p>The materials appearing on ResumeBuilder Pro may include technical, typographical, or photographic errors. ResumeBuilder Pro will not be responsible for any such errors or omissions that may appear on the website.</p>

            <h2>9. Links</h2>
            <p>ResumeBuilder Pro has not reviewed all of the sites linked to its website and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by ResumeBuilder Pro of the site. Use of any such linked website is at the user's own risk.</p>

            <h2>10. Modifications</h2>
            <p>ResumeBuilder Pro may revise these terms of service for its website at any time without notice. By using this website, you are agreeing to be bound by the then current version of these terms of service.</p>

            <h2>11. Governing Law</h2>
            <p>These terms and conditions are governed by and construed in accordance with the laws of the jurisdiction in which ResumeBuilder Pro operates, and you irrevocably submit to the exclusive jurisdiction of the courts in that location.</p>

            <h2>12. Contact Information</h2>
            <p>If you have any questions about these Terms of Service, please contact us at:</p>
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
