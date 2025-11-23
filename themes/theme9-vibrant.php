<?php
/**
 * Vibrant Colors Theme
 * Colorful and energetic design for creative professionals
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}
?>

<div class="resume-document theme-vibrant">
    <!-- Header -->
    <div class="resume-header">
        <div class="header-content">
            <div class="header-left">
                <?php if (!empty($data['personal']['profilePicture'])): ?>
                    <img src="<?php echo htmlspecialchars($data['personal']['profilePicture']); ?>" alt="Profile" class="profile-image">
                <?php endif; ?>
            </div>
            <div class="header-right">
                <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>
                
                <div class="contact-info">
                    <?php if (!empty($data['personal']['email'])): ?>
                        <span><?php echo htmlspecialchars($data['personal']['email']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($data['personal']['phone'])): ?>
                        <span>•</span>
                        <span><?php echo htmlspecialchars($data['personal']['phone']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="social-links">
                    <?php if (!empty($data['personal']['website'])): ?>
                        <a href="<?php echo htmlspecialchars($data['personal']['website']); ?>" target="_blank">Portfolio</a>
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
            <p class="summary"><?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?></p>
        </div>
    <?php endif; ?>

    <!-- Work Experience -->
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
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Skills -->
    <?php if (!empty($data['skills'])): ?>
        <div class="resume-section">
            <h2>Skills</h2>
            <div class="skills-container">
                <?php $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#FFA07A', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E2']; ?>
                <?php foreach ($data['skills'] as $index => $skill): ?>
                    <div class="skill-badge" style="background-color: <?php echo $colors[$index % count($colors)]; ?>;">
                        <?php echo htmlspecialchars($skill['skillName'] ?? ''); ?>
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
                        <p><strong>Tech:</strong> <?php echo htmlspecialchars($project['technologiesUsed']); ?></p>
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
                    <span class="language-item"><?php echo htmlspecialchars($lang['languageName'] ?? ''); ?> - <?php echo htmlspecialchars($lang['proficiency'] ?? ''); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .resume-document {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #2c3e50;
        line-height: 1.6;
        padding: 40px;
        background: #f8f9fa;
    }

    .resume-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        color: white;
        padding: 30px;
        margin: -40px -40px 30px -40px;
        border-radius: 0 0 20px 20px;
    }

    .header-content {
        display: flex;
        gap: 25px;
        align-items: flex-start;
    }

    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .resume-header h1 {
        font-size: 28px;
        margin: 0 0 5px 0;
        font-weight: 700;
    }

    .job-title {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.9);
        margin: 0 0 15px 0;
        font-weight: 500;
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .social-links {
        display: flex;
        gap: 12px;
    }

    .social-links a {
        color: white;
        text-decoration: none;
        font-size: 12px;
        border-bottom: 2px solid white;
        padding-bottom: 2px;
    }

    .summary {
        font-size: 13px;
        line-height: 1.8;
        color: #2c3e50;
    }

    .resume-section {
        margin-bottom: 24px;
        background: white;
        padding: 16px;
        border-radius: 8px;
        border-left: 4px solid #667eea;
    }

    .resume-section h2 {
        font-size: 14px;
        color: #667eea;
        margin: 0 0 12px 0;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .experience-item,
    .education-item,
    .project-item,
    .certification-item {
        margin-bottom: 12px;
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 4px;
        gap: 10px;
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
        color: white;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .language-item {
        background: #e8f4f8;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        color: #2c3e50;
    }

    @media print {
        .resume-document {
            padding: 0;
            background: white;
        }

        .resume-header {
            margin: 0;
            border-radius: 0;
        }

        .resume-section {
            background: white;
            border-left: 4px solid #667eea;
        }
    }
</style>
