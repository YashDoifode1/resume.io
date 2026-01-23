<?php
/**
 * Navbar Component
 */

require_once __DIR__ . '/../config/constants.php';
?>

<nav class="navbar">
    <div class="container navbar-container">

        <!-- Logo -->
        <a href="<?php echo BASE_URL; ?>" class="logo">
            ResumeCraft
        </a>

        <!-- Desktop Navigation -->
        <ul class="nav-links">
            <li><a href="<?php echo BASE_URL; ?>" class="active">Home</a></li>
            <!-- <li><a href="#templates">Templates</a></li> -->
            <li><a href="<?php echo BASE_URL; ?>?page=faq">FAQ</a></li>
            <li><a href="<?php echo BASE_URL; ?>?page=contact">Contact</a></li>
        </ul>

        <!-- CTA -->
        <div class="nav-cta">
            <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary">
                Build Resume
            </a>
        </div>

        <!-- Mobile Toggle -->
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <div class="mobile-menu-header">
                <span class="logo">ResumeCraft</span>
                <button class="mobile-menu-close" id="mobileMenuClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <ul class="mobile-nav-links">
                <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <!-- <li><a href="#templates">Templates</a></li> -->
                <li><a href="<?php echo BASE_URL; ?>?page=faq">FAQ</a></li>
                <li><a href="<?php echo BASE_URL; ?>?page=contact">Contact</a></li>
                <li>
                    <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-block">
                        Build Resume
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<style>/* ===============================
   NAVBAR – SHARP PROFESSIONAL
================================ */
.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
}

.navbar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 70px;
}

/* Logo */
.logo {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--primary);
    text-decoration: none;
    letter-spacing: -0.5px;
}

/* Desktop Links */
.nav-links {
    display: flex;
    list-style: none;
    gap: 32px;
}

.nav-links a {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--dark);
    text-decoration: none;
    padding: 26px 0;
    position: relative;
}

/* Sharp underline hover */
.nav-links a::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 18px;
    width: 0;
    height: 2px;
    background: var(--primary);
    transition: width 0.2s ease;
}

.nav-links a:hover::after,
.nav-links a.active::after {
    width: 100%;
}

/* CTA */
.nav-cta .btn {
    padding: 10px 22px;
    border-radius: 0; /* sharp edges */
    font-size: 0.95rem;
}

/* Buttons */
.btn {
    font-weight: 600;
    text-decoration: none;
    border: 2px solid transparent;
    transition: 0.2s ease;
}

.btn-primary {
    background: var(--primary);
    color: #fff;
}

.btn-primary:hover {
    background: var(--primary-dark);
}

/* Mobile Button */
.mobile-menu-btn {
    display: none;
    background: none;
    border: none;
    font-size: 1.4rem;
    cursor: pointer;
    color: var(--dark);
}

/* ===============================
   MOBILE MENU – CLEAN PANEL
================================ */
.mobile-menu {
    position: fixed;
    inset: 0;
    background: #ffffff;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    z-index: 1100;
    padding: 24px;
}

.mobile-menu.active {
    transform: translateX(0);
}

.mobile-menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 16px;
    margin-bottom: 24px;
}

.mobile-menu-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
}

/* Mobile Links */
.mobile-nav-links {
    list-style: none;
}

.mobile-nav-links li {
    margin-bottom: 12px;
}

.mobile-nav-links a {
    display: block;
    padding: 14px;
    font-weight: 600;
    color: var(--dark);
    text-decoration: none;
    border: 1px solid #e5e7eb;
}

.mobile-nav-links a:hover {
    background: var(--light);
}

/* Block button */
.btn-block {
    width: 100%;
    text-align: center;
    border-radius: 0;
}

/* Responsive */
@media (max-width: 992px) {
    .nav-links,
    .nav-cta {
        display: none;
    }

    .mobile-menu-btn {
        display: block;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('mobileMenuBtn');
    const close = document.getElementById('mobileMenuClose');
    const menu = document.getElementById('mobileMenu');

    btn.onclick = () => {
        menu.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    close.onclick = () => {
        menu.classList.remove('active');
        document.body.style.overflow = '';
    };

    document.querySelectorAll('.mobile-nav-links a').forEach(link => {
        link.onclick = () => {
            menu.classList.remove('active');
            document.body.style.overflow = '';
        };
    });
});
</script>
