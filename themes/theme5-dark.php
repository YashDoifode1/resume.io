<?php
/**
 * Dark Mode Theme
 * Modern dark theme with bold typography for tech professionals
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}
?>

<div class="resume-document theme-dark">
    <!-- Header -->
    <div class="resume-header">
        <div class="header-content">
            <div class="header-left">
                <?php if (!empty($data['personal']['profilePicture'])): ?>
                    <img src="<?php echo htmlspecialchars($data['personal']['profilePicture']); ?>" alt="Profile" class="profile-image">
                <?php endif; ?>
            </div>
            <div class="header-right">
                <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>
                
                <div class="contact-info">
                    <?php if (!empty($data['personal']['email'])): ?>
                        <span><?php echo htmlspecialchars($data['personal']['email']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['phone'])): ?>
                        <span><?php echo htmlspecialchars($data['personal']['phone']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['address'])): ?>
                        <span><?php echo htmlspecialchars($data['personal']['address']); ?></span>
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
            <p class="summary"><?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
        </div>
    <?php endif; ?>

    <!-- Work Experience -->
    <?php if (!empty($data['workExperience'])): ?>
        <div class="resume-section">
            <h2>Experience</h2>
            <?php foreach ($data['workExperience'] as $exp): ?>
                <div class="experience-item">
                    <div class="item-header">
                        <h3><?php echo htmlspecialchars($exp['jobRole'] ?? ''); ?></h3>
                        <span class="date"><?php echo htmlspecialchars($exp['startDate'] ?? ''); ?> - <?php echo htmlspecialchars($exp['endDate'] ?? ''); ?></span>
                    </div>
                    <p class="company"><?php echo htmlspecialchars($exp['company'] ?? ''); ?></p>
                    <?php if (!empty($exp['responsibilities'])): ?>
                        <p><?php echo nl2br(htmlspecialchars($exp['responsibilities'])); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Education -->
    <?php if (!empty($data['education'])): ?>
        <div class="resume-section">
            <h2>Education</h2>
            <?php foreach ($data['education'] as $edu): ?>
                <div class="education-item">
                    <div class="item-header">
                        <h3><?php echo htmlspecialchars($edu['degree'] ?? ''); ?></h3>
                        <span class="date"><?php echo htmlspecialchars($edu['startYear'] ?? ''); ?> - <?php echo htmlspecialchars($edu['endYear'] ?? ''); ?></span>
                    </div>
                    <p class="institute"><?php echo htmlspecialchars($edu['institute'] ?? ''); ?></p>
                    <?php if (!empty($edu['cgpa'])): ?>
                        <p class="cgpa">GPA: <?php echo htmlspecialchars($edu['cgpa']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
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
                        <p><strong>Tech:</strong> <?php echo htmlspecialchars($project['technologiesUsed']); ?></p>
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
                        <span><?php echo htmlspecialchars($lang['languageName'] ?? ''); ?></span>
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
    .resume-document {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #e0e0e0;
        line-height: 1.6;
        padding: 40px;
        background: #1a1a1a;
    }

    .resume-header {
        background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%);
        color: white;
        padding: 30px;
        margin: -40px -40px 30px -40px;
        border-bottom: 3px solid #00d4ff;
    }

    .header-content {
        display: flex;
        gap: 25px;
        align-items: flex-start;
    }

    .header-left {
        flex-shrink: 0;
    }

    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        object-fit: cover;
        border: 3px solid #00d4ff;
    }

    .header-right {
        flex: 1;
    }

    .resume-header h1 {
        font-size: 28px;
        margin: 0 0 5px 0;
        font-weight: 700;
        color: #00d4ff;
    }

    .job-title {
        font-size: 16px;
        color: #b0b0b0;
        margin: 0 0 15px 0;
        font-weight: 500;
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 12px;
        color: #b0b0b0;
        margin-bottom: 10px;
    }

    .social-links {
        display: flex;
        gap: 15px;
    }

    .social-links a {
        color: #00d4ff;
        text-decoration: none;
        font-size: 12px;
    }

    .summary {
        font-size: 13px;
        line-height: 1.8;
        color: #d0d0d0;
    }

    .resume-section {
        margin-bottom: 25px;
    }

    .resume-section h2 {
        font-size: 14px;
        color: #00d4ff;
        border-bottom: 3px solid #00d4ff;
        padding-bottom: 8px;
        margin: 0 0 15px 0;
        font-weight: 700;
    }

    .experience-item,
    .education-item,
    .project-item,
    .certification-item {
        margin-bottom: 15px;
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 5px;
        gap: 10px;
    }

    .item-header h3 {
        font-size: 13px;
        margin: 0;
        color: white;
        font-weight: 700;
    }

    .date {
        font-size: 12px;
        color: #808080;
        white-space: nowrap;
    }

    .company,
    .institute {
        font-size: 12px;
        color: #00d4ff;
        margin: 0 0 6px 0;
        font-weight: 600;
    }

    .cgpa {
        font-size: 12px;
        color: #a0a0a0;
        margin: 0;
    }

    .skills-container,
    .languages-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .skill-badge,
    .language-item {
        background: #2a2a2a;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 12px;
        color: #e0e0e0;
        border-left: 3px solid #00d4ff;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .skill-level,
    .proficiency {
        font-size: 11px;
        color: #00d4ff;
        font-weight: 500;
    }

    .project-item a {
        color: #00d4ff;
    }

    @media print {
        .resume-document {
            padding: 0;
            background: white;
            color: #333;
        }

        .resume-header {
            background: #f5f5f5;
            color: #333;
            border-bottom: 3px solid #333;
        }

        .resume-header h1,
        .resume-section h2,
        .company,
        .institute,
        .social-links a,
        .skill-level,
        .proficiency {
            color: #333;
        }

        .contact-info,
        .job-title {
            color: #666;
        }
    }
</style>
