<?php
/**
 * Timeline Design Theme
 * 
 * Experience shown in timeline format with modern styling
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}

// Include placeholder generator
if (!function_exists('getProfileImage')) {
    require_once __DIR__ . '/../utils/placeholder-generator.php';
}
?>

<div class="resume-document theme-timeline">
    <!-- Header -->
    <div class="resume-header">
        <div class="header-content">
            <img src="<?php echo getProfileImage($data['personal']['profilePicture'] ?? '', $data['personal']['fullName'] ?? 'User'); ?>" alt="Profile" class="profile-image">
            
            <div class="header-text">
                <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>
                
                <div class="contact-info">
                    <?php if (!empty($data['personal']['email'])): ?>
                        <span class="contact-item">
                            <span class="text-icon">E:</span>
                            <?php echo htmlspecialchars($data['personal']['email']); ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['phone'])): ?>
                        <span class="contact-item">
                            <span class="text-icon">P:</span>
                            <?php echo htmlspecialchars($data['personal']['phone']); ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['address'])): ?>
                        <span class="contact-item">
                            <span class="text-icon">A:</span>
                            <?php echo htmlspecialchars($data['personal']['address']); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="social-links">
                    <?php if (!empty($data['personal']['website'])): ?>
                        <a href="<?php echo htmlspecialchars($data['personal']['website']); ?>" target="_blank">Website</a>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['linkedin'])): ?>
                        <a href="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>" target="_blank">LinkedIn</a>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['github'])): ?>
                        <a href="<?php echo htmlspecialchars($data['personal']['github']); ?>" target="_blank">GitHub</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Summary -->
    <?php if (!empty($data['personal']['profileSummary'])): ?>
        <div class="resume-section">
            <h2>Professional Summary</h2>
            <p><?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
        </div>
    <?php endif; ?>

    <!-- Work Experience Timeline -->
    <?php if (!empty($data['workExperience'])): ?>
        <div class="resume-section">
            <h2>Work Experience</h2>
            <div class="timeline">
                <?php foreach ($data['workExperience'] as $index => $exp): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="item-header">
                                <h3><?php echo htmlspecialchars($exp['jobRole'] ?? ''); ?></h3>
                                <span class="date"><?php echo htmlspecialchars($exp['startDate'] ?? ''); ?> - <?php echo htmlspecialchars($exp['endDate'] ?? ''); ?></span>
                            </div>
                            <p class="company"><?php echo htmlspecialchars($exp['company'] ?? ''); ?></p>
                            <?php if (!empty($exp['responsibilities'])): ?>
                                <p><?php echo nl2br(htmlspecialchars($exp['responsibilities'])); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Education Timeline -->
    <?php if (!empty($data['education'])): ?>
        <div class="resume-section">
            <h2>Education</h2>
            <div class="timeline">
                <?php foreach ($data['education'] as $index => $edu): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="item-header">
                                <h3><?php echo htmlspecialchars($edu['degree'] ?? ''); ?></h3>
                                <span class="date"><?php echo htmlspecialchars($edu['startYear'] ?? ''); ?> - <?php echo htmlspecialchars($edu['endYear'] ?? ''); ?></span>
                            </div>
                            <p class="institute"><?php echo htmlspecialchars($edu['institute'] ?? ''); ?></p>
                            <?php if (!empty($edu['cgpa'])): ?>
                                <p>CGPA: <?php echo htmlspecialchars($edu['cgpa']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Skills -->
    <?php if (!empty($data['skills'])): ?>
        <div class="resume-section">
            <h2>Skills</h2>
            <div class="skills-container">
                <?php foreach ($data['skills'] as $skill): ?>
                    <div class="skill-badge">
                        <span class="skill-name"><?php echo htmlspecialchars($skill['skillName'] ?? ''); ?></span>
                        <span class="skill-level"><?php echo htmlspecialchars($skill['level'] ?? ''); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Projects -->
    <?php if (!empty($data['projects'])): ?>
        <div class="resume-section">
            <h2>Projects</h2>
            <?php foreach ($data['projects'] as $project): ?>
                <div class="project-item">
                    <h3><?php echo htmlspecialchars($project['projectName'] ?? ''); ?></h3>
                    <?php if (!empty($project['description'])): ?>
                        <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($project['technologiesUsed'])): ?>
                        <p><strong>Technologies:</strong> <?php echo htmlspecialchars($project['technologiesUsed']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($project['projectLink'])): ?>
                        <p><a href="<?php echo htmlspecialchars($project['projectLink']); ?>" target="_blank">View Project</a></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Certifications -->
    <?php if (!empty($data['certifications'])): ?>
        <div class="resume-section">
            <h2>Certifications</h2>
            <?php foreach ($data['certifications'] as $cert): ?>
                <div class="certification-item">
                    <h3><?php echo htmlspecialchars($cert['certificateTitle'] ?? ''); ?></h3>
                    <p><?php echo htmlspecialchars($cert['issuedBy'] ?? ''); ?> - <?php echo htmlspecialchars($cert['year'] ?? ''); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Languages -->
    <?php if (!empty($data['languages'])): ?>
        <div class="resume-section">
            <h2>Languages</h2>
            <div class="languages-container">
                <?php foreach ($data['languages'] as $lang): ?>
                    <div class="language-item">
                        <span class="language-name"><?php echo htmlspecialchars($lang['languageName'] ?? ''); ?></span>
                        <span class="proficiency"><?php echo htmlspecialchars($lang['proficiency'] ?? ''); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Interests -->
    <?php if (!empty($data['interests'])): ?>
        <div class="resume-section">
            <h2>Interests</h2>
            <p><?php echo nl2br(htmlspecialchars($data['interests'])); ?></p>
        </div>
    <?php endif; ?>
</div>

<style>
    .resume-document.theme-timeline {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #2c3e50;
        line-height: 1.6;
        padding: 40px;
        background: white;
    }

    .resume-header {
        border-bottom: 3px solid #2c3e50;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .header-content {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        object-fit: cover;
        border: 3px solid #3498db;
    }

    .header-text {
        flex: 1;
    }

    .resume-header h1 {
        font-size: 28px;
        margin: 0 0 5px 0;
        color: #2c3e50;
        font-weight: 700;
    }

    .job-title {
        font-size: 16px;
        color: #7f8c8d;
        margin: 0 0 15px 0;
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .text-icon {
        font-weight: bold;
        color: #ff6b6b;
        font-size: 12px;
    }

    .social-links {
        display: flex;
        gap: 15px;
    }

    .social-links a {
        color: #3498db;
        text-decoration: none;
        font-size: 13px;
    }

    .resume-section {
        margin-bottom: 25px;
    }

    .resume-section h2 {
        font-size: 16px;
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 8px;
        margin: 0 0 15px 0;
        font-weight: 700;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #3498db, #2ecc71, #f39c12);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
        padding-bottom: 15px;
    }

    .timeline-marker {
        position: absolute;
        left: -18px;
        top: 5px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #3498db;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #3498db;
    }

    .timeline-item:nth-child(2) .timeline-marker {
        background: #2ecc71;
        box-shadow: 0 0 0 2px #2ecc71;
    }

    .timeline-item:nth-child(3) .timeline-marker {
        background: #f39c12;
        box-shadow: 0 0 0 2px #f39c12;
    }

    .timeline-item:nth-child(4) .timeline-marker {
        background: #e74c3c;
        box-shadow: 0 0 0 2px #e74c3c;
    }

    .timeline-content {
        padding: 10px 0;
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 5px;
    }

    .item-header h3 {
        font-size: 14px;
        margin: 0;
        color: #2c3e50;
        font-weight: 700;
    }

    .date {
        font-size: 12px;
        color: #95a5a6;
    }

    .company,
    .institute {
        font-size: 13px;
        color: #3498db;
        margin: 0 0 8px 0;
        font-weight: 600;
    }

    .skills-container,
    .languages-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .skill-badge,
    .language-item {
        background: #ecf0f1;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .skill-level,
    .proficiency {
        font-size: 11px;
        color: #7f8c8d;
    }

    .project-item,
    .certification-item {
        margin-bottom: 15px;
    }

    @media print {
        .resume-document {
            padding: 0;
        }

        .profile-image {
            width: 80px;
            height: 80px;
        }

        .resume-header h1 {
            font-size: 24px;
        }

        .timeline::before {
            left: 0;
        }

        .timeline-marker {
            left: -18px;
        }
    }
</style>
