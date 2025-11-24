# Complete Testing & Debugging Guide

## Step-by-Step Testing

### Step 1: Start Fresh Session
1. Open browser
2. Go to: `http://localhost/resume`
3. Clear browser cache (Ctrl+Shift+Delete)
4. Close all tabs with resume
5. Open fresh tab: `http://localhost/resume`

### Step 2: Fill Personal Information
1. Click on "Get Started Free" or go to builder
2. Fill in:
   - Full Name: `John Doe`
   - Job Title: `Software Engineer`
   - Email: `john@example.com`
   - Phone: `1234567890`
3. Click "Save Personal Information" button
4. **Expected**: Green notification "Personal saved successfully!"

### Step 3: Add Work Experience
1. Scroll to "Work Experience" section
2. Click "+ Add Work Experience"
3. Fill in:
   - Company Name: `Tech Corp`
   - Job Role: `Developer`
   - Start Date: `2020-01`
   - End Date: `2023-12`
   - Responsibilities: `Built web applications`
4. Click "Save Section" button
5. **Expected**: Green notification "Work experience saved successfully!"

### Step 4: Add Education
1. Scroll to "Education" section
2. Click "+ Add Education"
3. Fill in:
   - Degree: `Bachelor of Science`
   - Institute: `XYZ University`
   - Start Year: `2016`
   - End Year: `2020`
   - CGPA: `3.8`
4. Click "Save Section" button
5. **Expected**: Green notification "Education saved successfully!"

### Step 5: Add Skills
1. Scroll to "Skills" section
2. Click "+ Add Skill"
3. Fill in:
   - Skill Name: `JavaScript`
   - Proficiency: `Expert`
4. Click "Save Section" button
5. **Expected**: Green notification "Skills saved successfully!"

### Step 6: Preview Resume
1. Click "Preview Resume" button in sidebar
2. **Expected**: Resume displays with:
   - Personal info at top
   - Work experience section
   - Education section
   - Skills section
3. All sections should show your entered data

### Step 7: Test Theme Selection
1. In preview page, click different theme buttons
2. Resume should update with different styling
3. All data should remain the same

### Step 8: Download PDF
1. In preview page, click "Download PDF"
2. **Expected**: PDF file downloads with all sections

### Step 9: Download PowerPoint
1. Go back to builder
2. Click "📊 Download PPT" button
3. **Expected**: PowerPoint file downloads with all sections

---

## Debugging Steps

### If Personal Info Not Saving

**Check 1**: Browser Console
1. Press F12 to open DevTools
2. Go to Console tab
3. Look for red errors
4. Screenshot and share error

**Check 2**: Network Tab
1. Press F12 to open DevTools
2. Go to Network tab
3. Fill form and click Save
4. Look for request to `api/save-section.php`
5. Click on it and check Response
6. Should see: `"success": true`

**Check 3**: Session Data
1. Add this to `pages/builder.php` after line 80:
```php
<?php
// DEBUG: Show session data
if (isset($_GET['debug'])) {
    echo '<pre>';
    var_dump($_SESSION['resume_data']);
    echo '</pre>';
}
?>
```
2. Go to: `http://localhost/resume?page=builder&debug=1`
3. Should show all saved data

### If Work Experience Not Saving

**Check 1**: Form Item Created
1. Press F12 to open DevTools
2. Go to Elements tab
3. Look for `.form-item` divs in Work Experience section
4. Should see form fields inside

**Check 2**: Data Collection
1. Press F12 to open DevTools
2. Go to Console tab
3. Type: `SectionSaveManager.collectFormData('work')`
4. Should return array of objects with data

**Check 3**: API Response
1. Press F12 to open DevTools
2. Go to Network tab
3. Click "Save Section" for work experience
4. Look for request to `api/save-section.php`
5. Check Response tab
6. Should see: `"success": true`

### If Preview Not Showing Data

**Check 1**: Session Data
1. Go to: `http://localhost/resume?page=builder&debug=1`
2. Look for `workExperience` array
3. Should have entries with your data

**Check 2**: Theme File
1. Open `themes/theme1-classic.php`
2. Look for Work Experience section (around line 63)
3. Should have: `foreach ($data['workExperience'] as $exp)`

**Check 3**: Field Names
1. In theme, look for: `$exp['job_role']` or `$exp['jobRole']`
2. Should display without errors

---

## Common Issues & Solutions

### Issue 1: "Save Section" button not working
**Solution**:
1. Check browser console for errors (F12)
2. Verify `api/save-section.php` exists
3. Check file permissions on api folder
4. Restart browser

### Issue 2: Green notification appears but data not saved
**Solution**:
1. Check session is active
2. Go to builder page and check debug mode
3. Verify session data is populated
4. Check if page is being cached

### Issue 3: Preview shows only personal info
**Solution**:
1. Make sure to click "Save Section" for each section
2. Don't just fill form and go to preview
3. Each section needs explicit save
4. Check session data in debug mode

### Issue 4: Download buttons not working
**Solution**:
1. Check `api/download-ppt.php` exists
2. Check `utils/ppt-generator.php` exists
3. Check uploads folder has write permissions
4. Check browser allows downloads

### Issue 5: Mobile not showing sections
**Solution**:
1. Check responsive CSS is loaded
2. Press F12 and toggle device mode
3. Check all media queries are correct
4. Clear browser cache

---

## Quick Verification Checklist

- [ ] Personal info saves
- [ ] Work experience saves
- [ ] Education saves
- [ ] Skills saves
- [ ] Projects saves
- [ ] Certifications saves
- [ ] Languages saves
- [ ] Interests saves
- [ ] Preview shows all sections
- [ ] Theme switching works
- [ ] PDF download works
- [ ] PPT download works
- [ ] Mobile responsive
- [ ] No console errors

---

## Browser Console Commands

### Check Session Data
```javascript
// In browser console, this will show what's saved
fetch('?page=builder&debug=1').then(r => r.text()).then(t => console.log(t))
```

### Test Save Function
```javascript
// Test saving a section
const data = {company: 'Test Corp', job_role: 'Tester'};
SectionSaveManager.saveSection('work_experience', [data]);
```

### Check Form Data Collection
```javascript
// Check what data will be collected
SectionSaveManager.collectFormData('work')
```

---

## Server-Side Debugging

### Check PHP Errors
1. Open `php.ini`
2. Set: `display_errors = On`
3. Set: `error_reporting = E_ALL`
4. Restart Apache
5. Check browser for errors

### Check Session Files
1. Go to: `C:\xampp\tmp` (or your session path)
2. Look for session files
3. Check modification time
4. Should update when you save

### Check API Logs
1. Add to `api/save-section.php` after line 40:
```php
error_log("Save request: " . json_encode($input));
```
2. Check `C:\xampp\apache\logs\error.log`

---

## If Still Not Working

### Provide This Information:
1. **Screenshot of error** - What do you see?
2. **Browser console errors** - Press F12, go to Console
3. **Network tab response** - What does API return?
4. **Debug mode output** - Go to `?page=builder&debug=1`
5. **What you filled** - What data did you enter?
6. **What you expected** - What should happen?
7. **What actually happened** - What did happen?

### Steps to Provide Debug Info:
1. Press F12 to open DevTools
2. Go to Console tab
3. Fill form and click Save
4. Right-click in console and "Save as"
5. Share the file

---

## Reset Everything

If nothing is working, reset:

1. **Clear Session**:
```php
// Add to index.php temporarily
session_destroy();
session_start();
```

2. **Clear Browser Cache**:
   - Ctrl+Shift+Delete
   - Select "All time"
   - Check all boxes
   - Click Clear

3. **Restart Apache**:
   - Open XAMPP Control Panel
   - Stop Apache
   - Start Apache
   - Wait 5 seconds

4. **Restart Browser**:
   - Close all tabs
   - Close browser completely
   - Reopen browser
   - Go to `http://localhost/resume`

---

## Contact Support

If you've followed all steps and still have issues:

1. Go to: `http://localhost/resume?page=builder&debug=1`
2. Screenshot the output
3. Open browser DevTools (F12)
4. Go to Network tab
5. Fill form and save
6. Right-click on `save-section.php` request
7. Click "Copy as cURL"
8. Share all this information

---

**Version**: 1.0  
**Date**: November 24, 2025  
**Status**: Complete Testing Guide
