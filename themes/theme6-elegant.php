<?php
/**
 * Elegant Gold Theme - PDF Safe Version
 * Luxury design with gold accents for professionals
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
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
<title>Resume PDF</title>
<style>
body {
    font-family: 'DejaVu Sans', serif;
    font-size: 12px;
    color: #2c2c2c;
    line-height: 1.6;
    margin: 0;
    padding: 20px;
    background: #fefef8;
}

/* HEADER */
.resume-header {
    background: #1a1a1a;
    color: #f4e4c1;
    padding: 30px;
    margin: -20px -20px 25px -20px;
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

/* CONTACT INFO */
.contact-info-table {
    width: 100%;
    font-size: 11px;
    margin-bottom: 10px;
}

.contact-info-table td {
    padding-right: 15px;
}

/* SOCIAL LINKS */
.social-links a {
    color: #d4af37;
    text-decoration: none;
    font-size: 11px;
    margin-right: 12px;
}

/* SUMMARY BOX */
.summary-box {
    background: #f0ede4;
    padding: 20px;
    border-left: 4px solid #d4af37;
    border-radius: 4px;
    line-height: 1.6;
}

/* SECTIONS */
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
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 2px;
    gap: 10px;
}

.item-header h3 {
    font-size: 12px;
    margin: 0;
    font-weight: 700;
    color: #1a1a1a;
}

.date {
    font-size: 11px;
    color: #666;
    white-space: nowrap;
}

.company,
.institute {
    font-size: 11px;
    color: #d4af37;
    margin: 0 0 4px 0;
    font-weight: 600;
}

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
    color: #1a1a1a;
    border: 1px solid #d4af37;
}

a {
    color: #2c2c2c;
    text-decoration: none;
    font-size: 11px;
}

@media print {
    body {
        padding: 0;
    }
    .resume-header {
        margin: 0;
    }
    .profile-image {
        width: 100px;
        height: 100px;
    }
    .header-text h1 {
        font-size: 24px;
    }
}
</style>
</head>
<body>

<!-- HEADER -->
<div class="resume-header">
    <table class="header-table">
        <tr>
            <td width="130">
                <?php if (!empty($data['personal']['profilePicture'])): ?>
                    <img src="<?php echo getProfileImage($data['personal']['profilePicture'] ?? '', $data['personal']['fullName'] ?? 'User'); ?>" class="profile-image">
                <?php endif; ?>
            </td>
            <td>
                <div class="header-text">
                    <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                    <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>
                    
                    <table class="contact-info-table">
                        <tr>
                            <?php if (!empty($data['personal']['email'])): ?>
                                <td><?php echo htmlspecialchars($data['personal']['email']); ?></td>
                            <?php endif; ?>
                            <?php if (!empty($data['personal']['phone'])): ?>
                                <td><?php echo htmlspecialchars($data['personal']['phone']); ?></td>
                            <?php endif; ?>
                        </tr>
                    </table>

                    <p class="social-links">
                        <?php if (!empty($data['personal']['website'])): ?><a href="<?php echo htmlspecialchars($data['personal']['website']); ?>">Website</a><?php endif; ?>
                        <?php if (!empty($data['personal']['linkedin'])): ?><a href="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>">LinkedIn</a><?php endif; ?>
                    </p>
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- PROFESSIONAL SUMMARY -->
<?php if (!empty($data['personal']['profileSummary'])): ?>
<div class="resume-section">
    <div class="summary-box">
        <?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?>
    </div>
</div>
<?php endif; ?>

<!-- WORK EXPERIENCE -->
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

<!-- EDUCATION -->
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

<!-- SKILLS -->
<?php if (!empty($data['skills'])): ?>
<div class="resume-section">
    <h2>Core Competencies</h2>
    <div class="skills-container">
        <?php foreach ($data['skills'] as $skill): ?>
        <span class="skill-badge"><?php echo htmlspecialchars($skill['skillName'] ?? ''); ?></span>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- PROJECTS -->
<?php if (!empty($data['projects'])): ?>
<div class="resume-section">
    <h2>Notable Projects</h2>
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

<!-- CERTIFICATIONS -->
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

<!-- LANGUAGES -->
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

</body>
</html>
