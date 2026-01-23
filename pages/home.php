<?php
/**
 * Home Page - Landing Page
 */

$page_title = 'Home';
$page_description = 'Create professional resumes in minutes with our AI-powered resume builder. Choose from beautiful templates and download as PDF.';
$page_keywords = 'resume builder, resume maker, CV builder, professional resume, free resume';
$canonical_url = BASE_URL;
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container hero-container">
        <div class="hero-content">
            <h1>Create a Professional Resume in Minutes</h1>
            <p>ResumeCraft is a free, easy-to-use resume builder that helps you create a professional resume that stands out to employers and passes through Applicant Tracking Systems (ATS).</p>
            <div class="hero-cta">
                <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-large">
                    <i class="fas fa-bolt"></i> Start Building Free
                </a>
                <a href="#templates" class="btn btn-secondary btn-large">
                    <i class="fas fa-eye"></i> View Templates
                </a>
            </div>
            <div class="hero-features">
                <p><i class="fas fa-check-circle" style="color: var(--success);"></i> No sign-up required</p>
                <p><i class="fas fa-check-circle" style="color: var(--success);"></i> 100% free, no hidden fees</p>
                <p><i class="fas fa-check-circle" style="color: var(--success);"></i> ATS-optimized templates</p>
            </div>
        </div>
        <div class="hero-image">
            <!-- Resume preview image -->
            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: var(--shadow-lg);">
                <div style="width: 300px; max-width: 100%;">
                    <div style="background: var(--primary); height: 40px; border-radius: 4px 4px 0 0;"></div>
                    <div style="padding: 20px;">
                        <div style="display: flex; align-items: center; margin-bottom: 20px;">
                            <div style="width: 60px; height: 60px; background: var(--light-gray); border-radius: 50%; margin-right: 15px;"></div>
                            <div>
                                <div style="height: 12px; width: 150px; background: var(--dark); margin-bottom: 8px;"></div>
                                <div style="height: 10px; width: 120px; background: var(--medium-gray);"></div>
                            </div>
                        </div>
                        <div style="height: 8px; width: 100%; background: var(--light-gray); margin-bottom: 8px;"></div>
                        <div style="height: 8px; width: 90%; background: var(--light-gray); margin-bottom: 8px;"></div>
                        <div style="height: 8px; width: 95%; background: var(--light-gray); margin-bottom: 8px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Templates Section -->
<section id="templates" class="section">
    <div class="container">
        <div class="section-title">
            <h2>Professional Resume Templates</h2>
            <p>Choose from our collection of ATS-friendly templates designed to help you land your next job interview.</p>
        </div>
        <div class="templates-grid">
            <!-- Template 1 -->
            <div class="template-card">
                <div class="template-preview" style="background: linear-gradient(135deg, #4361ee, #4cc9f0);">
                    <div style="width: 100%; height: 100%; background: white; opacity: 0.2; border-radius: 4px;"></div>
                </div>
                <div class="template-info">
                    <h3>Modern Pro</h3>
                    <p>Clean, contemporary design perfect for tech and creative roles.</p>
                    <div class="template-tags">
                        <span class="tag">ATS Friendly</span>
                        <span class="tag">Modern</span>
                        <span class="tag">Popular</span>
                    </div>
                   
                </div>
            </div>
            
            <!-- Template 2 -->
            <div class="template-card">
                <div class="template-preview" style="background: linear-gradient(135deg, #495057, #6c757d);">
                    <div style="width: 100%; height: 100%; background: white; opacity: 0.2; border-radius: 4px;"></div>
                </div>
                <div class="template-info">
                    <h3>Classic</h3>
                    <p>Traditional layout preferred by conservative industries.</p>
                    <div class="template-tags">
                        <span class="tag">ATS Friendly</span>
                        <span class="tag">Traditional</span>
                        <span class="tag">Finance</span>
                    </div>
                   
                </div>
            </div>
            
            <!-- Template 3 -->
            <div class="template-card">
                <div class="template-preview" style="background: linear-gradient(135deg, #7209b7, #4361ee);">
                    <div style="width: 100%; height: 100%; background: white; opacity: 0.2; border-radius: 4px;"></div>
                </div>
                <div class="template-info">
                    <h3>Creative</h3>
                    <p>Bold design for designers, marketers, and creative professionals.</p>
                    <div class="template-tags">
                        <span class="tag">Creative</span>
                        <span class="tag">Colorful</span>
                        <span class="tag">Design</span>
                    </div>
                   
                </div>
            </div>
            
            <!-- Template 4 -->
            <div class="template-card">
                <div class="template-preview" style="background: linear-gradient(135deg, #4bb543, #28a745);">
                    <div style="width: 100%; height: 100%; background: white; opacity: 0.2; border-radius: 4px;"></div>
                </div>
                <div class="template-info">
                    <h3>Minimal</h3>
                    <p>Clean, minimal design with focus on content and readability.</p>
                    <div class="template-tags">
                        <span class="tag">Minimal</span>
                        <span class="tag">Clean</span>
                        <span class="tag">Simple</span>
                    </div>
                   
                </div>
            </div>
            
            <!-- Template 5 -->
            <div class="template-card">
                <div class="template-preview" style="background: linear-gradient(135deg, #212529, #343a40);">
                    <div style="width: 100%; height: 100%; background: white; opacity: 0.2; border-radius: 4px;"></div>
                </div>
                <div class="template-info">
                    <h3>Dark Mode</h3>
                    <p>Modern dark theme with high contrast for tech professionals.</p>
                    <div class="template-tags">
                        <span class="tag">Dark</span>
                        <span class="tag">Modern</span>
                        <span class="tag">Tech</span>
                    </div>
                   
                </div>
            </div>
            
            <!-- CTA Card -->
            <div class="template-card" style="background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; display: flex; flex-direction: column; justify-content: center;">
                <div class="template-info">
                    <h3 style="color: white;">Ready to Create Yours?</h3>
                    <p style="color: rgba(255,255,255,0.9);">Start building your professional resume now and take the next step in your career.</p>
                    <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-secondary" style="margin-top: 15px; background: white; color: var(--primary);">Start Building</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section" style="background-color: #f8f9ff;">
    <div class="container">
        <div class="section-title">
            <h2>Why Choose ResumeCraft?</h2>
            <p>Our platform is designed with simplicity and effectiveness in mind.</p>
        </div>
        <div class="features-grid">
            <!-- Feature 1 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Instant Creation</h3>
                <p>Build a professional resume in minutes with our intuitive step-by-step builder.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <h3>PDF & DOC Export</h3>
                <p>Download your resume in PDF or Word format with one click. No watermarks.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <h3>ATS Optimized</h3>
                <p>Our templates are designed to pass through Applicant Tracking Systems.</p>
            </div>
            
            <!-- Feature 4 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h3>Customizable</h3>
                <p>Change colors, fonts, and layouts to match your personal style.</p>
            </div>
            
            <!-- Feature 5 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-cloud"></i>
                </div>
                <h3>Auto-Save</h3>
                <p>Your progress is automatically saved so you can return anytime.</p>
            </div>
            
            <!-- Feature 6 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Mobile Friendly</h3>
                <p>Build and edit your resume on any device, anywhere.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>How It Works</h2>
            <p>Three simple steps to create your professional resume</p>
        </div>
        
        <div class="how-it-works">
            <div class="step-container">
                <div class="step-circle">1</div>
                <div class="step-content">
                    <h3>Fill Your Information</h3>
                    <p>Enter your personal details, work experience, education, skills, and more using our intuitive form.</p>
                </div>
            </div>
            
            <div class="step-line"></div>
            
            <div class="step-container">
                <div class="step-circle">2</div>
                <div class="step-content">
                    <h3>Choose a Template</h3>
                    <p>Select from professionally designed templates and see your resume update in real-time.</p>
                </div>
            </div>
            
            <div class="step-line"></div>
            
            <div class="step-container">
                <div class="step-circle">3</div>
                <div class="step-content">
                    <h3>Download Instantly</h3>
                    <p>Download your resume as a PDF file instantly. Ready to send to employers!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; text-align: center;">
    <div class="container">
        <h2 style="color: white; margin-bottom: 16px;">Don't Wait. Build Your Resume Today.</h2>
        <p style="color: rgba(255,255,255,0.9); font-size: 18px; margin-bottom: 32px;">Join thousands of professionals who have created stunning resumes with ResumeCraft.</p>
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
    position: relative;
    overflow: hidden;
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
    font-size: 2.8rem;
    margin-bottom: 1.5rem;
    color: var(--dark);
    font-weight: 700;
}

.hero-content p {
    font-size: 1.1rem;
    color: var(--dark-gray);
    margin-bottom: 2rem;
    max-width: 600px;
}

.hero-cta {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}

.hero-features {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.hero-features p {
    margin: 0;
    font-size: 1rem;
    color: var(--dark-gray);
}

.hero-features i {
    margin-right: 8px;
}

.hero-image {
    flex: 1;
    display: flex;
    justify-content: flex-end;
    position: relative;
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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

/* Templates Grid */
.templates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.template-card {
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.template-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.template-preview {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.template-info {
    padding: 20px;
}

.template-info h3 {
    margin-bottom: 10px;
    color: var(--dark);
}

.template-info p {
    color: var(--dark-gray);
    margin-bottom: 15px;
}

.template-tags {
    display: flex;
    gap: 8px;
    margin-top: 10px;
    flex-wrap: wrap;
}

.tag {
    background-color: var(--light-gray);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--dark-gray);
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
}

.step-content {
    max-width: 300px;
}

.step-content h3 {
    color: var(--dark);
    margin-bottom: 10px;
}

.step-content p {
    color: var(--dark-gray);
}

.step-line {
    position: absolute;
    top: 30px;
    left: 20%;
    right: 20%;
    height: 2px;
    background: var(--light-gray);
    z-index: -1;
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

.btn-sm {
    padding: 8px 16px;
    font-size: 0.9rem;
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
}

.section-title p {
    color: var(--dark-gray);
    max-width: 700px;
    margin: 0 auto;
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
    
    .how-it-works {
        flex-direction: column;
        gap: 40px;
    }
    
    .step-line {
        display: none;
    }
    
    .templates-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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
    
    .hero-cta {
        flex-direction: column;
        align-items: center;
    }
    
    .features-grid {
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
    
    .section-title h2 {
        font-size: 1.6rem;
    }
    
    .templates-grid {
        grid-template-columns: 1fr;
    }
}
</style>