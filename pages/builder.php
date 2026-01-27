<?php
/**
 * Resume Builder - Updated with Theme Integration
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';

// ================= THEME RESOLUTION LOGIC =================
// Get the requested theme from URL parameter
$requestedThemeSlug = $_GET['theme'] ?? '';

// Get all available themes for switching dropdown
try {
    $allThemesStmt = $pdo->query("
        SELECT id, slug, name, description, icon, file_name, is_active, is_premium 
        FROM themes 
        WHERE is_active = 1 
        ORDER BY is_premium DESC, name ASC
    ");
    $allThemes = $allThemesStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $allThemes = [];
    error_log("Error fetching themes: " . $e->getMessage());
}

// Default fallback theme slug (should exist in database)
$defaultThemeSlug = 'modern';
$activeTheme = null;
$themeErrorMessage = '';

try {
    // If theme slug provided, use it; otherwise use session theme or default
    if (empty($requestedThemeSlug) && isset($_SESSION['active_theme_slug'])) {
        $requestedThemeSlug = $_SESSION['active_theme_slug'];
    }
    
    // Fetch the matching active theme from database
    if (!empty($requestedThemeSlug)) {
        $stmt = $pdo->prepare("
            SELECT id, slug, name, description, icon, file_name, is_active, is_premium 
            FROM themes 
            WHERE slug = :slug AND is_active = 1
            LIMIT 1
        ");
        $stmt->execute([':slug' => $requestedThemeSlug]);
        $activeTheme = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // If requested theme not found or not active, fallback to default
    if (!$activeTheme) {
        $stmt = $pdo->prepare("
            SELECT id, slug, name, description, icon, file_name, is_active, is_premium 
            FROM themes 
            WHERE slug = :slug AND is_active = 1
            LIMIT 1
        ");
        $stmt->execute([':slug' => $defaultThemeSlug]);
        $activeTheme = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($activeTheme && !empty($requestedThemeSlug)) {
            $themeErrorMessage = "Requested theme not available. Using default theme.";
        }
    }
    
    // If still no theme, fetch first active theme as ultimate fallback
    if (!$activeTheme && !empty($allThemes)) {
        $activeTheme = $allThemes[0];
    }
    
    // Store active theme in session
    if ($activeTheme) {
        $_SESSION['active_theme_slug'] = $activeTheme['slug'];
    } else {
        throw new Exception("No active themes available in database.");
    }
    
    // ================= TEMPLATE FILE VALIDATION =================
    // Validate and sanitize the file_name
    $templateFile = $activeTheme['file_name'] ?? '';
    
    // Security: Only allow alphanumeric, hyphens, underscores, and dots
    if (!preg_match('/^[a-zA-Z0-9_\-\.]+\.php$/', $templateFile)) {
        throw new Exception("Invalid template file name format.");
    }
    
    // Prevent directory traversal
    $templatePath = __DIR__ . '/../themes/' . basename($templateFile);
    
    // Verify the template file exists
    if (!file_exists($templatePath)) {
        // Try to find any existing template as fallback
        $fallbackTemplate = 'theme2-modern.php';
        $templatePath = __DIR__ . '/../themes/' . $fallbackTemplate;
        
        if (!file_exists($templatePath)) {
            throw new Exception("Template file not found.");
        }
        
        $activeTheme['file_name'] = $fallbackTemplate;
        $themeErrorMessage = "Template file not found. Using fallback template.";
    }
    
} catch (Exception $e) {
    // Log error in production, show user-friendly message
    error_log("Theme Error: " . $e->getMessage());
    $themeErrorMessage = "Theme configuration issue. Using basic layout.";
    
    // Ultimate fallback to ensure builder always works
    $activeTheme = [
        'slug' => 'fallback',
        'name' => 'Basic Template',
        'description' => 'Fallback template',
        'icon' => '📄',
        'file_name' => 'theme2-modern.php',
        'is_premium' => 0
    ];
}

// ================= RESUME DATA INITIALIZATION =================
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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $step = $_POST['step'] ?? 1;

    if (in_array($action, ['save_step', 'save_personal', 'save_all', 'switch_theme'])) {
        
        // Handle theme switching
        if ($action === 'switch_theme' && isset($_POST['theme_slug'])) {
            $newThemeSlug = trim($_POST['theme_slug']);
            $_SESSION['active_theme_slug'] = $newThemeSlug;
            
            // Redirect to refresh with new theme
            echo '<script>window.location.href = "' . BASE_URL . '?page=builder&theme=' . urlencode($newThemeSlug) . '&step=' . $step . '";</script>';
            exit;
        }
        
        // Personal Info (Step 1)
        if (in_array($action, ['save_step', 'save_personal', 'save_all']) && $step == 1) {
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
                $fileName = $_FILES['profilePicture']['name'];
                $fileTmp = $_FILES['profilePicture']['tmp_name'];
                $fileSize = $_FILES['profilePicture']['size'];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                if (in_array($fileExt, $allowed) && $fileSize <= MAX_UPLOAD_SIZE) {
                    if (!is_dir(UPLOADS_PATH)) {
                        mkdir(UPLOADS_PATH, 0755, true);
                    }
                    
                    $newFileName = 'profile_' . session_id() . '_' . time() . '.' . $fileExt;
                    $uploadPath = UPLOADS_PATH . $newFileName;
                    
                    if (move_uploaded_file($fileTmp, $uploadPath)) {
                        $data['personal']['profilePicture'] = BASE_URL . 'uploads/' . $newFileName;
                    }
                }
            }

            // Handle profile picture removal
            if (isset($_POST['remove_picture']) && $_POST['remove_picture'] == '1') {
                $data['personal']['profilePicture'] = '';
            }

            // Set default profile picture if none exists
            if (empty($data['personal']['profilePicture']) || !filter_var($data['personal']['profilePicture'], FILTER_VALIDATE_URL)) {
                $data['personal']['profilePicture'] = BASE_URL . 'assets/images/default-profile.png';
            }
            
            $_SESSION['success_message'] = "Personal information saved successfully!";
        }

        // Work Experience (Step 2)
        if (in_array($action, ['save_step', 'save_all']) && $step == 2) {
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
                $_SESSION['success_message'] = "Work experience saved successfully!";
            }
        }

        // Education (Step 3)
        if (in_array($action, ['save_step', 'save_all']) && $step == 3) {
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
                $_SESSION['success_message'] = "Education details saved successfully!";
            }
        }

        // Skills (Step 4)
        if (in_array($action, ['save_step', 'save_all']) && $step == 4) {
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
                $_SESSION['success_message'] = "Skills saved successfully!";
            }
        }

        if ($action === 'save_all') {
            $_SESSION['success_message'] = "All changes saved successfully!";
        }

        // Use JavaScript redirect instead of header() to avoid "headers already sent" error
        echo '<script>window.location.href = "' . BASE_URL . '?page=builder&theme=' . urlencode($activeTheme['slug']) . '&step=' . $step . '";</script>';
        exit;
    }
}

// Get current step from URL or default to 1
$current_step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
if ($current_step < 1 || $current_step > 5) $current_step = 1;

$page_title = 'Resume Builder - ' . htmlspecialchars($activeTheme['name']);
$page_description = 'Create your professional resume with ' . htmlspecialchars($activeTheme['name']) . ' template.';
?>

<!-- Theme Information Display -->
<div class="theme-info-bar">
    <div class="container">
        <div class="theme-info-content">
            <span class="theme-icon"><?php echo htmlspecialchars($activeTheme['icon'] ?? '📄'); ?></span>
            <div class="theme-details">
                <h4><?php echo htmlspecialchars($activeTheme['name']); ?></h4>
                <p><?php echo htmlspecialchars($activeTheme['description']); ?></p>
            </div>
            <?php if ($activeTheme['is_premium']): ?>
                <span class="badge premium-badge">
                    <i class="fas fa-crown"></i> Premium
                </span>
            <?php endif; ?>
            
            <!-- Theme Switcher Dropdown -->
            <div class="theme-switcher-dropdown">
                <button class="btn-theme-switch" id="themeSwitchButton">
                    <i class="fas fa-palette"></i> Switch Theme
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="theme-dropdown-menu" id="themeDropdown">
                    <?php foreach ($allThemes as $theme): ?>
                        <a href="#" class="theme-option <?php echo $theme['slug'] === $activeTheme['slug'] ? 'active' : ''; ?>" 
                           data-theme-slug="<?php echo htmlspecialchars($theme['slug']); ?>">
                            <span class="theme-option-icon"><?php echo htmlspecialchars($theme['icon'] ?? '📄'); ?></span>
                            <span class="theme-option-name"><?php echo htmlspecialchars($theme['name']); ?></span>
                            <?php if ($theme['is_premium']): ?>
                                <span class="theme-option-premium">Premium</span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php if ($themeErrorMessage): ?>
            <div class="theme-warning">
                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($themeErrorMessage); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($_SESSION['success_message'])): ?>
<div class="alert-success">
    <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
</div>
<?php endif; ?>

<!-- Builder Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Build Your Resume</h2>
            <p>Fill in your details step by step and see your resume update in real-time.</p>
        </div>
        
        <div class="builder-container">
            <!-- Left: Builder Form -->
            <div class="builder-form-container">
                <!-- Progress Stepper -->
                <div class="progress-stepper">
                    <?php for ($i = 1; $i <= 5; $i++): 
                        $step_class = '';
                        if ($i == $current_step) {
                            $step_class = 'active';
                        } elseif ($i < $current_step) {
                            $step_class = 'completed';
                        }
                    ?>
                    <div class="step <?php echo $step_class; ?>" onclick="goToStep(<?php echo $i; ?>)">
                        <div class="step-number"><?php echo $i; ?></div>
                        <div class="step-label">
                            <?php 
                            switch($i) {
                                case 1: echo 'Personal'; break;
                                case 2: echo 'Experience'; break;
                                case 3: echo 'Education'; break;
                                case 4: echo 'Skills'; break;
                                case 5: echo 'Preview'; break;
                            }
                            ?>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                
                <!-- Form -->
                <form id="resume-builder-form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="save_step">
                    <input type="hidden" name="step" id="current_step" value="<?php echo $current_step; ?>">
                    <input type="hidden" name="theme_slug" value="<?php echo htmlspecialchars($activeTheme['slug']); ?>">
                    
                    <!-- Personal Information (Step 1) -->
                    <div class="form-step <?php echo $current_step == 1 ? 'active' : ''; ?>" id="step1">
                        <h3>Personal Information</h3>
                        <p>Let's start with your basic information.</p>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fullName">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" 
                                       value="<?php echo htmlspecialchars($data['personal']['fullName']); ?>" 
                                       required placeholder="John Doe" oninput="updatePreviewField('fullName', this.value)">
                            </div>
                            <div class="form-group">
                                <label for="jobTitle">Job Title *</label>
                                <input type="text" id="jobTitle" name="jobTitle" 
                                       value="<?php echo htmlspecialchars($data['personal']['jobTitle']); ?>" 
                                       required placeholder="Software Engineer" oninput="updatePreviewField('jobTitle', this.value)">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="profileSummary">Professional Summary</label>
                            <textarea id="profileSummary" name="profileSummary" rows="4" 
                                      placeholder="Brief summary of your professional background and goals..." 
                                      oninput="updatePreviewField('profileSummary', this.value)"><?php echo htmlspecialchars($data['personal']['profileSummary']); ?></textarea>
                            <div class="form-help">Write a brief summary of your professional background and goals</div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($data['personal']['email']); ?>" 
                                       required placeholder="john.doe@example.com" oninput="updatePreviewField('email', this.value)">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone *</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($data['personal']['phone']); ?>" 
                                       required placeholder="(123) 456-7890" oninput="updatePreviewField('phone', this.value)">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="linkedin">LinkedIn Profile</label>
                                <input type="url" id="linkedin" name="linkedin" 
                                       value="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>" 
                                       placeholder="https://linkedin.com/in/johndoe" oninput="updatePreviewField('linkedin', this.value)">
                            </div>
                            <div class="form-group">
                                <label for="github">GitHub Profile</label>
                                <input type="url" id="github" name="github" 
                                       value="<?php echo htmlspecialchars($data['personal']['github']); ?>" 
                                       placeholder="https://github.com/johndoe" oninput="updatePreviewField('github', this.value)">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" 
                                   value="<?php echo htmlspecialchars($data['personal']['address']); ?>" 
                                   placeholder="New York, NY" oninput="updatePreviewField('address', this.value)">
                        </div>
                        
                        <div class="form-group">
                            <label for="website">Website/Portfolio</label>
                            <input type="url" id="website" name="website" 
                                   value="<?php echo htmlspecialchars($data['personal']['website']); ?>" 
                                   placeholder="https://johndoe.com" oninput="updatePreviewField('website', this.value)">
                        </div>
                        
                        <!-- Profile Picture -->
                        <div class="form-group">
                            <label for="profilePicture">Profile Picture</label>
                            <div class="drag-container" onclick="document.getElementById('profilePicture').click()">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <h4>Drag & Drop or Click to Upload</h4>
                                <p>JPG, PNG, GIF, or WebP (Max <?php echo round(MAX_UPLOAD_SIZE / (1024*1024)); ?>MB)</p>
                            </div>
                            <input type="file" id="profilePicture" name="profilePicture" accept="image/*" 
                                   style="display: none;" onchange="handleProfilePictureUpload(this)">
                            
                            <!-- Profile Picture Preview -->
                            <div id="profile-picture-container" style="margin-top: 12px; display: <?php echo !empty($data['personal']['profilePicture']) ? 'block' : 'none'; ?>;">
                                <?php 
                                $profilePic = $data['personal']['profilePicture'];
                                $isDefault = strpos($profilePic, 'default-profile.png') !== false;
                                ?>
                                <img id="profile-picture-preview" 
                                     src="<?php echo htmlspecialchars($profilePic); ?>" 
                                     alt="Profile Picture" 
                                     style="width: 120px; height: 120px; border-radius: 8px; object-fit: cover; border: 2px solid var(--border-color);">
                                <div style="margin-top: 8px;">
                                    <button type="button" onclick="removeProfilePicture()" class="btn-danger btn-sm">
                                        Remove Picture
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" id="remove_picture" name="remove_picture" value="0">
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Save & Continue
                            </button>
                            <button type="button" class="btn-secondary" onclick="nextStep()">
                                Next: Experience <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Work Experience (Step 2) -->
                    <div class="form-step <?php echo $current_step == 2 ? 'active' : ''; ?>" id="step2">
                        <h3>Work Experience</h3>
                        <p>Add your work history, starting with your most recent position.</p>
                        
                        <div id="work-experience-items">
                            <?php if (empty($data['workExperience'])): ?>
                            <div class="form-item" data-index="0">
                                <div class="form-item-header">
                                    <h4>Work Experience #1</h4>
                                    <button type="button" class="btn-danger btn-sm remove-item">Remove</button>
                                </div>
                                <div class="form-group">
                                    <label for="company_0">Company *</label>
                                    <input type="text" id="company_0" name="company[]" placeholder="TechCorp Inc." oninput="updateWorkExperiencePreview(0, 'company', this.value)">
                                </div>
                                <div class="form-group">
                                    <label for="job_role_0">Job Title *</label>
                                    <input type="text" id="job_role_0" name="job_role[]" placeholder="Software Engineer" oninput="updateWorkExperiencePreview(0, 'job_role', this.value)">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="start_date_0">Start Date *</label>
                                        <input type="text" id="start_date_0" name="start_date[]" placeholder="Jan 2020" oninput="updateWorkExperiencePreview(0, 'start_date', this.value)">
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date_0">End Date</label>
                                        <input type="text" id="end_date_0" name="end_date[]" placeholder="Present" oninput="updateWorkExperiencePreview(0, 'end_date', this.value)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="responsibilities_0">Responsibilities & Achievements</label>
                                    <textarea id="responsibilities_0" name="responsibilities[]" rows="4" placeholder="Describe your key responsibilities and achievements..." oninput="updateWorkExperiencePreview(0, 'responsibilities', this.value)"></textarea>
                                    <div class="form-help">Use bullet points for better readability</div>
                                </div>
                            </div>
                            <?php else: ?>
                                <?php foreach ($data['workExperience'] as $index => $work): ?>
                                <div class="form-item" data-index="<?php echo $index; ?>">
                                    <div class="form-item-header">
                                        <h4>Work Experience #<?php echo $index + 1; ?></h4>
                                        <button type="button" class="btn-danger btn-sm remove-item">Remove</button>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_<?php echo $index; ?>">Company *</label>
                                        <input type="text" id="company_<?php echo $index; ?>" name="company[]" 
                                               value="<?php echo htmlspecialchars($work['company']); ?>" 
                                               placeholder="TechCorp Inc." oninput="updateWorkExperiencePreview(<?php echo $index; ?>, 'company', this.value)">
                                    </div>
                                    <div class="form-group">
                                        <label for="job_role_<?php echo $index; ?>">Job Title *</label>
                                        <input type="text" id="job_role_<?php echo $index; ?>" name="job_role[]" 
                                               value="<?php echo htmlspecialchars($work['job_role']); ?>" 
                                               placeholder="Software Engineer" oninput="updateWorkExperiencePreview(<?php echo $index; ?>, 'job_role', this.value)">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="start_date_<?php echo $index; ?>">Start Date *</label>
                                            <input type="text" id="start_date_<?php echo $index; ?>" name="start_date[]" 
                                                   value="<?php echo htmlspecialchars($work['start_date']); ?>" 
                                                   placeholder="Jan 2020" oninput="updateWorkExperiencePreview(<?php echo $index; ?>, 'start_date', this.value)">
                                        </div>
                                        <div class="form-group">
                                            <label for="end_date_<?php echo $index; ?>">End Date</label>
                                            <input type="text" id="end_date_<?php echo $index; ?>" name="end_date[]" 
                                                   value="<?php echo htmlspecialchars($work['end_date']); ?>" 
                                                   placeholder="Present" oninput="updateWorkExperiencePreview(<?php echo $index; ?>, 'end_date', this.value)">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="responsibilities_<?php echo $index; ?>">Responsibilities & Achievements</label>
                                        <textarea id="responsibilities_<?php echo $index; ?>" name="responsibilities[]" 
                                                  rows="4" placeholder="Describe your key responsibilities and achievements..." oninput="updateWorkExperiencePreview(<?php echo $index; ?>, 'responsibilities', this.value)"><?php echo htmlspecialchars($work['responsibilities']); ?></textarea>
                                        <div class="form-help">Use bullet points for better readability</div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <button type="button" id="add-work-experience" class="btn-primary">
                            <i class="fas fa-plus"></i> Add Work Experience
                        </button>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i> Previous
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Save & Continue
                            </button>
                            <button type="button" class="btn-secondary" onclick="nextStep()">
                                Next: Education <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Education (Step 3) -->
                    <div class="form-step <?php echo $current_step == 3 ? 'active' : ''; ?>" id="step3">
                        <h3>Education</h3>
                        <p>Add your educational background.</p>
                        
                        <div id="education-items">
                            <?php if (empty($data['education'])): ?>
                            <div class="form-item" data-index="0">
                                <div class="form-item-header">
                                    <h4>Education #1</h4>
                                    <button type="button" class="btn-danger btn-sm remove-item">Remove</button>
                                </div>
                                <div class="form-group">
                                    <label for="degree_0">Degree *</label>
                                    <input type="text" id="degree_0" name="degree[]" placeholder="Bachelor of Science in Computer Science" oninput="updateEducationPreview(0, 'degree', this.value)">
                                </div>
                                <div class="form-group">
                                    <label for="institute_0">Institution *</label>
                                    <input type="text" id="institute_0" name="institute[]" placeholder="Stanford University" oninput="updateEducationPreview(0, 'institute', this.value)">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="start_year_0">Start Year</label>
                                        <input type="text" id="start_year_0" name="start_year[]" placeholder="2016" oninput="updateEducationPreview(0, 'start_year', this.value)">
                                    </div>
                                    <div class="form-group">
                                        <label for="end_year_0">End Year</label>
                                        <input type="text" id="end_year_0" name="end_year[]" placeholder="2020" oninput="updateEducationPreview(0, 'end_year', this.value)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cgpa_0">CGPA/Grade</label>
                                    <input type="text" id="cgpa_0" name="cgpa[]" placeholder="3.8/4.0" oninput="updateEducationPreview(0, 'cgpa', this.value)">
                                </div>
                            </div>
                            <?php else: ?>
                                <?php foreach ($data['education'] as $index => $edu): ?>
                                <div class="form-item" data-index="<?php echo $index; ?>">
                                    <div class="form-item-header">
                                        <h4>Education #<?php echo $index + 1; ?></h4>
                                        <button type="button" class="btn-danger btn-sm remove-item">Remove</button>
                                    </div>
                                    <div class="form-group">
                                        <label for="degree_<?php echo $index; ?>">Degree *</label>
                                        <input type="text" id="degree_<?php echo $index; ?>" name="degree[]" 
                                               value="<?php echo htmlspecialchars($edu['degree']); ?>" 
                                               placeholder="Bachelor of Science in Computer Science" oninput="updateEducationPreview(<?php echo $index; ?>, 'degree', this.value)">
                                    </div>
                                    <div class="form-group">
                                        <label for="institute_<?php echo $index; ?>">Institution *</label>
                                        <input type="text" id="institute_<?php echo $index; ?>" name="institute[]" 
                                               value="<?php echo htmlspecialchars($edu['institute']); ?>" 
                                               placeholder="Stanford University" oninput="updateEducationPreview(<?php echo $index; ?>, 'institute', this.value)">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="start_year_<?php echo $index; ?>">Start Year</label>
                                            <input type="text" id="start_year_<?php echo $index; ?>" name="start_year[]" 
                                                   value="<?php echo htmlspecialchars($edu['start_year']); ?>" 
                                                   placeholder="2016" oninput="updateEducationPreview(<?php echo $index; ?>, 'start_year', this.value)">
                                        </div>
                                        <div class="form-group">
                                            <label for="end_year_<?php echo $index; ?>">End Year</label>
                                            <input type="text" id="end_year_<?php echo $index; ?>" name="end_year[]" 
                                                   value="<?php echo htmlspecialchars($edu['end_year']); ?>" 
                                                   placeholder="2020" oninput="updateEducationPreview(<?php echo $index; ?>, 'end_year', this.value)">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cgpa_<?php echo $index; ?>">CGPA/Grade</label>
                                        <input type="text" id="cgpa_<?php echo $index; ?>" name="cgpa[]" 
                                               value="<?php echo htmlspecialchars($edu['cgpa']); ?>" 
                                               placeholder="3.8/4.0" oninput="updateEducationPreview(<?php echo $index; ?>, 'cgpa', this.value)">
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <button type="button" id="add-education" class="btn-primary">
                            <i class="fas fa-plus"></i> Add Education
                        </button>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i> Previous
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Save & Continue
                            </button>
                            <button type="button" class="btn-secondary" onclick="nextStep()">
                                Next: Skills <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Skills (Step 4) -->
                    <div class="form-step <?php echo $current_step == 4 ? 'active' : ''; ?>" id="step4">
                        <h3>Skills</h3>
                        <p>Add your technical and professional skills.</p>
                        
                        <div id="skills-items">
                            <?php if (empty($data['skills'])): ?>
                            <div class="form-item" data-index="0">
                                <div class="form-item-header">
                                    <h4>Skill #1</h4>
                                    <button type="button" class="btn-danger btn-sm remove-item">Remove</button>
                                </div>
                                <div class="form-group">
                                    <label for="skill_name_0">Skill Name *</label>
                                    <input type="text" id="skill_name_0" name="skill_name[]" placeholder="JavaScript" oninput="updateSkillPreview(0, 'skillName', this.value)">
                                </div>
                                <div class="form-group">
                                    <label for="skill_level_0">Skill Level</label>
                                    <select id="skill_level_0" name="skill_level[]" onchange="updateSkillPreview(0, 'level', this.value)">
                                        <option value="Beginner">Beginner</option>
                                        <option value="Intermediate" selected>Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                        <option value="Expert">Expert</option>
                                    </select>
                                </div>
                            </div>
                            <?php else: ?>
                                <?php foreach ($data['skills'] as $index => $skill): ?>
                                <div class="form-item" data-index="<?php echo $index; ?>">
                                    <div class="form-item-header">
                                        <h4>Skill #<?php echo $index + 1; ?></h4>
                                        <button type="button" class="btn-danger btn-sm remove-item">Remove</button>
                                    </div>
                                    <div class="form-group">
                                        <label for="skill_name_<?php echo $index; ?>">Skill Name *</label>
                                        <input type="text" id="skill_name_<?php echo $index; ?>" name="skill_name[]" 
                                               value="<?php echo htmlspecialchars($skill['skillName']); ?>" 
                                               placeholder="JavaScript" oninput="updateSkillPreview(<?php echo $index; ?>, 'skillName', this.value)">
                                    </div>
                                    <div class="form-group">
                                        <label for="skill_level_<?php echo $index; ?>">Skill Level</label>
                                        <select id="skill_level_<?php echo $index; ?>" name="skill_level[]" onchange="updateSkillPreview(<?php echo $index; ?>, 'level', this.value)">
                                            <option value="Beginner" <?php echo $skill['level'] === 'Beginner' ? 'selected' : ''; ?>>Beginner</option>
                                            <option value="Intermediate" <?php echo $skill['level'] === 'Intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                                            <option value="Advanced" <?php echo $skill['level'] === 'Advanced' ? 'selected' : ''; ?>>Advanced</option>
                                            <option value="Expert" <?php echo $skill['level'] === 'Expert' ? 'selected' : ''; ?>>Expert</option>
                                        </select>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <button type="button" id="add-skill" class="btn-primary">
                            <i class="fas fa-plus"></i> Add Skill
                        </button>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i> Previous
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Save Skills
                            </button>
                            <button type="button" class="btn-success" onclick="showPreview()">
                                Preview Resume <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Final Save All Button (only shown after all steps) -->
                <?php if ($current_step == 5): ?>
                <div class="final-save-section">
                    <form method="POST" id="final-save-form">
                        <input type="hidden" name="action" value="save_all">
                        <input type="hidden" name="step" value="5">
                        <input type="hidden" name="theme_slug" value="<?php echo htmlspecialchars($activeTheme['slug']); ?>">
                        <div class="form-actions">
                            <button type="submit" class="btn-success btn-lg">
                                <i class="fas fa-save"></i> Save Complete Resume
                            </button>
                            <a href="<?php echo BASE_URL; ?>?page=download&theme=<?php echo urlencode($activeTheme['slug']); ?>" class="btn-primary btn-lg">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Right: Live Preview -->
            <div class="preview-container">
                <div class="preview-header">
                    <h3>Live Preview 
                        <span class="auto-save-status" id="autoSaveStatus"></span>
                        <span class="step-indicator">Step <?php echo $current_step; ?>/5</span>
                        <span class="theme-badge"><?php echo htmlspecialchars($activeTheme['name']); ?></span>
                    </h3>
                    <div class="preview-controls">
                        <button type="button" class="btn-preview-control" onclick="togglePreviewScale()" title="Zoom">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" class="btn-preview-control" onclick="refreshPreview()" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                
                <div class="resume-preview-wrapper">
                    <div class="resume-preview" id="livePreview">
                        <!-- ================= TEMPLATE RENDERING ================= -->
                        <?php 
                        try {
                            // Pass resume data to template via variables, not globals
                            $resumeData = $data;
                            $themeSlug = $activeTheme['slug'];
                            $isPremium = $activeTheme['is_premium'];
                            
                            // Include the selected theme template
                            include __DIR__ . '/../themes/' . basename($activeTheme['file_name']);
                            
                        } catch (Exception $e) {
                            // Fallback template rendering if theme fails
                            echo '<div class="theme-error">';
                            echo '<h4>Template Rendering Error</h4>';
                            echo '<p>The selected theme could not be loaded. Using basic layout.</p>';
                            echo '</div>';
                            
                            // Include fallback template
                            include __DIR__ . '/../themes/theme2-modern.php';
                        }
                        ?>
                    </div>
                </div>
                
                <div class="preview-actions">
                    <p class="auto-save-info">
                        <i class="fas fa-sync-alt"></i> <span id="autoSaveText">Auto-saved just now</span>
                        <span class="theme-info">Theme: <?php echo htmlspecialchars($activeTheme['name']); ?></span>
                    </p>
                    <div class="preview-buttons">
                        <button type="button" class="btn btn-secondary" onclick="goToStep(<?php echo $current_step; ?>)">
                            <i class="fas fa-edit"></i> Edit This Section
                        </button>
                        <a href="<?php echo BASE_URL; ?>?page=preview&theme=<?php echo urlencode($activeTheme['slug']); ?>" class="btn btn-primary">
                            <i class="fas fa-eye"></i> Full Preview
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Theme Switcher Form (Hidden) -->
<form id="theme-switcher-form" method="POST" style="display: none;">
    <input type="hidden" name="action" value="switch_theme">
    <input type="hidden" name="step" value="<?php echo $current_step; ?>">
    <input type="hidden" name="theme_slug" id="switch_theme_slug">
</form>

<!-- Pass data to JavaScript -->
<script>
window.resumeData = <?php echo json_encode($data); ?>;
window.currentStep = <?php echo $current_step; ?>;
window.activeTheme = <?php echo json_encode($activeTheme); ?>;
window.allThemes = <?php echo json_encode($allThemes); ?>;
window.previewScale = 0.85;
</script>

<!-- JavaScript for Real-time Updates -->
<script>
// Main preview update functions that call theme functions
function updatePreviewField(field, value) {
    // Show auto-save status
    showAutoSaveStatus('Updating...');
    
    // Update the data object
    if (window.resumeData.personal) {
        window.resumeData.personal[field] = value;
    }
    
    // Call the theme's update function if available
    if (typeof window.updatePreview === 'function') {
        window.updatePreview(field, value);
    } else {
        // Fallback to basic update
        const element = document.getElementById(`preview-${field}`);
        if (element) {
            element.textContent = value || getDefaultValue(field);
            element.classList.add('updated');
            setTimeout(() => element.classList.remove('updated'), 1500);
        }
    }
}

function updateWorkExperiencePreview(index, field, value) {
    showAutoSaveStatus('Updating experience...');
    
    // Update data object
    if (!window.resumeData.workExperience[index]) {
        window.resumeData.workExperience[index] = {};
    }
    window.resumeData.workExperience[index][field] = value;
    
    if (typeof window.updateWorkExperience === 'function') {
        window.updateWorkExperience(index, field, value);
    }
}

function updateEducationPreview(index, field, value) {
    showAutoSaveStatus('Updating education...');
    
    // Update data object
    if (!window.resumeData.education[index]) {
        window.resumeData.education[index] = {};
    }
    window.resumeData.education[index][field] = value;
    
    if (typeof window.updateEducation === 'function') {
        window.updateEducation(index, field, value);
    }
}

function updateSkillPreview(index, field, value) {
    showAutoSaveStatus('Updating skills...');
    
    // Update data object
    if (!window.resumeData.skills[index]) {
        window.resumeData.skills[index] = {};
    }
    window.resumeData.skills[index][field] = value;
    
    if (typeof window.updateSkill === 'function') {
        window.updateSkill(index, field, value);
    }
}

// Profile picture handling
function handleProfilePictureUpload(input) {
    const preview = document.getElementById('profile-picture-preview');
    const container = document.getElementById('profile-picture-container');
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
            document.getElementById('remove_picture').value = '0';
            
            // Update data and preview
            window.resumeData.personal.profilePicture = e.target.result;
            
            if (typeof window.updateProfilePicture === 'function') {
                window.updateProfilePicture(e.target.result);
            }
            showAutoSaveStatus('Profile picture updated');
        }
        
        reader.readAsDataURL(file);
    }
}

function removeProfilePicture() {
    const preview = document.getElementById('profile-picture-preview');
    const container = document.getElementById('profile-picture-container');
    const fileInput = document.getElementById('profilePicture');
    const removeInput = document.getElementById('remove_picture');
    
    fileInput.value = '';
    preview.src = '<?php echo BASE_URL; ?>assets/images/default-profile.png';
    container.style.display = 'block';
    removeInput.value = '1';
    
    // Update data and preview
    window.resumeData.personal.profilePicture = preview.src;
    
    if (typeof window.updateProfilePicture === 'function') {
        window.updateProfilePicture('');
    }
    showAutoSaveStatus('Profile picture removed');
}

// Helper functions
function getDefaultValue(field) {
    const defaults = {
        'fullName': 'Your Name',
        'jobTitle': 'Job Title',
        'email': 'email@example.com',
        'phone': '(123) 456-7890',
        'address': 'City, State',
        'profileSummary': ''
    };
    return defaults[field] || '';
}

function showAutoSaveStatus(text) {
    const statusEl = document.getElementById('autoSaveStatus');
    const textEl = document.getElementById('autoSaveText');
    
    if (statusEl) {
        statusEl.textContent = text;
        statusEl.className = 'auto-save-status saving';
        
        // Clear after 2 seconds
        setTimeout(() => {
            statusEl.textContent = '';
            statusEl.className = 'auto-save-status';
            if (textEl) textEl.textContent = 'Auto-saved just now';
        }, 2000);
    }
}

// Step navigation with theme preservation
function goToStep(step) {
    const theme = window.activeTheme?.slug || '<?php echo htmlspecialchars($activeTheme["slug"]); ?>';
    window.location.href = '<?php echo BASE_URL; ?>?page=builder&theme=' + encodeURIComponent(theme) + '&step=' + step;
}

function nextStep() {
    const current = parseInt(document.getElementById('current_step').value);
    if (current < 5) {
        goToStep(current + 1);
    }
}

function prevStep() {
    const current = parseInt(document.getElementById('current_step').value);
    if (current > 1) {
        goToStep(current - 1);
    }
}

function showPreview() {
    goToStep(5);
}

// Theme switching
function switchTheme(themeSlug) {
    if (themeSlug === window.activeTheme.slug) return;
    
    showAutoSaveStatus('Switching theme...');
    
    // Update the hidden form and submit
    document.getElementById('switch_theme_slug').value = themeSlug;
    document.getElementById('theme-switcher-form').submit();
}

// Preview controls
function togglePreviewScale() {
    const preview = document.querySelector('.resume-preview .resume-container');
    if (preview) {
        window.previewScale = window.previewScale === 0.85 ? 1 : 0.85;
        preview.style.transform = `scale(${window.previewScale})`;
        preview.style.transformOrigin = 'top center';
        preview.style.width = `${100 / window.previewScale}%`;
        
        // Show notification
        const scaleText = window.previewScale === 1 ? 'Normal' : 'Zoomed';
        showAutoSaveStatus(`Preview: ${scaleText}`);
    }
}

function refreshPreview() {
    const previewContainer = document.getElementById('livePreview');
    if (previewContainer) {
        // Add loading animation
        previewContainer.style.opacity = '0.5';
        
        // Reload the preview after a short delay
        setTimeout(() => {
            previewContainer.style.opacity = '1';
            // In a real implementation, you might want to re-render the template
            // For now, we'll just reload the page to get fresh template
            window.location.reload();
        }, 300);
        
        showAutoSaveStatus('Refreshing preview...');
    }
}

// Dynamic form fields
document.addEventListener('DOMContentLoaded', function() {
    // Initialize theme switcher dropdown
    const themeButton = document.getElementById('themeSwitchButton');
    const themeDropdown = document.getElementById('themeDropdown');
    
    if (themeButton && themeDropdown) {
        themeButton.addEventListener('click', function(e) {
            e.stopPropagation();
            themeDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            themeDropdown.classList.remove('show');
        });
        
        // Handle theme selection
        themeDropdown.querySelectorAll('.theme-option').forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const themeSlug = this.getAttribute('data-theme-slug');
                switchTheme(themeSlug);
            });
        });
    }
    
    // Add Work Experience
    let workCount = <?php echo count($data['workExperience']); ?>;
    document.getElementById('add-work-experience')?.addEventListener('click', function() {
        const container = document.getElementById('work-experience-items');
        const index = workCount++;
        
        const html = `
            <div class="form-item" data-index="${index}">
                <div class="form-item-header">
                    <h4>Work Experience #${index + 1}</h4>
                    <button type="button" class="btn-danger btn-sm remove-item">Remove</button>
                </div>
                <div class="form-group">
                    <label for="company_${index}">Company *</label>
                    <input type="text" id="company_${index}" name="company[]" placeholder="TechCorp Inc." oninput="updateWorkExperiencePreview(${index}, 'company', this.value)">
                </div>
                <div class="form-group">
                    <label for="job_role_${index}">Job Title *</label>
                    <input type="text" id="job_role_${index}" name="job_role[]" placeholder="Software Engineer" oninput="updateWorkExperiencePreview(${index}, 'job_role', this.value)">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_date_${index}">Start Date *</label>
                        <input type="text" id="start_date_${index}" name="start_date[]" placeholder="Jan 2020" oninput="updateWorkExperiencePreview(${index}, 'start_date', this.value)">
                    </div>
                    <div class="form-group">
                        <label for="end_date_${index}">End Date</label>
                        <input type="text" id="end_date_${index}" name="end_date[]" placeholder="Present" oninput="updateWorkExperiencePreview(${index}, 'end_date', this.value)">
                    </div>
                </div>
                <div class="form-group">
                    <label for="responsibilities_${index}">Responsibilities & Achievements</label>
                    <textarea id="responsibilities_${index}" name="responsibilities[]" rows="4" placeholder="Describe your key responsibilities and achievements..." oninput="updateWorkExperiencePreview(${index}, 'responsibilities', this.value)"></textarea>
                    <div class="form-help">Use bullet points for better readability</div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', html);
        showAutoSaveStatus('Added new work experience');
    });
    
    // Add Education
    let eduCount = <?php echo count($data['education']); ?>;
    document.getElementById('add-education')?.addEventListener('click', function() {
        const container = document.getElementById('education-items');
        const index = eduCount++;
        
        const html = `
            <div class="form-item" data-index="${index}">
                <div class="form-item-header">
                    <h4>Education #${index + 1}</h4>
                    <button type="button" class="btn-danger btn-sm remove-item">Remove</button>
                </div>
                <div class="form-group">
                    <label for="degree_${index}">Degree *</label>
                    <input type="text" id="degree_${index}" name="degree[]" placeholder="Bachelor of Science in Computer Science" oninput="updateEducationPreview(${index}, 'degree', this.value)">
                </div>
                <div class="form-group">
                    <label for="institute_${index}">Institution *</label>
                    <input type="text" id="institute_${index}" name="institute[]" placeholder="Stanford University" oninput="updateEducationPreview(${index}, 'institute', this.value)">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_year_${index}">Start Year</label>
                        <input type="text" id="start_year_${index}" name="start_year[]" placeholder="2016" oninput="updateEducationPreview(${index}, 'start_year', this.value)">
                    </div>
                    <div class="form-group">
                        <label for="end_year_${index}">End Year</label>
                        <input type="text" id="end_year_${index}" name="end_year[]" placeholder="2020" oninput="updateEducationPreview(${index}, 'end_year', this.value)">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cgpa_${index}">CGPA/Grade</label>
                    <input type="text" id="cgpa_${index}" name="cgpa[]" placeholder="3.8/4.0" oninput="updateEducationPreview(${index}, 'cgpa', this.value)">
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', html);
        showAutoSaveStatus('Added new education');
    });
    
    // Add Skill
    let skillCount = <?php echo count($data['skills']); ?>;
    document.getElementById('add-skill')?.addEventListener('click', function() {
        const container = document.getElementById('skills-items');
        const index = skillCount++;
        
        const html = `
            <div class="form-item" data-index="${index}">
                <div class="form-item-header">
                    <h4>Skill #${index + 1}</h4>
                    <button type="button" class="btn-danger btn-sm remove-item">Remove</button>
                </div>
                <div class="form-group">
                    <label for="skill_name_${index}">Skill Name *</label>
                    <input type="text" id="skill_name_${index}" name="skill_name[]" placeholder="JavaScript" oninput="updateSkillPreview(${index}, 'skillName', this.value)">
                </div>
                <div class="form-group">
                    <label for="skill_level_${index}">Skill Level</label>
                    <select id="skill_level_${index}" name="skill_level[]" onchange="updateSkillPreview(${index}, 'level', this.value)">
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate" selected>Intermediate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Expert">Expert</option>
                    </select>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', html);
        showAutoSaveStatus('Added new skill');
    });
    
    // Remove items
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            const item = e.target.closest('.form-item');
            const index = item.dataset.index;
            
            // Check if this is a skill item
            if (item.closest('#skills-items')) {
                if (typeof window.removeSkill === 'function') {
                    window.removeSkill(index);
                }
            }
            
            item.remove();
            showAutoSaveStatus('Item removed');
        }
    });
    
    // Auto-save on input with debounce
    let autoSaveTimeout;
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                showAutoSaveStatus('Auto-saving...');
            }, 1000);
        });
    });
    
    // Initialize preview scaling
    setTimeout(() => {
        const preview = document.querySelector('.resume-preview .resume-container');
        if (preview) {
            preview.style.transform = `scale(${window.previewScale})`;
            preview.style.transformOrigin = 'top center';
            preview.style.width = `${100 / window.previewScale}%`;
        }
    }, 100);
});

// Auto-save simulation
setInterval(() => {
    const saveIndicator = document.querySelector('.fa-sync-alt');
    if (saveIndicator) {
        saveIndicator.style.transform = 'rotate(360deg)';
        saveIndicator.style.transition = 'transform 0.5s ease';
        
        setTimeout(() => {
            saveIndicator.style.transform = 'rotate(0deg)';
        }, 500);
    }
}, 30000);
</script>

<style>
/* ================= THEME INFO BAR ================= */
.theme-info-bar {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid var(--border-color);
    padding: 12px 0;
}

.theme-info-content {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.theme-icon {
    font-size: 24px;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.theme-details {
    flex: 1;
    min-width: 200px;
}

.theme-details h4 {
    margin: 0 0 4px 0;
    font-size: 16px;
    color: var(--dark);
}

.theme-details p {
    margin: 0;
    font-size: 13px;
    color: var(--medium-gray);
    line-height: 1.4;
}

.premium-badge {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
}

.premium-badge i {
    font-size: 10px;
}

/* Theme Switcher Dropdown */
.theme-switcher-dropdown {
    position: relative;
}

.btn-theme-switch {
    background: var(--primary);
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
    border: none;
    cursor: pointer;
}

.btn-theme-switch:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow);
}

.btn-theme-switch i.fa-chevron-down {
    font-size: 10px;
    transition: transform 0.3s ease;
}

.theme-dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    box-shadow: var(--shadow-lg);
    min-width: 250px;
    max-height: 400px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
    margin-top: 5px;
}

.theme-dropdown-menu.show {
    display: block;
}

.theme-option {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid var(--light-gray);
    text-decoration: none;
    color: var(--dark);
    transition: var(--transition);
}

.theme-option:hover {
    background: var(--light);
}

.theme-option.active {
    background: rgba(67, 97, 238, 0.1);
    border-left: 3px solid var(--primary);
}

.theme-option-icon {
    font-size: 20px;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

.theme-option-name {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
}

.theme-option-premium {
    background: #fef08a;
    color: #854d0e;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 600;
}

.theme-warning {
    margin-top: 8px;
    padding: 8px 12px;
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 6px;
    color: #856404;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.theme-warning i {
    color: #f59e0b;
}

/* Theme badge in preview */
.theme-badge {
    font-size: 12px;
    font-weight: 600;
    color: var(--primary);
    background: rgba(67, 97, 238, 0.1);
    padding: 4px 10px;
    border-radius: 20px;
}

.theme-info {
    font-size: 12px;
    color: var(--medium-gray);
    margin-left: 12px;
}

/* Theme error state */
.theme-error {
    padding: 40px;
    text-align: center;
    background: #f8f9fa;
    border-radius: 8px;
    border: 2px dashed var(--border-color);
}

.theme-error h4 {
    color: var(--danger);
    margin-bottom: 12px;
}

.theme-error p {
    color: var(--medium-gray);
}

/* ================= EXISTING STYLES ================= */
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
    --border-color: #dee2e6;
    --border-radius: 8px;
    --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
    --transition: all 0.3s ease;
}

/* Alert */
.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 16px;
    border-radius: 8px;
    margin: 20px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success i {
    color: #28a745;
}

/* Builder Container */
.builder-container {
    display: flex;
    gap: 30px;
    margin-top: 30px;
    flex-direction: column;
}

@media (min-width: 992px) {
    .builder-container {
        flex-direction: row;
    }
}

.builder-form-container {
    flex: 1;
    background: white;
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow);
}

.preview-container {
    flex: 1;
    background: white;
    border-radius: var(--border-radius);
    padding: 0;
    box-shadow: var(--shadow);
    position: sticky;
    top: 100px;
    max-height: calc(100vh - 120px);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.preview-header {
    padding: 20px 30px;
    border-bottom: 1px solid var(--light-gray);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.preview-header h3 {
    margin: 0;
    padding: 0;
    border: none;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.preview-controls {
    display: flex;
    gap: 8px;
}

.btn-preview-control {
    background: var(--light);
    border: 1px solid var(--border-color);
    border-radius: 4px;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--medium-gray);
    transition: var(--transition);
}

.btn-preview-control:hover {
    background: var(--light-gray);
    color: var(--primary);
}

.resume-preview-wrapper {
    flex: 1;
    overflow: auto;
    padding: 20px;
}

.resume-preview {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    min-height: 100%;
}

.resume-preview:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.step-indicator {
    font-size: 12px;
    font-weight: 600;
    color: var(--primary);
    background: rgba(67, 97, 238, 0.1);
    padding: 4px 10px;
    border-radius: 20px;
}

.auto-save-status {
    font-size: 12px;
    font-weight: normal;
    color: var(--medium-gray);
}

.auto-save-status.saving {
    color: var(--success);
    font-weight: 600;
}

/* Progress Stepper */
.progress-stepper {
    display: flex;
    justify-content: space-between;
    margin-bottom: 40px;
    position: relative;
}

.progress-stepper::before {
    content: '';
    position: absolute;
    top: 15px;
    left: 0;
    right: 0;
    height: 2px;
    background-color: var(--light-gray);
    z-index: 1;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
    cursor: pointer;
    transition: var(--transition);
}

.step:hover {
    transform: translateY(-2px);
}

.step:hover .step-number {
    box-shadow: var(--shadow);
}

.step-number {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: white;
    border: 2px solid var(--light-gray);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-bottom: 8px;
    transition: var(--transition);
}

.step.active .step-number {
    background-color: var(--primary);
    border-color: var(--primary);
    color: white;
}

.step.completed .step-number {
    background-color: var(--success);
    border-color: var(--success);
    color: white;
}

.step-label {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--medium-gray);
}

.step.active .step-label {
    color: var(--primary);
    font-weight: 600;
}

/* Form Steps */
.form-step {
    display: none;
}

.form-step.active {
    display: block;
}

.form-step h3 {
    color: var(--primary);
    margin-bottom: 8px;
    font-size: 1.5rem;
}

.form-step p {
    color: var(--dark-gray);
    margin-bottom: 24px;
}

/* Form Elements */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--dark);
    font-size: 14px;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 12px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    transition: var(--transition);
    background: white;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
}

.form-help {
    font-size: 12px;
    color: var(--medium-gray);
    margin-top: 6px;
}

/* Form Items */
.form-item {
    margin-bottom: 24px;
    padding: 20px;
    background: var(--light);
    border-radius: var(--border-radius);
    border: 1px solid var(--border-color);
    transition: var(--transition);
}

.form-item:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    border-color: var(--primary);
}

.form-item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border-color);
}

.form-item-header h4 {
    margin: 0;
    color: var(--primary);
    font-weight: 600;
    font-size: 16px;
}

/* Drag & Drop */
.drag-container {
    border: 2px dashed var(--light-gray);
    border-radius: var(--border-radius);
    padding: 30px;
    text-align: center;
    margin-bottom: 20px;
    transition: var(--transition);
    cursor: pointer;
}

.drag-container:hover {
    border-color: var(--primary);
    background-color: rgba(67, 97, 238, 0.05);
}

.drag-container i {
    font-size: 2.5rem;
    color: var(--medium-gray);
    margin-bottom: 15px;
}

.drag-container h4 {
    margin-bottom: 8px;
    color: var(--dark);
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.final-save-section {
    margin-top: 40px;
    padding: 30px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: var(--border-radius);
    text-align: center;
    border: 2px dashed var(--primary);
}

.final-save-section .form-actions {
    justify-content: center;
    gap: 20px;
    border-top: none;
    margin-top: 0;
    padding-top: 0;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: var(--border-radius);
    font-weight: 600;
    font-size: 14px;
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

.btn-success {
    background-color: var(--success);
    color: white;
}

.btn-success:hover {
    background-color: #3d9a37;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(75, 181, 67, 0.3);
}

.btn-danger {
    background-color: var(--danger);
    color: white;
    padding: 8px 16px;
    font-size: 12px;
}

.btn-danger:hover {
    background-color: #c82333;
}

.btn-sm {
    padding: 8px 16px;
    font-size: 12px;
}

.btn-lg {
    padding: 15px 30px;
    font-size: 16px;
}

/* Preview Actions */
.preview-actions {
    padding: 20px 30px;
    border-top: 1px solid var(--light-gray);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.auto-save-info {
    font-size: 14px;
    color: var(--medium-gray);
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.auto-save-info i {
    color: var(--success);
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.preview-buttons {
    display: flex;
    gap: 12px;
}

/* Section Title */
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

/* Section */
.section {
    padding: 80px 0;
}

@media (max-width: 768px) {
    .section {
        padding: 60px 0;
    }
    
    .preview-actions {
        flex-direction: column;
        gap: 16px;
        align-items: stretch;
    }
    
    .preview-buttons {
        flex-direction: column;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 12px;
    }
    
    .form-actions .btn {
        width: 100%;
        text-align: center;
    }
    
    .final-save-section .form-actions {
        flex-direction: column;
    }
    
    .preview-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .preview-controls {
        align-self: flex-end;
    }
    
    .theme-info-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .theme-details {
        min-width: 100%;
    }
    
    .theme-switcher-dropdown {
        width: 100%;
    }
    
    .btn-theme-switch {
        width: 100%;
        justify-content: center;
    }
    
    .theme-dropdown-menu {
        position: relative;
        right: auto;
        left: 0;
        width: 100%;
    }
}

/* Animation for real-time updates */
@keyframes highlight {
    0% { background-color: rgba(67, 97, 238, 0.2); }
    100% { background-color: transparent; }
}

.updated {
    animation: highlight 1.5s ease;
}

/* Responsive adjustments for theme bar */
@media (max-width: 576px) {
    .theme-info-bar {
        padding: 16px 0;
    }
    
    .theme-info-content {
        gap: 12px;
    }
    
    .btn-theme-switch {
        width: 100%;
        justify-content: center;
    }
}
</style>