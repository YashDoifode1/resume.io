# Quick Troubleshooting Checklist

## Before You Start
- [ ] Apache is running (XAMPP Control Panel)
- [ ] MySQL is running (if needed)
- [ ] Browser is updated (Chrome, Firefox, Safari, Edge)
- [ ] You're using `http://localhost/resume` (not https)

---

## Issue: Nothing Works

### Step 1: Restart Everything
```
1. Stop Apache in XAMPP
2. Stop MySQL in XAMPP
3. Wait 5 seconds
4. Start MySQL in XAMPP
5. Start Apache in XAMPP
6. Wait 10 seconds
7. Open browser
8. Go to http://localhost/resume
```

### Step 2: Clear Cache
```
1. Press Ctrl+Shift+Delete
2. Select "All time"
3. Check: Cookies, Cache, Cached images
4. Click "Clear data"
5. Close browser completely
6. Reopen browser
7. Go to http://localhost/resume
```

### Step 3: Check Files Exist
```
Files that MUST exist:
✓ pages/builder.php
✓ pages/preview.php
✓ pages/home.php
✓ api/save-section.php
✓ api/download-ppt.php
✓ utils/placeholder-generator.php
✓ utils/ppt-generator.php
✓ themes/theme1-classic.php through theme15-timeline.php
✓ assets/js/builder.js
✓ assets/css/responsive.css
```

---

## Issue: Save Not Working

### Check 1: Form Filled?
- [ ] Did you fill in ALL required fields?
- [ ] Required fields: Full Name, Job Title, Email, Phone
- [ ] Optional fields: Address, Website, LinkedIn, GitHub

### Check 2: Click Save Button?
- [ ] Did you click "Save Personal Information"?
- [ ] Not just fill and go to preview
- [ ] Wait for green notification

### Check 3: Browser Console
```
1. Press F12
2. Go to Console tab
3. Look for red errors
4. Screenshot errors
5. Share with support
```

### Check 4: Network Tab
```
1. Press F12
2. Go to Network tab
3. Fill form and click Save
4. Look for request to "save-section.php"
5. Click on it
6. Go to Response tab
7. Should show: "success": true
```

---

## Issue: Preview Not Showing Data

### Check 1: Did You Save?
- [ ] Go back to builder
- [ ] Check if data is still there
- [ ] If not, fill and save again

### Check 2: Session Active?
- [ ] Don't close browser tab
- [ ] Don't clear cookies
- [ ] Data stored in session only

### Check 3: Theme Loaded?
- [ ] In preview, click different themes
- [ ] Resume should update
- [ ] If not, check browser console

---

## Issue: Mobile Not Working

### Check 1: Responsive Design
```
1. Press F12
2. Click device toggle (Ctrl+Shift+M)
3. Select iPhone X or Android
4. Should show mobile layout
5. If not, check responsive.css
```

### Check 2: Touch Buttons
- [ ] Buttons should be at least 44px tall
- [ ] Should be easy to tap
- [ ] If not, check CSS

### Check 3: Form Sections
- [ ] All 8 sections should be visible
- [ ] Should be able to scroll
- [ ] Navigation links should work

---

## Issue: Download Not Working

### Check PDF Download
```
1. Go to preview page
2. Click "Download PDF"
3. Should download file
4. Check browser download folder
5. If not downloading, check browser settings
```

### Check PPT Download
```
1. Go to builder page
2. Click "📊 Download PPT"
3. Should download file
4. Check browser download folder
5. If not downloading, check browser settings
```

### Check Browser Settings
```
1. Open browser settings
2. Go to Downloads
3. Check "Ask where to save"
4. Or set default download folder
5. Make sure downloads are allowed
```

---

## Issue: Theme Not Switching

### Check 1: Preview Page
- [ ] Are you on preview page?
- [ ] Can you see theme buttons?
- [ ] Are buttons clickable?

### Check 2: Theme Files
```
Check all theme files exist:
✓ theme1-classic.php
✓ theme2-modern.php
✓ theme3-corporate.php
✓ theme4-creative.php
✓ theme5-dark.php
✓ theme6-elegant.php
✓ theme7-tech.php
✓ theme8-minimal.php
✓ theme9-vibrant.php
✓ theme10-executive.php
✓ theme11-gradient.php
✓ theme12-sidebar.php
✓ theme13-minimalist.php
✓ theme14-colorful.php
✓ theme15-timeline.php
```

### Check 3: Browser Console
```
1. Press F12
2. Go to Console tab
3. Look for errors
4. Screenshot and share
```

---

## Issue: Placeholder Image Not Showing

### Check 1: Profile Picture
- [ ] Did you upload a picture?
- [ ] If not, placeholder should show
- [ ] Placeholder should be colorful gradient

### Check 2: File Permissions
```
Check folder permissions:
✓ uploads/ folder exists
✓ uploads/ is writable
✓ uploads/ has 755 permissions
```

### Check 3: Placeholder Generator
```
Check file exists:
✓ utils/placeholder-generator.php
```

---

## Issue: Favicon Not Showing

### Check 1: Browser Cache
- [ ] Clear browser cache (Ctrl+Shift+Delete)
- [ ] Close browser
- [ ] Reopen browser
- [ ] Go to http://localhost/resume

### Check 2: File Exists
```
Check file:
✓ assets/favicon.svg exists
✓ File is not empty
✓ File is valid SVG
```

### Check 3: Header Integration
```
Check in components/header.php:
✓ Line with: <link rel="icon" type="image/svg+xml"
✓ Should point to: assets/favicon.svg
```

---

## Quick Fixes

### Fix 1: Session Not Working
```php
// Add to top of index.php
session_start();
session_regenerate_id();
```

### Fix 2: API Not Responding
```php
// Check api/save-section.php
// Add at top:
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Fix 3: Theme Not Loading
```php
// Check pages/preview.php
// Verify theme files path:
$themeFile = THEMES_PATH . $themeFiles[$theme];
// Should be: /path/to/themes/theme1-classic.php
```

### Fix 4: Mobile Not Responsive
```css
/* Check assets/css/responsive.css */
/* Should have media queries for: */
@media (max-width: 480px) { }
@media (max-width: 768px) { }
@media (max-width: 1024px) { }
```

---

## Debug Mode

### Enable Debug Output
```php
// Add to pages/builder.php after line 80
<?php
if (isset($_GET['debug'])) {
    echo '<pre>';
    echo 'SESSION DATA:<br>';
    var_dump($_SESSION['resume_data']);
    echo '</pre>';
}
?>
```

### Access Debug Mode
```
Go to: http://localhost/resume?page=builder&debug=1
Should show all session data
```

### Check Specific Section
```php
// In debug output, look for:
$_SESSION['resume_data']['workExperience']
$_SESSION['resume_data']['education']
$_SESSION['resume_data']['skills']
// etc.
```

---

## When All Else Fails

### Step 1: Verify Installation
```
1. Check all files are in: c:\xampp\htdocs\resume\
2. Check folder structure is correct
3. Check file permissions
4. Check Apache can read files
```

### Step 2: Check PHP
```
1. Create test.php in resume folder
2. Add: <?php phpinfo(); ?>
3. Go to http://localhost/resume/test.php
4. Should show PHP info
5. Delete test.php after
```

### Step 3: Check Database (if used)
```
1. Open phpMyAdmin
2. Check database exists
3. Check tables exist
4. Check data is there
```

### Step 4: Check Logs
```
1. Open: C:\xampp\apache\logs\error.log
2. Look for recent errors
3. Check timestamps
4. Screenshot errors
```

---

## Getting Help

### Provide This Information:
1. **What you did** - Step by step
2. **What you expected** - What should happen
3. **What happened** - What actually happened
4. **Error messages** - Any red text
5. **Browser** - Chrome, Firefox, Safari, Edge
6. **OS** - Windows, Mac, Linux
7. **Screenshots** - Of the issue
8. **Console errors** - Press F12, go to Console

### Where to Find Help:
1. Read `COMPLETE_TESTING_GUIDE.md`
2. Check `BUG_FIX_*.md` files
3. Review relevant documentation
4. Check browser console (F12)
5. Check server logs

---

## Quick Test

### 5-Minute Test
```
1. Go to http://localhost/resume
2. Click "Get Started Free"
3. Fill in: Name, Job Title, Email, Phone
4. Click "Save Personal Information"
5. See green notification ✓
6. Click "Preview Resume"
7. See your info displayed ✓
8. Click different theme
9. Resume updates ✓
10. Click "Download PDF"
11. File downloads ✓
```

If all 11 steps work, everything is fine!

---

**Version**: 1.0  
**Date**: November 24, 2025  
**Status**: Ready to Use
