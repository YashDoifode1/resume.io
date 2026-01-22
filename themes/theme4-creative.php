<?php
/**
 * Creative Portfolio Theme
 * SAME UI – PDF SAFE VERSION
 */

if (!isset($data)) {
    $data = $_SESSION['resume_data'] ?? [];
}
?>

<div class="resume-document theme-creative">

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
                    <h1><?= htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                    <p class="job-title"><?= htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>

                    <div class="contact-info">
                        <?php if (!empty($data['personal']['email'])): ?>
                            <span><?= htmlspecialchars($data['personal']['email']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['phone'])): ?>
                            <span><?= htmlspecialchars($data['personal']['phone']); ?></span>
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
            <p class="summary"><?= nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
        </div>
    <?php endif; ?>

    <!-- Experience -->
    <?php if (!empty($data['workExperience'])): ?>
        <div class="resume-section">
            <h2>Experience</h2>
            <?php foreach ($data['workExperience'] as $exp): ?>
                <div class="experience-item">
                    <table class="item-header">
                        <tr>
                            <td><h3><?= htmlspecialchars($exp['jobRole'] ?? ''); ?></h3></td>
                            <td class="date">
                                <?= htmlspecialchars($exp['startDate'] ?? ''); ?> -
                                <?= htmlspecialchars($exp['endDate'] ?? ''); ?>
                            </td>
                        </tr>
                    </table>
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
                    <table class="item-header">
                        <tr>
                            <td><h3><?= htmlspecialchars($edu['degree'] ?? ''); ?></h3></td>
                            <td class="date">
                                <?= htmlspecialchars($edu['startYear'] ?? ''); ?> -
                                <?= htmlspecialchars($edu['endYear'] ?? ''); ?>
                            </td>
                        </tr>
                    </table>
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
            <h2>Skills</h2>
            <?php foreach ($data['skills'] as $skill): ?>
                <span class="skill-badge">
                    <?= htmlspecialchars($skill['skillName'] ?? ''); ?> —
                    <span class="skill-level"><?= htmlspecialchars($skill['level'] ?? ''); ?></span>
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Projects -->
    <?php if (!empty($data['projects'])): ?>
        <div class="resume-section">
            <h2>Projects</h2>
            <?php foreach ($data['projects'] as $project): ?>
                <div class="project-item">
                    <h3><?= htmlspecialchars($project['projectName'] ?? ''); ?></h3>
                    <p><?= nl2br(htmlspecialchars($project['description'] ?? '')); ?></p>
                    <?php if (!empty($project['technologiesUsed'])): ?>
                        <p><strong>Tech:</strong> <?= htmlspecialchars($project['technologiesUsed']); ?></p>
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
                    <h3><?= htmlspecialchars($cert['certificateTitle'] ?? ''); ?></h3>
                    <p><?= htmlspecialchars($cert['issuedBy'] ?? ''); ?> - <?= htmlspecialchars($cert['year'] ?? ''); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Languages -->
    <?php if (!empty($data['languages'])): ?>
        <div class="resume-section">
            <h2>Languages</h2>
            <?php foreach ($data['languages'] as $lang): ?>
                <span class="language-item">
                    <?= htmlspecialchars($lang['languageName'] ?? ''); ?> —
                    <span class="proficiency"><?= htmlspecialchars($lang['proficiency'] ?? ''); ?></span>
                </span>
            <?php endforeach; ?>
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
    font-family: DejaVu Sans, Segoe UI, Arial, sans-serif;
    color: #2c3e50;
    padding: 40px;
}

.resume-header {
    background: #6b6eea;
    color: #fff;
    padding: 30px;
    margin: -40px -40px 30px -40px;
    border-bottom: 6px solid #764ba2;
}

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
    border-radius: 50%;
    border: 4px solid #fff;
}

.resume-header h1 {
    font-size: 28px;
    margin: 0;
}

.job-title {
    font-size: 16px;
    color: #eee;
    margin-bottom: 12px;
}

.contact-info span,
.social-links span {
    font-size: 12px;
    margin-right: 12px;
}

.resume-section h2 {
    font-size: 14px;
    border-bottom: 3px solid #6b6eea;
    padding-bottom: 6px;
    margin-bottom: 12px;
}

.item-header {
    width: 100%;
}

.item-header h3 {
    font-size: 13px;
    color: #6b6eea;
}

.date {
    text-align: right;
    font-size: 12px;
    color: #95a5a6;
}

.company,
.institute {
    font-size: 12px;
    color: #6b6eea;
    font-weight: 600;
}

.skill-badge,
.language-item {
    display: inline-block;
    border: 1px solid #6b6eea;
    border-radius: 20px;
    padding: 6px 10px;
    font-size: 12px;
    margin: 5px 6px 0 0;
}

.skill-level,
.proficiency {
    color: #6b6eea;
    font-weight: 600;
}
</style>
