<?php
/**
 * Corporate Blue Theme – FIXED ALIGNMENT (Preview Safe)
 */

if (!isset($data)) {
    $data = $_SESSION['resume_data'] ?? [];
}
?>

<div class="resume-document theme-corporate">

    <!-- ================= HEADER ================= -->
    <div class="resume-header">

        <table class="header-table" width="100%">
            <tr>
                <td class="header-left">
                    <?php if (!empty($data['personal']['profilePicture'])): ?>
                        <img src="<?= htmlspecialchars($data['personal']['profilePicture']); ?>" class="profile-image">
                    <?php endif; ?>
                </td>
                <td class="header-right">
                    <h1><?= htmlspecialchars($data['personal']['fullName'] ?? ''); ?></h1>
                    <p class="job-title"><?= htmlspecialchars($data['personal']['jobTitle'] ?? ''); ?></p>
                </td>
            </tr>
        </table>

        <!-- CONTACT -->
        <div class="contact-info">
            <?php if (!empty($data['personal']['email'])): ?>
                <span><?= htmlspecialchars($data['personal']['email']); ?></span>
            <?php endif; ?>
            <?php if (!empty($data['personal']['phone'])): ?>
                <span> | <?= htmlspecialchars($data['personal']['phone']); ?></span>
            <?php endif; ?>
            <?php if (!empty($data['personal']['address'])): ?>
                <span> | <?= htmlspecialchars($data['personal']['address']); ?></span>
            <?php endif; ?>
        </div>

        <!-- SOCIAL -->
        <div class="social-links">
            <?php if (!empty($data['personal']['linkedin'])): ?>
                <span><?= htmlspecialchars($data['personal']['linkedin']); ?></span>
            <?php endif; ?>
            <?php if (!empty($data['personal']['website'])): ?>
                <span><?= htmlspecialchars($data['personal']['website']); ?></span>
            <?php endif; ?>
            <?php if (!empty($data['personal']['github'])): ?>
                <span><?= htmlspecialchars($data['personal']['github']); ?></span>
            <?php endif; ?>
        </div>

    </div>

    <!-- ================= SUMMARY ================= -->
    <?php if (!empty($data['personal']['profileSummary'])): ?>
        <div class="resume-section">
            <div class="summary-box">
                <?= nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- ================= EXPERIENCE ================= -->
    <?php if (!empty($data['workExperience'])): ?>
        <div class="resume-section">
            <h2>Professional Experience</h2>
            <?php foreach ($data['workExperience'] as $exp): ?>
                <div class="experience-item">
                    <table width="100%">
                        <tr>
                            <td><strong><?= htmlspecialchars($exp['job_role'] ?? ''); ?></strong></td>
                            <td class="date"><?= htmlspecialchars($exp['start_date'] ?? ''); ?> - <?= htmlspecialchars($exp['end_date'] ?? ''); ?></td>
                        </tr>
                    </table>
                    <p class="company"><?= htmlspecialchars($exp['company'] ?? ''); ?></p>
                    <p><?= nl2br(htmlspecialchars($exp['responsibilities'] ?? '')); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= EDUCATION ================= -->
    <?php if (!empty($data['education'])): ?>
        <div class="resume-section">
            <h2>Education</h2>
            <?php foreach ($data['education'] as $edu): ?>
                <div class="education-item">
                    <table width="100%">
                        <tr>
                            <td><strong><?= htmlspecialchars($edu['degree'] ?? ''); ?></strong></td>
                            <td class="date"><?= htmlspecialchars($edu['start_year'] ?? ''); ?> - <?= htmlspecialchars($edu['end_year'] ?? ''); ?></td>
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

    <!-- ================= SKILLS ================= -->
    <?php if (!empty($data['skills'])): ?>
        <div class="resume-section">
            <h2>Core Competencies</h2>
            <?php foreach ($data['skills'] as $skill): ?>
                <div class="skill-item">
                    <span class="skill-name"><?= htmlspecialchars($skill['skillName'] ?? ''); ?></span>
                    <span class="skill-level"><?= htmlspecialchars($skill['level'] ?? ''); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= LANGUAGES ================= -->
    <?php if (!empty($data['languages'])): ?>
        <div class="resume-section">
            <h2>Languages</h2>
            <?php foreach ($data['languages'] as $lang): ?>
                <span class="language-item">
                    <?= htmlspecialchars($lang['languageName'] ?? ''); ?> (<?= htmlspecialchars($lang['proficiency'] ?? ''); ?>)
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
<STYLE>.resume-document {
    font-family: DejaVu Sans, Arial, sans-serif;
    color: #1a3a52;
    padding: 40px;
    background: #ffffff;
    line-height: 1.6;
}

/* HEADER */
.resume-header {
    background: #1a3a52;
    color: #ffffff;
    padding: 30px;
    margin: -40px -40px 30px -40px;
    border-bottom: 5px solid #f39c12;
}

.header-left { width: 120px; }

.profile-image {
    width: 100px;
    height: 100px;
    border: 4px solid #f39c12;
    border-radius: 8px;
}

/* TEXT */
.resume-header h1 {
    font-size: 28px;
    margin: 0;
}

.job-title {
    font-size: 15px;
    color: #e8f4f8;
}

/* CONTACT */
.contact-info {
    font-size: 11px;
    margin-top: 10px;
    border-top: 1px solid #f39c12;
    padding-top: 8px;
}

.social-links span {
    font-size: 11px;
    margin-right: 10px;
}

/* SECTIONS */
.resume-section {
    margin-bottom: 24px;
}

.resume-section h2 {
    font-size: 13px;
    border-bottom: 3px solid #f39c12;
    padding-bottom: 6px;
}

/* SUMMARY */
.summary-box {
    background: #f0f7ff;
    padding: 16px;
    border-left: 4px solid #f39c12;
}

/* ITEMS */
.date {
    text-align: right;
    font-size: 11px;
    color: #7f8c8d;
}

.company, .institute {
    font-size: 11px;
    color: #2c5aa0;
    font-weight: bold;
}

/* SKILLS */
.skill-item {
    width: 48%;
    display: inline-block;
    font-size: 11px;
    padding: 6px 0;
    border-bottom: 1px solid #e0e0e0;
}

.skill-level {
    float: right;
    color: #2c5aa0;
}

/* LANGUAGES */
.language-item {
    font-size: 11px;
    margin-right: 10px;
    display: inline-block;
}
</STYLE>