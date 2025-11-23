# ResumeBuilder Pro - Quick Reference Guide

## 🚀 Quick Start (30 Seconds)

1. **Extract files** to `C:\xampp\htdocs\resume\` (Windows) or `/var/www/html/resume/` (Linux)
2. **Open browser**: `http://localhost/resume/`
3. **Click "Resume Builder"** and start filling the form
4. **Preview** your resume with different themes
5. **Download PDF** when ready

## 📂 File Structure Quick Reference

```
resume/
├── index.php                 ← Main entry point
├── config/constants.php      ← Configuration (edit this!)
├── pages/                    ← Website pages
├── themes/                   ← Resume templates
├── assets/css/               ← Stylesheets
├── assets/js/                ← JavaScript files
├── components/               ← Reusable components
└── uploads/                  ← Profile pictures
```

## ⚙️ Configuration Quick Reference

### Edit `config/constants.php`

```php
// Line 9 - Your domain
define('BASE_URL', 'http://yourdomain.com/resume/');

// Line 50-52 - Contact info
define('CONTACT_EMAIL', 'your-email@example.com');
define('CONTACT_PHONE', '+1 (555) 123-4567');
define('CONTACT_ADDRESS', '123 Street, City, State');

// Line 55-58 - Social links
define('SOCIAL_TWITTER', 'https://twitter.com/...');
define('SOCIAL_LINKEDIN', 'https://linkedin.com/...');
define('SOCIAL_GITHUB', 'https://github.com/...');
```

## 🎨 Theme Files Quick Reference

| Theme | File | Style |
|-------|------|-------|
| Classic | `theme1-classic.php` | Traditional corporate |
| Modern | `theme2-modern.php` | Clean & minimal |
| Corporate | `theme3-corporate.php` | Blue professional |
| Creative | `theme4-creative.php` | Vibrant & modern |
| Dark | `theme5-dark.php` | Bold & tech-focused |

## 🔧 Common Tasks

### Change Site Colors
Edit `assets/css/variables.css`:
```css
:root {
    --color-primary: #3498db;      /* Change this */
    --color-secondary: #2c3e50;    /* And this */
}
```

### Add New Form Field
1. Edit `pages/builder.php`
2. Add HTML input
3. Update `index.php` session handling
4. Add to theme files

### Customize Theme
1. Edit theme file in `themes/`
2. Modify HTML structure
3. Update CSS styling
4. Test in preview

### Change Fonts
Edit `components/header.php`:
```html
<link href="https://fonts.googleapis.com/css2?family=YourFont" rel="stylesheet">
```

## 📋 Page URLs

| Page | URL |
|------|-----|
| Home | `http://localhost/resume/` |
| About | `http://localhost/resume/?page=about` |
| Builder | `http://localhost/resume/?page=builder` |
| Preview | `http://localhost/resume/?page=preview` |
| Contact | `http://localhost/resume/?page=contact` |
| FAQ | `http://localhost/resume/?page=faq` |
| Privacy | `http://localhost/resume/?page=privacy` |
| Terms | `http://localhost/resume/?page=terms` |

## 🐛 Quick Troubleshooting

| Problem | Solution |
|---------|----------|
| Page not found | Check BASE_URL in config |
| CSS not loading | Clear cache, check ASSETS_URL |
| Upload fails | Check permissions on `/uploads/` |
| PDF not working | Install DOMPDF or mPDF |
| Data lost | This is normal - session-based |

## 📦 Installation Quick Reference

### XAMPP (Windows)
```bash
xcopy resume C:\xampp\htdocs\resume /E /I
```

### Linux
```bash
sudo cp -r resume /var/www/html/
sudo chmod 755 /var/www/html/resume
```

### Permissions
```bash
chmod 755 resume/
chmod 755 resume/uploads/
chmod 644 resume/*.php
```

## 🔐 Security Checklist

- [ ] Update BASE_URL
- [ ] Update contact information
- [ ] Set proper file permissions
- [ ] Enable HTTPS in production
- [ ] Update PHP security settings
- [ ] Regular backups
- [ ] Monitor error logs

## 📊 CSS Variables Reference

### Colors
```css
--color-primary: #3498db
--color-secondary: #2c3e50
--color-success: #27ae60
--color-danger: #e74c3c
--color-warning: #f39c12
```

### Spacing
```css
--spacing-1: 4px
--spacing-2: 8px
--spacing-3: 12px
--spacing-4: 16px
--spacing-6: 24px
--spacing-8: 32px
```

### Shadows
```css
--shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05)
--shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1)
--shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1)
```

## 🎯 Resume Form Fields

### Personal Information
- Full Name (required)
- Job Title (required)
- Profile Summary
- Email (required)
- Phone (required)
- Address
- Website/Portfolio
- LinkedIn
- GitHub
- Profile Picture

### Work Experience
- Company Name
- Job Role
- Start Date
- End Date
- Responsibilities

### Education
- Degree
- Institute
- Start Year
- End Year
- CGPA/Percentage

### Skills
- Skill Name
- Level (Beginner/Intermediate/Expert)

### Projects
- Project Name
- Description
- Technologies Used
- Project Link

### Certifications
- Certificate Title
- Issued By
- Year

### Languages
- Language Name
- Proficiency (Beginner/Intermediate/Fluent/Native)

### Interests
- Free text list

## 📱 Responsive Breakpoints

```css
Mobile:      320px - 479px
Tablet:      480px - 767px
Desktop:     768px - 1023px
Large:       1024px - 1279px
Extra Large: 1280px+
```

## 🎓 Key Files to Know

| File | Purpose |
|------|---------|
| `index.php` | Main router |
| `config/constants.php` | Configuration |
| `pages/builder.php` | Resume form |
| `pages/preview.php` | Theme preview |
| `themes/theme*.php` | Resume templates |
| `assets/css/variables.css` | Design system |
| `assets/js/builder.js` | Form handling |

## 💾 Backup Important Files

Before making changes, backup:
- `config/constants.php`
- `pages/builder.php`
- `themes/` directory
- `assets/css/` directory

## 🚀 Deployment Checklist

- [ ] Update BASE_URL
- [ ] Update contact info
- [ ] Set permissions (755)
- [ ] Test all pages
- [ ] Test form submission
- [ ] Test PDF download
- [ ] Enable HTTPS
- [ ] Set up backups
- [ ] Monitor error logs

## 📞 Quick Help

**Documentation**: See `README.md`
**Setup Guide**: See `SETUP.md`
**Installation**: See `INSTALLATION.md`
**Project Info**: See `PROJECT_SUMMARY.md`

## 🎉 You're All Set!

Your Resume Builder is ready to use. Start creating amazing resumes!

---

**Questions?** Check the FAQ page or contact support.

**Happy Resume Building! 🚀**
