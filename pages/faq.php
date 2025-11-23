<?php
/**
 * FAQ Page
 */

$page_title = 'FAQ';
$page_description = 'Frequently asked questions about ResumeBuilder Pro.';
$canonical_url = BASE_URL . '?page=faq';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Frequently Asked Questions</h1>
        <p>Find answers to common questions about ResumeBuilder Pro</p>
    </div>
</section>

<!-- FAQ Section -->
<section class="section">
    <div class="container container-md">
        <div class="faq-container">
            <!-- FAQ Item 1 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Is ResumeBuilder Pro really free?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>Yes! ResumeBuilder Pro is completely free. There are no hidden fees, no premium plans, and no subscriptions. You can create, preview, and download your resume without paying anything.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Do I need to create an account?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>No, you don't need to create an account. ResumeBuilder Pro is completely anonymous. Your data is stored in your browser session and is never sent to our servers.</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>How many templates are available?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>We offer 5 professionally designed templates: Classic Professional, Modern Minimal, Corporate Blue, Creative Portfolio, and Dark Mode. Each template is fully customizable and responsive.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Can I download my resume as PDF?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>Yes! You can download your resume as a PDF file with just one click. The PDF is generated instantly and ready to send to employers.</p>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Are the templates ATS-friendly?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>Yes, all our templates are optimized for Applicant Tracking Systems (ATS). We ensure that your resume will be properly parsed by ATS software used by most employers.</p>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Can I upload a profile picture?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>Yes, you can upload a profile picture in JPG, PNG, GIF, or WebP format. The maximum file size is 5MB. Your picture will be displayed in your resume.</p>
                </div>
            </div>

            <!-- FAQ Item 7 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>How do I add multiple work experiences?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>Simply click the "Add Work Experience" button to add as many work experiences as you need. You can add, edit, and remove entries as needed.</p>
                </div>
            </div>

            <!-- FAQ Item 8 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Is my data secure?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>Your data is stored locally in your browser session and is never sent to our servers. We don't collect, store, or share any of your personal information.</p>
                </div>
            </div>

            <!-- FAQ Item 9 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Can I customize the templates?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>Yes, all templates are fully customizable. You can adjust colors, fonts, and layout to match your personal brand and preferences.</p>
                </div>
            </div>

            <!-- FAQ Item 10 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>What sections can I include in my resume?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>You can include: Personal Information, Work Experience, Education, Skills, Projects, Certifications, Languages, and Interests. Each section can have multiple entries.</p>
                </div>
            </div>

            <!-- FAQ Item 11 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Can I use ResumeBuilder Pro on mobile?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>Yes, ResumeBuilder Pro is fully responsive and works on mobile devices. You can create and preview your resume on any device with a web browser.</p>
                </div>
            </div>

            <!-- FAQ Item 12 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>How do I contact support?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>You can contact us through our <a href="<?php echo BASE_URL; ?>?page=contact">Contact Page</a>. We'll get back to you as soon as possible.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .faq-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .faq-item {
        margin-bottom: 16px;
        border: 1px solid var(--color-border);
        border-radius: 8px;
        overflow: hidden;
    }

    .faq-question {
        width: 100%;
        padding: 20px;
        background: var(--color-bg-secondary);
        border: none;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: var(--color-text-primary);
        transition: all 0.3s ease;
    }

    .faq-question:hover {
        background: var(--color-primary);
        color: white;
    }

    .faq-icon {
        font-size: 24px;
        transition: transform 0.3s ease;
    }

    .faq-item.active .faq-question {
        background: var(--color-primary);
        color: white;
    }

    .faq-item.active .faq-icon {
        transform: rotate(45deg);
    }

    .faq-answer {
        display: none;
        padding: 20px;
        background: var(--color-bg-primary);
        border-top: 1px solid var(--color-border);
    }

    .faq-item.active .faq-answer {
        display: block;
        animation: slideDown 0.3s ease;
    }

    .faq-answer p {
        margin: 0;
        color: var(--color-text-secondary);
        line-height: 1.8;
    }

    .faq-answer a {
        color: var(--color-primary);
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', function() {
            const item = this.parentElement;
            item.classList.toggle('active');
        });
    });
</script>
