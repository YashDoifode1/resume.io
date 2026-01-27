<?php
/**
 * Gradient Modern Theme – FIXED ALIGNMENT (Preview Safe)
 * PDF + Resume Builder compatible
 */

if (!isset($data)) {
    $data = $_SESSION['resume_data'] ?? [];
}

if (!function_exists('getProfileImage')) {
    require_once __DIR__ . '/../utils/placeholder-generator.php';
}
?>

<div class="resume-document theme-gradient-modern">

    <!-- ================= HEADER ================= -->
    <div class="resume-header">

        <table class="resume-header-table" width="100%">
            <tr>
                <td width="100">
                    <img src="<?php echo getProfileImage(
                        $data['personal']['profilePicture'] ?? '',
                        $data['personal']['fullName'] ?? 'User'
                    ); ?>" class="profile-image">
                </td>
                <td>
                    <h1 class="header-name">
                        <?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?>
                    </h1>
                    <p class="job-title">
                        <?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?>
                    </p>

                    <p class="contact-line">
                        <?php if (!empty($data['personal']['email'])) echo htmlspecialchars($data['personal']['email']); ?>
                        <?php if (!empty($data['personal']['phone'])) echo ' | ' . htmlspecialchars($data['personal']['phone']); ?>
                        <?php if (!empty($data['personal']['address'])) echo ' | ' . htmlspecialchars($data['personal']['address']); ?>
                    </p>

                    <p class="social-links">
                        <?php if (!empty($data['personal']['website'])): ?>
                            <a href="<?php echo htmlspecialchars($data['personal']['website']); ?>">Website</a>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['linkedin'])): ?>
                            <a href="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>">LinkedIn</a>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['github'])): ?>
                            <a href="<?php echo htmlspecialchars($data['personal']['github']); ?>">GitHub</a>
                        <?php endif; ?>
                    </p>
                </td>
            </tr>
        </table>

    </div>

    <!-- ================= SUMMARY ================= -->
    <?php if (!empty($data['personal']['profileSummary'])): ?>
        <div class="resume-section">
            <h2>Professional Summary</h2>
            <p><?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
        </div>
    <?php endif; ?>

    <!-- ================= EXPERIENCE ================= -->
    <?php if (!empty($data['workExperience'])): ?>
        <div class="resume-section">
            <h2>Work Experience</h2>
            <?php foreach ($data['workExperience'] as $exp): ?>
                <div class="experience-item">
                    <table width="100%">
                        <tr>
                            <td><strong><?php echo htmlspecialchars($exp['jobRole'] ?? ''); ?></strong></td>
                            <td class="date">
                                <?php echo htmlspecialchars($exp['startDate'] ?? ''); ?> -
                                <?php echo htmlspecialchars($exp['endDate'] ?? ''); ?>
                            </td>
                        </tr>
                    </table>
                    <p class="company"><?php echo htmlspecialchars($exp['company'] ?? ''); ?></p>
                    <?php if (!empty($exp['responsibilities'])): ?>
                        <p><?php echo nl2br(htmlspecialchars($exp['responsibilities'])); ?></p>
                    <?php endif; ?>
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
                            <td><strong><?php echo htmlspecialchars($edu['degree'] ?? ''); ?></strong></td>
                            <td class="date">
                                <?php echo htmlspecialchars($edu['startYear'] ?? ''); ?> -
                                <?php echo htmlspecialchars($edu['endYear'] ?? ''); ?>
                            </td>
                        </tr>
                    </table>
                    <p class="institute"><?php echo htmlspecialchars($edu['institute'] ?? ''); ?></p>
                    <?php if (!empty($edu['cgpa'])): ?>
                        <p>CGPA: <?php echo htmlspecialchars($edu['cgpa']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= SKILLS ================= -->
    <?php if (!empty($data['skills'])): ?>
        <div class="resume-section">
            <h2>Skills</h2>
            <div class="skills-container">
                <?php foreach ($data['skills'] as $skill): ?>
                    <span class="skill-badge">
                        <?php echo htmlspecialchars($skill['skillName'] ?? ''); ?>
                        <span class="skill-level">
                            <?php echo htmlspecialchars($skill['level'] ?? ''); ?>
                        </span>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- ================= PROJECTS ================= -->
    <?php if (!empty($data['projects'])): ?>
        <div class="resume-section">
            <h2>Projects</h2>
            <?php foreach ($data['projects'] as $project): ?>
                <div class="project-item">
                    <strong><?php echo htmlspecialchars($project['projectName'] ?? ''); ?></strong>
                    <?php if (!empty($project['description'])): ?>
                        <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= LANGUAGES ================= -->
    <?php if (!empty($data['languages'])): ?>
        <div class="resume-section">
            <h2>Languages</h2>
            <div class="languages-container">
                <?php foreach ($data['languages'] as $lang): ?>
                    <span class="language-item">
                        <?php echo htmlspecialchars($lang['languageName'] ?? ''); ?>
                        (<?php echo htmlspecialchars($lang['proficiency'] ?? ''); ?>)
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<style>
/* ================= CONTAINER ================= */
.resume-document {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 12px;
    color: #2c3e50;
    background: #ffffff;
    line-height: 1.5;
    padding: 24px; /* FIXED */
}

/* ================= HEADER ================= */
.resume-header {
    background: #667eea;
    color: #ffffff;
    padding: 22px;
    margin-bottom: 24px;
}

.profile-image {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 3px solid #ffffff;
}

.header-name {
    font-size: 22px;
    margin: 0 0 4px 0;
    font-weight: bold;
}

.job-title {
    font-size: 13px;
    margin: 0 0 8px 0;
}

.contact-line {
    font-size: 11px;
    margin-bottom: 6px;
}

.social-links a {
    font-size: 11px;
    color: #ffffff;
    margin-right: 8px;
    text-decoration: none;
}

/* ================= SECTIONS ================= */
.resume-section {
    margin-bottom: 20px;
}

.resume-section h2 {
    font-size: 14px;
    margin-bottom: 8px;
    padding-left: 6px;
    border-left: 4px solid #667eea;
}

/* ================= ITEMS ================= */
.date {
    text-align: right;
    font-size: 11px;
    color: #95a5a6;
}

.company,
.institute {
    font-size: 11px;
    color: #667eea;
    font-weight: bold;
}

/* ================= SKILLS / LANG ================= */
.skill-badge,
.language-item {
    display: inline-block;
    border: 1px solid #667eea;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 10px;
    margin: 3px 4px 0 0;
}

.skill-level {
    margin-left: 6px;
    font-size: 10px;
}

/* ================= LINKS ================= */
a {
    color: #2c3e50;
    text-decoration: none;
}
</style>
