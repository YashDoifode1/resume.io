<?php
/**
 * Navbar Component
 * 
 * Renders the main navigation bar
 */

require_once __DIR__ . '/../config/constants.php';
?>
<nav class="navbar navbar-professional">
    <div class="navbar-container">
        <!-- Left: Logo -->
        <div class="navbar-left">
            <a href="<?php echo BASE_URL; ?>" class="logo-link">
                <span class="logo-icon">📄</span>
                <span class="logo-text"><?php echo SITE_NAME; ?></span>
            </a>
        </div>
        
        <!-- Center: Menu -->
        <div class="navbar-center" id="navbarMenu">
            <a href="<?php echo BASE_URL; ?>" class="nav-link">Home</a>
            <a href="<?php echo BASE_URL; ?>?page=about" class="nav-link">About</a>
            <a href="<?php echo BASE_URL; ?>?page=builder" class="nav-link">Builder</a>
            <a href="<?php echo BASE_URL; ?>?page=faq" class="nav-link">FAQ</a>
            <a href="<?php echo BASE_URL; ?>?page=contact" class="nav-link">Contact</a>
        </div>
        
        <!-- Right: CTA Button -->
        <div class="navbar-right">
            <a href="<?php echo BASE_URL; ?>?page=builder" class="btn btn-primary btn-get-started">Get Started</a>
            <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</nav>

<style>
    .navbar-professional {
        background: linear-gradient(to right, #ffffff 0%, #f8f9fa 100%);
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .navbar-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 70px;
        gap: 30px;
    }

    /* Left: Logo */
    .navbar-left {
        flex-shrink: 0;
    }

    .logo-link {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 20px;
        color: var(--color-primary);
        transition: all 0.3s ease;
    }

    .logo-link:hover {
        color: var(--color-secondary);
        transform: scale(1.05);
    }

    .logo-icon {
        font-size: 28px;
    }

    .logo-text {
        letter-spacing: 0.5px;
    }

    /* Center: Menu */
    .navbar-center {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .nav-link {
        padding: 8px 16px;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        border-radius: 6px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .nav-link:hover {
        background: rgba(52, 152, 219, 0.1);
        color: var(--color-primary);
    }

    /* Right: CTA */
    .navbar-right {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .btn-get-started {
        padding: 10px 24px;
        background: var(--color-primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-get-started:hover {
        background: var(--color-secondary);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(52, 152, 219, 0.3);
    }

    /* Hamburger Menu */
    .hamburger {
        display: none;
        flex-direction: column;
        background: none;
        border: none;
        cursor: pointer;
        gap: 5px;
        padding: 5px;
    }

    .hamburger span {
        width: 25px;
        height: 3px;
        background: #333;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .navbar-container {
            height: 60px;
            gap: 15px;
            padding: 0 15px;
        }

        .navbar-center {
            display: none;
            position: absolute;
            top: 60px;
            left: 0;
            right: 0;
            flex-direction: column;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 15px 0;
            gap: 0;
        }

        .navbar-center.active {
            display: flex;
        }

        .nav-link {
            padding: 12px 20px;
            border-radius: 0;
            width: 100%;
        }

        .hamburger {
            display: flex;
        }

        .logo-text {
            display: none;
        }

        .logo-icon {
            font-size: 24px;
        }

        .btn-get-started {
            padding: 8px 16px;
            font-size: 12px;
        }
    }

    @media (max-width: 480px) {
        .navbar-container {
            height: 55px;
        }

        .navbar-center {
            top: 55px;
        }

        .btn-get-started {
            display: none;
        }
    }
</style>

<script>
    // Hamburger menu toggle
    document.getElementById('hamburgerBtn')?.addEventListener('click', function() {
        const menu = document.getElementById('navbarMenu');
        menu.classList.toggle('active');
    });

    // Close menu when link is clicked
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            document.getElementById('navbarMenu').classList.remove('active');
        });
    });
</script>
