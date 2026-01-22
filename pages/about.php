<?php
/**
 * About Page - Updated to match our theme
 */

$page_title = 'About ResumeCraft';
$page_description = 'Learn about ResumeCraft and how we help professionals create stunning resumes.';
$canonical_url = BASE_URL . '?page=about';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container hero-container">
        <div class="hero-content">
            <h1>About ResumeCraft</h1>
            <p class="subtitle">Empowering professionals to showcase their best selves with professional resumes</p>
            <div class="hero-cta">
                <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-large">
                    <i class="fas fa-bolt"></i> Start Building Free
                </a>
            </div>
        </div>
        <div class="hero-image">
            <div style="background: linear-gradient(135deg, var(--primary), var(--secondary)); height: 200px; width: 100%; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 64px; box-shadow: var(--shadow-lg);">
                📄
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Our Mission</h2>
            <p>We're on a mission to democratize professional resume building</p>
        </div>
        
        <div class="about-content">
            <div class="about-text">
                <p>At ResumeCraft, we believe that everyone deserves access to professional resume-building tools. Our mission is to empower job seekers and professionals to create stunning, ATS-friendly resumes that showcase their skills and experience effectively.</p>
                <p>We've designed our platform to be simple, intuitive, and completely free. No subscriptions, no hidden fees, no complicated features. Just a straightforward tool that helps you build a resume that works.</p>
                <p>With ResumeCraft, you can create a professional resume in minutes, choose from multiple templates, and download it instantly as PDF.</p>
            </div>
            <div class="about-stats">
                <div class="stat-card">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Free to Use</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">5+</div>
                    <div class="stat-label">Professional Templates</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Resumes Created</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">0</div>
                    <div class="stat-label">Sign-ups Required</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="section" style="background-color: #f8f9ff;">
    <div class="container">
        <div class="section-title">
            <h2>Why Choose ResumeCraft?</h2>
            <p>We've built the best resume builder for modern professionals</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h3>Professional Templates</h3>
                <p>Our templates are designed by professional designers and are optimized for both human recruiters and ATS systems.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Lightning Fast</h3>
                <p>No waiting, no loading. Our platform is optimized for speed. Build and download your resume in seconds.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Privacy First</h3>
                <p>Your data stays on your device. We don't store your information on our servers. Everything is session-based.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Fully Responsive</h3>
                <p>Build your resume on any device. Our platform works seamlessly on desktop, tablet, and mobile.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <h3>Fully Customizable</h3>
                <p>Customize colors, fonts, and layouts to match your personal brand. Make your resume truly yours.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <h3>ATS Optimized</h3>
                <p>All our templates are tested and optimized for Applicant Tracking Systems to ensure your resume gets through.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>How ResumeCraft Works</h2>
            <p>Three simple steps to create your professional resume</p>
        </div>
        
        <div class="how-it-works">
            <div class="step-container">
                <div class="step-circle">1</div>
                <div class="step-content">
                    <h3>Fill Your Information</h3>
                    <p>Start by entering your personal information, work experience, education, skills, and more. Our form is designed to be simple and intuitive.</p>
                </div>
            </div>
            
            <div class="step-container">
                <div class="step-circle">2</div>
                <div class="step-content">
                    <h3>Choose Your Template</h3>
                    <p>Select from 5 professionally designed templates. Each template is fully responsive and optimized for both web and PDF viewing.</p>
                </div>
            </div>
            
            <div class="step-container">
                <div class="step-circle">3</div>
                <div class="step-content">
                    <h3>Download Instantly</h3>
                    <p>Once you're happy with your resume, download it as a PDF file. Your resume is ready to send to employers and recruiters.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section" style="background-color: #f8f9ff;">
    <div class="container">
        <div class="section-title">
            <h2>Key Features</h2>
            <p>Everything you need to create a perfect resume</p>
        </div>
        
        <div class="features-list">
            <div class="feature-column">
                <h3><i class="fas fa-file-alt"></i> Comprehensive Form</h3>
                <ul>
                    <li><i class="fas fa-user"></i> Personal Information</li>
                    <li><i class="fas fa-briefcase"></i> Work Experience</li>
                    <li><i class="fas fa-graduation-cap"></i> Education</li>
                    <li><i class="fas fa-code"></i> Skills</li>
                    <li><i class="fas fa-project-diagram"></i> Projects</li>
                </ul>
            </div>
            
            <div class="feature-column">
                <h3><i class="fas fa-download"></i> Export Options</h3>
                <ul>
                    <li><i class="fas fa-file-pdf"></i> PDF Download</li>
                    <li><i class="fas fa-print"></i> Print Ready</li>
                    <li><i class="fas fa-eye"></i> Live Preview</li>
                    <li><i class="fas fa-sync"></i> Auto-Save</li>
                    <li><i class="fas fa-cloud"></i> No Login Required</li>
                </ul>
            </div>
            
            <div class="feature-column">
                <h3><i class="fas fa-laptop-code"></i> Technology</h3>
                <ul>
                    <li><i class="fab fa-php"></i> PHP 8+</li>
                    <li><i class="fab fa-html5"></i> HTML5</li>
                    <li><i class="fab fa-css3-alt"></i> CSS3</li>
                    <li><i class="fab fa-js"></i> JavaScript</li>
                    <li><i class="fas fa-mobile"></i> Responsive Design</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Technology Stack -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Built With Modern Technology</h2>
            <p>ResumeCraft is built with the latest web technologies</p>
        </div>
        
        <div class="tech-stack">
            <div class="tech-card">
                <div class="tech-icon">
                    <i class="fab fa-php"></i>
                </div>
                <h4>PHP 8+</h4>
                <p>Modern server-side processing</p>
            </div>
            
            <div class="tech-card">
                <div class="tech-icon">
                    <i class="fab fa-html5"></i>
                </div>
                <h4>HTML5</h4>
                <p>Semantic markup</p>
            </div>
            
            <div class="tech-card">
                <div class="tech-icon">
                    <i class="fab fa-css3-alt"></i>
                </div>
                <h4>CSS3</h4>
                <p>Modern styling</p>
            </div>
            
            <div class="tech-card">
                <div class="tech-icon">
                    <i class="fab fa-js"></i>
                </div>
                <h4>JavaScript</h4>
                <p>Interactive features</p>
            </div>
        </div>
    </div>
</section>

<!-- About Creator Section -->
<section class="section" style="background-color: #f8f9ff;">
    <div class="container">
        <div class="section-title">
            <h2>Meet the Creator</h2>
            <p>Learn about the person behind ResumeCraft</p>
        </div>
        
        <div class="creator-profile">
            <div class="creator-image">
                <div style="background: linear-gradient(135deg, var(--primary), var(--secondary)); width: 200px; height: 200px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 80px; box-shadow: var(--shadow-lg);">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
            
            <div class="creator-info">
                <h3><?php echo OWNER_NAME; ?></h3>
                <p class="creator-title"><?php echo OWNER_TITLE; ?></p>
                
                <div class="creator-details">
                    <p><i class="fas fa-graduation-cap"></i> <strong>Education:</strong> <?php echo OWNER_COLLEGE; ?></p>
                    <p><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> <?php echo OWNER_LOCATION; ?></p>
                </div>
                
                <p class="creator-bio"><?php echo OWNER_BIO; ?></p>
                
                <p style="color: var(--medium-gray); font-size: 14px; line-height: 1.6; margin-top: 16px;">
                    <?php echo OWNER_NAME; ?> is a passionate developer and entrepreneur dedicated to creating tools that empower professionals. With a background in computer science and a commitment to user-centric design, she developed ResumeCraft to make professional resume building accessible to everyone.
                </p>
                
                <div class="creator-social">
                    <p style="font-weight: 600; margin-bottom: 12px; color: var(--dark);">Connect with <?php echo explode(' ', OWNER_NAME)[0]; ?>:</p>
                    <div class="social-links">
                        <a href="<?php echo SOCIAL_LINKEDIN; ?>" target="_blank" class="social-link">
                            <i class="fab fa-linkedin"></i> LinkedIn
                        </a>
                        <a href="<?php echo SOCIAL_GITHUB; ?>" target="_blank" class="social-link">
                            <i class="fab fa-github"></i> GitHub
                        </a>
                        <a href="<?php echo SOCIAL_TWITTER; ?>" target="_blank" class="social-link">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; text-align: center;">
    <div class="container">
        <h2 style="color: white; margin-bottom: 16px;">Ready to Build Your Resume?</h2>
        <p style="color: rgba(255,255,255,0.9); font-size: 18px; margin-bottom: 32px;">Start creating your professional resume today with ResumeCraft.</p>
        <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-secondary btn-large" style="background: white; color: var(--primary); padding: 16px 40px; font-size: 18px;">
            <i class="fas fa-rocket"></i> Get Started Free
        </a>
    </div>
</section>

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

.hero-content .subtitle {
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

/* About Content */
.about-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    align-items: start;
}

.about-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--dark-gray);
}

.about-text p {
    margin-bottom: 1.5rem;
}

.about-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.stat-card {
    background: white;
    padding: 24px;
    border-radius: var(--border-radius);
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 8px;
    font-family: 'Poppins', sans-serif;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--dark-gray);
    font-weight: 500;
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.feature-card {
    background: white;
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.feature-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.feature-icon i {
    font-size: 1.8rem;
    color: white;
}

.feature-card h3 {
    color: var(--dark);
    margin-bottom: 12px;
    font-size: 1.3rem;
    font-weight: 600;
}

.feature-card p {
    color: var(--dark-gray);
    line-height: 1.6;
}

/* How It Works */
.how-it-works {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-top: 40px;
    position: relative;
}

.step-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    flex: 1;
    position: relative;
}

.step-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 20px;
    font-family: 'Poppins', sans-serif;
}

.step-content {
    max-width: 300px;
}

.step-content h3 {
    color: var(--dark);
    margin-bottom: 10px;
    font-size: 1.2rem;
    font-weight: 600;
}

.step-content p {
    color: var(--dark-gray);
    line-height: 1.6;
}

/* Features List */
.features-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 40px;
    margin-top: 40px;
}

.feature-column h3 {
    color: var(--dark);
    margin-bottom: 20px;
    font-size: 1.3rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.feature-column ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.feature-column li {
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--dark-gray);
}

.feature-column li i {
    color: var(--primary);
    width: 20px;
}

/* Technology Stack */
.tech-stack {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.tech-card {
    background: white;
    padding: 30px;
    border-radius: var(--border-radius);
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.tech-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.tech-icon {
    font-size: 3rem;
    color: var(--primary);
    margin-bottom: 20px;
}

.tech-card h4 {
    color: var(--dark);
    margin-bottom: 8px;
    font-size: 1.2rem;
    font-weight: 600;
}

.tech-card p {
    color: var(--dark-gray);
    font-size: 0.95rem;
}

/* Creator Profile */
.creator-profile {
    display: flex;
    gap: 40px;
    align-items: center;
    margin-top: 40px;
}

.creator-image {
    flex-shrink: 0;
}

.creator-info {
    flex: 1;
}

.creator-info h3 {
    font-size: 2rem;
    color: var(--dark);
    margin-bottom: 8px;
    font-family: 'Poppins', sans-serif;
}

.creator-title {
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 20px;
    font-size: 1.1rem;
}

.creator-details {
    background: white;
    padding: 20px;
    border-radius: var(--border-radius);
    margin-bottom: 20px;
    box-shadow: var(--shadow);
}

.creator-details p {
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.creator-details p:last-child {
    margin-bottom: 0;
}

.creator-details i {
    color: var(--primary);
    width: 20px;
}

.creator-bio {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--dark-gray);
    margin-bottom: 20px;
}

.creator-social {
    margin-top: 30px;
}

.social-links {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.social-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: white;
    border: 2px solid var(--light-gray);
    border-radius: var(--border-radius);
    color: var(--dark);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.social-link:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 12px 28px;
    border-radius: var(--border-radius);
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: var(--transition);
    border: none;
    text-decoration: none;
    font-family: 'Inter', sans-serif;
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

/* Container */
.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
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
    
    .about-content {
        grid-template-columns: 1fr;
    }
    
    .how-it-works {
        flex-direction: column;
        gap: 40px;
    }
    
    .creator-profile {
        flex-direction: column;
        text-align: center;
    }
    
    .creator-details p {
        justify-content: center;
    }
    
    .social-links {
        justify-content: center;
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
    
    .about-stats {
        grid-template-columns: 1fr;
    }
    
    .features-grid,
    .features-list {
        grid-template-columns: 1fr;
    }
    
    .tech-stack {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .hero-content h1 {
        font-size: 1.8rem;
    }
    
    .section-title h2 {
        font-size: 1.6rem;
    }
    
    .tech-stack {
        grid-template-columns: 1fr;
    }
    
    .social-links {
        flex-direction: column;
    }
}
</style>