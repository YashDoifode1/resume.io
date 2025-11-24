<?php
/**
 * Sidebar Professional Theme
 * 
 * Two-column layout with sidebar for contact and skills
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}

// Include placeholder generator
if (!function_exists('getProfileImage')) {
    require_once __DIR__ . '/../utils/placeholder-generator.php';
}
?>

<div class="resume-document theme-sidebar">
    <div class="resume-container">
        <!-- Sidebar -->
        <aside class="resume-sidebar">
            <img src="<?php echo getProfileImage($data['personal']['profilePicture'] ?? '', $data['personal']['fullName'] ?? 'User'); ?>" alt="Profile" class="profile-image">
            
            <div class="sidebar-section">
                <h3>Contact</h3>
                <?php if (!empty($data['personal']['email'])): ?>
                    <p><strong>Email:</strong><br><?php echo htmlspecialchars($data['personal']['email']); ?></p>
                <?php endif; ?>
                <?php if (!empty($data['personal']['phone'])): ?>
                    <p><strong>Phone:</strong><br><?php echo htmlspecialchars($data['personal']['phone']); ?></p>
                <?php endif; ?>
                <?php if (!empty($data['personal']['address'])): ?>
                    <p><strong>Address:</strong><br><?php echo htmlspecialchars($data['personal']['address']); ?></p>
                <?php endif; ?>
            </div>

            <!-- Skills in Sidebar -->
            <?php if (!empty($data['skills'])): ?>
                <div class="sidebar-section">
                    <h3>Skills</h3>
                    <div class="sidebar-skills">
                        <?php foreach ($data['skills'] as $skill): ?>
                            <div class="skill-item">
                                <span><?php echo htmlspecialchars($skill['skillName'] ?? ''); ?></span>
                                <span class="level"><?php echo htmlspecialchars($skill['level'] ?? ''); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Languages in Sidebar -->
            <?php if (!empty($data['languages'])): ?>
                <div class="sidebar-section">
                    <h3>Languages</h3>
                    <div class="sidebar-languages">
                        <?php foreach ($data['languages'] as $lang): ?>
                            <div class="language-item">
                                <span><?php echo htmlspecialchars($lang['languageName'] ?? ''); ?></span>
                                <span class="level"><?php echo htmlspecialchars($lang['proficiency'] ?? ''); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Social Links -->
            <div class="sidebar-section">
                <h3>Links</h3>
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
        </aside>

        <!-- Main Content -->
        <main class="resume-main">
            <!-- Header -->
            <div class="resume-header">
                <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
                <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>
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

            <!-- Interests -->
            <?php if (!empty($data['interests'])): ?>
                <div class="resume-section">
                    <h2>Interests</h2>
                    <p><?php echo nl2br(htmlspecialchars($data['interests'])); ?></p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<style>
    .resume-document.theme-sidebar {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #2c3e50;
        line-height: 1.6;
        padding: 40px;
        background: white;
    }

    .resume-container {
        display: flex;
        gap: 30px;
    }

    .resume-sidebar {
        flex: 0 0 220px;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #3498db;
    }

    .profile-image {
        width: 100%;
        height: auto;
        border-radius: 8px;
        object-fit: cover;
        margin-bottom: 20px;
        border: 3px solid #3498db;
    }

    .sidebar-section {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .sidebar-section:last-child {
        border-bottom: none;
    }

    .sidebar-section h3 {
        font-size: 13px;
        color: #3498db;
        font-weight: 700;
        margin: 0 0 10px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sidebar-section p {
        font-size: 12px;
        margin: 0 0 8px 0;
    }

    .sidebar-skills,
    .sidebar-languages {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .skill-item,
    .language-item {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        padding: 6px 0;
    }

    .skill-item span:first-child,
    .language-item span:first-child {
        font-weight: 500;
    }

    .level {
        color: #7f8c8d;
        font-size: 11px;
    }

    .social-links {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .social-links a {
        color: #3498db;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
    }

    .resume-main {
        flex: 1;
    }

    .resume-header {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #3498db;
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
        margin: 0;
    }

    .resume-section {
        margin-bottom: 20px;
    }

    .resume-section h2 {
        font-size: 14px;
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 8px;
        margin: 0 0 12px 0;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
    }

    .item-header h3 {
        font-size: 13px;
        margin: 0;
        color: #2c3e50;
        font-weight: 700;
    }

    .date {
        font-size: 11px;
        color: #95a5a6;
    }

    .company,
    .institute {
        font-size: 12px;
        color: #3498db;
        margin: 0 0 6px 0;
        font-weight: 600;
    }

    @media print {
        .resume-document {
            padding: 0;
        }

        .resume-container {
            gap: 20px;
        }

        .resume-sidebar {
            flex: 0 0 180px;
            padding: 15px;
        }

        .profile-image {
            margin-bottom: 15px;
        }
    }
</style>
