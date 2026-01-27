<?php
/**
 * Mono Editorial Right Sidebar Theme
 * Clean, professional, black & white
 * PDF Safe + ATS Safe
 */

if (!isset($data)) {
    $data = $_SESSION['resume_data'] ?? [];
}

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
/* BASE */
.resume-document {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 12px;
    color: #222222;
    background: #ffffff;
}

/* TABLE LAYOUT */
.resume-table {
    width: 100%;
    border-collapse: collapse;
}

/* MAIN CONTENT (LEFT) */
.main-content {
    width: 70%;
    padding: 32px 34px;
    vertical-align: top;
}

/* SIDEBAR (RIGHT) */
.sidebar {
    width: 30%;
    background: #f3f3f3;
    color: #111111;
    vertical-align: top;
    padding: 28px 24px;
    border-left: 3px solid #111111;
}

/* PROFILE */
.profile-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 2px solid #111111;
    object-fit: cover;
    margin-bottom: 14px;
}

.sidebar h1 {
    font-size: 17px;
    margin: 0 0 4px 0;
}

.job-title {
    font-size: 11px;
    color: #555555;
    margin-bottom: 18px;
}

/* SIDEBAR SECTIONS */
.sidebar-section {
    margin-bottom: 18px;
}

.sidebar-section h2 {
    font-size: 10.5px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border-bottom: 1px solid #999999;
    padding-bottom: 4px;
    margin-bottom: 8px;
}

.sidebar span {
    display: block;
    font-size: 10.5px;
    margin-bottom: 6px;
    line-height: 1.4;
}

/* SKILLS */
.skill-tag {
    display: inline-block;
    font-size: 10px;
    padding: 3px 6px;
    margin: 0 4px 6px 0;
    border: 1px solid #777777;
    border-radius: 3px;
    color: #111111;
}

/* MAIN SECTIONS */
.section {
    margin-bottom: 26px;
}

.section h2 {
    font-size: 14px;
    color: #111111;
    border-bottom: 2px solid #111111;
    padding-bottom: 6px;
    margin-bottom: 12px;
}

/* ITEMS */
.item-header {
    width: 100%;
    margin-bottom: 3px;
}

.item-header h3 {
    font-size: 12px;
    margin: 0;
}

.date {
    font-size: 11px;
    color: #555555;
    text-align: right;
}

.company,
.institute {
    font-size: 11px;
    font-weight: bold;
    margin-bottom: 4px;
}

p {
    font-size: 11px;
    margin: 0 0 8px 0;
}
</style>
</head>

<body>
<div class="resume-document">
<table class="resume-table">
<tr>

<!-- ================= MAIN CONTENT (LEFT) ================= -->
<td class="main-content">

<?php if (!empty($data['personal']['profileSummary'])): ?>
<div class="section">
    <h2>Summary</h2>
    <p><?= nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
</div>
<?php endif; ?>

<?php if (!empty($data['workExperience'])): ?>
<div class="section">
    <h2>Experience</h2>
    <?php foreach ($data['workExperience'] as $exp): ?>
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
        <p><?= nl2br(htmlspecialchars($exp['responsibilities'] ?? '')); ?></p>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (!empty($data['education'])): ?>
<div class="section">
    <h2>Education</h2>
    <?php foreach ($data['education'] as $edu): ?>
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
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (!empty($data['projects'])): ?>
<div class="section">
    <h2>Projects</h2>
    <?php foreach ($data['projects'] as $project): ?>
        <h3><?= htmlspecialchars($project['projectName'] ?? ''); ?></h3>
        <p><?= nl2br(htmlspecialchars($project['description'] ?? '')); ?></p>
    <?php endforeach; ?>
</div>
<?php endif; ?>

</td>

<!-- ================= SIDEBAR (RIGHT) ================= -->
<td class="sidebar">

    <img
        src="<?php echo getProfileImage(
            $data['personal']['profilePicture'] ?? '',
            $data['personal']['fullName'] ?? 'User'
        ); ?>"
        class="profile-image"
        alt="Profile Photo"
    >

    <h1><?= htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
    <p class="job-title"><?= htmlspecialchars($data['personal']['jobTitle'] ?? 'Position'); ?></p>

    <!-- CONTACT -->
    <div class="sidebar-section">
        <h2>Contact</h2>
        <?php if (!empty($data['personal']['email'])): ?>
            <span><?= htmlspecialchars($data['personal']['email']); ?></span>
        <?php endif; ?>
        <?php if (!empty($data['personal']['phone'])): ?>
            <span><?= htmlspecialchars($data['personal']['phone']); ?></span>
        <?php endif; ?>
        <?php if (!empty($data['personal']['linkedin'])): ?>
            <span><?= htmlspecialchars($data['personal']['linkedin']); ?></span>
        <?php endif; ?>
    </div>

    <!-- SKILLS -->
    <?php if (!empty($data['skills'])): ?>
    <div class="sidebar-section">
        <h2>Skills</h2>
        <?php foreach ($data['skills'] as $skill): ?>
            <span class="skill-tag"><?= htmlspecialchars($skill['skillName']); ?></span>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- LANGUAGES -->
    <?php if (!empty($data['languages'])): ?>
    <div class="sidebar-section">
        <h2>Languages</h2>
        <?php foreach ($data['languages'] as $lang): ?>
            <span>
                <?= htmlspecialchars($lang['languageName']); ?>
                (<?= htmlspecialchars($lang['proficiency']); ?>)
            </span>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</td>

</tr>
</table>
</div>
</body>
</html>
