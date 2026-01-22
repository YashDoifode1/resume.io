<?php
/**
 * Classic Professional Theme - PDF Safe Version
 * Full resume with horizontal contact info
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}

// Placeholder image function
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
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #2c3e50;
    line-height: 1.5;
    margin: 0;
    padding: 20px;
    background: #ffffff;
}

.resume-header {
    border-bottom: 3px solid #2c3e50;
    padding-bottom: 20px;
    margin-bottom: 25px;
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
    border: 3px solid #3498db;
}

.header-text h1 {
    font-size: 24px;
    margin: 0 0 5px 0;
}

.job-title {
    font-size: 13px;
    margin: 0 0 10px 0;
    color: #7f8c8d;
}

/* Contact info side by side */
.contact-info-table {
    width: 100%;
    margin-bottom: 10px;
    font-size: 11px;
}

.contact-info-table td {
    padding-right: 15px;
}

.text-icon {
    font-weight: bold;
    color: #3498db;
}

/* Social links */
.social-links a {
    color: #3498db;
    text-decoration: none;
    font-size: 11px;
    margin-right: 10px;
}

/* Sections */
.resume-section {
    margin-bottom: 20px;
}

.resume-section h2 {
    font-size: 14px;
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 5px;
    margin-bottom: 10px;
}

.item-header {
    width: 100%;
    margin-bottom: 3px;
}

.item-header h3 {
    font-size: 12px;
    font-weight: bold;
    margin: 0;
}

.date {
    font-size: 11px;
    color: #95a5a6;
}

.company, .institute {
    font-size: 11px;
    color: #3498db;
    margin: 0 0 3px 0;
    font-weight: bold;
}

.skills-container,
.languages-container {
    display: block;
}

.skill-badge,
.language-item {
    display: inline-block;
    background: #ecf0f1;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 10px;
    margin: 2px 2px 2px 0;
}

.skill-level,
.proficiency {
    font-size: 10px;
    color: #7f8c8d;
}

a {
    color: #2c3e50;
    text-decoration: none;
    font-size: 11px;
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
                    <img src="<?php echo getProfileImage($data['personal']['profilePicture'] ?? '', $data['personal']['fullName'] ?? 'User'); ?>" class="profile-image">
                <?php endif; ?>
            </td>
            <td>
                <div class="header-text">
                    <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                    <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>
                    
                    <!-- Contact info horizontal -->
                    <table class="contact-info-table">
                        <tr>
                            <?php if (!empty($data['personal']['email'])): ?>
                                <td><span class="text-icon">E:</span> <?php echo htmlspecialchars($data['personal']['email']); ?></td>
                            <?php endif; ?>
                            <?php if (!empty($data['personal']['phone'])): ?>
                                <td><span class="text-icon">P:</span> <?php echo htmlspecialchars($data['personal']['phone']); ?></td>
                            <?php endif; ?>
                            <?php if (!empty($data['personal']['address'])): ?>
                                <td><span class="text-icon">A:</span> <?php echo htmlspecialchars($data['personal']['address']); ?></td>
                            <?php endif; ?>
                        </tr>
                    </table>

                    <!-- Social links -->
                    <p class="social-links">
                        <?php if (!empty($data['personal']['website'])): ?><a href="<?php echo htmlspecialchars($data['personal']['website']); ?>">Website</a><?php endif; ?>
                        <?php if (!empty($data['personal']['linkedin'])): ?><a href="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>">LinkedIn</a><?php endif; ?>
                        <?php if (!empty($data['personal']['github'])): ?><a href="<?php echo htmlspecialchars($data['personal']['github']); ?>">GitHub</a><?php endif; ?>
                    </p>
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- PROFESSIONAL SUMMARY -->
<?php if (!empty($data['personal']['profileSummary'])): ?>
<div class="resume-section">
    <h2>Professional Summary</h2>
    <p><?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
</div>
<?php endif; ?>

<!-- WORK EXPERIENCE -->
<?php if (!empty($data['workExperience'])): ?>
<div class="resume-section">
    <h2>Work Experience</h2>
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
        <?php if (!empty($edu['cgpa'])): ?>
            <p>CGPA: <?php echo htmlspecialchars($edu['cgpa']); ?></p>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- SKILLS -->
<?php if (!empty($data['skills'])): ?>
<div class="resume-section">
    <h2>Skills</h2>
    <div class="skills-container">
        <?php foreach ($data['skills'] as $skill): ?>
        <div class="skill-badge">
            <span class="skill-name"><?php echo htmlspecialchars($skill['skillName'] ?? ''); ?></span>
            <span class="skill-level"><?php echo htmlspecialchars($skill['level'] ?? ''); ?></span>
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
        <?php if (!empty($project['description'])): ?>
            <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
        <?php endif; ?>
        <?php if (!empty($project['technologiesUsed'])): ?>
            <p><strong>Technologies:</strong> <?php echo htmlspecialchars($project['technologiesUsed']); ?></p>
        <?php endif; ?>
        <?php if (!empty($project['projectLink'])): ?>
            <p><a href="<?php echo htmlspecialchars($project['projectLink']); ?>">View Project</a></p>
        <?php endif; ?>
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
        <div class="language-item">
            <span class="language-name"><?php echo htmlspecialchars($lang['languageName'] ?? ''); ?></span>
            <span class="proficiency"><?php echo htmlspecialchars($lang['proficiency'] ?? ''); ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- INTERESTS -->
<?php if (!empty($data['interests'])): ?>
<div class="resume-section">
    <h2>Interests</h2>
    <p><?php echo nl2br(htmlspecialchars($data['interests'])); ?></p>
</div>
<?php endif; ?>

</body>
</html>
