/**
 * Resume Builder - Form Handler
 * 
 * Handles dynamic form sections and data management
 * 
 * Note: SectionSaveManager is defined in main.js for global availability
 */

'use strict';

// ============================================
// Form Section Management
// ============================================

class FormSection {
    constructor(sectionName) {
        this.sectionName = sectionName;
        this.itemCount = 0;
    }

    addItem() {
        const container = document.getElementById(`${this.sectionName}-items`);
        if (!container) return;

        const itemId = `item-${this.sectionName}-${Date.now()}`;
        const itemHTML = this.getItemTemplate(itemId);
        
        const itemElement = document.createElement('div');
        itemElement.id = itemId;
        itemElement.className = 'form-item card';
        itemElement.innerHTML = itemHTML;
        
        container.appendChild(itemElement);
        this.itemCount++;
        
        // Add remove button listener
        const removeBtn = itemElement.querySelector('.btn-remove-item');
        if (removeBtn) {
            removeBtn.addEventListener('click', () => this.removeItem(itemId));
        }
    }

    removeItem(itemId) {
        const item = document.getElementById(itemId);
        if (item) {
            item.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => {
                item.remove();
                this.itemCount--;
            }, 300);
        }
    }

    getItemTemplate(itemId) {
        // Override in subclasses
        return '';
    }
}

// ============================================
// Work Experience Section
// ============================================

class WorkExperienceSection extends FormSection {
    constructor() {
        super('work-experience');
    }

    getItemTemplate(itemId) {
        return `
            <div class="form-item-header">
                <h4>Work Experience</h4>
                <button type="button" class="btn btn-danger btn-sm btn-remove-item">Remove</button>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="company-${itemId}">Company Name *</label>
                    <input type="text" id="company-${itemId}" name="company[]" required>
                </div>
                <div class="form-group">
                    <label for="job-role-${itemId}">Job Role *</label>
                    <input type="text" id="job-role-${itemId}" name="job_role[]" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="start-date-${itemId}">Start Date *</label>
                    <input type="month" id="start-date-${itemId}" name="start_date[]" required>
                </div>
                <div class="form-group">
                    <label for="end-date-${itemId}">End Date *</label>
                    <input type="month" id="end-date-${itemId}" name="end_date[]" required>
                </div>
            </div>
            <div class="form-group">
                <label for="responsibilities-${itemId}">Responsibilities</label>
                <textarea id="responsibilities-${itemId}" name="responsibilities[]" rows="4"></textarea>
            </div>
        `;
    }
}

// ============================================
// Education Section
// ============================================

class EducationSection extends FormSection {
    constructor() {
        super('education');
    }

    getItemTemplate(itemId) {
        return `
            <div class="form-item-header">
                <h4>Education</h4>
                <button type="button" class="btn btn-danger btn-sm btn-remove-item">Remove</button>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="degree-${itemId}">Degree *</label>
                    <input type="text" id="degree-${itemId}" name="degree[]" required>
                </div>
                <div class="form-group">
                    <label for="institute-${itemId}">Institute *</label>
                    <input type="text" id="institute-${itemId}" name="institute[]" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="start-year-${itemId}">Start Year *</label>
                    <input type="number" id="start-year-${itemId}" name="start_year[]" min="1950" max="2100" required>
                </div>
                <div class="form-group">
                    <label for="end-year-${itemId}">End Year *</label>
                    <input type="number" id="end-year-${itemId}" name="end_year[]" min="1950" max="2100" required>
                </div>
            </div>
            <div class="form-group">
                <label for="cgpa-${itemId}">CGPA/Percentage</label>
                <input type="text" id="cgpa-${itemId}" name="cgpa[]">
            </div>
        `;
    }
}

// ============================================
// Skills Section
// ============================================

class SkillsSection extends FormSection {
    constructor() {
        super('skills');
    }

    getItemTemplate(itemId) {
        return `
            <div class="form-item-header">
                <h4>Skill</h4>
                <button type="button" class="btn btn-danger btn-sm btn-remove-item">Remove</button>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="skill-name-${itemId}">Skill Name *</label>
                    <input type="text" id="skill-name-${itemId}" name="skill_name[]" required>
                </div>
                <div class="form-group">
                    <label for="skill-level-${itemId}">Level *</label>
                    <select id="skill-level-${itemId}" name="skill_level[]" required>
                        <option value="">Select Level</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Expert">Expert</option>
                    </select>
                </div>
            </div>
        `;
    }
}

// ============================================
// Projects Section
// ============================================

class ProjectsSection extends FormSection {
    constructor() {
        super('projects');
    }

    getItemTemplate(itemId) {
        return `
            <div class="form-item-header">
                <h4>Project</h4>
                <button type="button" class="btn btn-danger btn-sm btn-remove-item">Remove</button>
            </div>
            <div class="form-group">
                <label for="project-name-${itemId}">Project Name *</label>
                <input type="text" id="project-name-${itemId}" name="project_name[]" required>
            </div>
            <div class="form-group">
                <label for="project-description-${itemId}">Description</label>
                <textarea id="project-description-${itemId}" name="project_description[]" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="technologies-${itemId}">Technologies Used</label>
                <input type="text" id="technologies-${itemId}" name="technologies[]" placeholder="e.g., PHP, MySQL, JavaScript">
            </div>
            <div class="form-group">
                <label for="project-link-${itemId}">Project Link</label>
                <input type="url" id="project-link-${itemId}" name="project_link[]">
            </div>
        `;
    }
}

// ============================================
// Certifications Section
// ============================================

class CertificationsSection extends FormSection {
    constructor() {
        super('certifications');
    }

    getItemTemplate(itemId) {
        return `
            <div class="form-item-header">
                <h4>Certification</h4>
                <button type="button" class="btn btn-danger btn-sm btn-remove-item">Remove</button>
            </div>
            <div class="form-group">
                <label for="cert-title-${itemId}">Certificate Title *</label>
                <input type="text" id="cert-title-${itemId}" name="cert_title[]" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="issued-by-${itemId}">Issued By *</label>
                    <input type="text" id="issued-by-${itemId}" name="issued_by[]" required>
                </div>
                <div class="form-group">
                    <label for="cert-year-${itemId}">Year *</label>
                    <input type="number" id="cert-year-${itemId}" name="cert_year[]" min="1950" max="2100" required>
                </div>
            </div>
        `;
    }
}

// ============================================
// Languages Section
// ============================================

class LanguagesSection extends FormSection {
    constructor() {
        super('languages');
    }

    getItemTemplate(itemId) {
        return `
            <div class="form-item-header">
                <h4>Language</h4>
                <button type="button" class="btn btn-danger btn-sm btn-remove-item">Remove</button>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="language-name-${itemId}">Language Name *</label>
                    <input type="text" id="language-name-${itemId}" name="language_name[]" required>
                </div>
                <div class="form-group">
                    <label for="proficiency-${itemId}">Proficiency *</label>
                    <select id="proficiency-${itemId}" name="proficiency[]" required>
                        <option value="">Select Proficiency</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Fluent">Fluent</option>
                        <option value="Native">Native</option>
                    </select>
                </div>
            </div>
        `;
    }
}

// ============================================
// Initialize Form Sections
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    // Create section instances
    const workExperience = new WorkExperienceSection();
    const education = new EducationSection();
    const skills = new SkillsSection();
    const projects = new ProjectsSection();
    const certifications = new CertificationsSection();
    const languages = new LanguagesSection();

    // Attach to window for global access
    window.formSections = {
        workExperience,
        education,
        skills,
        projects,
        certifications,
        languages
    };

    // Add event listeners to add buttons
    document.getElementById('add-work-experience')?.addEventListener('click', () => {
        workExperience.addItem();
    });

    document.getElementById('add-education')?.addEventListener('click', () => {
        education.addItem();
    });

    document.getElementById('add-skill')?.addEventListener('click', () => {
        skills.addItem();
    });

    document.getElementById('add-project')?.addEventListener('click', () => {
        projects.addItem();
    });

    document.getElementById('add-certification')?.addEventListener('click', () => {
        certifications.addItem();
    });

    document.getElementById('add-language')?.addEventListener('click', () => {
        languages.addItem();
    });

    // Handle form submission
    const builderForm = document.getElementById('resume-builder-form');
    if (builderForm) {
        builderForm.addEventListener('submit', function(e) {
            if (!validateForm('resume-builder-form')) {
                e.preventDefault();
                showAlert('Please fill all required fields correctly', 'danger');
            }
        });
    }
});

// ============================================
// File Upload Handler
// ============================================

function handleProfilePictureUpload(input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    // Validate file size
    if (file.size > maxSize) {
        showAlert('File size must be less than 5MB', 'danger');
        input.value = '';
        return;
    }

    // Validate file type
    if (!allowedTypes.includes(file.type)) {
        showAlert('Only image files are allowed (JPG, PNG, GIF, WebP)', 'danger');
        input.value = '';
        return;
    }

    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('profile-picture-preview');
        if (preview) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
    };
    reader.readAsDataURL(file);
}

// ============================================
// Form Auto-save (Optional)
// ============================================

function autoSaveForm() {
    const form = document.getElementById('resume-builder-form');
    if (!form) return;

    try {
        const data = {};
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Skip file inputs and hidden action fields
            if (input.type !== 'file' && input.name && input.name !== 'action') {
                data[input.name] = input.value;
            }
        });

        Storage.set('resume_builder_draft', data);
        console.log('Form auto-saved');
    } catch (e) {
        console.warn('Auto-save error:', e.message);
    }
}

// Auto-save every 30 seconds
setInterval(autoSaveForm, 30000);

// ============================================
// Form Recovery
// ============================================

function recoverFormData() {
    const savedData = Storage.get('resume_builder_draft');
    if (!savedData) return;

    const form = document.getElementById('resume-builder-form');
    if (!form) return;

    try {
        Object.keys(savedData).forEach(key => {
            try {
                const input = form.querySelector(`[name="${key}"]`);
                if (input && input.type !== 'file') {
                    input.value = savedData[key];
                }
            } catch (e) {
                // Skip this field if there's an error
                console.warn(`Could not recover field ${key}:`, e.message);
            }
        });

        showAlert('Form data recovered from last session', 'info');
    } catch (e) {
        console.warn('Form recovery error:', e.message);
    }
}

// Recover on page load
document.addEventListener('DOMContentLoaded', recoverFormData);

// ============================================
// Theme Preview
// ============================================

function previewTheme(themeName) {
    const previewFrame = document.getElementById('resume-preview');
    if (previewFrame) {
        previewFrame.src = `preview.php?theme=${themeName}`;
    }
}

// ============================================
// Export Functions
// ============================================

function downloadPDF(themeName = 'classic') {
    const form = document.getElementById('resume-builder-form');
    if (!validateForm('resume-builder-form')) {
        showAlert('Please fill all required fields before downloading', 'danger');
        return;
    }

    // Submit form to PDF endpoint
    const downloadForm = document.createElement('form');
    downloadForm.method = 'POST';
    downloadForm.action = 'download.php';
    downloadForm.innerHTML = form.innerHTML + `<input type="hidden" name="theme" value="${themeName}">`;
    document.body.appendChild(downloadForm);
    downloadForm.submit();
    document.body.removeChild(downloadForm);
}

// ============================================
// PowerPoint Download
// ============================================

async function downloadPowerPoint() {
    try {
        showAlert('Generating PowerPoint presentation...', 'info');
        
        const response = await fetch('api/download-ppt.php', {
            method: 'GET'
        });
        
        if (!response.ok) {
            throw new Error('Failed to generate PowerPoint');
        }
        
        // Create blob and download
        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'resume_' + new Date().getTime() + '.pptx';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
        
        showAlert('PowerPoint downloaded successfully!', 'success');
    } catch (error) {
        console.error('PPT download error:', error);
        showAlert('Error downloading PowerPoint: ' + error.message, 'danger');
    }
}

// ============================================
// Animations
// ============================================

// Add animation to style
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }
    `;
    document.head.appendChild(style);
});
