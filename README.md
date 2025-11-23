# ResumeBuilder Pro - Professional Resume Builder

A modern, production-ready Resume Builder website built with PHP 8+, HTML5, CSS3, and JavaScript. Create professional resumes in minutes with 5 beautiful templates and download as PDF.

## 🌟 Features

### Core Functionality
- **Complete Resume Form** with all essential sections
- **5 Professional Templates** for resume display
- **Live Preview** with theme switching
- **PDF Download** functionality using mPDF/DOMPDF
- **Session-based Storage** (no database required)
- **Image Upload** for profile pictures
- **Fully Responsive** design for all devices

### Resume Sections
1. **Personal Information**
   - Full Name, Job Title, Profile Summary
   - Email, Phone, Address
   - Website/Portfolio, LinkedIn, GitHub
   - Profile Picture Upload

2. **Work Experience** (Multiple)
   - Company Name, Job Role
   - Start/End Dates
   - Responsibilities

3. **Education** (Multiple)
   - Degree, Institute
   - Start/End Years
   - CGPA/Percentage

4. **Skills** (Multiple)
   - Skill Name
   - Level (Beginner/Intermediate/Expert)

5. **Projects** (Multiple)
   - Project Name, Description
   - Technologies Used
   - Project Link

6. **Certifications** (Multiple)
   - Certificate Title
   - Issued By, Year

7. **Languages** (Multiple)
   - Language Name
   - Proficiency Level

8. **Interests**
   - Free text list of interests

### Available Themes
1. **Classic Professional** - Traditional, corporate-style resume
2. **Modern Minimal** - Clean, minimalist design
3. **Corporate Blue** - Professional blue-themed layout
4. **Creative Portfolio** - Vibrant design for creative professionals
5. **Dark Mode** - Modern dark theme with bold typography

## 📁 Project Structure

```
resume/
├── index.php                    # Main router
├── config/
│   └── constants.php           # Global constants
├── components/
│   ├── header.php              # HTML head section
│   ├── navbar.php              # Navigation bar
│   └── footer.php              # Footer section
├── pages/
│   ├── home.php                # Landing page
│   ├── about.php               # About page
│   ├── builder.php             # Resume builder form
│   ├── preview.php             # Resume preview
│   ├── contact.php             # Contact page
│   ├── faq.php                 # FAQ page
│   ├── privacy.php             # Privacy policy
│   └── terms.php               # Terms of service
├── themes/
│   ├── theme1-classic.php
│   ├── theme2-modern.php
│   ├── theme3-corporate.php
│   ├── theme4-creative.php
│   └── theme5-dark.php
├── assets/
│   ├── css/
│   │   ├── reset.css           # CSS reset
│   │   ├── variables.css       # CSS variables
│   │   ├── global.css          # Global styles
│   │   ├── layout.css          # Layout styles
│   │   ├── components.css      # Component styles
│   │   ├── responsive.css      # Responsive styles
│   │   ├── builder.css         # Builder page styles
│   │   └── preview.css         # Preview page styles
│   └── js/
│       ├── main.js             # Main JavaScript
│       └── builder.js          # Builder form handler
└── uploads/                    # Profile picture storage (auto-created)
```

## 🚀 Installation & Setup

### Requirements
- PHP 8.0 or higher
- Web server (Apache, Nginx, etc.)
- Modern web browser
- 10MB disk space

### Optional (for PDF generation)
- DOMPDF library (recommended)
- mPDF library (alternative)

### Steps

1. **Download/Clone the Project**
   ```bash
   git clone https://github.com/yourusername/resume-builder.git
   cd resume-builder
   ```

2. **Copy to Web Root**
   ```bash
   cp -r resume/ /var/www/html/
   # or
   cp -r resume/ C:\xampp\htdocs\
   ```

3. **Set Permissions**
   ```bash
   chmod 755 /var/www/html/resume/
   chmod 755 /var/www/html/resume/uploads/
   ```

4. **Update Configuration** (if needed)
   - Edit `config/constants.php`
   - Update `BASE_URL` to match your domain
   - Update contact information

5. **Access the Application**
   - Open browser: `http://localhost/resume/`
   - Or your domain: `https://yourdomain.com/resume/`

6. **(Optional) Install PDF Libraries**
   ```bash
   cd /var/www/html/resume/
   composer require dompdf/dompdf
   # or
   composer require mpdf/mpdf
   ```

## 🎯 Usage Guide

### Creating a Resume

1. **Navigate to Resume Builder**
   - Click "Resume Builder" in navigation
   - Or visit `?page=builder`

2. **Fill Personal Information**
   - Enter your name, job title, and contact details
   - Upload a profile picture (optional)
   - Write a professional summary

3. **Add Work Experience**
   - Click "Add Work Experience"
   - Fill in company, role, dates, and responsibilities
   - Add multiple entries as needed

4. **Add Education**
   - Click "Add Education"
   - Enter degree, institute, years, and CGPA
   - Add multiple entries as needed

5. **Add Skills, Projects, Certifications, Languages**
   - Follow the same pattern for each section
   - Add as many entries as needed

6. **Preview Your Resume**
   - Click "Preview Resume" button
   - Select different themes to see variations
   - Review content and formatting

7. **Download as PDF**
   - Click "Download PDF" button
   - Choose your preferred theme
   - PDF downloads automatically

### Data Management
- All data is stored in PHP sessions
- Data persists during your session
- Clearing browser cookies will reset the data
- No data is stored on server

## 🎨 Customization

### Modifying Themes
1. Edit theme files in `/themes/`
2. Modify HTML structure and CSS
3. All themes receive same data variables
4. Test in preview before publishing

### Changing Colors
1. Edit `/assets/css/variables.css`
2. Modify CSS custom properties
3. Changes apply globally

### Adding New Sections
1. Add form fields in `pages/builder.php`
2. Update session data handling in `index.php`
3. Create display logic in theme files
4. Add corresponding CSS styling

### Customizing Pages
1. Edit files in `/pages/`
2. Modify HTML and content
3. Update navigation if needed
4. Test responsive design

## 🔒 Security Features

- **Input Validation**: All inputs sanitized with `htmlspecialchars()`
- **File Upload Validation**: Type and size checks
- **Session-based Storage**: No database vulnerabilities
- **CSRF Protection**: Ready for implementation
- **XSS Prevention**: Proper escaping throughout
- **No External Dependencies**: Minimal attack surface

## ⚡ Performance

- **Lightweight**: ~200KB total size
- **No Database**: Fast session-based operations
- **Optimized CSS**: Minified and organized
- **Lazy Loading**: Images load on demand
- **Responsive Design**: Mobile-first approach
- **Fast PDF Generation**: Instant downloads

## 📱 Browser Compatibility

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)
- IE 11 (limited support)

## 📥 PDF Generation

### Without Libraries
- Uses browser's print functionality
- Works in all modern browsers
- Manual PDF conversion via browser

### With DOMPDF
- Enhanced PDF generation
- Better formatting control
- Automatic page breaks
- Embedded images support

### With mPDF
- Advanced PDF features
- Better Unicode support
- Complex layouts support
- Faster generation

## 🔧 Configuration

Edit `config/constants.php` to customize:

```php
// Site Information
define('SITE_NAME', 'ResumeBuilder Pro');
define('BASE_URL', 'http://localhost/resume/');

// Upload Settings
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Contact Information
define('CONTACT_EMAIL', 'support@resumebuilder.com');
define('CONTACT_PHONE', '+1 (555) 123-4567');

// Social Media
define('SOCIAL_TWITTER', 'https://twitter.com');
define('SOCIAL_LINKEDIN', 'https://linkedin.com');
```

## 🐛 Troubleshooting

### Profile Picture Not Uploading
- Check `/uploads/` directory permissions
- Verify file size (max 5MB)
- Ensure file format is supported (JPG, PNG, GIF, WebP)

### PDF Not Generating
- Install DOMPDF or mPDF library
- Check PHP memory limits
- Verify write permissions

### Session Data Lost
- Check browser cookie settings
- Ensure `session.save_path` is writable
- Verify PHP session configuration

### Styling Issues
- Clear browser cache (Ctrl+Shift+Delete)
- Check CSS file paths
- Verify all CSS files are loaded

### Form Not Submitting
- Check browser console for errors
- Verify form validation
- Check PHP error logs

## 📊 Technical Stack

- **Backend**: PHP 8+
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Styling**: CSS Variables, Flexbox, Grid
- **PDF**: DOMPDF/mPDF
- **Session**: PHP Sessions
- **Storage**: Browser Session + File System

## 📄 License

This project is free to use and modify for personal or commercial projects.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues.

## 📞 Support

For issues or questions:
1. Check the FAQ page
2. Review troubleshooting section
3. Contact via email: support@resumebuilder.com

## 🎓 Learning Resources

- [PHP Documentation](https://www.php.net/docs.php)
- [HTML5 Guide](https://developer.mozilla.org/en-US/docs/Web/HTML)
- [CSS3 Reference](https://developer.mozilla.org/en-US/docs/Web/CSS)
- [JavaScript Guide](https://developer.mozilla.org/en-US/docs/Web/JavaScript)

## 🚀 Deployment

### Hosting Recommendations
- Shared Hosting (Bluehost, HostGator, SiteGround)
- VPS (DigitalOcean, Linode, Vultr)
- Cloud (AWS, Google Cloud, Azure)
- Dedicated Servers

### Deployment Steps
1. Upload files via FTP/SFTP
2. Set proper file permissions
3. Update `BASE_URL` in constants.php
4. Test all functionality
5. Set up SSL certificate
6. Configure backups

## 📈 Future Enhancements

- [ ] User accounts and authentication
- [ ] Resume templates library
- [ ] AI-powered content suggestions
- [ ] Multi-language support
- [ ] Export to Word format
- [ ] Resume analytics
- [ ] Social sharing features
- [ ] Template marketplace

## 📝 Version History

### v1.0 (Current)
- Initial release
- 5 professional templates
- Complete form functionality
- PDF generation support
- Session-based storage
- Responsive design

## 🙏 Acknowledgments

- Inspired by modern resume builders
- Built with best practices in mind
- Community feedback and suggestions

---

**Built with ❤️ for professionals worldwide**

**ResumeBuilder Pro** - Create stunning resumes in minutes!
