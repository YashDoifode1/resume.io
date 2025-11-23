<?php
/**
 * Home Page - Landing Page
 */

$page_title = 'Home';
$page_description = 'Create professional resumes in minutes with our AI-powered resume builder. Choose from 5 beautiful templates and download as PDF.';
$page_keywords = 'resume builder, resume maker, CV builder, professional resume, free resume';
$canonical_url = BASE_URL;
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Build Your Professional Resume in Minutes</h1>
        <p>Create a stunning, ATS-friendly resume with our intuitive resume builder. Choose from 5 professional templates, customize, and download as PDF instantly.</p>
        <div class="hero-buttons">
            <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-lg">Get Started Free</a>
            <a href="<?php echo BASE_URL; ?>?page=about" class="btn btn-outline btn-lg">Learn More</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Why Choose ResumeBuilder Pro?</h2>
            <p>Everything you need to create a professional resume that gets noticed</p>
        </div>

        <div class="grid grid-cols-3">
            <!-- Feature 1 -->
            <div class="card feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Instant PDF Download</h3>
                <p>Generate and download your resume as PDF in seconds. No waiting, no complications.</p>
            </div>

            <!-- Feature 2 -->
            <div class="card feature-card">
                <div class="feature-icon">🎨</div>
                <h3>5 Professional Templates</h3>
                <p>Choose from carefully designed templates: Classic, Modern, Corporate, Creative, and Dark Mode.</p>
            </div>

            <!-- Feature 3 -->
            <div class="card feature-card">
                <div class="feature-icon">📱</div>
                <h3>Fully Responsive</h3>
                <p>Works perfectly on desktop, tablet, and mobile. Build your resume anywhere, anytime.</p>
            </div>

            <!-- Feature 4 -->
            <div class="card feature-card">
                <div class="feature-icon">🔒</div>
                <h3>No Login Required</h3>
                <p>Start building immediately. No account creation, no personal data collection.</p>
            </div>

            <!-- Feature 5 -->
            <div class="card feature-card">
                <div class="feature-icon">✨</div>
                <h3>Clean & Modern UI</h3>
                <p>Intuitive interface designed for simplicity. Build your resume without any technical knowledge.</p>
            </div>

            <!-- Feature 6 -->
            <div class="card feature-card">
                <div class="feature-icon">🎯</div>
                <h3>ATS-Friendly</h3>
                <p>All templates are optimized for Applicant Tracking Systems to ensure your resume gets seen.</p>
            </div>
        </div>
    </div>
</section>

<!-- Templates Preview Section -->
<section class="section" style="background-color: var(--color-bg-secondary);">
    <div class="container">
        <div class="section-header">
            <h2>Choose Your Perfect Template</h2>
            <p>Each template is professionally designed and fully customizable</p>
        </div>

        <div class="grid grid-cols-2">
            <!-- Template 1 -->
            <div class="card">
                <div style="background: linear-gradient(135deg, #f5f7fa, #c3cfe2); height: 200px; border-radius: 8px; margin-bottom: 16px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 48px;">📄</span>
                </div>
                <h3>Classic Professional</h3>
                <p>Traditional, clean, and professional. Perfect for corporate and formal positions.</p>
                <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-sm" style="margin-top: 12px;">Use Template</a>
            </div>

            <!-- Template 2 -->
            <div class="card">
                <div style="background: linear-gradient(135deg, #ffecd2, #fcb69f); height: 200px; border-radius: 8px; margin-bottom: 16px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 48px;">✨</span>
                </div>
                <h3>Modern Minimal</h3>
                <p>Minimalist design with elegant typography. Great for creative professionals.</p>
                <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-sm" style="margin-top: 12px;">Use Template</a>
            </div>

            <!-- Template 3 -->
            <div class="card">
                <div style="background: linear-gradient(135deg, #a8edea, #fed6e3); height: 200px; border-radius: 8px; margin-bottom: 16px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 48px;">💼</span>
                </div>
                <h3>Corporate Blue</h3>
                <p>Professional blue theme with structured layout. Ideal for business roles.</p>
                <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-sm" style="margin-top: 12px;">Use Template</a>
            </div>

            <!-- Template 4 -->
            <div class="card">
                <div style="background: linear-gradient(135deg, #ff9a56, #ff6a88); height: 200px; border-radius: 8px; margin-bottom: 16px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 48px;">🎨</span>
                </div>
                <h3>Creative Portfolio</h3>
                <p>Stylish and modern design. Perfect for designers, developers, and creatives.</p>
                <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-sm" style="margin-top: 12px;">Use Template</a>
            </div>

            <!-- Template 5 -->
            <div class="card">
                <div style="background: linear-gradient(135deg, #1a1a1a, #2d2d2d); height: 200px; border-radius: 8px; margin-bottom: 16px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 48px; color: #00d4ff;">🌙</span>
                </div>
                <h3>Dark Mode</h3>
                <p>Modern dark theme with bold typography. Great for tech professionals.</p>
                <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-sm" style="margin-top: 12px;">Use Template</a>
            </div>

            <!-- CTA Card -->
            <div class="card" style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); color: white; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
                <h3 style="color: white; margin-bottom: 12px;">Ready to Get Started?</h3>
                <p style="color: rgba(255,255,255,0.9); margin-bottom: 20px;">Create your professional resume now and take the next step in your career.</p>
                <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-outline" style="border-color: white; color: white;">Start Building</a>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>How It Works</h2>
            <p>Three simple steps to create your professional resume</p>
        </div>

        <div class="grid grid-cols-3">
            <div class="card text-center">
                <div style="font-size: 48px; margin-bottom: 16px;">1️⃣</div>
                <h3>Fill Your Information</h3>
                <p>Enter your personal details, work experience, education, skills, and more using our intuitive form.</p>
            </div>

            <div class="card text-center">
                <div style="font-size: 48px; margin-bottom: 16px;">2️⃣</div>
                <h3>Choose a Template</h3>
                <p>Select from 5 professionally designed templates and see your resume update in real-time.</p>
            </div>

            <div class="card text-center">
                <div style="font-size: 48px; margin-bottom: 16px;">3️⃣</div>
                <h3>Download as PDF</h3>
                <p>Download your resume as a PDF file instantly. Ready to send to employers!</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section" style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); color: white; text-align: center;">
    <div class="container">
        <h2 style="color: white; margin-bottom: 16px;">Don't Wait. Build Your Resume Today.</h2>
        <p style="color: rgba(255,255,255,0.9); font-size: 18px; margin-bottom: 32px;">Join thousands of professionals who have created stunning resumes with ResumeBuilder Pro.</p>
        <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-outline" style="border-color: white; color: white; padding: 16px 40px; font-size: 18px;">Get Started Free</a>
    </div>
</section>
