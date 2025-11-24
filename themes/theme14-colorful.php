<?php
/**
 * Colorful Accent Theme
 * 
 * Professional design with colorful accent bars and modern styling
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}

// Include placeholder generator
if (!function_exists('getProfileImage')) {
    require_once __DIR__ . '/../utils/placeholder-generator.php';
}
?>

<div class="resume-document theme-colorful">
    <!-- Header -->
    <div class="resume-header">
        <div class="header-content">
            <img src="<?php echo getProfileImage($data['personal']['profilePicture'] ?? '', $data['personal']['fullName'] ?? 'User'); ?>" alt="Profile" class="profile-image">
            
            <div class="header-text">
                <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>
                
                <div class="contact-info">
                    <?php if (!empty($data['personal']['email'])): ?>
                        <span class="contact-item">
                            <span class="text-icon">E:</span>
                            <?php echo htmlspecialchars($data['personal']['email']); ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['phone'])): ?>
                        <span class="contact-item">
                            <span class="text-icon">P:</span>
                            <?php echo htmlspecialchars($data['personal']['phone']); ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['address'])): ?>
                        <span class="contact-item">
                            <span class="text-icon">A:</span>
                            <?php echo htmlspecialchars($data['personal']['address']); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="social-links">
                    <?php if (!empty($data['personal']['website'])): ?>
                        <a href="<?php echo htmlspecialchars($data['personal']['website']); ?>" target="_blank">Website</a>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['linkedin'])): ?>
                        <a href="<?php echo htmlspecialchars($data['personal']['linkedin']); ?>" target="_blank">LinkedIn</a>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['github'])): ?>
                        <a href="<?php echo htmlspecialchars($data['personal']['github']); ?>" target="_blank">GitHub</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Summary -->
    <?php if (!empty($data['personal']['profileSummary'])): ?>
        <div class="resume-section">
            <h2>Professional Summary</h2>
            <p><?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
        </div>
    <?php endif; ?>

    <!-- Work Experience -->
    <?php if (!empty($data['workExperience'])): ?>
        <div class="resume-section">
            <h2>Work Experience</h2>
            <?php $expIndex = 0; foreach ($data['workExperience'] as $exp): ?>
                <div class="experience-item" data-index="<?php echo $expIndex; ?>">
                    <div class="item-header">
                        <h3><?php echo htmlspecialchars($exp['jobRole'] ?? ''); ?></h3>
                        <span class="date"><?php echo htmlspecialchars($exp['startDate'] ?? ''); ?> - <?php echo htmlspecialchars($exp['endDate'] ?? ''); ?></span>
                    </div>
                    <p class="company"><?php echo htmlspecialchars($exp['company'] ?? ''); ?></p>
                    <?php if (!empty($exp['responsibilities'])): ?>
                        <p><?php echo nl2br(htmlspecialchars($exp['responsibilities'])); ?></p>
                    <?php endif; ?>
                </div>
            <?php $expIndex++; endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Education -->
    <?php if (!empty($data['education'])): ?>
        <div class="resume-section">
            <h2>Education</h2>
            <?php $eduIndex = 0; foreach ($data['education'] as $edu): ?>
                <div class="education-item" data-index="<?php echo $eduIndex; ?>">
                    <div class="item-header">
                        <h3><?php echo htmlspecialchars($edu['degree'] ?? ''); ?></h3>
                        <span class="date"><?php echo htmlspecialchars($edu['startYear'] ?? ''); ?> - <?php echo htmlspecialchars($edu['endYear'] ?? ''); ?></span>
                    </div>
                    <p class="institute"><?php echo htmlspecialchars($edu['institute'] ?? ''); ?></p>
                    <?php if (!empty($edu['cgpa'])): ?>
                        <p>CGPA: <?php echo htmlspecialchars($edu['cgpa']); ?></p>
                    <?php endif; ?>
                </div>
            <?php $eduIndex++; endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Skills -->
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

    <!-- Projects -->
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
                        <p><a href="<?php echo htmlspecialchars($project['projectLink']); ?>" target="_blank">View Project</a></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Certifications -->
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

    <!-- Languages -->
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

    <!-- Interests -->
    <?php if (!empty($data['interests'])): ?>
        <div class="resume-section">
            <h2>Interests</h2>
            <p><?php echo nl2br(htmlspecialchars($data['interests'])); ?></p>
        </div>
    <?php endif; ?>
</div>

<style>
    .resume-document.theme-colorful {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #2c3e50;
        line-height: 1.6;
        padding: 40px;
        background: white;
    }

    .resume-header {
        border-bottom: 3px solid #2c3e50;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .header-content {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        object-fit: cover;
        border: 3px solid #ff6b6b;
    }

    .header-text {
        flex: 1;
    }

    .resume-header h1 {
        font-size: 28px;
        margin: 0 0 5px 0;
        color: #2c3e50;
        font-weight: 700;
    }

    .job-title {
        font-size: 16px;
        color: #7f8c8d;
        margin: 0 0 15px 0;
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .text-icon {
        font-weight: bold;
        color: #ff6b6b;
        font-size: 12px;
    }

    .social-links {
        display: flex;
        gap: 15px;
    }

    .social-links a {
        color: #3498db;
        text-decoration: none;
        font-size: 13px;
    }

    .resume-section {
        margin-bottom: 25px;
    }

    .resume-section h2 {
        font-size: 16px;
        color: #2c3e50;
        padding-left: 12px;
        margin: 0 0 15px 0;
        font-weight: 700;
        border-left: 4px solid;
    }

    .resume-section:nth-child(3) h2 {
        border-left-color: #ff6b6b;
    }

    .resume-section:nth-child(4) h2 {
        border-left-color: #4ecdc4;
    }

    .resume-section:nth-child(5) h2 {
        border-left-color: #ffe66d;
    }

    .resume-section:nth-child(6) h2 {
        border-left-color: #95e1d3;
    }

    .resume-section:nth-child(7) h2 {
        border-left-color: #f38181;
    }

    .resume-section:nth-child(8) h2 {
        border-left-color: #aa96da;
    }

    .resume-section:nth-child(9) h2 {
        border-left-color: #fcbad3;
    }

    .experience-item,
    .education-item,
    .project-item,
    .certification-item {
        margin-bottom: 15px;
        padding-left: 12px;
        border-left: 3px solid #ecf0f1;
    }

    .experience-item[data-index="0"],
    .education-item[data-index="0"] {
        border-left-color: #ff6b6b;
    }

    .experience-item[data-index="1"],
    .education-item[data-index="1"] {
        border-left-color: #4ecdc4;
    }

    .experience-item[data-index="2"],
    .education-item[data-index="2"] {
        border-left-color: #ffe66d;
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 5px;
    }

    .item-header h3 {
        font-size: 14px;
        margin: 0;
        color: #2c3e50;
        font-weight: 700;
    }

    .date {
        font-size: 12px;
        color: #95a5a6;
    }

    .company,
    .institute {
        font-size: 13px;
        color: #3498db;
        margin: 0 0 8px 0;
        font-weight: 600;
    }

    .skills-container,
    .languages-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .skill-badge,
    .language-item {
        background: linear-gradient(135deg, #ff6b6b, #ff8e72);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .skill-badge:nth-child(2n) {
        background: linear-gradient(135deg, #4ecdc4, #44a08d);
    }

    .skill-badge:nth-child(3n) {
        background: linear-gradient(135deg, #ffe66d, #ffc93c);
    }

    .skill-badge:nth-child(4n) {
        background: linear-gradient(135deg, #95e1d3, #38ada9);
    }

    .skill-level,
    .proficiency {
        font-size: 11px;
        opacity: 0.9;
    }

    @media print {
        .resume-document {
            padding: 0;
        }

        .profile-image {
            width: 80px;
            height: 80px;
        }

        .resume-header h1 {
            font-size: 24px;
        }
    }
</style>
