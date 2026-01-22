<?php
/**
 * Vibrant Colors Theme - PDF-friendly version
 * Uses HEX colors for exact consistency
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}

// Helper to get absolute image path for PDF
function getProfileImage($path) {
    if (!$path) return '';
    if (strpos($path, 'http') !== 0) {
        return BASE_URL . ltrim($path, '/');
    }
    return $path;
}

// HEX colors for skill badges
$skillColors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#FFA07A', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E2'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Resume PDF - Vibrant Theme</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 12px;
    color: #2c3e50;
    line-height: 1.6;
    margin: 0;
    padding: 20px;
    background: #f8f9fa;
}

/* HEADER */
.resume-header {
    background-color: #764ba2; /* solid HEX for PDF */
    color: white;
    padding: 25px;
    margin: -20px -20px 25px -20px;
    border-radius: 0 0 10px 10px;
}

.header-table {
    width: 100%;
    border-collapse: collapse;
}

.header-table td {
    vertical-align: top;
}

.profile-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #FFFFFF;
}

.header-text h1 {
    font-size: 28px;
    margin: 0 0 5px 0;
    font-weight: 700;
}

.job-title {
    font-size: 16px;
    color: #FFD700; /* gold-like for contrast */
    margin: 0 0 10px 0;
    font-weight: 500;
}

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
    color: #FFFFFF;
    text-decoration: none;
    font-size: 11px;
    margin-right: 12px;
    border-bottom: 1px solid #FFFFFF;
    padding-bottom: 2px;
}

/* SUMMARY */
.summary {
    font-size: 13px;
    line-height: 1.7;
    color: #2c3e50;
}

/* SECTIONS */
.resume-section {
    margin-bottom: 24px;
    background: #FFFFFF;
    padding: 16px;
    border-radius: 8px;
    border-left: 4px solid #667eea; /* HEX color for section border */
}

.resume-section h2 {
    font-size: 14px;
    color: #667eea; /* HEX for section title */
    margin: 0 0 12px 0;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 2px;
}

.item-header h3 {
    font-size: 13px;
    margin: 0;
    color: #2c3e50;
    font-weight: 700;
}

.date {
    font-size: 12px;
    color: #95a5a6;
    white-space: nowrap;
}

.company,
.institute {
    font-size: 12px;
    color: #667eea;
    margin: 0 0 4px 0;
    font-weight: 600;
}

.skills-container,
.languages-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.skill-badge {
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 12px;
    color: #FFFFFF;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.language-item {
    background: #e8f4f8;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 12px;
    color: #2c3e50;
}

@media print {
    body { padding: 0; background: white; }
    .resume-header { margin: 0; border-radius: 0; }
    .resume-section { background: white; border-left: 4px solid #667eea; }
}
</style>
</head>
<body>

<!-- HEADER -->
<div class="resume-header">
    <table class="header-table">
        <tr>
            <td width="110">
                <?php if (!empty($data['personal']['profilePicture'])): ?>
                    <img src="<?php echo getProfileImage($data['personal']['profilePicture']); ?>" class="profile-image">
                <?php endif; ?>
            </td>
            <td>
                <div class="header-text">
                    <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                    <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>

                    <table class="contact-info-table">
                        <tr>
                            <?php if (!empty($data['personal']['email'])): ?><td><?php echo htmlspecialchars($data['personal']['email']); ?></td><?php endif; ?>
                            <?php if (!empty($data['personal']['phone'])): ?><td><?php echo htmlspecialchars($data['personal']['phone']); ?></td><?php endif; ?>
                            <?php if (!empty($data['personal']['address'])): ?><td><?php echo htmlspecialchars($data['personal']['address']); ?></td><?php endif; ?>
                        </tr>
                    </table>

                    <p class="social-links">
                        <?php if (!empty($data['personal']['website'])): ?><a href="<?php echo htmlspecialchars($data['personal']['website']); ?>">Portfolio</a><?php endif; ?>
                        <?php if (!empty($data['personal']['linkedin'])): ?><a href="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>">LinkedIn</a><?php endif; ?>
                        <?php if (!empty($data['personal']['github'])): ?><a href="<?php echo htmlspecialchars($data['personal']['github']); ?>">GitHub</a><?php endif; ?>
                    </p>
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- SUMMARY -->
<?php if (!empty($data['personal']['profileSummary'])): ?>
<div class="resume-section">
    <p class="summary"><?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
</div>
<?php endif; ?>

<!-- EXPERIENCE -->
<?php if (!empty($data['workExperience'])): ?>
<div class="resume-section">
    <h2>Experience</h2>
    <?php foreach ($data['workExperience'] as $exp): ?>
    <div class="experience-item">
        <div class="item-header">
            <h3><?php echo htmlspecialchars($exp['jobRole'] ?? ''); ?></h3>
            <span class="date"><?php echo htmlspecialchars($exp['startDate'] ?? ''); ?> - <?php echo htmlspecialchars($exp['endDate'] ?? ''); ?></span>
        </div>
        <p class="company"><?php echo htmlspecialchars($exp['company'] ?? ''); ?></p>
        <?php if (!empty($exp['responsibilities'])): ?><p><?php echo nl2br(htmlspecialchars($exp['responsibilities'])); ?></p><?php endif; ?>
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
            <span class="date"><?php echo htmlspecialchars($edu['startYear'] ?? ''); ?> - <?php echo htmlspecialchars($edu['endYear'] ?? ''); ?></span>
        </div>
        <p class="institute"><?php echo htmlspecialchars($edu['institute'] ?? ''); ?></p>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- SKILLS -->
<?php if (!empty($data['skills'])): ?>
<div class="resume-section">
    <h2>Skills</h2>
    <div class="skills-container">
        <?php foreach ($data['skills'] as $index => $skill): ?>
            <div class="skill-badge" style="background-color: <?php echo $skillColors[$index % count($skillColors)]; ?>;">
                <?php echo htmlspecialchars($skill['skillName'] ?? ''); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- PROJECTS -->
<?php if (!empty($data['projects'])): ?>
<div class="resume-section">
    <h2>Projects</h2>
    <?php foreach ($data['projects'] as $project): ?>
    <div class="project-item">
        <h3><?php echo htmlspecialchars($project['projectName'] ?? ''); ?></h3>
        <?php if (!empty($project['technologiesUsed'])): ?><p><strong>Tech:</strong> <?php echo htmlspecialchars($project['technologiesUsed']); ?></p><?php endif; ?>
        <?php if (!empty($project['description'])): ?><p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p><?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- CERTIFICATIONS -->
<?php if (!empty($data['certifications'])): ?>
<div class="resume-section">
    <h2>Certifications</h2>
    <?php foreach ($data['certifications'] as $cert): ?>
    <div class="certification-item">
        <h3><?php echo htmlspecialchars($cert['certificateTitle'] ?? ''); ?></h3>
        <p><?php echo htmlspecialchars($cert['issuedBy'] ?? ''); ?> - <?php echo htmlspecialchars($cert['year'] ?? ''); ?></p>
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
