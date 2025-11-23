<?php
/**
 * PDF Download Test
 * Test if PDF download is working correctly
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/constants.php';

// Create test resume data if not exists
if (!isset($_SESSION['resume_data'])) {
    $_SESSION['resume_data'] = [
        'personal' => [
            'fullName' => 'Test User',
            'jobTitle' => 'Software Developer',
            'profileSummary' => 'This is a test resume to verify PDF download functionality.',
            'email' => 'test@resume.io',
            'phone' => '+1 (555) 123-4567',
            'address' => 'Test City, Test State',
            'website' => 'https://example.com',
            'linkedin' => 'https://linkedin.com/in/testuser',
            'github' => 'https://github.com/testuser',
            'profilePicture' => ''
        ],
        'workExperience' => [
            [
                'company' => 'Test Company',
                'jobRole' => 'Developer',
                'startDate' => '2020-01-01',
                'endDate' => '2025-01-01',
                'responsibilities' => 'Developed web applications and maintained existing systems.'
            ]
        ],
        'education' => [
            [
                'degree' => 'Bachelor of Science',
                'institute' => 'Test University',
                'startYear' => '2016',
                'endYear' => '2020',
                'cgpa' => '3.8'
            ]
        ],
        'skills' => [
            ['skillName' => 'PHP', 'level' => 'Expert'],
            ['skillName' => 'JavaScript', 'level' => 'Expert'],
            ['skillName' => 'MySQL', 'level' => 'Intermediate']
        ],
        'projects' => [],
        'certifications' => [],
        'languages' => [],
        'interests' => 'Web Development, Open Source'
    ];
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>PDF Download Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .info { background: #d1ecf1; border: 1px solid #bee5eb; padding: 12px; border-radius: 4px; color: #0c5460; margin-bottom: 20px; }
        .test-section { margin: 20px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #3498db; border-radius: 4px; }
        .test-section h3 { margin-top: 0; color: #3498db; }
        .test-section p { margin: 8px 0; }
        .btn { display: inline-block; padding: 12px 24px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; margin: 8px 4px 8px 0; border: none; cursor: pointer; font-size: 14px; }
        .btn:hover { background: #2980b9; }
        .btn-success { background: #27ae60; }
        .btn-success:hover { background: #229954; }
        .btn-warning { background: #f39c12; }
        .btn-warning:hover { background: #e67e22; }
        .status { margin: 20px 0; padding: 12px; border-radius: 4px; }
        .status-pass { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .status-fail { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        code { background: #f0f0f0; padding: 4px 8px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 PDF Download Test</h1>
        
        <div class="info">
            <strong>ℹ️ Info:</strong> This page creates test resume data and allows you to test PDF downloads.
        </div>

        <div class="test-section">
            <h3>✅ Test Resume Data</h3>
            <p>Test resume data has been created with sample information.</p>
            <p><strong>Name:</strong> Test User</p>
            <p><strong>Job Title:</strong> Software Developer</p>
            <p><strong>Status:</strong> <span class="status status-pass">✅ Ready</span></p>
        </div>

        <div class="test-section">
            <h3>🎨 Test PDF Downloads</h3>
            <p>Click any button below to test PDF download with that theme:</p>
            <div>
                <a href="<?php echo BASE_URL; ?>download-pdf.php?theme=classic" class="btn btn-success" download>📄 Classic</a>
                <a href="<?php echo BASE_URL; ?>download-pdf.php?theme=modern" class="btn btn-success" download>✨ Modern</a>
                <a href="<?php echo BASE_URL; ?>download-pdf.php?theme=corporate" class="btn btn-success" download>💼 Corporate</a>
                <a href="<?php echo BASE_URL; ?>download-pdf.php?theme=creative" class="btn btn-success" download>🎨 Creative</a>
                <a href="<?php echo BASE_URL; ?>download-pdf.php?theme=dark" class="btn btn-success" download>🌙 Dark</a>
            </div>
            <div style="margin-top: 10px;">
                <a href="<?php echo BASE_URL; ?>download-pdf.php?theme=elegant" class="btn btn-success" download>✨ Elegant</a>
                <a href="<?php echo BASE_URL; ?>download-pdf.php?theme=tech" class="btn btn-success" download>💻 Tech</a>
                <a href="<?php echo BASE_URL; ?>download-pdf.php?theme=minimal" class="btn btn-success" download>⚪ Minimal</a>
                <a href="<?php echo BASE_URL; ?>download-pdf.php?theme=vibrant" class="btn btn-success" download>🌈 Vibrant</a>
                <a href="<?php echo BASE_URL; ?>download-pdf.php?theme=executive" class="btn btn-success" download>👔 Executive</a>
            </div>
        </div>

        <div class="test-section">
            <h3>🔍 Diagnostics</h3>
            <p><strong>Session Status:</strong> 
                <?php 
                if (session_status() === PHP_SESSION_ACTIVE) {
                    echo '<span class="status status-pass">✅ Active</span>';
                } else {
                    echo '<span class="status status-fail">❌ Inactive</span>';
                }
                ?>
            </p>
            <p><strong>Resume Data:</strong> 
                <?php 
                if (isset($_SESSION['resume_data'])) {
                    echo '<span class="status status-pass">✅ Exists</span>';
                } else {
                    echo '<span class="status status-fail">❌ Missing</span>';
                }
                ?>
            </p>
            <p><strong>DOMPDF:</strong> 
                <?php 
                if (file_exists(__DIR__ . '/vendor/autoload.php')) {
                    echo '<span class="status status-pass">✅ Installed</span>';
                } else {
                    echo '<span class="status status-fail">❌ Not Installed</span>';
                }
                ?>
            </p>
            <p><strong>PDF Generator:</strong> 
                <?php 
                if (file_exists(__DIR__ . '/utils/pdf-generator.php')) {
                    echo '<span class="status status-pass">✅ Found</span>';
                } else {
                    echo '<span class="status status-fail">❌ Not Found</span>';
                }
                ?>
            </p>
        </div>

        <div class="test-section">
            <h3>📝 Next Steps</h3>
            <ol>
                <li>Click any theme button above to download a test PDF</li>
                <li>If PDF downloads, everything is working! ✅</li>
                <li>If PDF doesn't download, check diagnostics above</li>
                <li>Go to <a href="<?php echo BASE_URL; ?>?page=builder">Resume Builder</a> to create your own resume</li>
            </ol>
        </div>

        <div class="test-section">
            <h3>🔗 Useful Links</h3>
            <p>
                <a href="<?php echo BASE_URL; ?>" class="btn">🏠 Home</a>
                <a href="<?php echo BASE_URL; ?>?page=builder" class="btn">✏️ Resume Builder</a>
                <a href="<?php echo BASE_URL; ?>verify-pdf.php" class="btn btn-warning">🔍 Verify Installation</a>
            </p>
        </div>
    </div>
</body>
</html>
