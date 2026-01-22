<?php
/**
 * Tech Startup Theme - Full PDF Version
 * Modern, tech-focused, PDF-friendly design
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}

// Helper for absolute path if needed (PDF-safe)
function getProfileImage($path) {
    if (!$path) return '';
    if (strpos($path, 'http') !== 0) {
        return BASE_URL . ltrim($path, '/');
    }
    return $path;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Resume PDF</title>
<style>
body {
    font-family: 'Courier New', monospace;
    font-size: 12px;
    color: #1a1a1a;
    line-height: 1.6;
    margin: 0;
    padding: 20px;
    background: #ffffff;
}

/* HEADER */
.resume-header {
    background: #0d47a1;
    color: white;
    padding: 25px;
    margin: -20px -20px 25px -20px;
    border-bottom: 4px solid #00bcd4;
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
    border-radius: 8px;
    object-fit: cover;
    border: 3px solid #00bcd4;
}

.header-text h1 {
    font-size: 26px;
    margin: 0 0 5px 0;
    font-weight: 700;
}

.job-title {
    font-size: 14px;
    color: #00bcd4;
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
    color: #00bcd4;
    text-decoration: none;
    font-size: 11px;
    margin-right: 12px;
}

/* SUMMARY */
.summary {
    font-size: 13px;
    line-height: 1.7;
    color: #333;
}

/* SECTIONS */
.resume-section {
    margin-bottom: 24px;
}

.resume-section h2 {
    font-size: 13px;
    color: #0d47a1;
    border-bottom: 2px solid #00bcd4;
    padding-bottom: 6px;
    margin: 0 0 10px 0;
    font-weight: 700;
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 2px;
}

.item-header h3 {
    font-size: 12px;
    margin: 0;
    font-weight: 700;
    color: #0d47a1;
}

.date {
    font-size: 11px;
    color: #666;
}

.company,
.institute {
    font-size: 11px;
    color: #00bcd4;
    margin: 0 0 4px 0;
    font-weight: 600;
}

.skills-container {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.skill-badge {
    background: #f0f0f0;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 11px;
    border: 1px solid #00bcd4;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.level {
    font-size: 11px;
    color: #0d47a1;
    font-weight: 600;
}

.tech {
    font-size: 11px;
    color: #00bcd4;
    margin: 4px 0;
}

@media print {
    body { padding: 0; }
    .resume-header { margin: 0; }
    .profile-image { width: 90px; height: 90px; }
    .header-text h1 { font-size: 24px; }
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
                            <?php if (!empty($data['personal']['email'])): ?>
                                <td><?php echo htmlspecialchars($data['personal']['email']); ?></td>
                            <?php endif; ?>
                            <?php if (!empty($data['personal']['phone'])): ?>
                                <td><?php echo htmlspecialchars($data['personal']['phone']); ?></td>
                            <?php endif; ?>
                            <?php if (!empty($data['personal']['address'])): ?>
                                <td><?php echo htmlspecialchars($data['personal']['address']); ?></td>
                            <?php endif; ?>
                        </tr>
                    </table>

                    <p class="social-links">
                        <?php if (!empty($data['personal']['github'])): ?><a href="<?php echo htmlspecialchars($data['personal']['github']); ?>">GitHub</a><?php endif; ?>
                        <?php if (!empty($data['personal']['linkedin'])): ?><a href="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>">LinkedIn</a><?php endif; ?>
                        <?php if (!empty($data['personal']['website'])): ?><a href="<?php echo htmlspecialchars($data['personal']['website']); ?>">Portfolio</a><?php endif; ?>
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
        <?php if (!empty($exp['responsibilities'])): ?>
            <p><?php echo nl2br(htmlspecialchars($exp['responsibilities'])); ?></p>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- SKILLS -->
<?php if (!empty($data['skills'])): ?>
<div class="resume-section">
    <h2>Technical Skills</h2>
    <div class="skills-container">
        <?php foreach ($data['skills'] as $skill): ?>
        <div class="skill-badge">
            <span><?php echo htmlspecialchars($skill['skillName'] ?? ''); ?></span>
            <span class="level"><?php echo htmlspecialchars($skill['level'] ?? ''); ?></span>
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
        <?php if (!empty($project['technologiesUsed'])): ?>
            <p class="tech"><strong>Tech:</strong> <?php echo htmlspecialchars($project['technologiesUsed']); ?></p>
        <?php endif; ?>
        <?php if (!empty($project['description'])): ?>
            <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
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
            <span class="date"><?php echo htmlspecialchars($edu['startYear'] ?? ''); ?> - <?php echo htmlspecialchars($edu['endYear'] ?? ''); ?></span>
        </div>
        <p class="institute"><?php echo htmlspecialchars($edu['institute'] ?? ''); ?></p>
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

</body>
</html>
