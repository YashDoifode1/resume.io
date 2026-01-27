<?php
/**
 * Elegant Gold Theme - Preview & PDF Safe Version
 * FIXED: No body styling, no negative margins, container-safe
 */

if (!isset($data)) {
    $data = $_SESSION['resume_data'] ?? [];
}

// Placeholder image function for PDF
if (!function_exists('getProfileImage')) {
    require_once __DIR__ . '/../utils/placeholder-generator.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Resume</title>

<style>
/* ==============================
   MAIN CONTAINER (IMPORTANT FIX)
   ============================== */
.resume-document {
    font-family: 'DejaVu Sans', serif;
    font-size: 12px;
    color: #2c2c2c;
    line-height: 1.6;
    background: #fefef8;
    padding: 20px;
}

/* ==============================
   HEADER
   ============================== */
.resume-header {
    background: #1a1a1a;
    color: #f4e4c1;
    padding: 30px;
    margin-bottom: 25px;
    border-bottom: 3px solid #d4af37;
}

.header-table {
    width: 100%;
    border-collapse: collapse;
}

.header-table td {
    vertical-align: top;
}

.profile-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #d4af37;
}

.header-text h1 {
    font-size: 28px;
    margin: 0 0 5px 0;
    font-weight: 700;
    letter-spacing: 1px;
}

.job-title {
    font-size: 14px;
    color: #d4af37;
    margin: 0 0 10px 0;
    font-weight: 500;
}

/* ==============================
   CONTACT INFO
   ============================== */
.contact-info-table {
    width: 100%;
    font-size: 11px;
    margin-bottom: 10px;
}

.contact-info-table td {
    padding-right: 15px;
}

.social-links a {
    color: #d4af37;
    text-decoration: none;
    font-size: 11px;
    margin-right: 12px;
}

/* ==============================
   SUMMARY
   ============================== */
.summary-box {
    background: #f0ede4;
    padding: 20px;
    border-left: 4px solid #d4af37;
    border-radius: 4px;
}

/* ==============================
   SECTIONS
   ============================== */
.resume-section {
    margin-bottom: 25px;
}

.resume-section h2 {
    font-size: 13px;
    color: #1a1a1a;
    border-bottom: 2px solid #d4af37;
    padding-bottom: 6px;
    margin: 0 0 10px 0;
    font-weight: 700;
    letter-spacing: 1px;
}

.item-header {
    display: table;
    width: 100%;
    margin-bottom: 2px;
}

.item-header h3 {
    display: table-cell;
    font-size: 12px;
    font-weight: 700;
    color: #1a1a1a;
}

.date {
    display: table-cell;
    text-align: right;
    font-size: 11px;
    color: #666;
    white-space: nowrap;
}

.company,
.institute {
    font-size: 11px;
    color: #d4af37;
    font-weight: 600;
    margin-bottom: 4px;
}

/* ==============================
   SKILLS & LANGUAGES
   ============================== */
.skills-container,
.languages-container {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.skill-badge,
.language-item {
    background: #f0ede4;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 11px;
    border: 1px solid #d4af37;
}

/* ==============================
   LINKS
   ============================== */
a {
    color: #2c2c2c;
    text-decoration: none;
    font-size: 11px;
}
</style>
</head>

<body>

<div class="resume-document">

<!-- HEADER -->
<div class="resume-header">
    <table class="header-table">
        <tr>
            <td width="140">
                <?php if (!empty($data['personal']['profilePicture'])): ?>
                    <img src="<?= getProfileImage(
                        $data['personal']['profilePicture'],
                        $data['personal']['fullName'] ?? 'User'
                    ); ?>" class="profile-image">
                <?php endif; ?>
            </td>
            <td>
                <div class="header-text">
                    <h1><?= htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                    <p class="job-title"><?= htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>

                    <table class="contact-info-table">
                        <tr>
                            <?php if (!empty($data['personal']['email'])): ?>
                                <td><?= htmlspecialchars($data['personal']['email']); ?></td>
                            <?php endif; ?>
                            <?php if (!empty($data['personal']['phone'])): ?>
                                <td><?= htmlspecialchars($data['personal']['phone']); ?></td>
                            <?php endif; ?>
                        </tr>
                    </table>

                    <p class="social-links">
                        <?php if (!empty($data['personal']['website'])): ?>
                            <a><?= htmlspecialchars($data['personal']['website']); ?></a>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['linkedin'])): ?>
                            <a><?= htmlspecialchars($data['personal']['linkedin']); ?></a>
                        <?php endif; ?>
                    </p>
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- SUMMARY -->
<?php if (!empty($data['personal']['profileSummary'])): ?>
<div class="resume-section">
    <div class="summary-box">
        <?= nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?>
    </div>
</div>
<?php endif; ?>

<!-- EXPERIENCE -->
<?php if (!empty($data['workExperience'])): ?>
<div class="resume-section">
    <h2>Professional Experience</h2>
    <?php foreach ($data['workExperience'] as $exp): ?>
        <div>
            <div class="item-header">
                <h3><?= htmlspecialchars($exp['jobRole'] ?? ''); ?></h3>
                <span class="date">
                    <?= htmlspecialchars($exp['startDate'] ?? ''); ?> –
                    <?= htmlspecialchars($exp['endDate'] ?? ''); ?>
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

<!-- EDUCATION -->
<?php if (!empty($data['education'])): ?>
<div class="resume-section">
    <h2>Education</h2>
    <?php foreach ($data['education'] as $edu): ?>
        <div>
            <div class="item-header">
                <h3><?= htmlspecialchars($edu['degree'] ?? ''); ?></h3>
                <span class="date">
                    <?= htmlspecialchars($edu['startYear'] ?? ''); ?> –
                    <?= htmlspecialchars($edu['endYear'] ?? ''); ?>
                </span>
            </div>
            <p class="institute"><?= htmlspecialchars($edu['institute'] ?? ''); ?></p>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- SKILLS -->
<?php if (!empty($data['skills'])): ?>
<div class="resume-section">
    <h2>Core Competencies</h2>
    <div class="skills-container">
        <?php foreach ($data['skills'] as $skill): ?>
            <span class="skill-badge"><?= htmlspecialchars($skill['skillName']); ?></span>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- PROJECTS -->
<?php if (!empty($data['projects'])): ?>
<div class="resume-section">
    <h2>Notable Projects</h2>
    <?php foreach ($data['projects'] as $project): ?>
        <div>
            <h3><?= htmlspecialchars($project['projectName']); ?></h3>
            <?php if (!empty($project['description'])): ?>
                <p><?= nl2br(htmlspecialchars($project['description'])); ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- CERTIFICATIONS -->
<?php if (!empty($data['certifications'])): ?>
<div class="resume-section">
    <h2>Certifications & Awards</h2>
    <?php foreach ($data['certifications'] as $cert): ?>
        <div>
            <h3><?= htmlspecialchars($cert['certificateTitle']); ?></h3>
            <p><?= htmlspecialchars($cert['issuedBy']); ?> • <?= htmlspecialchars($cert['year']); ?></p>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- LANGUAGES -->
<?php if (!empty($data['languages'])): ?>
<div class="resume-section">
    <h2>Languages</h2>
    <div class="languages-container">
        <?php foreach ($data['languages'] as $lang): ?>
            <span class="language-item">
                <?= htmlspecialchars($lang['languageName']); ?> —
                <?= htmlspecialchars($lang['proficiency']); ?>
            </span>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

</div>
</body>
</html>
