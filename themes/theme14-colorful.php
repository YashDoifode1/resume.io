<?php
/**
 * Colorful Accent Theme (PDF Safe – Same Format)
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}

if (!function_exists('getProfileImage')) {
    require_once __DIR__ . '/../utils/placeholder-generator.php';
}
?>

<div class="resume-document theme-colorful">

    <!-- ================= HEADER ================= -->
    <div class="resume-header">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="110" valign="top">
                    <img
                        src="<?php echo getProfileImage($data['personal']['profilePicture'] ?? '', $data['personal']['fullName'] ?? 'User'); ?>"
                        class="profile-image"
                    >
                </td>
                <td valign="top" class="header-text">
                    <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                    <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>

                    <div class="contact-info">
                        <?php if (!empty($data['personal']['email'])): ?>
                            <span><strong>E:</strong> <?php echo htmlspecialchars($data['personal']['email']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['phone'])): ?>
                            <span> | <strong>P:</strong> <?php echo htmlspecialchars($data['personal']['phone']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['address'])): ?>
                            <span> | <strong>A:</strong> <?php echo htmlspecialchars($data['personal']['address']); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="social-links">
                        <?php if (!empty($data['personal']['website'])): ?>
                            <a href="<?php echo htmlspecialchars($data['personal']['website']); ?>">Website</a>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['linkedin'])): ?>
                            <a href="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>">LinkedIn</a>
                        <?php endif; ?>
                        <?php if (!empty($data['personal']['github'])): ?>
                            <a href="<?php echo htmlspecialchars($data['personal']['github']); ?>">GitHub</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- ================= SUMMARY ================= -->
    <?php if (!empty($data['personal']['profileSummary'])): ?>
        <div class="resume-section accent-red">
            <h2>Professional Summary</h2>
            <p><?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
        </div>
    <?php endif; ?>

    <!-- ================= EXPERIENCE ================= -->
    <?php if (!empty($data['workExperience'])): ?>
        <div class="resume-section accent-green">
            <h2>Work Experience</h2>
            <?php foreach ($data['workExperience'] as $exp): ?>
                <div class="experience-item">
                    <table width="100%">
                        <tr>
                            <td><strong><?php echo htmlspecialchars($exp['jobRole']); ?></strong></td>
                            <td class="date"><?php echo htmlspecialchars($exp['startDate']); ?> - <?php echo htmlspecialchars($exp['endDate']); ?></td>
                        </tr>
                    </table>
                    <p class="company"><?php echo htmlspecialchars($exp['company']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($exp['responsibilities'])); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= EDUCATION ================= -->
    <?php if (!empty($data['education'])): ?>
        <div class="resume-section accent-yellow">
            <h2>Education</h2>
            <?php foreach ($data['education'] as $edu): ?>
                <div class="education-item">
                    <table width="100%">
                        <tr>
                            <td><strong><?php echo htmlspecialchars($edu['degree']); ?></strong></td>
                            <td class="date"><?php echo htmlspecialchars($edu['startYear']); ?> - <?php echo htmlspecialchars($edu['endYear']); ?></td>
                        </tr>
                    </table>
                    <p class="company"><?php echo htmlspecialchars($edu['institute']); ?></p>
                    <?php if (!empty($edu['cgpa'])): ?>
                        <p>CGPA: <?php echo htmlspecialchars($edu['cgpa']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= SKILLS ================= -->
    <?php if (!empty($data['skills'])): ?>
        <div class="resume-section accent-teal">
            <h2>Skills</h2>
            <?php foreach ($data['skills'] as $skill): ?>
                <span class="skill-badge">
                    <?php echo htmlspecialchars($skill['skillName']); ?>
                    (<?php echo htmlspecialchars($skill['level']); ?>)
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= PROJECTS ================= -->
    <?php if (!empty($data['projects'])): ?>
        <div class="resume-section accent-purple">
            <h2>Projects</h2>
            <?php foreach ($data['projects'] as $project): ?>
                <div class="project-item">
                    <strong><?php echo htmlspecialchars($project['projectName']); ?></strong>
                    <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                    <?php if (!empty($project['technologiesUsed'])): ?>
                        <p><strong>Technologies:</strong> <?php echo htmlspecialchars($project['technologiesUsed']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= CERTIFICATIONS ================= -->
    <?php if (!empty($data['certifications'])): ?>
        <div class="resume-section accent-pink">
            <h2>Certifications</h2>
            <?php foreach ($data['certifications'] as $cert): ?>
                <div class="certification-item">
                    <strong><?php echo htmlspecialchars($cert['certificateTitle']); ?></strong>
                    <p><?php echo htmlspecialchars($cert['issuedBy']); ?> - <?php echo htmlspecialchars($cert['year']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= LANGUAGES ================= -->
    <?php if (!empty($data['languages'])): ?>
        <div class="resume-section accent-blue">
            <h2>Languages</h2>
            <?php foreach ($data['languages'] as $lang): ?>
                <span class="skill-badge">
                    <?php echo htmlspecialchars($lang['languageName']); ?>
                    (<?php echo htmlspecialchars($lang['proficiency']); ?>)
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<style>
.resume-document {
    font-family: Helvetica, Arial, sans-serif;
    color: #2C3E50;
    background: #FFFFFF;
    padding: 40px;
    line-height: 1.6;
}

/* HEADER */
.resume-header {
    border-bottom: 3px solid #2C3E50;
    padding-bottom: 20px;
    margin-bottom: 30px;
}

.profile-image {
    width: 100px;
    height: 100px;
    border: 3px solid #FF6B6B;
}

.header-text h1 {
    margin: 0;
    font-size: 28px;
    font-weight: bold;
}

.job-title {
    font-size: 16px;
    color: #7F8C8D;
    margin-bottom: 12px;
}

.contact-info {
    font-size: 13px;
    margin-bottom: 8px;
}

.social-links a {
    font-size: 13px;
    color: #3498DB;
    margin-right: 12px;
    text-decoration: none;
}

/* SECTIONS */
.resume-section {
    margin-bottom: 25px;
    padding-left: 12px;
    border-left: 4px solid #ECF0F1;
}

.resume-section h2 {
    font-size: 16px;
    margin-bottom: 15px;
    font-weight: bold;
}

/* ACCENTS */
.accent-red { border-left-color: #FF6B6B; }
.accent-green { border-left-color: #4ECDC4; }
.accent-yellow { border-left-color: #F1C40F; }
.accent-teal { border-left-color: #1ABC9C; }
.accent-purple { border-left-color: #9B59B6; }
.accent-pink { border-left-color: #E84393; }
.accent-blue { border-left-color: #3498DB; }

/* ITEMS */
.experience-item,
.education-item,
.project-item,
.certification-item {
    margin-bottom: 15px;
}

.date {
    text-align: right;
    font-size: 12px;
    color: #95A5A6;
}

.company {
    font-size: 13px;
    color: #3498DB;
    font-weight: bold;
}

/* SKILLS / LANGUAGES */
.skill-badge {
    display: inline-block;
    background: #FF6B6B;
    color: #FFFFFF;
    padding: 6px 12px;
    margin: 5px 8px 5px 0;
    border-radius: 20px;
    font-size: 12px;
}
</style>
