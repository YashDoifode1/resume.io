<?php
/**
 * FAQ Page - Updated to match our theme
 */

$page_title = 'FAQ';
$page_description = 'Frequently asked questions about ResumeCraft.';
$canonical_url = BASE_URL . '?page=faq';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container hero-container">
        <div class="hero-content">
            <h1>Frequently Asked Questions</h1>
            <p>Find answers to common questions about ResumeCraft</p>
            <div class="hero-cta">
                <a href="#faq-content" class="btn btn-secondary">
                    <i class="fas fa-arrow-down"></i> Browse FAQs
                </a>
            </div>
        </div>
        <div class="hero-image">
            <div style="background: linear-gradient(135deg, var(--primary), var(--secondary)); height: 200px; width: 100%; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 64px; box-shadow: var(--shadow-lg);">
                <i class="fas fa-question-circle"></i>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section" id="faq-content">
    <div class="container">
        <div class="section-title">
            <h2>Common Questions</h2>
            <p>Find quick answers to your questions about ResumeCraft</p>
        </div>
        
        <!-- FAQ Categories -->
        <div class="faq-categories">
            <button class="category-btn active" data-category="all">
                <i class="fas fa-th"></i> All Questions
            </button>
            <button class="category-btn" data-category="general">
                <i class="fas fa-info-circle"></i> General
            </button>
            <button class="category-btn" data-category="features">
                <i class="fas fa-star"></i> Features
            </button>
            <button class="category-btn" data-category="privacy">
                <i class="fas fa-shield-alt"></i> Privacy & Security
            </button>
            <button class="category-btn" data-category="technical">
                <i class="fas fa-cogs"></i> Technical
            </button>
        </div>

        <div class="faq-container">
            <!-- FAQ Item 1 -->
            <div class="faq-item" data-category="general">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">General</span>
                        <span class="faq-title">Is ResumeCraft really free?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Yes! ResumeCraft is completely free. There are no hidden fees, no premium plans, and no subscriptions. You can create, preview, and download your resume without paying anything.</p>
                    <p>We believe everyone should have access to professional resume-building tools without financial barriers.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-item" data-category="privacy">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">Privacy</span>
                        <span class="faq-title">Do I need to create an account?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>No, you don't need to create an account. ResumeCraft is completely anonymous. Your data is stored in your browser session and is never sent to our servers.</p>
                    <p>This means you can start building your resume immediately without any sign-up process.</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-item" data-category="features">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">Features</span>
                        <span class="faq-title">How many templates are available?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>We offer 5 professionally designed templates:</p>
                    <ul>
                        <li><strong>Classic Professional</strong> - Traditional and formal</li>
                        <li><strong>Modern Minimal</strong> - Clean and contemporary</li>
                        <li><strong>Corporate Blue</strong> - Professional business style</li>
                        <li><strong>Creative Portfolio</strong> - Artistic and bold</li>
                        <li><strong>Dark Mode</strong> - Modern dark theme</li>
                    </ul>
                    <p>Each template is fully customizable and responsive.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-item" data-category="features">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">Features</span>
                        <span class="faq-title">Can I download my resume as PDF?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Yes! You can download your resume as a PDF file with just one click. The PDF is generated instantly and ready to send to employers.</p>
                    <p>The PDF is optimized for both screen viewing and printing, ensuring your resume looks professional in any format.</p>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="faq-item" data-category="technical">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">Technical</span>
                        <span class="faq-title">Are the templates ATS-friendly?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Yes, all our templates are optimized for Applicant Tracking Systems (ATS). We ensure that your resume will be properly parsed by ATS software used by most employers.</p>
                    <p>Our templates follow industry best practices for ATS compatibility, including proper formatting, standard headings, and clean layout.</p>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="faq-item" data-category="features">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">Features</span>
                        <span class="faq-title">Can I upload a profile picture?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Yes, you can upload a profile picture in JPG, PNG, GIF, or WebP format. The maximum file size is 5MB. Your picture will be displayed in your resume.</p>
                    <p>We automatically resize and optimize your picture for the best display quality in your resume.</p>
                </div>
            </div>

            <!-- FAQ Item 7 -->
            <div class="faq-item" data-category="features">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">Features</span>
                        <span class="faq-title">How do I add multiple work experiences?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Simply click the "Add Work Experience" button to add as many work experiences as you need. You can add, edit, and remove entries as needed.</p>
                    <p>Each work experience entry includes fields for company name, job title, dates, and responsibilities.</p>
                </div>
            </div>

            <!-- FAQ Item 8 -->
            <div class="faq-item" data-category="privacy">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">Privacy</span>
                        <span class="faq-title">Is my data secure?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Your data is stored locally in your browser session and is never sent to our servers. We don't collect, store, or share any of your personal information.</p>
                    <p>For added security, your session data is automatically cleared when you close your browser.</p>
                </div>
            </div>

            <!-- FAQ Item 9 -->
            <div class="faq-item" data-category="features">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">Features</span>
                        <span class="faq-title">Can I customize the templates?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Yes, all templates are fully customizable. You can adjust colors, fonts, and layout to match your personal brand and preferences.</p>
                    <p>Changes are reflected in real-time in the preview, so you can see exactly how your resume will look.</p>
                </div>
            </div>

            <!-- FAQ Item 10 -->
            <div class="faq-item" data-category="features">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">Features</span>
                        <span class="faq-title">What sections can I include in my resume?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>You can include the following sections in your resume:</p>
                    <ul>
                        <li><strong>Personal Information</strong> - Name, contact details, etc.</li>
                        <li><strong>Work Experience</strong> - Multiple entries with detailed descriptions</li>
                        <li><strong>Education</strong> - Academic background and achievements</li>
                        <li><strong>Skills</strong> - Technical and professional skills</li>
                        <li><strong>Projects</strong> - Portfolio projects and accomplishments</li>
                        <li><strong>Certifications</strong> - Professional certifications</li>
                        <li><strong>Languages</strong> - Language proficiencies</li>
                        <li><strong>Interests</strong> - Personal interests and hobbies</li>
                    </ul>
                </div>
            </div>

            <!-- FAQ Item 11 -->
            <div class="faq-item" data-category="technical">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">Technical</span>
                        <span class="faq-title">Can I use ResumeCraft on mobile?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Yes, ResumeCraft is fully responsive and works on mobile devices. You can create and preview your resume on any device with a web browser.</p>
                    <p>The interface adapts to your screen size, making it easy to use on smartphones, tablets, and desktop computers.</p>
                </div>
            </div>

            <!-- FAQ Item 12 -->
            <div class="faq-item" data-category="general">
                <button class="faq-question">
                    <div class="faq-header">
                        <span class="faq-category-label">General</span>
                        <span class="faq-title">How do I contact support?</span>
                    </div>
                    <span class="faq-icon"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">
                    <p>You can contact us through our <a href="<?php echo BASE_URL; ?>?page=contact">Contact Page</a>. We'll get back to you as soon as possible.</p>
                    <p>We're always happy to help with any questions or issues you might have.</p>
                </div>
            </div>
        </div>
        
        <!-- Still Have Questions -->
        <div class="faq-cta">
            <div class="cta-card">
                <h3><i class="fas fa-question-circle"></i> Still have questions?</h3>
                <p>Can't find the answer you're looking for? Please don't hesitate to contact our team.</p>
                <a href="<?php echo BASE_URL; ?>?page=contact" class="btn btn-primary">
                    <i class="fas fa-envelope"></i> Contact Support
                </a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ accordion functionality
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', function() {
            const item = this.parentElement;
            const isActive = item.classList.contains('active');
            
            // Close all FAQ items
            document.querySelectorAll('.faq-item').forEach(faq => {
                faq.classList.remove('active');
                const icon = faq.querySelector('.faq-icon i');
                icon.className = 'fas fa-plus';
            });
            
            // Open clicked item if it wasn't active
            if (!isActive) {
                item.classList.add('active');
                const icon = this.querySelector('.faq-icon i');
                icon.className = 'fas fa-minus';
            }
        });
    });
    
    // FAQ category filtering
    const categoryBtns = document.querySelectorAll('.category-btn');
    const faqItems = document.querySelectorAll('.faq-item');
    
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button
            categoryBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const category = this.getAttribute('data-category');
            
            // Filter FAQ items
            faqItems.forEach(item => {
                if (category === 'all' || item.getAttribute('data-category') === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    // Open FAQ item from URL hash
    if (window.location.hash) {
        const targetId = window.location.hash.substring(1);
        if (targetId) {
            // For now, just scroll to FAQ section
            document.getElementById('faq-content')?.scrollIntoView({ behavior: 'smooth' });
        }
    }
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

/* FAQ Categories */
.faq-categories {
    display: flex;
    gap: 12px;
    margin-bottom: 40px;
    flex-wrap: wrap;
    justify-content: center;
}

.category-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: var(--light);
    border: 2px solid var(--light-gray);
    border-radius: var(--border-radius);
    color: var(--dark);
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
}

.category-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-2px);
}

.category-btn.active {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
    box-shadow: var(--shadow);
}

.category-btn i {
    font-size: 0.9rem;
}

/* FAQ Container */
.faq-container {
    max-width: 800px;
    margin: 0 auto 60px;
}

.faq-item {
    margin-bottom: 16px;
    background: white;
    border: 1px solid var(--light-gray);
    border-radius: var(--border-radius);
    overflow: hidden;
    transition: var(--transition);
}

.faq-item:hover {
    border-color: var(--primary);
    box-shadow: var(--shadow);
}

.faq-question {
    width: 100%;
    padding: 24px;
    background: white;
    border: none;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-align: left;
    transition: var(--transition);
}

.faq-header {
    display: flex;
    flex-direction: column;
    gap: 6px;
    flex: 1;
}

.faq-category-label {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 10px;
    background: var(--light);
    color: var(--primary);
    border-radius: 20px;
    display: inline-block;
    width: fit-content;
}

.faq-title {
    font-weight: 600;
    color: var(--dark);
    font-size: 1.1rem;
    line-height: 1.4;
}

.faq-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    transition: var(--transition);
    flex-shrink: 0;
    margin-left: 20px;
}

.faq-item.active .faq-icon {
    background: var(--primary);
    color: white;
    transform: rotate(180deg);
}

.faq-answer {
    display: none;
    padding: 0 24px 24px;
    border-top: 1px solid var(--light-gray);
}

.faq-item.active .faq-answer {
    display: block;
    animation: slideDown 0.3s ease;
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

.faq-answer p {
    color: var(--dark-gray);
    line-height: 1.8;
    margin-bottom: 16px;
}

.faq-answer p:last-child {
    margin-bottom: 0;
}

.faq-answer ul {
    margin: 16px 0;
    padding-left: 24px;
}

.faq-answer li {
    color: var(--dark-gray);
    margin-bottom: 8px;
    line-height: 1.6;
}

.faq-answer strong {
    color: var(--dark);
}

.faq-answer a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.faq-answer a:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

/* FAQ CTA */
.faq-cta {
    max-width: 800px;
    margin: 0 auto;
}

.cta-card {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    padding: 40px;
    border-radius: var(--border-radius);
    text-align: center;
    box-shadow: var(--shadow-lg);
}

.cta-card h3 {
    font-size: 1.8rem;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    font-family: 'Poppins', sans-serif;
}

.cta-card p {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 24px;
    font-size: 1.1rem;
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
    background-color: white;
    color: var(--primary);
}

.btn-primary:hover {
    background-color: var(--light);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
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

/* Responsive */
@media (max-width: 992px) {
    .hero-container {
        flex-direction: column;
        text-align: center;
    }
    
    .hero-image {
        justify-content: center;
        order: -1;
    }
}

@media (max-width: 768px) {
    .hero {
        padding: 60px 0;
    }
    
    .hero-content h1 {
        font-size: 2.2rem;
    }
    
    .section {
        padding: 60px 0;
    }
    
    .section-title h2 {
        font-size: 1.8rem;
    }
    
    .faq-categories {
        flex-direction: column;
        align-items: stretch;
    }
    
    .category-btn {
        justify-content: center;
    }
    
    .faq-question {
        padding: 20px;
    }
    
    .faq-answer {
        padding: 0 20px 20px;
    }
    
    .cta-card {
        padding: 30px 20px;
    }
}

@media (max-width: 480px) {
    .hero-content h1 {
        font-size: 1.8rem;
    }
    
    .hero-content p {
        font-size: 1rem;
    }
    
    .section-title h2 {
        font-size: 1.6rem;
    }
    
    .faq-title {
        font-size: 1rem;
    }
    
    .faq-icon {
        margin-left: 10px;
        width: 28px;
        height: 28px;
    }
    
    .cta-card h3 {
        font-size: 1.5rem;
        flex-direction: column;
        gap: 8px;
    }
}
</style>