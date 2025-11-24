<?php
/**
 * Tech Startup Theme
 * Modern tech industry focused design
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}
?>

<div class="resume-document theme-tech">
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
                </div>

                <div class="social-links">
                    <?php if (!empty($data['personal']['github'])): ?>
                        <a href="<?php echo htmlspecialchars($data['personal']['github']); ?>" target="_blank">GitHub</a>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['linkedin'])): ?>
                        <a href="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>" target="_blank">LinkedIn</a>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['website'])): ?>
                        <a href="<?php echo htmlspecialchars($data['personal']['website']); ?>" target="_blank">Portfolio</a>
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

    <!-- Skills -->
    <?php if (!empty($data['skills'])): ?>
        <div class="resume-section">
            <h2>Technical Skills</h2>
            <div class="skills-container">
                <?php foreach ($data['skills'] as $skill): ?>
                    <div class="skill-badge">
                        <span><?php echo htmlspecialchars($skill['skillName'] ?? ''); ?></span>
                        <span class="level"><?php echo htmlspecialchars($skill['level'] ?? ''); ?></span>
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
                    <?php if (!empty($project['technologiesUsed'])): ?>
                        <p class="tech"><strong>Tech:</strong> <?php echo htmlspecialchars($project['technologiesUsed']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($project['description'])): ?>
                        <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
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
</div>

<style>
    .resume-document {
        font-family: 'Courier New', 'Monaco', monospace;
        color: #1a1a1a;
        line-height: 1.6;
        padding: 40px;
        background: #ffffff;
    }

    .resume-header {
        background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
        color: white;
        padding: 30px;
        margin: -40px -40px 30px -40px;
        border-bottom: 4px solid #00bcd4;
    }

    .header-content {
        display: flex;
        gap: 25px;
        align-items: flex-start;
    }

    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        object-fit: cover;
        border: 3px solid #00bcd4;
    }

    .resume-header h1 {
        font-size: 28px;
        margin: 0 0 5px 0;
        font-weight: 700;
    }

    .job-title {
        font-size: 16px;
        color: #00bcd4;
        margin: 0 0 15px 0;
        font-weight: 500;
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .text-icon {
        font-weight: bold;
        color: #00d4ff;
        font-size: 12px;
    }

    .social-links {
        display: flex;
        gap: 12px;
    }

    .social-links a {
        color: #00bcd4;
        text-decoration: none;
        font-size: 12px;
    }

    .summary {
        font-size: 13px;
        line-height: 1.8;
        color: #333;
    }

    .resume-section {
        margin-bottom: 24px;
    }

    .resume-section h2 {
        font-size: 14px;
        color: #0d47a1;
        border-bottom: 2px solid #00bcd4;
        padding-bottom: 8px;
        margin: 0 0 14px 0;
        font-weight: 700;
    }

    .experience-item,
    .education-item,
    .project-item,
    .certification-item {
        margin-bottom: 14px;
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 4px;
        gap: 10px;
    }

    .item-header h3 {
        font-size: 13px;
        margin: 0;
        color: #0d47a1;
        font-weight: 700;
    }

    .date {
        font-size: 12px;
        color: #666;
        white-space: nowrap;
    }

    .company,
    .institute {
        font-size: 12px;
        color: #00bcd4;
        margin: 0 0 6px 0;
        font-weight: 600;
    }

    .skills-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .skill-badge {
        background: #f0f0f0;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        border: 1px solid #00bcd4;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .level {
        font-size: 11px;
        color: #0d47a1;
        font-weight: 600;
    }

    .tech {
        font-size: 12px;
        color: #00bcd4;
        margin: 4px 0;
    }

    @media print {
        .resume-document {
            padding: 0;
        }

        .resume-header {
            margin: 0;
        }
    }
</style>
