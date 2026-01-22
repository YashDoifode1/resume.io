<?php
/**
 * Corporate Blue Theme
 * SAME UI – PDF SAFE COLORS & LAYOUT
 */

if (!isset($data)) {
    $data = $_SESSION['resume_data'] ?? [];
}
?>

<div class="resume-document theme-corporate">

    <!-- Header -->
    <div class="resume-header">
        <table class="header-content">
            <tr>
                <td class="header-left">
                    <?php if (!empty($data['personal']['profilePicture'])): ?>
                        <img src="<?= htmlspecialchars($data['personal']['profilePicture']); ?>" class="profile-image">
                    <?php endif; ?>
                </td>
                <td class="header-right">
                    <h1><?= htmlspecialchars($data['personal']['fullName'] ?? ''); ?></h1>
                    <p class="job-title"><?= htmlspecialchars($data['personal']['jobTitle'] ?? ''); ?></p>

                    <div class="contact-info">
                        <?php if (!empty($data['personal']['email'])): ?>
                            <span>✉ <?= htmlspecialchars($data['personal']['email']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['phone'])): ?>
                            <span>☎ <?= htmlspecialchars($data['personal']['phone']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['address'])): ?>
                            <span>⌂ <?= htmlspecialchars($data['personal']['address']); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="social-links">
                        <?php if (!empty($data['personal']['website'])): ?>
                            <span><?= htmlspecialchars($data['personal']['website']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['linkedin'])): ?>
                            <span><?= htmlspecialchars($data['personal']['linkedin']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['github'])): ?>
                            <span><?= htmlspecialchars($data['personal']['github']); ?></span>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Profile Summary -->
    <?php if (!empty($data['personal']['profileSummary'])): ?>
        <div class="resume-section">
            <div class="summary-box">
                <?= nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Work Experience -->
    <?php if (!empty($data['workExperience'])): ?>
        <div class="resume-section">
            <h2>Professional Experience</h2>
            <?php foreach ($data['workExperience'] as $exp): ?>
                <div class="experience-item">
                    <div class="item-header">
                        <h3><?= htmlspecialchars($exp['job_role'] ?? ''); ?></h3>
                        <span class="date">
                            <?= htmlspecialchars($exp['start_date'] ?? ''); ?> - <?= htmlspecialchars($exp['end_date'] ?? ''); ?>
                        </span>
                    </div>
                    <p class="company"><?= htmlspecialchars($exp['company'] ?? ''); ?></p>
                    <?php if (!empty($exp['responsibilities'])): ?>
                        <p><?= nl2br(htmlspecialchars($exp['responsibilities'])); ?></p>
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
                        <h3><?= htmlspecialchars($edu['degree'] ?? ''); ?></h3>
                        <span class="date">
                            <?= htmlspecialchars($edu['start_year'] ?? ''); ?> - <?= htmlspecialchars($edu['end_year'] ?? ''); ?>
                        </span>
                    </div>
                    <p class="institute"><?= htmlspecialchars($edu['institute'] ?? ''); ?></p>
                    <?php if (!empty($edu['cgpa'])): ?>
                        <p class="cgpa">GPA: <?= htmlspecialchars($edu['cgpa']); ?></p>
                    <?php endif; ?>
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
                    <div class="skill-badge">
                        <span class="skill-name"><?= htmlspecialchars($skill['skillName'] ?? ''); ?></span>
                        <span class="skill-level"><?= htmlspecialchars($skill['level'] ?? ''); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Projects -->
    <?php if (!empty($data['projects'])): ?>
        <div class="resume-section">
            <h2>Key Projects</h2>
            <?php foreach ($data['projects'] as $project): ?>
                <div class="project-item">
                    <h3><?= htmlspecialchars($project['name'] ?? ''); ?></h3>
                    <?php if (!empty($project['description'])): ?>
                        <p><?= nl2br(htmlspecialchars($project['description'])); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($project['technologies'])): ?>
                        <p><strong>Technologies:</strong> <?= htmlspecialchars($project['technologies']); ?></p>
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
                    <h3><?= htmlspecialchars($cert['title'] ?? ''); ?></h3>
                    <p><?= htmlspecialchars($cert['issued_by'] ?? ''); ?> - <?= htmlspecialchars($cert['year'] ?? ''); ?></p>
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
                        <span><?= htmlspecialchars($lang['languageName'] ?? ''); ?></span>
                        <span class="proficiency"><?= htmlspecialchars($lang['proficiency'] ?? ''); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Interests -->
    <?php if (!empty($data['interests'])): ?>
        <div class="resume-section">
            <h2>Interests</h2>
            <p><?= nl2br(htmlspecialchars($data['interests'])); ?></p>
        </div>
    <?php endif; ?>
</div>

<style>
.resume-document {
    font-family: DejaVu Sans, Arial, sans-serif;
    color: #1a3a52;
    line-height: 1.6;
    padding: 40px;
    background: #ffffff;
}

/* HEADER – solid color instead of gradient */
.resume-header {
    background-color: #1a3a52;
    color: #ffffff;
    padding: 30px;
    margin: -40px -40px 30px -40px;
    border-bottom: 5px solid #f39c12;
}

/* TABLE used but UI preserved */
.header-content {
    width: 100%;
    border-collapse: collapse;
}

.header-left {
    width: 120px;
}

.profile-image {
    width: 100px;
    height: 100px;
    border-radius: 8px;
    object-fit: cover;
    border: 4px solid #f39c12;
}

.resume-header h1 {
    font-size: 28px;
    margin: 0 0 5px 0;
    font-weight: 700;
}

.job-title {
    font-size: 16px;
    color: #e8f4f8;
    margin-bottom: 15px;
}

.contact-info span,
.social-links span {
    display: inline-block;
    font-size: 12px;
    margin-right: 15px;
}

.summary-box {
    background: #f0f7ff;
    padding: 20px;
    border-left: 4px solid #f39c12;
}

.resume-section h2 {
    font-size: 14px;
    color: #1a3a52;
    border-bottom: 3px solid #f39c12;
    padding-bottom: 8px;
    margin-bottom: 15px;
}

.item-header {
    display: table;
    width: 100%;
}

.item-header h3 {
    display: table-cell;
    font-size: 13px;
    font-weight: 700;
}

.date {
    display: table-cell;
    text-align: right;
    font-size: 12px;
    color: #7f8c8d;
}

.company,
.institute {
    font-size: 12px;
    color: #2c5aa0;
    font-weight: 600;
}

.skills-container,
.languages-container {
    display: table;
    width: 100%;
}

.skill-badge,
.language-item {
    display: inline-block;
    background: #e8f4f8;
    padding: 8px 12px;
    border-left: 3px solid #f39c12;
    font-size: 12px;
    margin: 5px 8px 0 0;
}

.skill-level,
.proficiency {
    font-size: 11px;
    color: #2c5aa0;
}
</style>
