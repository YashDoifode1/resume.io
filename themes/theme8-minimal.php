<?php
/**
 * Ultra Minimal Theme
 * Extreme minimalism with focus on content
 */

if (!isset($data)) {
    $data = isset($_SESSION['resume_data']) ? $_SESSION['resume_data'] : [];
}
?>

<div class="resume-document theme-minimal">
    <!-- Header -->
    <div class="resume-header">
        <h1><?php echo htmlspecialchars($data['personal']['fullName'] ?? 'Your Name'); ?></h1>
        <p class="job-title"><?php echo htmlspecialchars($data['personal']['jobTitle'] ?? 'Job Title'); ?></p>
        
        <div class="contact-info">
            <?php if (!empty($data['personal']['email'])): ?>
                <span><?php echo htmlspecialchars($data['personal']['email']); ?></span>
            <?php endif; ?>
            <?php if (!empty($data['personal']['phone'])): ?>
                <span>|</span>
                <span><?php echo htmlspecialchars($data['personal']['phone']); ?></span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Profile Summary -->
    <?php if (!empty($data['personal']['profileSummary'])): ?>
        <div class="resume-section">
            <?php echo nl2br(htmlspecialchars($data['personal']['profileSummary'])); ?>
        </div>
    <?php endif; ?>

    <!-- Work Experience -->
    <?php if (!empty($data['workExperience'])): ?>
        <div class="resume-section">
            <h2>Experience</h2>
            <?php foreach ($data['workExperience'] as $exp): ?>
                <div class="experience-item">
                    <div class="item-header">
                        <strong><?php echo htmlspecialchars($exp['jobRole'] ?? ''); ?></strong>
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
                        <strong><?php echo htmlspecialchars($edu['degree'] ?? ''); ?></strong>
                        <span class="date"><?php echo htmlspecialchars($edu['startYear'] ?? ''); ?> - <?php echo htmlspecialchars($edu['endYear'] ?? ''); ?></span>
                    </div>
                    <p><?php echo htmlspecialchars($edu['institute'] ?? ''); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Skills -->
    <?php if (!empty($data['skills'])): ?>
        <div class="resume-section">
            <h2>Skills</h2>
            <p><?php echo implode(' • ', array_map(function($s) { return htmlspecialchars($s['skillName'] ?? ''); }, $data['skills'])); ?></p>
        </div>
    <?php endif; ?>

    <!-- Projects -->
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

    <!-- Certifications -->
    <?php if (!empty($data['certifications'])): ?>
        <div class="resume-section">
            <h2>Certifications</h2>
            <?php foreach ($data['certifications'] as $cert): ?>
                <p><strong><?php echo htmlspecialchars($cert['certificateTitle'] ?? ''); ?></strong> — <?php echo htmlspecialchars($cert['issuedBy'] ?? ''); ?> (<?php echo htmlspecialchars($cert['year'] ?? ''); ?>)</p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Languages -->
    <?php if (!empty($data['languages'])): ?>
        <div class="resume-section">
            <h2>Languages</h2>
            <p><?php echo implode(' • ', array_map(function($l) { return htmlspecialchars($l['languageName'] ?? '') . ' (' . htmlspecialchars($l['proficiency'] ?? '') . ')'; }, $data['languages'])); ?></p>
        </div>
    <?php endif; ?>
</div>

<style>
    .resume-document {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #000;
        line-height: 1.5;
        padding: 40px;
        background: #fff;
        max-width: 8.5in;
    }

    .resume-header {
        margin-bottom: 24px;
        border-bottom: 1px solid #000;
        padding-bottom: 12px;
    }

    .resume-header h1 {
        font-size: 24px;
        margin: 0 0 4px 0;
        font-weight: 700;
    }

    .job-title {
        font-size: 14px;
        margin: 0 0 8px 0;
        font-weight: 500;
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 12px;
    }

    .resume-section {
        margin-bottom: 16px;
    }

    .resume-section h2 {
        font-size: 13px;
        margin: 0 0 8px 0;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .experience-item,
    .education-item,
    .project-item {
        margin-bottom: 12px;
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 2px;
        gap: 10px;
    }

    .item-header strong {
        font-size: 12px;
    }

    .date {
        font-size: 12px;
        color: #666;
        white-space: nowrap;
    }

    .company {
        font-size: 12px;
        margin: 0 0 4px 0;
        font-weight: 600;
    }

    .resume-section p {
        font-size: 12px;
        margin: 0 0 4px 0;
        line-height: 1.6;
    }

    @media print {
        .resume-document {
            padding: 0;
        }

        .resume-header {
            border-bottom: 1px solid #000;
        }
    }
</style>
