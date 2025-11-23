<?php
/**
 * Executive Premium Theme
 * Premium design for executives and senior professionals
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}
?>

<div class="resume-document theme-executive">
    <!-- Header -->
    <div class="resume-header">
        <div class="header-top">
            <div class="header-left">
                <?php if (!empty($data['personal']['profilePicture'])): ?>
                    <img src="<?php echo htmlspecialchars($data['personal']['profilePicture']); ?>" alt="Profile" class="profile-image">
                <?php endif; ?>
            </div>
            <div class="header-right">
                <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Executive Position'); ?></p>
            </div>
        </div>
        
        <div class="contact-info">
            <?php if (!empty($data['personal']['email'])): ?>
                <span><?php echo htmlspecialchars($data['personal']['email']); ?></span>
            <?php endif; ?>
            <?php if (!empty($data['personal']['phone'])): ?>
                <span>•</span>
                <span><?php echo htmlspecialchars($data['personal']['phone']); ?></span>
            <?php endif; ?>
            <?php if (!empty($data['personal']['address'])): ?>
                <span>•</span>
                <span><?php echo htmlspecialchars($data['personal']['address']); ?></span>
            <?php endif; ?>
        </div>

        <div class="social-links">
            <?php if (!empty($data['personal']['linkedin'])): ?>
                <a href="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>" target="_blank">LinkedIn</a>
            <?php endif; ?>
            <?php if (!empty($data['personal']['website'])): ?>
                <a href="<?php echo htmlspecialchars($data['personal']['website']); ?>" target="_blank">Website</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Profile Summary -->
    <?php if (!empty($data['personal']['profileSummary'])): ?>
        <div class="resume-section executive-summary">
            <h2>Executive Summary</h2>
            <p><?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
        </div>
    <?php endif; ?>

    <!-- Work Experience -->
    <?php if (!empty($data['workExperience'])): ?>
        <div class="resume-section">
            <h2>Professional Experience</h2>
            <?php foreach ($data['workExperience'] as $exp): ?>
                <div class="experience-item">
                    <div class="item-header">
                        <h3><?php echo htmlspecialchars($exp['jobRole'] ?? ''); ?></h3>
                        <span class="date"><?php echo htmlspecialchars($exp['startDate'] ?? ''); ?> – <?php echo htmlspecialchars($exp['endDate'] ?? ''); ?></span>
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
                        <span class="date"><?php echo htmlspecialchars($edu['startYear'] ?? ''); ?> – <?php echo htmlspecialchars($edu['endYear'] ?? ''); ?></span>
                    </div>
                    <p class="institute"><?php echo htmlspecialchars($edu['institute'] ?? ''); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Skills -->
    <?php if (!empty($data['skills'])): ?>
        <div class="resume-section">
            <h2>Core Competencies</h2>
            <div class="skills-container">
                <?php foreach ($data['skills'] as $skill): ?>
                    <div class="skill-item">
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
            <h2>Key Achievements</h2>
            <?php foreach ($data['projects'] as $project): ?>
                <div class="project-item">
                    <h3><?php echo htmlspecialchars($project['projectName'] ?? ''); ?></h3>
                    <?php if (!empty($project['description'])): ?>
                        <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Certifications -->
    <?php if (!empty($data['certifications'])): ?>
        <div class="resume-section">
            <h2>Certifications & Awards</h2>
            <?php foreach ($data['certifications'] as $cert): ?>
                <div class="certification-item">
                    <h3><?php echo htmlspecialchars($cert['certificateTitle'] ?? ''); ?></h3>
                    <p><?php echo htmlspecialchars($cert['issuedBy'] ?? ''); ?> • <?php echo htmlspecialchars($cert['year'] ?? ''); ?></p>
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
                    <span class="language-item"><?php echo htmlspecialchars($lang['languageName'] ?? ''); ?> - <?php echo htmlspecialchars($lang['proficiency'] ?? ''); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .resume-document {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #1a1a1a;
        line-height: 1.7;
        padding: 50px;
        background: white;
    }

    .resume-header {
        background: linear-gradient(to right, #1a1a1a 0%, #2d2d2d 100%);
        color: white;
        padding: 40px;
        margin: -50px -50px 40px -50px;
        border-bottom: 5px solid #c9a961;
    }

    .header-top {
        display: flex;
        gap: 30px;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 8px;
        object-fit: cover;
        border: 3px solid #c9a961;
    }

    .header-right h1 {
        font-size: 32px;
        margin: 0 0 8px 0;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .job-title {
        font-size: 16px;
        color: #c9a961;
        margin: 0;
        font-weight: 500;
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 12px;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(201, 169, 97, 0.3);
    }

    .social-links {
        display: flex;
        gap: 16px;
    }

    .social-links a {
        color: #c9a961;
        text-decoration: none;
        font-size: 12px;
    }

    .resume-section {
        margin-bottom: 32px;
    }

    .resume-section h2 {
        font-size: 14px;
        color: #1a1a1a;
        border-bottom: 2px solid #c9a961;
        padding-bottom: 8px;
        margin: 0 0 16px 0;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .executive-summary {
        background: #f9f7f4;
        padding: 16px;
        border-left: 4px solid #c9a961;
        border-radius: 4px;
    }

    .executive-summary p {
        margin: 0;
        line-height: 1.8;
    }

    .experience-item,
    .education-item,
    .project-item,
    .certification-item {
        margin-bottom: 16px;
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
        color: #1a1a1a;
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
        color: #c9a961;
        margin: 0 0 6px 0;
        font-weight: 600;
    }

    .skills-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .skill-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .skill-name {
        font-size: 12px;
        font-weight: 600;
    }

    .skill-level {
        font-size: 11px;
        color: #c9a961;
        font-weight: 600;
    }

    .languages-container {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .language-item {
        font-size: 12px;
        color: #1a1a1a;
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
