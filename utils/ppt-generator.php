<?php
/**
 * PowerPoint Presentation Generator
 * Generates professional PowerPoint presentations from resume data
 */

class PPTGenerator {
    private $data;
    private $fileName;
    
    public function __construct($resumeData) {
        $this->data = $resumeData;
        $this->fileName = 'resume_' . time() . '.pptx';
    }
    
    /**
     * Generate PowerPoint presentation
     */
    public function generate() {
        // Create XML structure for PowerPoint
        $pptContent = $this->createPPTStructure();
        
        // Create temporary directory
        $tempDir = sys_get_temp_dir() . '/ppt_' . time();
        mkdir($tempDir, 0755, true);
        
        // Create directory structure
        mkdir($tempDir . '/ppt', 0755, true);
        mkdir($tempDir . '/ppt/slides', 0755, true);
        mkdir($tempDir . '/_rels', 0755, true);
        mkdir($tempDir . '/ppt/_rels', 0755, true);
        mkdir($tempDir . '/ppt/theme', 0755, true);
        
        // Write files
        $this->writeFiles($tempDir);
        
        // Create ZIP file
        $zipFile = UPLOADS_PATH . $this->fileName;
        $this->createZip($tempDir, $zipFile);
        
        // Clean up
        $this->deleteDirectory($tempDir);
        
        return $this->fileName;
    }
    
    /**
     * Create PPT XML structure
     */
    private function createPPTStructure() {
        $slides = [];
        
        // Slide 1: Title Slide
        $slides[] = $this->createTitleSlide();
        
        // Slide 2: Personal Info
        $slides[] = $this->createPersonalInfoSlide();
        
        // Slide 3: Professional Summary
        if (!empty($this->data['personal']['profileSummary'])) {
            $slides[] = $this->createSummarySlide();
        }
        
        // Slide 4: Work Experience
        if (!empty($this->data['workExperience'])) {
            $slides[] = $this->createWorkExperienceSlide();
        }
        
        // Slide 5: Education
        if (!empty($this->data['education'])) {
            $slides[] = $this->createEducationSlide();
        }
        
        // Slide 6: Skills
        if (!empty($this->data['skills'])) {
            $slides[] = $this->createSkillsSlide();
        }
        
        // Slide 7: Projects
        if (!empty($this->data['projects'])) {
            $slides[] = $this->createProjectsSlide();
        }
        
        // Slide 8: Certifications
        if (!empty($this->data['certifications'])) {
            $slides[] = $this->createCertificationsSlide();
        }
        
        // Slide 9: Languages
        if (!empty($this->data['languages'])) {
            $slides[] = $this->createLanguagesSlide();
        }
        
        // Slide 10: Interests
        if (!empty($this->data['interests'])) {
            $slides[] = $this->createInterestsSlide();
        }
        
        return $slides;
    }
    
    /**
     * Create title slide
     */
    private function createTitleSlide() {
        $name = htmlspecialchars($this->data['personal']['fullName'] ?? 'Resume');
        $title = htmlspecialchars($this->data['personal']['jobTitle'] ?? '');
        
        return [
            'title' => $name,
            'subtitle' => $title,
            'type' => 'title'
        ];
    }
    
    /**
     * Create personal info slide
     */
    private function createPersonalInfoSlide() {
        $contact = [];
        
        if (!empty($this->data['personal']['email'])) {
            $contact[] = 'Email: ' . htmlspecialchars($this->data['personal']['email']);
        }
        if (!empty($this->data['personal']['phone'])) {
            $contact[] = 'Phone: ' . htmlspecialchars($this->data['personal']['phone']);
        }
        if (!empty($this->data['personal']['address'])) {
            $contact[] = 'Address: ' . htmlspecialchars($this->data['personal']['address']);
        }
        if (!empty($this->data['personal']['website'])) {
            $contact[] = 'Website: ' . htmlspecialchars($this->data['personal']['website']);
        }
        if (!empty($this->data['personal']['linkedin'])) {
            $contact[] = 'LinkedIn: ' . htmlspecialchars($this->data['personal']['linkedin']);
        }
        if (!empty($this->data['personal']['github'])) {
            $contact[] = 'GitHub: ' . htmlspecialchars($this->data['personal']['github']);
        }
        
        return [
            'title' => 'Contact Information',
            'content' => $contact,
            'type' => 'content'
        ];
    }
    
    /**
     * Create professional summary slide
     */
    private function createSummarySlide() {
        return [
            'title' => 'Professional Summary',
            'content' => [htmlspecialchars($this->data['personal']['profileSummary'])],
            'type' => 'content'
        ];
    }
    
    /**
     * Create work experience slide
     */
    private function createWorkExperienceSlide() {
        $content = [];
        
        foreach ($this->data['workExperience'] as $job) {
            $company = htmlspecialchars($job['company'] ?? '');
            $role = htmlspecialchars($job['job_role'] ?? '');
            $startDate = htmlspecialchars($job['start_date'] ?? '');
            $endDate = htmlspecialchars($job['end_date'] ?? '');
            $responsibilities = htmlspecialchars($job['responsibilities'] ?? '');
            
            $content[] = "$company - $role";
            $content[] = "$startDate to $endDate";
            if (!empty($responsibilities)) {
                $content[] = $responsibilities;
            }
            $content[] = '';
        }
        
        return [
            'title' => 'Work Experience',
            'content' => $content,
            'type' => 'content'
        ];
    }
    
    /**
     * Create education slide
     */
    private function createEducationSlide() {
        $content = [];
        
        foreach ($this->data['education'] as $edu) {
            $school = htmlspecialchars($edu['school'] ?? '');
            $degree = htmlspecialchars($edu['degree'] ?? '');
            $field = htmlspecialchars($edu['field'] ?? '');
            $graduationDate = htmlspecialchars($edu['graduation_date'] ?? '');
            
            $content[] = "$degree in $field";
            $content[] = $school;
            if (!empty($graduationDate)) {
                $content[] = "Graduated: $graduationDate";
            }
            $content[] = '';
        }
        
        return [
            'title' => 'Education',
            'content' => $content,
            'type' => 'content'
        ];
    }
    
    /**
     * Create skills slide
     */
    private function createSkillsSlide() {
        $content = [];
        
        foreach ($this->data['skills'] as $skill) {
            $skillName = htmlspecialchars($skill['skill_name'] ?? '');
            $proficiency = htmlspecialchars($skill['proficiency'] ?? '');
            
            if (!empty($skillName)) {
                $content[] = "• $skillName ($proficiency)";
            }
        }
        
        return [
            'title' => 'Skills',
            'content' => $content,
            'type' => 'content'
        ];
    }
    
    /**
     * Create projects slide
     */
    private function createProjectsSlide() {
        $content = [];
        
        foreach ($this->data['projects'] as $project) {
            $projectName = htmlspecialchars($project['project_name'] ?? '');
            $description = htmlspecialchars($project['description'] ?? '');
            $link = htmlspecialchars($project['project_link'] ?? '');
            
            $content[] = $projectName;
            if (!empty($description)) {
                $content[] = $description;
            }
            if (!empty($link)) {
                $content[] = "Link: $link";
            }
            $content[] = '';
        }
        
        return [
            'title' => 'Projects',
            'content' => $content,
            'type' => 'content'
        ];
    }
    
    /**
     * Create certifications slide
     */
    private function createCertificationsSlide() {
        $content = [];
        
        foreach ($this->data['certifications'] as $cert) {
            $certName = htmlspecialchars($cert['certification_name'] ?? '');
            $issuer = htmlspecialchars($cert['issuer'] ?? '');
            $issueDate = htmlspecialchars($cert['issue_date'] ?? '');
            
            $content[] = "• $certName";
            if (!empty($issuer)) {
                $content[] = "  Issued by: $issuer";
            }
            if (!empty($issueDate)) {
                $content[] = "  Date: $issueDate";
            }
        }
        
        return [
            'title' => 'Certifications',
            'content' => $content,
            'type' => 'content'
        ];
    }
    
    /**
     * Create languages slide
     */
    private function createLanguagesSlide() {
        $content = [];
        
        foreach ($this->data['languages'] as $lang) {
            $language = htmlspecialchars($lang['language_name'] ?? '');
            $proficiency = htmlspecialchars($lang['proficiency'] ?? '');
            
            if (!empty($language)) {
                $content[] = "• $language - $proficiency";
            }
        }
        
        return [
            'title' => 'Languages',
            'content' => $content,
            'type' => 'content'
        ];
    }
    
    /**
     * Create interests slide
     */
    private function createInterestsSlide() {
        $interests = htmlspecialchars($this->data['interests'] ?? '');
        
        return [
            'title' => 'Interests',
            'content' => [str_replace([',', '\n'], [', ', ', '], $interests)],
            'type' => 'content'
        ];
    }
    
    /**
     * Write PPT files
     */
    private function writeFiles($tempDir) {
        // Write [Content_Types].xml
        file_put_contents($tempDir . '/[Content_Types].xml', $this->getContentTypesXml());
        
        // Write _rels/.rels
        file_put_contents($tempDir . '/_rels/.rels', $this->getRelsXml());
        
        // Write ppt/_rels/presentation.xml.rels
        file_put_contents($tempDir . '/ppt/_rels/presentation.xml.rels', $this->getPresentationRelsXml());
        
        // Write ppt/presentation.xml
        file_put_contents($tempDir . '/ppt/presentation.xml', $this->getPresentationXml());
        
        // Write slides
        $slides = $this->createPPTStructure();
        foreach ($slides as $index => $slide) {
            $slideNum = $index + 1;
            file_put_contents(
                $tempDir . "/ppt/slides/slide$slideNum.xml",
                $this->getSlideXml($slide, $slideNum)
            );
        }
        
        // Write slide layout
        file_put_contents($tempDir . '/ppt/slideLayouts/slideLayout1.xml', $this->getSlideLayoutXml());
        
        // Write theme
        file_put_contents($tempDir . '/ppt/theme/theme1.xml', $this->getThemeXml());
    }
    
    /**
     * Get Content Types XML
     */
    private function getContentTypesXml() {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/ppt/presentation.xml" ContentType="application/vnd.openxmlformats-officedocument.presentationml.presentation.main+xml"/>
    <Override PartName="/ppt/slides/slide1.xml" ContentType="application/vnd.openxmlformats-officedocument.presentationml.slide+xml"/>
    <Override PartName="/ppt/slideLayouts/slideLayout1.xml" ContentType="application/vnd.openxmlformats-officedocument.presentationml.slideLayout+xml"/>
    <Override PartName="/ppt/theme/theme1.xml" ContentType="application/vnd.openxmlformats-officedocument.presentationml.theme+xml"/>
</Types>';
    }
    
    /**
     * Get Rels XML
     */
    private function getRelsXml() {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="ppt/presentation.xml"/>
</Relationships>';
    }
    
    /**
     * Get Presentation Rels XML
     */
    private function getPresentationRelsXml() {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/slide" Target="slides/slide1.xml"/>
    <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/slideMaster" Target="slideMasters/slideMaster1.xml"/>
    <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme" Target="theme/theme1.xml"/>
</Relationships>';
    }
    
    /**
     * Get Presentation XML
     */
    private function getPresentationXml() {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<p:presentation xmlns:p="http://schemas.openxmlformats.org/presentationml/2006/main">
    <p:sldIdLst>
        <p:sldId id="256" r:id="rId1" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"/>
    </p:sldIdLst>
</p:presentation>';
    }
    
    /**
     * Get Slide XML
     */
    private function getSlideXml($slide, $slideNum) {
        $title = htmlspecialchars($slide['title']);
        $contentXml = '';
        
        if (isset($slide['content']) && is_array($slide['content'])) {
            foreach ($slide['content'] as $line) {
                $line = htmlspecialchars($line);
                $contentXml .= "<a:p><a:r><a:t>$line</a:t></a:r></a:p>";
            }
        }
        
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<p:sld xmlns:p="http://schemas.openxmlformats.org/presentationml/2006/main" xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main">
    <p:cSld>
        <p:bg><p:bgPr><a:solidFill><a:srgbClr val="FFFFFF"/></a:solidFill><a:effectLst/></p:bgPr></p:bg>
        <p:spTree>
            <p:nvGrpSpPr><p:cNvPr id="1" name="Title"/><p:cNvGrpSpPr/><p:nvPr/></p:nvGrpSpPr>
            <p:grpSpPr><a:xfrm><a:off x="0" y="0"/><a:ext cx="9144000" cy="6858000"/></a:xfrm></p:grpSpPr>
            <p:sp>
                <p:nvSpPr><p:cNvPr id="2" name="Title"/><p:cNvSpPr><a:spLocks noGrp="1"/></p:cNvSpPr><p:nvPr/></p:nvSpPr>
                <p:spPr><a:xfrm><a:off x="457200" y="274638"/><a:ext cx="8230200" cy="1143000"/></a:xfrm></p:spPr>
                <p:txBody><a:bodyPr/><a:lstStyle/>
                    <a:p><a:r><a:rPr lang="en-US" sz="5400" b="1"/><a:t>$title</a:t></a:r></a:p>
                </p:txBody>
            </p:sp>
            <p:sp>
                <p:nvSpPr><p:cNvPr id="3" name="Content"/><p:cNvSpPr><a:spLocks noGrp="1"/></p:cNvSpPr><p:nvPr/></p:nvSpPr>
                <p:spPr><a:xfrm><a:off x="457200" y="1600200"/><a:ext cx="8230200" cy="4914600"/></a:xfrm></p:spPr>
                <p:txBody><a:bodyPr/><a:lstStyle/>
                    ' . $contentXml . '
                </p:txBody>
            </p:sp>
        </p:spTree>
    </p:cSld>
</p:sld>';
    }
    
    /**
     * Get Slide Layout XML
     */
    private function getSlideLayoutXml() {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<p:sldLayout xmlns:p="http://schemas.openxmlformats.org/presentationml/2006/main" xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main">
    <p:cSld><p:bg><p:bgPr><a:solidFill><a:srgbClr val="FFFFFF"/></a:solidFill><a:effectLst/></p:bgPr></p:bg></p:cSld>
</p:sldLayout>';
    }
    
    /**
     * Get Theme XML
     */
    private function getThemeXml() {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<a:theme xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" name="Office Theme">
    <a:themeElements>
        <a:clrScheme name="Office">
            <a:dk1><a:srgbClr val="000000"/></a:dk1>
            <a:lt1><a:srgbClr val="FFFFFF"/></a:lt1>
            <a:dk2><a:srgbClr val="1F497D"/></a:dk2>
            <a:lt2><a:srgbClr val="EBEBEB"/></a:lt2>
            <a:accent1><a:srgbClr val="4472C4"/></a:accent1>
            <a:accent2><a:srgbClr val="ED7D31"/></a:accent2>
            <a:accent3><a:srgbClr val="A5A5A5"/></a:accent3>
            <a:accent4><a:srgbClr val="FFC000"/></a:accent4>
            <a:accent5><a:srgbClr val="5B9BD5"/></a:accent5>
            <a:accent6><a:srgbClr val="70AD47"/></a:accent6>
            <a:hyperlink><a:srgbClr val="0563C1"/></a:hyperlink>
            <a:folHyperlink><a:srgbClr val="954F72"/></a:folHyperlink>
        </a:clrScheme>
    </a:themeElements>
</a:theme>';
    }
    
    /**
     * Create ZIP file
     */
    private function createZip($source, $destination) {
        $zip = new ZipArchive();
        
        if ($zip->open($destination, ZipArchive::CREATE) !== true) {
            throw new Exception("Cannot create ZIP file");
        }
        
        $this->addFilesToZip($zip, $source, '');
        $zip->close();
    }
    
    /**
     * Add files to ZIP recursively
     */
    private function addFilesToZip($zip, $source, $path) {
        $files = scandir($source);
        
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            
            $filePath = $source . '/' . $file;
            $zipPath = $path ? $path . '/' . $file : $file;
            
            if (is_dir($filePath)) {
                $this->addFilesToZip($zip, $filePath, $zipPath);
            } else {
                $zip->addFile($filePath, $zipPath);
            }
        }
    }
    
    /**
     * Delete directory recursively
     */
    private function deleteDirectory($dir) {
        if (!is_dir($dir)) return;
        
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            
            $filePath = $dir . '/' . $file;
            if (is_dir($filePath)) {
                $this->deleteDirectory($filePath);
            } else {
                unlink($filePath);
            }
        }
        
        rmdir($dir);
    }
}

/**
 * Generate PowerPoint from resume data
 */
function generatePowerPoint($resumeData) {
    try {
        $generator = new PPTGenerator($resumeData);
        return $generator->generate();
    } catch (Exception $e) {
        error_log("PPT Generation Error: " . $e->getMessage());
        return false;
    }
}
?>
