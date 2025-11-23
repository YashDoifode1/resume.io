<?php
/**
 * Modern Minimal Theme
 * A clean, minimalist design with elegant typography
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}
?>

<div class="resume-document theme-modern">
    <!-- Header -->
    <div class="resume-header">
        <div class="header-top">
            <?php if (!empty($data['personal']['profilePicture'])): ?>
                <img src="<?php echo htmlspecialchars($data['personal']['profilePicture']); ?>" alt="Profile" class="profile-image">
            <?php endif; ?>
            <div class="header-main">
                <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>
            </div>
        </div>
        
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
                    <p><?php echo htmlspecialchars($cert['issuedBy'] ?? ''); ?> · <?php echo htmlspecialchars($cert['year'] ?? ''); ?></p>
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
        color: #1a1a1a;
        line-height: 1.7;
        padding: 50px;
        background: white;
    }

    .resume-header {
        margin-bottom: 40px;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 30px;
    }

    .header-top {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .profile-image {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #1a1a1a;
    }

    .header-main {
        flex: 1;
    }

    .resume-header h1 {
        font-size: 32px;
        margin: 0 0 5px 0;
        color: #1a1a1a;
        font-weight: 300;
        letter-spacing: -0.5px;
    }

    .job-title {
        font-size: 14px;
        color: #666;
        margin: 0;
        font-weight: 400;
        letter-spacing: 0.5px;
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        font-size: 12px;
        color: #666;
        margin-bottom: 15px;
    }

    .social-links {
        display: flex;
        gap: 20px;
    }

    .social-links a {
        color: #1a1a1a;
        text-decoration: none;
        font-size: 12px;
        border-bottom: 1px solid #1a1a1a;
        padding-bottom: 2px;
    }

    .resume-section {
        margin-bottom: 30px;
    }

    .resume-section h2 {
        font-size: 12px;
        color: #1a1a1a;
        margin: 0 0 15px 0;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 8px;
    }

    .summary {
        font-size: 13px;
        line-height: 1.8;
        color: #333;
    }

    .experience-item,
    .education-item,
    .project-item,
    .certification-item {
        margin-bottom: 18px;
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 3px;
        gap: 10px;
    }

    .item-header h3 {
        font-size: 13px;
        margin: 0;
        color: #1a1a1a;
        font-weight: 600;
    }

    .date {
        font-size: 12px;
        color: #999;
        white-space: nowrap;
    }

    .company,
    .institute {
        font-size: 12px;
        color: #666;
        margin: 0 0 6px 0;
        font-weight: 500;
    }

    .cgpa {
        font-size: 12px;
        color: #999;
        margin: 0;
    }

    .skills-container,
    .languages-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .skill-item,
    .language-item {
        display: flex;
        gap: 8px;
        font-size: 12px;
    }

    .skill-name {
        color: #1a1a1a;
        font-weight: 500;
    }

    .skill-level,
    .proficiency {
        color: #999;
    }

    @media print {
        .resume-document {
            padding: 0;
        }
    }
</style>
