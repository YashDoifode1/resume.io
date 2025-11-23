<?php
/**
 * Resume Builder Form Page
 */

// Session already started in index.php, no need to start again

// Initialize session data
if (!isset($_SESSION['resume_data'])) {
    $_SESSION['resume_data'] = [
        'personal' => [
            'fullName' => '',
            'jobTitle' => '',
            'profileSummary' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
            'website' => '',
            'linkedin' => '',
            'github' => '',
            'profilePicture' => ''
        ],
        'workExperience' => [],
        'education' => [],
        'skills' => [],
        'projects' => [],
        'certifications' => [],
        'languages' => [],
        'interests' => ''
    ];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_personal') {
        $_SESSION['resume_data']['personal'] = [
            'fullName' => $_POST['fullName'] ?? '',
            'jobTitle' => $_POST['jobTitle'] ?? '',
            'profileSummary' => $_POST['profileSummary'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'address' => $_POST['address'] ?? '',
            'website' => $_POST['website'] ?? '',
            'linkedin' => $_POST['linkedin'] ?? '',
            'github' => $_POST['github'] ?? '',
            'profilePicture' => $_SESSION['resume_data']['personal']['profilePicture'] ?? ''
        ];

        // Handle profile picture upload
        if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = UPLOADS_PATH;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = 'profile_' . time() . '_' . basename($_FILES['profilePicture']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $filePath)) {
                $_SESSION['resume_data']['personal']['profilePicture'] = UPLOAD_DIRECTORY . $fileName;
            }
        }
        
        // Set default profile picture if none uploaded
        if (empty($_SESSION['resume_data']['personal']['profilePicture'])) {
            $_SESSION['resume_data']['personal']['profilePicture'] = ASSETS_URL . 'images/default-profile.png';
        }
    }
}

$page_title = 'Resume Builder';
$page_description = 'Create your professional resume with our easy-to-use resume builder.';
$page_css = 'builder.css';
$page_js = 'builder.js';
$data = $_SESSION['resume_data'];
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Create Your Professional Resume</h1>
        <p>Fill in your information below and we'll help you create a stunning resume</p>
    </div>
</section>

<!-- Builder Section -->
<section class="section">
    <div class="container">
        <div class="grid grid-cols-4">
            <!-- Sidebar Navigation -->
            <aside class="builder-sidebar">
                <div class="sidebar-sticky">
                    <h3>Resume Sections</h3>
                    <ul class="section-nav">
                        <li><a href="#personal" class="section-link active">👤 Personal Info</a></li>
                        <li><a href="#work" class="section-link">💼 Work Experience</a></li>
                        <li><a href="#education" class="section-link">🎓 Education</a></li>
                        <li><a href="#skills" class="section-link">⚡ Skills</a></li>
                        <li><a href="#projects" class="section-link">🚀 Projects</a></li>
                        <li><a href="#certifications" class="section-link">🏆 Certifications</a></li>
                        <li><a href="#languages" class="section-link">🌍 Languages</a></li>
                        <li><a href="#interests" class="section-link">❤️ Interests</a></li>
                    </ul>

                    <div style="margin-top: 32px;">
                        <a href="<?php echo BASE_URL; ?>?page=preview" class="btn btn-primary btn-block">Preview Resume</a>
                    </div>
                </div>
            </aside>

            <!-- Main Form -->
            <div class="builder-main" style="grid-column: span 3;">
                <form id="resume-builder-form" method="POST" enctype="multipart/form-data">
                    <!-- Personal Information Section -->
                    <div id="personal" class="form-section">
                        <h2>Personal Information</h2>
                        <input type="hidden" name="action" value="save_personal">

                        <div class="form-row">
                            <div class="form-group">
                                <label for="fullName">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($data['personal']['fullName']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="jobTitle">Job Title *</label>
                                <input type="text" id="jobTitle" name="jobTitle" value="<?php echo htmlspecialchars($data['personal']['jobTitle']); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="profileSummary">Professional Summary</label>
                            <textarea id="profileSummary" name="profileSummary" rows="4"><?php echo htmlspecialchars($data['personal']['profileSummary']); ?></textarea>
                            <div class="form-help">Write a brief summary of your professional background and goals</div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['personal']['email']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone *</label>
                                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($data['personal']['phone']); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($data['personal']['address']); ?>">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="website">Website/Portfolio</label>
                                <input type="url" id="website" name="website" value="<?php echo htmlspecialchars($data['personal']['website']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="linkedin">LinkedIn Profile</label>
                                <input type="url" id="linkedin" name="linkedin" value="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="github">GitHub Profile</label>
                                <input type="url" id="github" name="github" value="<?php echo htmlspecialchars($data['personal']['github']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="profilePicture">Profile Picture</label>
                                <input type="file" id="profilePicture" name="profilePicture" accept="image/*" onchange="handleProfilePictureUpload(this)">
                                <div class="form-help">JPG, PNG, GIF, or WebP (Max 5MB)</div>
                                <?php if (!empty($data['personal']['profilePicture'])): ?>
                                    <div style="margin-top: 12px;">
                                        <img id="profile-picture-preview" src="<?php echo htmlspecialchars($data['personal']['profilePicture']); ?>" alt="Profile Picture" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover;">
                                    </div>
                                <?php else: ?>
                                    <img id="profile-picture-preview" src="" alt="Profile Picture" style="display: none; width: 100px; height: 100px; border-radius: 8px; object-fit: cover; margin-top: 12px;">
                                <?php endif; ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Save Personal Information</button>
                    </div>

                    <!-- Work Experience Section -->
                    <div id="work" class="form-section">
                        <h2>Work Experience</h2>
                        <div id="work-experience-items"></div>
                        <button type="button" id="add-work-experience" class="btn btn-primary">+ Add Work Experience</button>
                    </div>

                    <!-- Education Section -->
                    <div id="education" class="form-section">
                        <h2>Education</h2>
                        <div id="education-items"></div>
                        <button type="button" id="add-education" class="btn btn-primary">+ Add Education</button>
                    </div>

                    <!-- Skills Section -->
                    <div id="skills" class="form-section">
                        <h2>Skills</h2>
                        <div id="skills-items"></div>
                        <button type="button" id="add-skill" class="btn btn-primary">+ Add Skill</button>
                    </div>

                    <!-- Projects Section -->
                    <div id="projects" class="form-section">
                        <h2>Projects</h2>
                        <div id="projects-items"></div>
                        <button type="button" id="add-project" class="btn btn-primary">+ Add Project</button>
                    </div>

                    <!-- Certifications Section -->
                    <div id="certifications" class="form-section">
                        <h2>Certifications</h2>
                        <div id="certifications-items"></div>
                        <button type="button" id="add-certification" class="btn btn-primary">+ Add Certification</button>
                    </div>

                    <!-- Languages Section -->
                    <div id="languages" class="form-section">
                        <h2>Languages</h2>
                        <div id="languages-items"></div>
                        <button type="button" id="add-language" class="btn btn-primary">+ Add Language</button>
                    </div>

                    <!-- Interests Section -->
                    <div id="interests" class="form-section">
                        <h2>Interests</h2>
                        <div class="form-group">
                            <label for="interests">List Your Interests</label>
                            <textarea id="interests" name="interests" rows="4" placeholder="e.g., Web Development, AI, Machine Learning, Open Source"><?php echo htmlspecialchars($data['interests']); ?></textarea>
                            <div class="form-help">Separate interests with commas or line breaks</div>
                        </div>
                        <button type="submit" class="btn btn-success">Save Interests</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    .builder-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .sidebar-sticky {
        background: var(--color-bg-secondary);
        padding: 24px;
        border-radius: 12px;
    }

    .sidebar-sticky h3 {
        margin-bottom: 16px;
        color: var(--color-primary);
    }

    .section-nav {
        list-style: none;
        padding: 0;
    }

    .section-nav li {
        margin-bottom: 8px;
    }

    .section-link {
        display: block;
        padding: 8px 12px;
        border-radius: 6px;
        color: var(--color-text-secondary);
        transition: all 0.3s ease;
    }

    .section-link:hover,
    .section-link.active {
        background-color: var(--color-primary);
        color: white;
    }

    .form-section {
        margin-bottom: 48px;
        padding-bottom: 48px;
        border-bottom: 2px solid var(--color-border);
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .form-section h2 {
        color: var(--color-primary);
        margin-bottom: 24px;
        font-size: 24px;
    }

    .form-item {
        margin-bottom: 16px;
    }

    .form-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--color-border);
    }

    .form-item-header h4 {
        margin: 0;
    }

    @media (max-width: 1024px) {
        .builder-main {
            grid-column: span 4 !important;
        }

        .builder-sidebar {
            display: none;
        }
    }
</style>
