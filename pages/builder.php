<?php
/**
 * Resume Builder - Complete & Final Working Version
 * Matches your original design exactly with fixed image handling
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

        // Profile Picture Upload - FIXED VERSION
        if (!empty($_FILES['profilePicture']['name']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $fileName = $_FILES['profilePicture']['name'];
            $fileTmp = $_FILES['profilePicture']['tmp_name'];
            $fileSize = $_FILES['profilePicture']['size'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            // Validate file
            if (in_array($fileExt, $allowed) && $fileSize <= MAX_UPLOAD_SIZE) {
                // Ensure upload directory exists
                if (!is_dir(UPLOADS_PATH)) {
                    mkdir(UPLOADS_PATH, 0755, true);
                }
                
                // Generate unique filename
                $newFileName = 'profile_' . session_id() . '_' . time() . '.' . $fileExt;
                $uploadPath = UPLOADS_PATH . $newFileName;
                
                // Move uploaded file
                if (move_uploaded_file($fileTmp, $uploadPath)) {
                    // Store both relative and absolute paths
                    $data['personal']['profilePicture'] = BASE_URL . 'uploads/' . $newFileName;
                    $data['personal']['profilePicturePath'] = $uploadPath; // Store for PDF generation
                } else {
                    // Log error but don't break the app
                    error_log("Failed to move uploaded file: " . $uploadPath);
                }
            }
        }

        // Set default profile picture if none exists
        if (empty($data['personal']['profilePicture']) || !filter_var($data['personal']['profilePicture'], FILTER_VALIDATE_URL)) {
            $data['personal']['profilePicture'] = BASE_URL . 'assets/images/default-profile.png';
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
                        'skillName' => trim($name),
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
                        'languageName' => trim($name),
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
                                <input type="file" id="profilePicture" name="profilePicture" accept="image/*" onchange="previewImage(this)">
                                <div class="form-help">JPG, PNG, GIF, or WebP (Max <?php echo round(MAX_UPLOAD_SIZE / (1024*1024)); ?>MB)</div>
                                
                                <!-- Profile Picture Preview -->
                                <div id="profile-picture-container" style="margin-top: 12px; display: <?php echo !empty($data['personal']['profilePicture']) && strpos($data['personal']['profilePicture'], 'default-profile.png') === false ? 'block' : 'none'; ?>;">
                                    <?php 
                                    $profilePic = $data['personal']['profilePicture'];
                                    $isDefault = strpos($profilePic, 'default-profile.png') !== false;
                                    ?>
                                    <img id="profile-picture-preview" 
                                         src="<?php echo $isDefault ? BASE_URL . 'assets/images/default-profile.png' : htmlspecialchars($profilePic); ?>" 
                                         alt="Profile Picture" 
                                         style="width: 120px; height: 120px; border-radius: 8px; object-fit: cover; border: 2px solid var(--color-border);"
                                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/images/default-profile.png';">
                                    <div style="margin-top: 8px;">
                                        <button type="button" onclick="removeProfilePicture()" class="btn btn-danger btn-sm" style="padding: 4px 12px; font-size: 12px;">
                                            Remove Picture
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Hidden field to track picture removal -->
                                <input type="hidden" id="remove_picture" name="remove_picture" value="0">
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

<!-- Image Handling JavaScript -->
<script>
function previewImage(input) {
    const preview = document.getElementById('profile-picture-preview');
    const container = document.getElementById('profile-picture-container');
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
            document.getElementById('remove_picture').value = '0';
        }
        
        reader.readAsDataURL(file);
    }
}

function removeProfilePicture() {
    const preview = document.getElementById('profile-picture-preview');
    const container = document.getElementById('profile-picture-container');
    const fileInput = document.getElementById('profilePicture');
    const removeInput = document.getElementById('remove_picture');
    
    // Reset file input
    fileInput.value = '';
    
    // Set default image
    preview.src = '<?php echo BASE_URL; ?>assets/images/default-profile.png';
    
    // Hide container or keep it visible with default image
    container.style.display = 'block';
    
    // Mark for removal on server side
    removeInput.value = '1';
    
    alert('Profile picture will be removed when you save changes.');
}
</script>

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