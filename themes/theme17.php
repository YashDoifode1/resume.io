<?php
/**
 * Minimal Ivory Sidebar Theme (Redesigned)
 * Preview Safe + PDF Safe
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
    color: #111827;
    background: #ffffff;
}

/* LAYOUT */
.resume-table {
    width: 100%;
    border-collapse: collapse;
}

/* SIDEBAR */
.sidebar {
    width: 30%;
    background: #f4f4f5;
    vertical-align: top;
    padding: 25px;
    border-right: 1px solid #e5e7eb;
}

.sidebar .profile-image {
    width: 105px;
    height: 105px;
    border-radius: 50%;
    border: 3px solid #6366f1;
    object-fit: cover;
    margin-bottom: 14px;
}

.sidebar h1 {
    font-size: 19px;
    margin: 0 0 4px 0;
    color: #111827;
}

.sidebar .job-title {
    font-size: 12px;
    color: #4f46e5;
    margin-bottom: 18px;
}

.sidebar-section {
    margin-bottom: 22px;
}

.sidebar-section h2 {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 1px solid #c7d2fe;
    padding-bottom: 4px;
    margin-bottom: 8px;
    color: #3730a3;
}

.sidebar span {
    display: block;
    font-size: 11px;
    margin-bottom: 6px;
    color: #1f2937;
}

/* MAIN CONTENT */
.main-content {
    width: 70%;
    padding: 30px;
    vertical-align: top;
}

.section {
    margin-bottom: 24px;
}

.section h2 {
    font-size: 14px;
    color: #3730a3;
    border-bottom: 2px solid #c7d2fe;
    padding-bottom: 6px;
    margin-bottom: 12px;
}

.item-header {
    width: 100%;
    margin-bottom: 3px;
}

.item-header h3 {
    font-size: 12px;
    margin: 0;
    color: #111827;
}

.date {
    font-size: 11px;
    color: #6b7280;
    text-align: right;
}

.company,
.institute {
    font-size: 11px;
    color: #4f46e5;
    font-weight: bold;
    margin-bottom: 4px;
}

/* TEXT */
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

<!-- ============ SIDEBAR ============ -->
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
    <p class="job-title"><?= htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>

    <!-- CONTACT -->
    <div class="sidebar-section">
        <h2>Contact</h2>
        <?php if (!empty($data['personal']['email'])): ?>
            <span><?= htmlspecialchars($data['personal']['email']); ?></span>
        <?php endif; ?>
        <?php if (!empty($data['personal']['phone'])): ?>
            <span><?= htmlspecialchars($data['personal']['phone']); ?></span>
        <?php endif; ?>
        <?php if (!empty($data['personal']['address'])): ?>
            <span><?= htmlspecialchars($data['personal']['address']); ?></span>
        <?php endif; ?>
    </div>

    <!-- SKILLS -->
    <?php if (!empty($data['skills'])): ?>
    <div class="sidebar-section">
        <h2>Skills</h2>
        <?php foreach ($data['skills'] as $skill): ?>
            <span><?= htmlspecialchars($skill['skillName']); ?></span>
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

<!-- ============ MAIN CONTENT ============ -->
<td class="main-content">

<?php if (!empty($data['personal']['profileSummary'])): ?>
<div class="section">
    <h2>Professional Summary</h2>
    <p><?= nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
</div>
<?php endif; ?>

<?php if (!empty($data['workExperience'])): ?>
<div class="section">
    <h2>Work Experience</h2>
    <?php foreach ($data['workExperience'] as $exp): ?>
        <table class="item-header">
            <tr>
                <td><h3><?= htmlspecialchars($exp['jobRole'] ?? ''); ?></h3></td>
                <td class="date"><?= htmlspecialchars($exp['startDate'] ?? ''); ?> - <?= htmlspecialchars($exp['endDate'] ?? ''); ?></td>
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
                <td class="date"><?= htmlspecialchars($edu['startYear'] ?? ''); ?> - <?= htmlspecialchars($edu['endYear'] ?? ''); ?></td>
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
</tr>
</table>

</div>
</body>
</html>
