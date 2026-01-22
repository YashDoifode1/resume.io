<?php
/**
 * Resume Builder - Updated to match design with progress stepper and live preview
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
                    $data['personal']['profilePicture'] = BASE_URL . 'uploads/' . $newFileName;
                    $data['personal']['profilePicturePath'] = $uploadPath;
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
<div class="alert-success" style="margin: 20px 0; padding: 16px; border-radius: 8px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
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
                    <div class="step completed">
                        <div class="step-number">1</div>
                        <div class="step-label">Personal</div>
                    </div>
                    <div class="step active">
                        <div class="step-number">2</div>
                        <div class="step-label">Experience</div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-label">Education</div>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <div class="step-label">Skills</div>
                    </div>
                    <div class="step">
                        <div class="step-number">5</div>
                        <div class="step-label">Theme</div>
                    </div>
                </div>
                
                <!-- Form -->
                <form id="resume-builder-form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="save_all">
                    
                    <!-- Personal Information (Step 1) -->
                    <div class="form-step active" id="step1">
                        <h3>Personal Information</h3>
                        <p>Let's start with your basic information.</p>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fullName">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" 
                                       value="<?php echo htmlspecialchars($data['personal']['fullName']); ?>" 
                                       required placeholder="John Doe">
                            </div>
                            <div class="form-group">
                                <label for="jobTitle">Job Title *</label>
                                <input type="text" id="jobTitle" name="jobTitle" 
                                       value="<?php echo htmlspecialchars($data['personal']['jobTitle']); ?>" 
                                       required placeholder="Software Engineer">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="profileSummary">Professional Summary</label>
                            <textarea id="profileSummary" name="profileSummary" rows="4" 
                                      placeholder="Brief summary of your professional background and goals..."><?php echo htmlspecialchars($data['personal']['profileSummary']); ?></textarea>
                            <div class="form-help">Write a brief summary of your professional background and goals</div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($data['personal']['email']); ?>" 
                                       required placeholder="john.doe@example.com">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone *</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($data['personal']['phone']); ?>" 
                                       required placeholder="(123) 456-7890">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="linkedin">LinkedIn Profile</label>
                                <input type="url" id="linkedin" name="linkedin" 
                                       value="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>" 
                                       placeholder="https://linkedin.com/in/johndoe">
                            </div>
                            <div class="form-group">
                                <label for="github">GitHub Profile</label>
                                <input type="url" id="github" name="github" 
                                       value="<?php echo htmlspecialchars($data['personal']['github']); ?>" 
                                       placeholder="https://github.com/johndoe">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" 
                                   value="<?php echo htmlspecialchars($data['personal']['address']); ?>" 
                                   placeholder="New York, NY">
                        </div>
                        
                        <div class="form-group">
                            <label for="website">Website/Portfolio</label>
                            <input type="url" id="website" name="website" 
                                   value="<?php echo htmlspecialchars($data['personal']['website']); ?>" 
                                   placeholder="https://johndoe.com">
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
                                   style="display: none;" onchange="previewImage(this)">
                            
                            <!-- Profile Picture Preview -->
                            <div id="profile-picture-container" style="margin-top: 12px; display: <?php echo !empty($data['personal']['profilePicture']) && strpos($data['personal']['profilePicture'], 'default-profile.png') === false ? 'block' : 'none'; ?>;">
                                <?php 
                                $profilePic = $data['personal']['profilePicture'];
                                $isDefault = strpos($profilePic, 'default-profile.png') !== false;
                                ?>
                                <img id="profile-picture-preview" 
                                     src="<?php echo $isDefault ? BASE_URL . 'assets/images/default-profile.png' : htmlspecialchars($profilePic); ?>" 
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
                            <button type="button" class="btn-secondary" onclick="nextStep(2)">Next: Experience</button>
                        </div>
                    </div>
                    
                    <!-- Work Experience (Step 2) -->
                    <div class="form-step" id="step2">
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
                                    <input type="text" id="company_0" name="company[]" placeholder="TechCorp Inc.">
                                </div>
                                <div class="form-group">
                                    <label for="job_role_0">Job Title *</label>
                                    <input type="text" id="job_role_0" name="job_role[]" placeholder="Software Engineer">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="start_date_0">Start Date *</label>
                                        <input type="text" id="start_date_0" name="start_date[]" placeholder="Jan 2020">
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date_0">End Date</label>
                                        <input type="text" id="end_date_0" name="end_date[]" placeholder="Present">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="responsibilities_0">Responsibilities & Achievements</label>
                                    <textarea id="responsibilities_0" name="responsibilities[]" rows="4" placeholder="Describe your key responsibilities and achievements..."></textarea>
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
                                               placeholder="TechCorp Inc.">
                                    </div>
                                    <div class="form-group">
                                        <label for="job_role_<?php echo $index; ?>">Job Title *</label>
                                        <input type="text" id="job_role_<?php echo $index; ?>" name="job_role[]" 
                                               value="<?php echo htmlspecialchars($work['job_role']); ?>" 
                                               placeholder="Software Engineer">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="start_date_<?php echo $index; ?>">Start Date *</label>
                                            <input type="text" id="start_date_<?php echo $index; ?>" name="start_date[]" 
                                                   value="<?php echo htmlspecialchars($work['start_date']); ?>" 
                                                   placeholder="Jan 2020">
                                        </div>
                                        <div class="form-group">
                                            <label for="end_date_<?php echo $index; ?>">End Date</label>
                                            <input type="text" id="end_date_<?php echo $index; ?>" name="end_date[]" 
                                                   value="<?php echo htmlspecialchars($work['end_date']); ?>" 
                                                   placeholder="Present">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="responsibilities_<?php echo $index; ?>">Responsibilities & Achievements</label>
                                        <textarea id="responsibilities_<?php echo $index; ?>" name="responsibilities[]" 
                                                  rows="4" placeholder="Describe your key responsibilities and achievements..."><?php echo htmlspecialchars($work['responsibilities']); ?></textarea>
                                        <div class="form-help">Use bullet points for better readability</div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <button type="button" id="add-work-experience" class="btn-primary">
                            <i class="fas fa-plus"></i> Add Work Experience
                        </button>
                        
                        <div class="drag-container">
                            <i class="fas fa-grip-vertical"></i>
                            <h4>Drag & Drop Sections</h4>
                            <p>Drag sections to reorder your resume content</p>
                        </div>
                        
                        <!-- Draggable Sections -->
                        <div class="draggable-section">
                            <div>
                                <h4>Work Experience</h4>
                                <p>Drag to reorder sections</p>
                            </div>
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        
                        <div class="draggable-section">
                            <div>
                                <h4>Education</h4>
                                <p>Drag to reorder sections</p>
                            </div>
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        
                        <div class="draggable-section">
                            <div>
                                <h4>Skills</h4>
                                <p>Drag to reorder sections</p>
                            </div>
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="prevStep(1)">Previous</button>
                            <button type="button" class="btn-primary" onclick="nextStep(3)">Next: Education</button>
                        </div>
                    </div>
                    
                    <!-- Education (Step 3) -->
                    <div class="form-step" id="step3">
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
                                    <input type="text" id="degree_0" name="degree[]" placeholder="Bachelor of Science in Computer Science">
                                </div>
                                <div class="form-group">
                                    <label for="institute_0">Institution *</label>
                                    <input type="text" id="institute_0" name="institute[]" placeholder="Stanford University">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="start_year_0">Start Year</label>
                                        <input type="text" id="start_year_0" name="start_year[]" placeholder="2016">
                                    </div>
                                    <div class="form-group">
                                        <label for="end_year_0">End Year</label>
                                        <input type="text" id="end_year_0" name="end_year[]" placeholder="2020">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cgpa_0">CGPA/Grade</label>
                                    <input type="text" id="cgpa_0" name="cgpa[]" placeholder="3.8/4.0">
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
                                               placeholder="Bachelor of Science in Computer Science">
                                    </div>
                                    <div class="form-group">
                                        <label for="institute_<?php echo $index; ?>">Institution *</label>
                                        <input type="text" id="institute_<?php echo $index; ?>" name="institute[]" 
                                               value="<?php echo htmlspecialchars($edu['institute']); ?>" 
                                               placeholder="Stanford University">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="start_year_<?php echo $index; ?>">Start Year</label>
                                            <input type="text" id="start_year_<?php echo $index; ?>" name="start_year[]" 
                                                   value="<?php echo htmlspecialchars($edu['start_year']); ?>" 
                                                   placeholder="2016">
                                        </div>
                                        <div class="form-group">
                                            <label for="end_year_<?php echo $index; ?>">End Year</label>
                                            <input type="text" id="end_year_<?php echo $index; ?>" name="end_year[]" 
                                                   value="<?php echo htmlspecialchars($edu['end_year']); ?>" 
                                                   placeholder="2020">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cgpa_<?php echo $index; ?>">CGPA/Grade</label>
                                        <input type="text" id="cgpa_<?php echo $index; ?>" name="cgpa[]" 
                                               value="<?php echo htmlspecialchars($edu['cgpa']); ?>" 
                                               placeholder="3.8/4.0">
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <button type="button" id="add-education" class="btn-primary">
                            <i class="fas fa-plus"></i> Add Education
                        </button>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="prevStep(2)">Previous</button>
                            <button type="button" class="btn-primary" onclick="nextStep(4)">Next: Skills</button>
                        </div>
                    </div>
                    
                    <!-- Skills (Step 4) -->
                    <div class="form-step" id="step4">
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
                                    <input type="text" id="skill_name_0" name="skill_name[]" placeholder="JavaScript">
                                </div>
                                <div class="form-group">
                                    <label for="skill_level_0">Skill Level</label>
                                    <select id="skill_level_0" name="skill_level[]">
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
                                               placeholder="JavaScript">
                                    </div>
                                    <div class="form-group">
                                        <label for="skill_level_<?php echo $index; ?>">Skill Level</label>
                                        <select id="skill_level_<?php echo $index; ?>" name="skill_level[]">
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
                            <button type="button" class="btn-secondary" onclick="prevStep(3)">Previous</button>
                            <button type="submit" class="btn-success">Save All & Continue</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Right: Live Preview -->
            <div class="preview-container">
                <h3>Live Preview</h3>
                <div class="resume-preview">
                    <!-- Resume Preview Content -->
                    <div class="resume-header">
                        <div>
                            <div class="resume-name"><?php echo !empty($data['personal']['fullName']) ? htmlspecialchars($data['personal']['fullName']) : 'Your Name'; ?></div>
                            <div class="resume-title"><?php echo !empty($data['personal']['jobTitle']) ? htmlspecialchars($data['personal']['jobTitle']) : 'Job Title'; ?></div>
                        </div>
                        <div class="resume-contact">
                            <?php if (!empty($data['personal']['email'])): ?>
                                <div><?php echo htmlspecialchars($data['personal']['email']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($data['personal']['phone'])): ?>
                                <div><?php echo htmlspecialchars($data['personal']['phone']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($data['personal']['address'])): ?>
                                <div><?php echo htmlspecialchars($data['personal']['address']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if (!empty($data['personal']['profileSummary'])): ?>
                    <div class="resume-section">
                        <div class="resume-section-title">Professional Summary</div>
                        <p><?php echo htmlspecialchars($data['personal']['profileSummary']); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['workExperience'])): ?>
                    <div class="resume-section">
                        <div class="resume-section-title">Work Experience</div>
                        <?php foreach ($data['workExperience'] as $work): ?>
                        <div class="resume-item">
                            <div class="resume-item-title"><?php echo htmlspecialchars($work['job_role']); ?></div>
                            <div class="resume-item-subtitle"><?php echo htmlspecialchars($work['company']); ?></div>
                            <div class="resume-item-date"><?php echo htmlspecialchars($work['start_date']); ?> - <?php echo htmlspecialchars($work['end_date']); ?></div>
                            <p><?php echo nl2br(htmlspecialchars($work['responsibilities'])); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['education'])): ?>
                    <div class="resume-section">
                        <div class="resume-section-title">Education</div>
                        <?php foreach ($data['education'] as $edu): ?>
                        <div class="resume-item">
                            <div class="resume-item-title"><?php echo htmlspecialchars($edu['degree']); ?></div>
                            <div class="resume-item-subtitle"><?php echo htmlspecialchars($edu['institute']); ?></div>
                            <div class="resume-item-date"><?php echo htmlspecialchars($edu['start_year']); ?> - <?php echo htmlspecialchars($edu['end_year']); ?></div>
                            <?php if (!empty($edu['cgpa'])): ?>
                                <p>CGPA: <?php echo htmlspecialchars($edu['cgpa']); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['skills'])): ?>
                    <div class="resume-section">
                        <div class="resume-section-title">Skills</div>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <?php foreach ($data['skills'] as $skill): ?>
                            <span style="background: #f0f4ff; color: var(--primary); padding: 4px 12px; border-radius: 20px; font-size: 14px;">
                                <?php echo htmlspecialchars($skill['skillName']); ?>
                                <?php if ($skill['level'] !== 'Intermediate'): ?>
                                    <span style="font-size: 12px; color: var(--dark-gray);">(<?php echo $skill['level']; ?>)</span>
                                <?php endif; ?>
                            </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="mt-3">
                    <p style="font-size: 0.9rem; color: var(--medium-gray); text-align: center;">
                        <i class="fas fa-sync-alt"></i> Auto-saved just now
                    </p>
                </div>
                
                <div style="margin-top: 24px; text-align: center;">
                    <a href="<?php echo BASE_URL; ?>?page=preview" class="btn-primary" style="display: inline-block; padding: 12px 24px;">
                        <i class="fas fa-eye"></i> Full Preview
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PASS DATA TO JS -->
<script>
    window.resumeData = <?php echo json_encode($data); ?>;
    window.currentStep = 2;
</script>

<!-- Builder JavaScript -->
<script>
// Step Navigation
function nextStep(step) {
    document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
    document.getElementById('step' + step).classList.add('active');
    
    document.querySelectorAll('.step').forEach((el, index) => {
        el.classList.remove('active');
        if (index + 1 === step) {
            el.classList.add('active');
        } else if (index + 1 < step) {
            el.classList.add('completed');
        }
    });
}

function prevStep(step) {
    document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
    document.getElementById('step' + step).classList.add('active');
    
    document.querySelectorAll('.step').forEach((el, index) => {
        el.classList.remove('active');
        if (index + 1 === step) {
            el.classList.add('active');
        } else if (index + 1 > step) {
            el.classList.remove('completed');
        }
    });
}

// Dynamic Form Fields
document.addEventListener('DOMContentLoaded', function() {
    // Add Work Experience
    let workCount = <?php echo count($data['workExperience']); ?>;
    document.getElementById('add-work-experience').addEventListener('click', function() {
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
                    <input type="text" id="company_${index}" name="company[]" placeholder="TechCorp Inc.">
                </div>
                <div class="form-group">
                    <label for="job_role_${index}">Job Title *</label>
                    <input type="text" id="job_role_${index}" name="job_role[]" placeholder="Software Engineer">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_date_${index}">Start Date *</label>
                        <input type="text" id="start_date_${index}" name="start_date[]" placeholder="Jan 2020">
                    </div>
                    <div class="form-group">
                        <label for="end_date_${index}">End Date</label>
                        <input type="text" id="end_date_${index}" name="end_date[]" placeholder="Present">
                    </div>
                </div>
                <div class="form-group">
                    <label for="responsibilities_${index}">Responsibilities & Achievements</label>
                    <textarea id="responsibilities_${index}" name="responsibilities[]" rows="4" placeholder="Describe your key responsibilities and achievements..."></textarea>
                    <div class="form-help">Use bullet points for better readability</div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', html);
    });
    
    // Add Education
    let eduCount = <?php echo count($data['education']); ?>;
    document.getElementById('add-education').addEventListener('click', function() {
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
                    <input type="text" id="degree_${index}" name="degree[]" placeholder="Bachelor of Science in Computer Science">
                </div>
                <div class="form-group">
                    <label for="institute_${index}">Institution *</label>
                    <input type="text" id="institute_${index}" name="institute[]" placeholder="Stanford University">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_year_${index}">Start Year</label>
                        <input type="text" id="start_year_${index}" name="start_year[]" placeholder="2016">
                    </div>
                    <div class="form-group">
                        <label for="end_year_${index}">End Year</label>
                        <input type="text" id="end_year_${index}" name="end_year[]" placeholder="2020">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cgpa_${index}">CGPA/Grade</label>
                    <input type="text" id="cgpa_${index}" name="cgpa[]" placeholder="3.8/4.0">
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', html);
    });
    
    // Add Skill
    let skillCount = <?php echo count($data['skills']); ?>;
    document.getElementById('add-skill').addEventListener('click', function() {
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
                    <input type="text" id="skill_name_${index}" name="skill_name[]" placeholder="JavaScript">
                </div>
                <div class="form-group">
                    <label for="skill_level_${index}">Skill Level</label>
                    <select id="skill_level_${index}" name="skill_level[]">
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate" selected>Intermediate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Expert">Expert</option>
                    </select>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', html);
    });
    
    // Remove items
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.form-item').remove();
        }
    });
});

// Image Preview Functions
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
    
    fileInput.value = '';
    preview.src = '<?php echo BASE_URL; ?>assets/images/default-profile.png';
    container.style.display = 'block';
    removeInput.value = '1';
}

// Auto-save indicator
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

// Form auto-save
const form = document.getElementById('resume-builder-form');
const formInputs = form.querySelectorAll('input, textarea, select');
let autoSaveTimeout;

formInputs.forEach(input => {
    input.addEventListener('input', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            // Simulate auto-save
            console.log('Auto-saving...');
        }, 2000);
    });
});
</script>

<!-- Additional Styles for Builder -->
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
    --border-color: #dee2e6;
    --border-radius: 8px;
    --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
    --transition: all 0.3s ease;
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
    padding: 30px;
    box-shadow: var(--shadow);
    position: sticky;
    top: 100px;
    max-height: calc(100vh - 120px);
    overflow-y: auto;
}

.preview-container h3 {
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--light-gray);
}

.resume-preview {
    background: white;
    padding: 30px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    min-height: 400px;
    font-family: 'Inter', sans-serif;
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

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    transition: var(--transition);
}

.form-control:focus {
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

.draggable-section {
    background: var(--light);
    border-radius: var(--border-radius);
    padding: 15px;
    margin-bottom: 15px;
    cursor: move;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: var(--transition);
    border: 1px solid var(--border-color);
}

.draggable-section:hover {
    background: var(--light-gray);
    transform: translateX(5px);
}

.draggable-section h4 {
    margin: 0;
    font-size: 16px;
    color: var(--dark);
}

.draggable-section p {
    margin: 4px 0 0;
    font-size: 12px;
    color: var(--medium-gray);
}

.draggable-section i {
    color: var(--medium-gray);
    font-size: 1.2rem;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
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

/* Resume Preview Styles */
.resume-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid var(--primary);
    padding-bottom: 20px;
    margin-bottom: 25px;
}

.resume-name {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 4px;
}

.resume-title {
    font-size: 1.2rem;
    color: var(--dark-gray);
    font-weight: 500;
}

.resume-contact {
    text-align: right;
    font-size: 0.9rem;
    color: var(--dark-gray);
}

.resume-contact div {
    margin-bottom: 4px;
}

.resume-section {
    margin-bottom: 25px;
}

.resume-section-title {
    font-size: 1.3rem;
    color: var(--dark);
    border-bottom: 1px solid var(--light-gray);
    padding-bottom: 5px;
    margin-bottom: 15px;
    font-weight: 600;
}

.resume-item {
    margin-bottom: 15px;
}

.resume-item-title {
    font-weight: 600;
    font-size: 1.1rem;
    color: var(--dark);
    margin-bottom: 4px;
}

.resume-item-subtitle {
    font-weight: 500;
    color: var(--dark-gray);
    font-size: 0.95rem;
    margin-bottom: 4px;
}

.resume-item-date {
    color: var(--medium-gray);
    font-size: 0.9rem;
    margin-bottom: 8px;
}

/* Alert */
.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 16px;
    border-radius: 8px;
    margin: 20px 0;
}

/* Auto-save Indicator */
.fa-sync-alt {
    animation: spin 2s linear infinite;
    animation-play-state: paused;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
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
}
</style>