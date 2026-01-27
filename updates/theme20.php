<?php
/**
 * Creative Mono Sidebar Theme
 * Clean, professional, black & white sidebar
 * PDF Safe + Preview Safe
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

/* SIDEBAR */
.sidebar {
    width: 30%;
    background: #111111;
    color: #ffffff;
    vertical-align: top;
    padding: 30px;
}

.profile-image {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    border: 3px solid #ffffff;
    object-fit: cover;
    margin-bottom: 16px;
}

.sidebar h1 {
    font-size: 18px;
    margin: 0 0 4px 0;
}

.job-title {
    font-size: 12px;
    color: #cccccc;
    margin-bottom: 20px;
}

/* SIDEBAR SECTIONS */
.sidebar-section {
    margin-bottom: 20px;
}

.sidebar-section h2 {
    font-size: 11px;
    text-transform: uppercase;
    border-bottom: 1px solid #ffffff;
    padding-bottom: 3px;
    margin-bottom: 8px;
}

.sidebar span {
    display: block;
    font-size: 11px;
    margin-bottom: 6px;
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
    color: #111111;
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
