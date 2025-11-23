# ResumeBuilder Pro - Complete Installation Guide

## 📋 Table of Contents
1. [System Requirements](#system-requirements)
2. [Installation Steps](#installation-steps)
3. [Configuration](#configuration)
4. [PDF Library Setup](#pdf-library-setup)
5. [Verification](#verification)
6. [Troubleshooting](#troubleshooting)
7. [Deployment](#deployment)

## 🖥️ System Requirements

### Minimum Requirements
- **PHP**: 8.0 or higher
- **Web Server**: Apache 2.4+, Nginx 1.18+, or IIS 10+
- **Disk Space**: 50MB
- **Memory**: 256MB RAM
- **Browser**: Modern browser (Chrome, Firefox, Safari, Edge)

### Recommended Requirements
- **PHP**: 8.2 or higher
- **Web Server**: Apache 2.4.52+ or Nginx 1.24+
- **Disk Space**: 200MB
- **Memory**: 512MB RAM or more
- **SSL/TLS**: HTTPS enabled

### Optional Components
- **DOMPDF**: For enhanced PDF generation
- **mPDF**: Alternative PDF library
- **Composer**: For dependency management

## 📥 Installation Steps

### Step 1: Download Files
Download the resume-builder package and extract to your desired location.

### Step 2: Copy to Web Root

#### XAMPP (Windows)
```bash
# Copy to XAMPP htdocs
xcopy resume C:\xampp\htdocs\resume /E /I
```

#### XAMPP (Mac/Linux)
```bash
# Copy to XAMPP htdocs
cp -r resume /Applications/XAMPP/htdocs/
```

#### Linux (Apache)
```bash
# Copy to Apache root
sudo cp -r resume /var/www/html/
sudo chown -R www-data:www-data /var/www/html/resume
```

#### cPanel/Shared Hosting
1. Use File Manager or FTP
2. Upload files to `public_html/resume/`
3. Extract if uploaded as zip

### Step 3: Set Permissions

#### Linux/Mac
```bash
# Set directory permissions
chmod 755 resume/
chmod 755 resume/uploads/
chmod 755 resume/config/
chmod 755 resume/assets/
chmod 755 resume/themes/
chmod 755 resume/pages/
chmod 755 resume/components/

# Set file permissions
chmod 644 resume/*.php
chmod 644 resume/assets/css/*.css
chmod 644 resume/assets/js/*.js
```

#### Windows (XAMPP)
- No action needed - XAMPP handles permissions automatically

### Step 4: Create Uploads Directory
```bash
# Linux/Mac
mkdir -p resume/uploads
chmod 755 resume/uploads

# Windows
mkdir resume\uploads
```

### Step 5: Verify Installation
1. Open browser
2. Navigate to `http://localhost/resume/`
3. You should see the home page

## ⚙️ Configuration

### Update Base URL
Edit `config/constants.php`:

```php
// Line 9 - Update to your domain
define('BASE_URL', 'http://yourdomain.com/resume/');
// or for local development
define('BASE_URL', 'http://localhost/resume/');
```

### Update Contact Information
Edit `config/constants.php` (lines 50-52):

```php
define('CONTACT_EMAIL', 'your-email@example.com');
define('CONTACT_PHONE', '+1 (555) 123-4567');
define('CONTACT_ADDRESS', '123 Your Street, City, State 12345');
```

### Update Social Media Links
Edit `config/constants.php` (lines 55-58):

```php
define('SOCIAL_TWITTER', 'https://twitter.com/yourhandle');
define('SOCIAL_LINKEDIN', 'https://linkedin.com/in/yourprofile');
define('SOCIAL_GITHUB', 'https://github.com/yourprofile');
define('SOCIAL_FACEBOOK', 'https://facebook.com/yourpage');
```

### Update Site Information
Edit `config/constants.php` (lines 1-4):

```php
define('SITE_NAME', 'Your Resume Builder');
define('SITE_DESCRIPTION', 'Your custom description');
define('SITE_AUTHOR', 'Your Name');
define('SITE_KEYWORDS', 'resume, cv, builder');
```

### Adjust Upload Settings
Edit `config/constants.php` (lines 32-34):

```php
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('UPLOAD_DIRECTORY', 'uploads/');
```

## 📦 PDF Library Setup

### Option 1: DOMPDF (Recommended)

#### Using Composer
```bash
cd resume/
composer require dompdf/dompdf
```

#### Manual Installation
1. Download from https://github.com/dompdf/dompdf
2. Extract to `resume/vendor/dompdf/`
3. Include autoloader in `pdf.php`

### Option 2: mPDF

#### Using Composer
```bash
cd resume/
composer require mpdf/mpdf
```

#### Manual Installation
1. Download from https://github.com/mpdf/mpdf
2. Extract to `resume/vendor/mpdf/`
3. Include autoloader in `pdf.php`

### Verify PDF Library
Test PDF generation:
1. Fill resume form
2. Click "Preview Resume"
3. Click "Download PDF"
4. Check if PDF downloads successfully

## ✅ Verification Checklist

- [ ] Files extracted to correct location
- [ ] Permissions set correctly (755 for directories, 644 for files)
- [ ] Can access `http://localhost/resume/`
- [ ] Home page loads without errors
- [ ] Navigation menu works
- [ ] All pages load correctly
- [ ] Resume builder form displays
- [ ] Can add/remove form items
- [ ] Profile picture upload works
- [ ] Preview page displays correctly
- [ ] PDF download works (if library installed)
- [ ] No PHP errors in browser console
- [ ] No 404 errors for CSS/JS files

## 🐛 Troubleshooting

### Issue: "Page Not Found" (404 Error)
**Symptoms**: White page or 404 error when accessing site

**Solutions**:
1. Check BASE_URL in `config/constants.php`
2. Verify files are in correct directory
3. Check web server is running
4. Verify .htaccess is present (if using Apache)
5. Check web server error logs

### Issue: CSS/JavaScript Not Loading
**Symptoms**: Page loads but styling is broken

**Solutions**:
1. Clear browser cache (Ctrl+Shift+Delete)
2. Check ASSETS_URL in `config/constants.php`
3. Verify CSS/JS files exist in `/assets/`
4. Check browser console for 404 errors
5. Verify file permissions (644)

### Issue: Profile Picture Upload Fails
**Symptoms**: Upload button doesn't work or file not saved

**Solutions**:
1. Check `/uploads/` directory exists
2. Verify directory permissions (755)
3. Check file size (max 5MB)
4. Verify file format (JPG, PNG, GIF, WebP)
5. Check PHP upload_max_filesize setting
6. Check PHP post_max_size setting

### Issue: PDF Download Not Working
**Symptoms**: PDF download button doesn't work

**Solutions**:
1. Install DOMPDF or mPDF library
2. Check PHP memory_limit (min 128MB)
3. Verify write permissions on temp directory
4. Check PHP error logs
5. Verify PDF library is properly installed

### Issue: Form Data Lost After Refresh
**Symptoms**: Form data disappears when page is refreshed

**This is normal behavior** - data is session-based:
- Data persists during your session
- Data is lost when browser is closed
- Clearing cookies resets data
- This is by design for privacy

### Issue: Session Data Not Persisting
**Symptoms**: Form data lost immediately

**Solutions**:
1. Check PHP session.save_path is writable
2. Verify PHP sessions are enabled
3. Check browser cookie settings
4. Check PHP error logs
5. Verify session.gc_maxlifetime setting

### Issue: Blank White Page
**Symptoms**: Page loads but shows nothing

**Solutions**:
1. Check PHP error logs
2. Verify PHP version is 8.0+
3. Check for syntax errors in PHP files
4. Verify all required files exist
5. Check memory_limit setting

## 🌐 Deployment

### Pre-Deployment Checklist
- [ ] All configuration updated
- [ ] PDF library installed (optional)
- [ ] All pages tested locally
- [ ] Forms tested and working
- [ ] PDF generation tested
- [ ] All links verified
- [ ] Security review completed
- [ ] Backups created

### Deployment to Live Server

#### Via FTP/SFTP
1. Connect to server via FTP client
2. Navigate to `public_html/` or `www/`
3. Upload all files from `resume/` directory
4. Set permissions to 755 for directories
5. Set permissions to 644 for files
6. Update BASE_URL in `config/constants.php`
7. Test all functionality

#### Via Git
```bash
# Clone repository
git clone https://github.com/yourusername/resume-builder.git

# Navigate to directory
cd resume-builder

# Set permissions
chmod 755 .
chmod 755 uploads/

# Update configuration
nano config/constants.php
# Update BASE_URL and contact info

# Test
curl http://yourdomain.com/resume/
```

#### Via cPanel File Manager
1. Login to cPanel
2. Open File Manager
3. Navigate to `public_html`
4. Upload zip file
5. Right-click and extract
6. Set permissions via File Manager
7. Update configuration files
8. Test functionality

### Post-Deployment
1. Test all pages load correctly
2. Test form submission
3. Test PDF download
4. Check SSL/HTTPS works
5. Monitor error logs
6. Set up regular backups
7. Configure email notifications

## 📊 Performance Optimization

### Enable Caching
Add to `.htaccess` (Apache):
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
</IfModule>
```

### Enable Gzip Compression
Add to `.htaccess`:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

### Optimize Images
- Compress profile pictures before upload
- Use appropriate image formats
- Set MAX_UPLOAD_SIZE appropriately

## 🔒 Security Hardening

### Update PHP Settings
Edit `php.ini`:
```ini
upload_max_filesize = 5M
post_max_size = 5M
memory_limit = 128M
max_execution_time = 30
```

### Enable HTTPS
1. Get SSL certificate (Let's Encrypt is free)
2. Configure web server for HTTPS
3. Update BASE_URL to use https://
4. Set secure cookie flags

### Protect Sensitive Files
Create `.htaccess` in root:
```apache
<FilesMatch "\.php$">
    Deny from all
</FilesMatch>
<FilesMatch "^index\.php$">
    Allow from all
</FilesMatch>
```

## 📞 Support & Help

### Getting Help
1. Check README.md for documentation
2. Review FAQ page in application
3. Check troubleshooting section above
4. Review PHP error logs
5. Contact support via contact form

### Useful Resources
- [PHP Documentation](https://www.php.net/)
- [Apache Documentation](https://httpd.apache.org/)
- [Nginx Documentation](https://nginx.org/)
- [DOMPDF Documentation](https://github.com/dompdf/dompdf)
- [mPDF Documentation](https://github.com/mpdf/mpdf)

## 🎉 You're Ready!

Your Resume Builder is now installed and ready to use. Start creating amazing resumes!

---

**Need help?** Check the FAQ page or contact support.

**Happy Resume Building! 🚀**
