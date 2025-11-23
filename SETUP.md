# ResumeBuilder Pro - Quick Setup Guide

## ⚡ Quick Start (5 Minutes)

### Step 1: Extract Files
Extract the resume-builder.zip to your web root:
- **XAMPP**: `C:\xampp\htdocs\resume\`
- **Linux**: `/var/www/html/resume/`
- **cPanel**: `public_html/resume/`

### Step 2: Set Permissions
```bash
# Linux/Mac
chmod 755 resume/
chmod 755 resume/uploads/

# Windows (via XAMPP Control Panel)
# No action needed - XAMPP handles permissions
```

### Step 3: Access the Application
Open your browser and visit:
- `http://localhost/resume/` (Local)
- `http://yourdomain.com/resume/` (Live)

### Step 4: Start Building!
1. Click "Resume Builder" in the navigation
2. Fill in your information
3. Preview your resume
4. Download as PDF

## 🔧 Configuration

### Update Base URL
Edit `config/constants.php`:

```php
// Change this line to your domain
define('BASE_URL', 'http://yourdomain.com/resume/');
```

### Update Contact Information
Edit `config/constants.php`:

```php
define('CONTACT_EMAIL', 'your-email@example.com');
define('CONTACT_PHONE', '+1 (555) 123-4567');
define('CONTACT_ADDRESS', '123 Your Street, City, State 12345');
```

### Update Social Links
Edit `config/constants.php`:

```php
define('SOCIAL_TWITTER', 'https://twitter.com/yourhandle');
define('SOCIAL_LINKEDIN', 'https://linkedin.com/in/yourprofile');
define('SOCIAL_GITHUB', 'https://github.com/yourprofile');
```

## 📦 Optional: Install PDF Libraries

### Option 1: DOMPDF (Recommended)

```bash
# Navigate to project directory
cd resume/

# Install via Composer
composer require dompdf/dompdf

# Or download manually from https://github.com/dompdf/dompdf
```

### Option 2: mPDF

```bash
# Install via Composer
composer require mpdf/mpdf

# Or download manually from https://github.com/mpdf/mpdf
```

## ✅ Verification Checklist

- [ ] Files extracted to correct location
- [ ] Permissions set correctly (755)
- [ ] Can access `http://localhost/resume/`
- [ ] Home page loads without errors
- [ ] Navigation links work
- [ ] Resume builder form loads
- [ ] Can add/remove form items
- [ ] Profile picture upload works
- [ ] Preview page displays correctly
- [ ] PDF download works

## 🚨 Common Issues & Solutions

### Issue: "Page Not Found" Error
**Solution**: 
- Check BASE_URL in `config/constants.php`
- Verify files are in correct directory
- Check web server is running

### Issue: CSS/JS Not Loading
**Solution**:
- Clear browser cache (Ctrl+Shift+Delete)
- Check file paths in header.php
- Verify ASSETS_URL is correct

### Issue: Profile Picture Upload Fails
**Solution**:
- Check `/uploads/` directory exists
- Verify directory permissions (755)
- Check file size (max 5MB)
- Verify file format (JPG, PNG, GIF, WebP)

### Issue: PDF Download Not Working
**Solution**:
- Install DOMPDF or mPDF library
- Check PHP memory limit (min 128MB)
- Verify write permissions
- Check PHP error logs

### Issue: Form Data Lost After Refresh
**Solution**:
- This is normal - data is session-based
- Data persists during your session
- Clear cookies to reset data

## 📱 Mobile Testing

Test on mobile devices:
1. Use responsive design mode (F12)
2. Test on actual mobile devices
3. Check form usability on small screens
4. Verify PDF download on mobile

## 🔐 Security Recommendations

1. **Use HTTPS**: Always use SSL/TLS in production
2. **Update PHP**: Keep PHP version current
3. **Regular Backups**: Backup files regularly
4. **Monitor Logs**: Check PHP error logs
5. **Limit Uploads**: Keep MAX_UPLOAD_SIZE reasonable

## 📊 Performance Optimization

1. **Enable Caching**: Use browser caching
2. **Minify CSS/JS**: Minify for production
3. **Optimize Images**: Compress profile pictures
4. **Use CDN**: Serve assets from CDN
5. **Enable Gzip**: Compress responses

## 🌐 Deployment to Live Server

### Via FTP/SFTP
1. Connect to server via FTP
2. Upload all files to `public_html/resume/`
3. Set permissions to 755
4. Update BASE_URL in config
5. Test all functionality

### Via Git
```bash
# Clone repository
git clone https://github.com/yourusername/resume-builder.git

# Navigate to directory
cd resume-builder

# Set permissions
chmod 755 .
chmod 755 uploads/

# Update configuration
# Edit config/constants.php with production values
```

### Via cPanel
1. Upload zip file via File Manager
2. Extract in public_html
3. Set permissions via File Manager
4. Update configuration files
5. Test functionality

## 📞 Getting Help

1. **Check README.md** for detailed documentation
2. **Review FAQ page** for common questions
3. **Check troubleshooting section** in README
4. **Contact support** via contact form

## 🎓 Next Steps

1. Customize themes to match your brand
2. Add your contact information
3. Test all features thoroughly
4. Deploy to live server
5. Promote your resume builder

## 📚 Additional Resources

- [PHP Documentation](https://www.php.net/)
- [HTML5 Guide](https://developer.mozilla.org/en-US/docs/Web/HTML)
- [CSS3 Reference](https://developer.mozilla.org/en-US/docs/Web/CSS)
- [JavaScript Guide](https://developer.mozilla.org/en-US/docs/Web/JavaScript)

## 🎉 You're All Set!

Your Resume Builder is ready to use. Start creating amazing resumes!

---

**Questions?** Check the FAQ page or contact support.

**Happy Resume Building! 🚀**
