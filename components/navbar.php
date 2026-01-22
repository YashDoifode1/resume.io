<?php
/**
 * Navbar Component
 * 
 * Renders the main navigation bar
 */

require_once __DIR__ . '/../config/constants.php';
?>
<nav class="navbar">
    <div class="container navbar-container">
        <!-- Logo -->
        <a href="<?php echo BASE_URL; ?>" class="logo">
            <i class="fas fa-file-alt"></i> ResumeCraft
        </a>
        
        <!-- Desktop Navigation -->
        <ul class="nav-links">
            <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
            <li><a href="#templates">Templates</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="<?php echo BASE_URL; ?>?page=examples">Examples</a></li>
            <li><a href="<?php echo BASE_URL; ?>?page=faq">FAQ</a></li>
            <li><a href="<?php echo BASE_URL; ?>?page=contact">Contact</a></li>
        </ul>
        
        <!-- CTA Buttons -->
        <div class="nav-cta">
            <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary">
                <i class="fas fa-bolt"></i> Build Resume
            </a>
        </div>
        
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <div class="mobile-menu-header">
                <a href="<?php echo BASE_URL; ?>" class="logo">
                    <i class="fas fa-file-alt"></i> ResumeCraft
                </a>
                <button class="mobile-menu-close" id="mobileMenuClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <ul class="mobile-nav-links">
                <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li><a href="#templates" onclick="closeMobileMenu()">Templates</a></li>
                <li><a href="#features" onclick="closeMobileMenu()">Features</a></li>
                <li><a href="<?php echo BASE_URL; ?>?page=examples">Examples</a></li>
                <li><a href="<?php echo BASE_URL; ?>?page=faq">FAQ</a></li>
                <li><a href="<?php echo BASE_URL; ?>?page=contact">Contact</a></li>
                <li><a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-block">
                    <i class="fas fa-bolt"></i> Build Resume
                </a></li>
            </ul>
        </div>
    </div>
</nav>

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

/* Navigation */
.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    background-color: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    padding: 15px 0;
}

.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary);
    display: flex;
    align-items: center;
    text-decoration: none;
}

.logo i {
    margin-right: 8px;
    color: var(--accent);
}

.nav-links {
    display: flex;
    list-style: none;
    gap: 30px;
}

.nav-links li {
    display: inline-block;
}

.nav-links a {
    font-weight: 500;
    color: var(--dark);
    text-decoration: none;
    transition: var(--transition);
    padding: 8px 0;
    position: relative;
}

.nav-links a:hover {
    color: var(--primary);
}

.nav-links a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--primary);
    transition: var(--transition);
}

.nav-links a:hover::after {
    width: 100%;
}

.nav-cta {
    display: flex;
    align-items: center;
}

.nav-cta .btn {
    display: flex;
    align-items: center;
    gap: 8px;
}

.mobile-menu-btn {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--dark);
    cursor: pointer;
    padding: 5px;
}

/* Mobile Menu */
.mobile-menu {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: white;
    z-index: 1001;
    padding: 20px;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
}

.mobile-menu.active {
    transform: translateX(0);
}

.mobile-menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--light-gray);
}

.mobile-menu-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--dark);
    cursor: pointer;
    padding: 5px;
}

.mobile-nav-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.mobile-nav-links li {
    margin-bottom: 15px;
}

.mobile-nav-links a {
    display: block;
    padding: 12px 0;
    color: var(--dark);
    text-decoration: none;
    font-weight: 500;
    font-size: 1.1rem;
    border-bottom: 1px solid var(--light-gray);
    transition: var(--transition);
}

.mobile-nav-links a:hover {
    color: var(--primary);
    padding-left: 10px;
}

.mobile-nav-links .btn {
    margin-top: 20px;
    text-align: center;
}

.btn-block {
    width: 100%;
    display: block;
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

/* Container */
.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Responsive */
@media (max-width: 992px) {
    .nav-links {
        display: none;
    }
    
    .mobile-menu-btn {
        display: block;
    }
    
    .nav-cta .btn {
        display: none;
    }
}

@media (max-width: 768px) {
    .logo {
        font-size: 1.5rem;
    }
    
    .mobile-menu {
        display: block;
    }
}
</style>

<script>
// Mobile menu functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenuClose = document.getElementById('mobileMenuClose');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }
    
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', function() {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
    
    // Close menu when clicking outside
    mobileMenu.addEventListener('click', function(e) {
        if (e.target === mobileMenu) {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});

function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenu.classList.remove('active');
    document.body.style.overflow = '';
}

// Close mobile menu when clicking internal links
document.querySelectorAll('.mobile-nav-links a').forEach(link => {
    link.addEventListener('click', closeMobileMenu);
});
</script>