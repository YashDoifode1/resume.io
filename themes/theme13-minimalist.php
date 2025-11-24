<?php
/**
 * Minimalist Clean Theme
 * 
 * Extremely clean design with maximum white space and minimal styling
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}

// Include placeholder generator
if (!function_exists('getProfileImage')) {
    require_once __DIR__ . '/../utils/placeholder-generator.php';
}
?>

<div class="resume-document theme-minimalist">
    <!-- Header -->
    <div class="resume-header">
        <div class="header-content">
            <img src="<?php echo getProfileImage($data['personal']['profilePicture'] ?? '', $data['personal']['fullName'] ?? 'User'); ?>" alt="Profile" class="profile-image">
            
            <div class="header-text">
                <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>
            </div>
        </div>

        <div class="contact-info">
            <?php if (!empty($data['personal']['email'])): ?>
                <span><?php echo htmlspecialchars($data['personal']['email']); ?></span>
            <?php endif; ?>
            <?php if (!empty($data['personal']['phone'])): ?>
                <span><?php echo htmlspecialchars($data['personal']['phone']); ?></span>
            <?php endif; ?>
            <?php if (!empty($data['personal']['address'])): ?>
                <span><?php echo htmlspecialchars($data['personal']['address']); ?></span>
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

    <!-- Education -->
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

    <!-- Skills -->
    <?php if (!empty($data['skills'])): ?>
        <div class="resume-section">
            <h2>Skills</h2>
            <div class="skills-container">
                <?php foreach ($data['skills'] as $skill): ?>
                    <span class="skill-badge"><?php echo htmlspecialchars($skill['skillName'] ?? ''); ?></span>
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
                    <span class="language-badge"><?php echo htmlspecialchars($lang['languageName'] ?? ''); ?></span>
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
    .resume-document.theme-minimalist {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #1a1a1a;
        line-height: 1.8;
        padding: 50px;
        background: white;
    }

    .resume-header {
        margin-bottom: 50px;
    }

    .header-content {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .profile-image {
        width: 80px;
        height: 80px;
        border-radius: 4px;
        object-fit: cover;
    }

    .header-text {
        flex: 1;
    }

    .resume-header h1 {
        font-size: 32px;
        margin: 0 0 8px 0;
        color: #1a1a1a;
        font-weight: 400;
        letter-spacing: -0.5px;
    }

    .job-title {
        font-size: 14px;
        color: #666;
        margin: 0;
        font-weight: 400;
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        font-size: 12px;
        margin-bottom: 15px;
        color: #666;
    }

    .social-links {
        display: flex;
        gap: 20px;
    }

    .social-links a {
        color: #1a1a1a;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
    }

    .resume-section {
        margin-bottom: 40px;
    }

    .resume-section h2 {
        font-size: 13px;
        color: #1a1a1a;
        margin: 0 0 20px 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .experience-item,
    .education-item,
    .project-item,
    .certification-item {
        margin-bottom: 20px;
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 4px;
    }

    .item-header h3 {
        font-size: 13px;
        margin: 0;
        color: #1a1a1a;
        font-weight: 600;
    }

    .date {
        font-size: 12px;
        color: #999;
    }

    .company,
    .institute {
        font-size: 12px;
        color: #666;
        margin: 0 0 8px 0;
        font-weight: 500;
    }

    .skills-container,
    .languages-container {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .skill-badge,
    .language-badge {
        background: transparent;
        border: 1px solid #ddd;
        padding: 6px 12px;
        border-radius: 3px;
        font-size: 12px;
        color: #1a1a1a;
    }

    @media print {
        .resume-document {
            padding: 40px;
        }

        .profile-image {
            width: 70px;
            height: 70px;
        }

        .resume-header h1 {
            font-size: 28px;
        }
    }
</style>
