<?php
/**
 * Executive Premium Theme (PDF Safe Version)
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}
?>

<div class="resume-document theme-executive">

    <!-- ================= HEADER ================= -->
    <div class="resume-header">

        <table class="header-table" width="100%">
            <tr>
                <td class="header-left">
                    <?php if (!empty($data['personal']['profilePicture'])): ?>
                        <img src="<?php echo htmlspecialchars($data['personal']['profilePicture']); ?>" class="profile-image">
                    <?php endif; ?>
                </td>
                <td class="header-right">
                    <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                    <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Executive Position'); ?></p>
                </td>
            </tr>
        </table>

        <div class="contact-info">
            <?php if (!empty($data['personal']['email'])): ?>
                <span><?php echo htmlspecialchars($data['personal']['email']); ?></span>
            <?php endif; ?>
            <?php if (!empty($data['personal']['phone'])): ?>
                <span> | <?php echo htmlspecialchars($data['personal']['phone']); ?></span>
            <?php endif; ?>
            <?php if (!empty($data['personal']['address'])): ?>
                <span> | <?php echo htmlspecialchars($data['personal']['address']); ?></span>
            <?php endif; ?>
        </div>

        <div class="social-links">
            <?php if (!empty($data['personal']['linkedin'])): ?>
                <a href="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>">LinkedIn</a>
            <?php endif; ?>
            <?php if (!empty($data['personal']['website'])): ?>
                <a href="<?php echo htmlspecialchars($data['personal']['website']); ?>">Website</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- ================= SUMMARY ================= -->
    <?php if (!empty($data['personal']['profileSummary'])): ?>
        <div class="resume-section executive-summary">
            <h2>Executive Summary</h2>
            <p><?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
        </div>
    <?php endif; ?>

    <!-- ================= EXPERIENCE ================= -->
    <?php if (!empty($data['workExperience'])): ?>
        <div class="resume-section">
            <h2>Professional Experience</h2>
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
        <div class="resume-section">
            <h2>Education</h2>
            <?php foreach ($data['education'] as $edu): ?>
                <div class="education-item">
                    <table width="100%">
                        <tr>
                            <td><strong><?php echo htmlspecialchars($edu['degree']); ?></strong></td>
                            <td class="date"><?php echo htmlspecialchars($edu['startYear']); ?> - <?php echo htmlspecialchars($edu['endYear']); ?></td>
                        </tr>
                    </table>
                    <p class="institute"><?php echo htmlspecialchars($edu['institute']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= SKILLS ================= -->
    <?php if (!empty($data['skills'])): ?>
        <div class="resume-section">
            <h2>Core Competencies</h2>
            <?php foreach ($data['skills'] as $skill): ?>
                <div class="skill-item">
                    <span class="skill-name"><?php echo htmlspecialchars($skill['skillName']); ?></span>
                    <span class="skill-level"><?php echo htmlspecialchars($skill['level']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= PROJECTS ================= -->
    <?php if (!empty($data['projects'])): ?>
        <div class="resume-section">
            <h2>Key Achievements</h2>
            <?php foreach ($data['projects'] as $project): ?>
                <div class="project-item">
                    <strong><?php echo htmlspecialchars($project['projectName']); ?></strong>
                    <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= CERTIFICATIONS ================= -->
    <?php if (!empty($data['certifications'])): ?>
        <div class="resume-section">
            <h2>Certifications & Awards</h2>
            <?php foreach ($data['certifications'] as $cert): ?>
                <div class="certification-item">
                    <strong><?php echo htmlspecialchars($cert['certificateTitle']); ?></strong>
                    <p><?php echo htmlspecialchars($cert['issuedBy']); ?> | <?php echo htmlspecialchars($cert['year']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ================= LANGUAGES ================= -->
    <?php if (!empty($data['languages'])): ?>
        <div class="resume-section">
            <h2>Languages</h2>
            <?php foreach ($data['languages'] as $lang): ?>
                <span class="language-item"><?php echo htmlspecialchars($lang['languageName']); ?> (<?php echo htmlspecialchars($lang['proficiency']); ?>)</span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<!-- ================= PDF SAFE CSS ================= -->
<style>
.resume-document {
    font-family: Helvetica, Arial, sans-serif;
    color: #1A1A1A;
    padding: 40px;
    background: #FFFFFF;
    line-height: 1.6;
}

/* HEADER */
.resume-header {
    background: #1A1A1A;
    color: #FFFFFF;
    padding: 30px;
    margin: -40px -40px 30px -40px;
    border-bottom: 4px solid #C9A961;
}

.header-left { width: 130px; }
.header-right h1 {
    font-size: 28px;
    margin: 0;
}
.job-title {
    font-size: 14px;
    color: #C9A961;
}

/* IMAGE */
.profile-image {
    width: 110px;
    height: 110px;
    border: 3px solid #C9A961;
}

/* CONTACT */
.contact-info {
    font-size: 11px;
    margin-top: 10px;
    border-top: 1px solid #C9A961;
    padding-top: 8px;
}

.social-links a {
    font-size: 11px;
    color: #C9A961;
    margin-right: 10px;
    text-decoration: none;
}

/* SECTIONS */
.resume-section {
    margin-bottom: 24px;
}
.resume-section h2 {
    font-size: 13px;
    border-bottom: 2px solid #C9A961;
    padding-bottom: 6px;
    margin-bottom: 12px;
}

/* SUMMARY */
.executive-summary {
    background: #F4F4F4;
    padding: 14px;
    border-left: 4px solid #C9A961;
}

/* ITEMS */
.date {
    text-align: right;
    font-size: 11px;
    color: #555555;
}
.company, .institute {
    font-size: 11px;
    color: #C9A961;
    font-weight: bold;
}

/* SKILLS */
.skill-item {
    width: 48%;
    display: inline-block;
    font-size: 11px;
    border-bottom: 1px solid #E0E0E0;
    padding: 6px 0;
}
.skill-level {
    float: right;
    color: #C9A961;
}

/* LANGUAGES */
.language-item {
    font-size: 11px;
    margin-right: 10px;
    display: inline-block;
}
</style>
