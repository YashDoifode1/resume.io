<?php
/**
 * Resume Builder - Complete & Final Working Version
 * Matches your original design exactly
 */

// Session already started in index.php

if (!isset($_SESSION['resume_data'])) {
    $_SESSION['resume_data'] = [
        'personal' => [
            'fullName' => '', 'jobTitle' => '', 'profileSummary' => '', 'email' => '',
            'phone' => '', 'address' => '', 'website' => '', 'linkedin' => '', 'github' => '',
            'profilePicture' => ''
        ],
        'workExperience' => [], 'education' => [], 'skills' => [], 'projects' => [],
        'certifications' => [], 'languages' => [], 'interests' => ''
    ];
}

$data = &$_SESSION['resume_data'];

// ========================================
// HANDLE ALL FORM SUBMISSIONS
// ========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if (in_array($action, ['save_personal', 'save_all'])) {
        // Personal Info
        $data['personal'] = [
            'fullName' => trim($_POST['fullName'] ?? ''),
            'jobTitle' => trim($_POST['jobTitle'] ?? ''),
            'profileSummary' => trim($_POST['profileSummary'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'website' => trim($_POST['website'] ?? ''),
            'linkedin' => trim($_POST['linkedin'] ?? ''),
            'github' => trim($_POST['github'] ?? ''),
            'profilePicture' => $data['personal']['profilePicture'] ?? ''
        ];

        // Profile Picture Upload
        if (!empty($_FILES['profilePicture']['name']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed) && $_FILES['profilePicture']['size'] <= 5 * 1024 * 1024) {
                $uploadDir = UPLOADS_PATH;
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                $fileName = 'profile_' . session_id() . '_' . time() . '.' . $ext;
                $filePath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $filePath)) {
                    $data['personal']['profilePicture'] = UPLOAD_DIRECTORY . $fileName;
                }
            }
        }

        if (empty($data['personal']['profilePicture'])) {
            $data['personal']['profilePicture'] = ASSETS_URL . 'images/default-profile.png';
        }
    }

    if ($action === 'save_all') {
        // Work Experience
        if (isset($_POST['company']) && is_array($_POST['company'])) {
            $work = [];
            foreach ($_POST['company'] as $i => $c) {
                if (!empty(trim($c))) {
                    $work[] = [
                        'company' => trim($c),
                        'job_role' => trim($_POST['job_role'][$i] ?? ''),
                        'start_date' => $_POST['start_date'][$i] ?? '',
                        'end_date' => $_POST['end_date'][$i] ?? '',
                        'responsibilities' => trim($_POST['responsibilities'][$i] ?? '')
                    ];
                }
            }
            $data['workExperience'] = $work;
        }

        // Education
        if (isset($_POST['degree']) && is_array($_POST['degree'])) {
            $edu = [];
            foreach ($_POST['degree'] as $i => $d) {
                if (!empty(trim($d))) {
                    $edu[] = [
                        'degree' => trim($d),
                        'institute' => trim($_POST['institute'][$i] ?? ''),
                        'start_year' => $_POST['start_year'][$i] ?? '',
                        'end_year' => $_POST['end_year'][$i] ?? '',
                        'cgpa' => trim($_POST['cgpa'][$i] ?? '')
                    ];
                }
            }
            $data['education'] = $edu;
        }

        // Skills
        if (isset($_POST['skill_name']) && is_array($_POST['skill_name'])) {
            $skills = [];
            foreach ($_POST['skill_name'] as $i => $name) {
                if (!empty(trim($name))) {
                    $skills[] = [
                        'name' => trim($name),
                        'level' => $_POST['skill_level'][$i] ?? 'Intermediate'
                    ];
                }
            }
            $data['skills'] = $skills;
        }

        // Projects
        if (isset($_POST['project_name']) && is_array($_POST['project_name'])) {
            $proj = [];
            foreach ($_POST['project_name'] as $i => $name) {
                if (!empty(trim($name))) {
                    $proj[] = [
                        'name' => trim($name),
                        'description' => trim($_POST['project_description'][$i] ?? ''),
                        'technologies' => trim($_POST['technologies'][$i] ?? ''),
                        'link' => trim($_POST['project_link'][$i] ?? '')
                    ];
                }
            }
            $data['projects'] = $proj;
        }

        // Certifications
        if (isset($_POST['cert_title']) && is_array($_POST['cert_title'])) {
            $certs = [];
            foreach ($_POST['cert_title'] as $i => $title) {
                if (!empty(trim($title))) {
                    $certs[] = [
                        'title' => trim($title),
                        'issued_by' => trim($_POST['issued_by'][$i] ?? ''),
                        'year' => $_POST['cert_year'][$i] ?? ''
                    ];
                }
            }
            $data['certifications'] = $certs;
        }

        // Languages
        if (isset($_POST['language_name']) && is_array($_POST['language_name'])) {
            $langs = [];
            foreach ($_POST['language_name'] as $i => $name) {
                if (!empty(trim($name))) {
                    $langs[] = [
                        'name' => trim($name),
                        'proficiency' => $_POST['proficiency'][$i] ?? 'Intermediate'
                    ];
                }
            }
            $data['languages'] = $langs;
        }

        // Interests
        $data['interests'] = trim($_POST['interests'] ?? '');

        $_SESSION['success_message'] = "All changes saved successfully!";
    }
}

$page_title = 'Resume Builder';
$page_description = 'Create your professional resume with our easy-to-use resume builder.';
$page_css = 'builder.css';
$page_js = 'builder.js';
?>

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

<!-- Your original styles -->
<style>
    .builder-sidebar { position: sticky; top: 100px; height: fit-content; }
    .sidebar-sticky { background: var(--color-bg-secondary); padding: 24px; border-radius: 12px; }
    .sidebar-sticky h3 { margin-bottom: 16px; color: var(--color-primary); }
    .section-nav { list-style: none; padding: 0; }
    .section-nav li { margin-bottom: 8px; }
    .section-link { display: block; padding: 8px 12px; border-radius: 6px; color: var(--color-text-secondary); transition: all 0.3s ease; }
    .section-link:hover, .section-link.active { background-color: var(--color-primary); color: white; }
    .form-section { margin-bottom: 48px; padding-bottom: 48px; border-bottom: 2px solid var(--color-border); }
    .form-section:last-child { border-bottom: none; }
    .form-section h2 { color: var(--color-primary); margin-bottom: 24px; font-size: 24px; }
    @media (max-width: 1024px) {
        .builder-main { grid-column: span 4 !important; }
        .builder-sidebar { display: none; }
    }
</style>