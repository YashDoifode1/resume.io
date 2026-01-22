<?php
/**
 * Resume Builder - NO VALIDATION VERSION
 * Uses user data exactly as provided
 */

// Session already started in index.php

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

$data = &$_SESSION['resume_data'];

// ========================================
// HANDLE FORM SUBMISSION (NO VALIDATION)
// ========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_personal' || $action === 'save_all') {

        // Personal Info (NO FILTERING)
        $data['personal'] = [
            'fullName' => $_POST['fullName'] ?? '',
            'jobTitle' => $_POST['jobTitle'] ?? '',
            'profileSummary' => $_POST['profileSummary'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'address' => $_POST['address'] ?? '',
            'website' => $_POST['website'] ?? '',
            'linkedin' => $_POST['linkedin'] ?? '',
            'github' => $_POST['github'] ?? '',
            'profilePicture' => $data['personal']['profilePicture'] ?? ''
        ];

        // Profile Picture Upload (NO VALIDATION)
        if (!empty($_FILES['profilePicture']['name'])) {
            $uploadDir = UPLOADS_PATH;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = time() . '_' . $_FILES['profilePicture']['name'];
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $filePath)) {
                $data['personal']['profilePicture'] = UPLOAD_DIRECTORY . $fileName;
            }
        }
    }

    if ($action === 'save_all') {

        // Work Experience
        $data['workExperience'] = [];
        if (isset($_POST['company'])) {
            foreach ($_POST['company'] as $i => $v) {
                $data['workExperience'][] = [
                    'company' => $_POST['company'][$i] ?? '',
                    'job_role' => $_POST['job_role'][$i] ?? '',
                    'start_date' => $_POST['start_date'][$i] ?? '',
                    'end_date' => $_POST['end_date'][$i] ?? '',
                    'responsibilities' => $_POST['responsibilities'][$i] ?? ''
                ];
            }
        }

        // Education
        $data['education'] = [];
        if (isset($_POST['degree'])) {
            foreach ($_POST['degree'] as $i => $v) {
                $data['education'][] = [
                    'degree' => $_POST['degree'][$i] ?? '',
                    'institute' => $_POST['institute'][$i] ?? '',
                    'start_year' => $_POST['start_year'][$i] ?? '',
                    'end_year' => $_POST['end_year'][$i] ?? '',
                    'cgpa' => $_POST['cgpa'][$i] ?? ''
                ];
            }
        }

        // Skills
        $data['skills'] = [];
        if (isset($_POST['skill_name'])) {
            foreach ($_POST['skill_name'] as $i => $v) {
                $data['skills'][] = [
                    'skillName' => $_POST['skill_name'][$i] ?? '',
                    'level' => $_POST['skill_level'][$i] ?? ''
                ];
            }
        }

        // Projects
        $data['projects'] = [];
        if (isset($_POST['project_name'])) {
            foreach ($_POST['project_name'] as $i => $v) {
                $data['projects'][] = [
                    'name' => $_POST['project_name'][$i] ?? '',
                    'description' => $_POST['project_description'][$i] ?? '',
                    'technologies' => $_POST['technologies'][$i] ?? '',
                    'link' => $_POST['project_link'][$i] ?? ''
                ];
            }
        }

        // Certifications
        $data['certifications'] = [];
        if (isset($_POST['cert_title'])) {
            foreach ($_POST['cert_title'] as $i => $v) {
                $data['certifications'][] = [
                    'title' => $_POST['cert_title'][$i] ?? '',
                    'issued_by' => $_POST['issued_by'][$i] ?? '',
                    'year' => $_POST['cert_year'][$i] ?? ''
                ];
            }
        }

        // Languages
        $data['languages'] = [];
        if (isset($_POST['language_name'])) {
            foreach ($_POST['language_name'] as $i => $v) {
                $data['languages'][] = [
                    'languageName' => $_POST['language_name'][$i] ?? '',
                    'proficiency' => $_POST['proficiency'][$i] ?? ''
                ];
            }
        }

        // Interests
        $data['interests'] = $_POST['interests'] ?? '';

        $_SESSION['success_message'] = "Data saved successfully (no validation applied).";
    }
}

$page_title = 'Resume Builder';
$page_css = 'builder.css';
$page_js = 'builder.js';
?>

<?php if (isset($_SESSION['success_message'])): ?>
<div class="alert alert-success">
    <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
</div>
<?php endif; ?>

<script>
    window.resumeData = <?= json_encode($data); ?>;
</script>
<script src="<?= ASSETS_URL ?>js/builder.js"></script>

<?php if (isset($_SESSION['success_message'])): ?>
<div class="alert alert-success" style="margin: 20px 0; padding: 16px; border-radius: 8px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
</div>
<?php endif; ?>

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
                        <li><a href="#personal" class="section-link active">Personal Info</a></li>
                        <li><a href="#work" class="section-link">Work Experience</a></li>
                        <li><a href="#education" class="section-link">Education</a></li>
                        <li><a href="#skills" class="section-link">Skills</a></li>
                        <li><a href="#projects" class="section-link">Projects</a></li>
                        <li><a href="#certifications" class="section-link">Certifications</a></li>
                        <li><a href="#languages" class="section-link">Languages</a></li>
                        <li><a href="#interests" class="section-link">Interests</a></li>
                    </ul>
                    <div style="margin-top: 32px;">
                        <a href="<?php echo BASE_URL; ?>?page=preview" class="btn btn-primary btn-block">Preview Resume</a>
                    </div>
                </div>
            </aside>

            <!-- Main Form -->
            <div class="builder-main" style="grid-column: span 3;">
                <form id="resume-builder-form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="save_all">

                    <!-- Personal Information Section -->
                    <div id="personal" class="form-section">
                        <h2>Personal Information</h2>

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
                    </div>

                    <!-- Dynamic Sections -->
                    <div id="work" class="form-section">
                        <h2>Work Experience</h2>
                        <div id="work-experience-items"></div>
                        <button type="button" id="add-work-experience" class="btn btn-primary">+ Add Work Experience</button>
                    </div>

                    <div id="education" class="form-section">
                        <h2>Education</h2>
                        <div id="education-items"></div>
                        <button type="button" id="add-education" class="btn btn-primary">+ Add Education</button>
                    </div>

                    <div id="skills" class="form-section">
                        <h2>Skills</h2>
                        <div id="skills-items"></div>
                        <button type="button" id="add-skill" class="btn btn-primary">+ Add Skill</button>
                    </div>

                    <div id="projects" class="form-section">
                        <h2>Projects</h2>
                        <div id="projects-items"></div>
                        <button type="button" id="add-project" class="btn btn-primary">+ Add Project</button>
                    </div>

                    <div id="certifications" class="form-section'">
                        <h2>Certifications</h2>
                        <div id="certifications-items"></div>
                        <button type="button" id="add-certification" class="btn btn-primary">+ Add Certification</button>
                    </div>

                    <div id="languages" class="form-section">
                        <h2>Languages</h2>
                        <div id="languages-items"></div>
                        <button type="button" id="add-language" class="btn btn-primary">+ Add Language</button>
                    </div>

                    <div id="interests" class="form-section">
                        <h2>Interests</h2>
                        <div class="form-group">
                            <label for="interests">List Your Interests</label>
                            <textarea id="interests" name="interests" rows="4" placeholder="e.g., Web Development, AI, Machine Learning, Open Source"><?php echo htmlspecialchars($data['interests']); ?></textarea>
                            <div class="form-help">Separate interests with commas or line breaks</div>
                        </div>
                    </div>

                    <!-- Final Save Button -->
                    <div style="margin: 48px 0; text-align: center; padding: 32px 0; border-top: 2px solid var(--color-border);">
                        <button type="submit" class="btn btn-success btn-lg" style="padding: 16px 50px; font-size: 18px;">
                            Save All Changes
                        </button>
                        <a href="<?php echo BASE_URL; ?>?page=preview" class="btn btn-primary btn-lg" style="margin-left: 20px; padding: 16px 50px; font-size: 18px;">
                            Preview Resume →
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- PASS DATA TO JS -->
<script>
    window.resumeData = <?php echo json_encode($data); ?>;
</script>
<script src="<?php echo ASSETS_URL; ?>js/builder.js"></script>

<!-- Enhanced Builder Styles -->
<style>
    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
    }

    .hero h1 {
        font-size: 42px;
        margin-bottom: 16px;
        font-weight: 700;
    }

    .hero p {
        font-size: 18px;
        opacity: 0.95;
    }

    /* Builder Layout */
    .builder-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .sidebar-sticky {
        background: var(--color-bg-secondary);
        padding: 28px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--color-border);
    }

    .sidebar-sticky h3 {
        margin-bottom: 20px;
        color: var(--color-primary);
        font-size: 18px;
        font-weight: 600;
    }

    .section-nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .section-nav li {
        margin-bottom: 6px;
    }

    .section-link {
        display: block;
        padding: 10px 14px;
        border-radius: 6px;
        color: var(--color-text-secondary);
        transition: all 0.3s ease;
        font-weight: 500;
        border-left: 3px solid transparent;
    }

    .section-link:hover {
        background-color: rgba(var(--color-primary-rgb), 0.1);
        border-left-color: var(--color-primary);
        transform: translateX(4px);
    }

    .section-link.active {
        background-color: var(--color-primary);
        color: white;
        border-left-color: var(--color-primary);
    }

    /* Form Sections */
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
        margin-bottom: 28px;
        font-size: 28px;
        font-weight: 700;
        position: relative;
        padding-bottom: 12px;
    }

    .form-section h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
        border-radius: 2px;
    }

    /* Form Items */
    .form-item {
        margin-bottom: 24px;
        padding: 20px;
        background: var(--color-bg-secondary);
        border-radius: 8px;
        border: 1px solid var(--color-border);
        transition: all 0.3s ease;
    }

    .form-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-color: var(--color-primary);
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
        color: var(--color-primary);
        font-weight: 600;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--color-text-primary);
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--color-border);
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb), 0.1);
    }

    .form-help {
        font-size: 12px;
        color: var(--color-text-secondary);
        margin-top: 6px;
    }

    /* Buttons */
    .btn {
        padding: 12px 24px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        font-size: 14px;
    }

    .btn-primary {
        background: var(--color-primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--color-primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(var(--color-primary-rgb), 0.3);
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 12px;
    }

    .btn-lg {
        padding: 16px 50px;
        font-size: 16px;
    }

    .btn-block {
        width: 100%;
        display: block;
    }

    /* Alert */
    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .builder-main {
            grid-column: span 4 !important;
        }

        .builder-sidebar {
            position: static;
            margin-bottom: 32px;
        }

        .sidebar-sticky {
            background: transparent;
            padding: 0;
            border: none;
            box-shadow: none;
        }

        .section-nav {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 8px;
            margin-bottom: 24px;
        }

        .section-nav li {
            margin-bottom: 0;
        }

        .section-link {
            text-align: center;
            border-left: none;
            border-top: 3px solid transparent;
        }

        .section-link:hover {
            border-left: none;
            border-top-color: var(--color-primary);
        }

        .section-link.active {
            border-left: none;
            border-top-color: var(--color-primary);
        }
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 32px;
        }

        .form-section h2 {
            font-size: 22px;
        }

        .form-row {
            grid-template-columns: 1fr !important;
        }

        .section-nav {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .hero h1 {
            font-size: 24px;
        }

        .hero p {
            font-size: 16px;
        }

        .form-section h2 {
            font-size: 20px;
        }

        .section-nav {
            grid-template-columns: 1fr;
        }

        .btn-lg {
            padding: 12px 24px;
            font-size: 14px;
        }
    }
</style>