# 📄 resume.io - Professional Resume Builder

A modern, feature-rich resume builder web application with PDF generation, 10 professional themes, visitor logging, and error tracking.

**Live Demo**: [resume.io](http://localhost/resume/)  
**GitHub**: [YashDoifode1/resume.io](https://github.com/YashDoifode1/resume.io)

---

## ✨ Features

### 🎨 **10 Professional Themes**
- Classic Professional
- Modern Minimal
- Corporate Blue
- Creative Portfolio
- Dark Mode
- Elegant Gold
- Tech Startup
- Ultra Minimal
- Vibrant Colors
- Executive Premium

### 📥 **PDF Generation**
- DOMPDF integration
- mPDF support
- All 10 themes support PDF export
- High-quality output
- Fast generation

### 🖼️ **Profile Management**
- Upload custom profile picture
- Default profile image fallback
- Image optimization
- Responsive display

### 📊 **Visitor & Error Logging**
- Complete visitor tracking
- IP address logging
- Device type detection
- Browser identification
- Error logging with stack traces
- JSON format logs

### 📄 **Custom Error Pages**
- 404 Page Not Found
- 500 Server Error
- Professional design
- User-friendly messages

### 🎯 **Professional UI/UX**
- Horizontal navbar (logo | menu | CTA)
- Sticky navigation
- Mobile responsive
- Smooth animations
- Modern design

### 📋 **Form Features**
- Work experience management
- Education history
- Skills with proficiency levels
- Projects showcase
- Certifications
- Languages
- Contact information

### 🔒 **Security**
- Input validation
- Output escaping
- Session management
- CSRF protection
- Secure file uploads

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.0+
- Apache with mod_rewrite
- Composer
- XAMPP (recommended for local development)

### Installation

1. **Clone the repository**
```bash
git clone https://github.com/YashDoifode1/resume.io.git
cd resume.io
```

2. **Install dependencies**
```bash
composer install
```

3. **Or install DOMPDF separately**
```bash
composer require dompdf/dompdf
```

4. **Configure permissions**
```bash
chmod 755 logs/
chmod 755 uploads/
```

5. **Access the application**
```
http://localhost/resume/
```

---

## 📁 Project Structure

```
resume.io/
├── assets/
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript files
│   └── images/           # Images and icons
├── components/
│   ├── header.php        # Header with meta tags
│   ├── navbar.php        # Navigation bar
│   └── footer.php        # Footer
├── config/
│   └── constants.php     # Configuration constants
├── pages/
│   ├── home.php          # Home page
│   ├── builder.php       # Resume builder form
│   ├── preview.php       # Resume preview
│   ├── download.php      # PDF download handler
│   ├── error-404.php     # 404 error page
│   ├── error-500.php     # 500 error page
│   └── ...               # Other pages
├── themes/
│   ├── theme1-classic.php
│   ├── theme2-modern.php
│   └── ...               # 10 total themes
├── utils/
│   ├── logger.php        # Visitor/error logging
│   ├── pdf-generator.php # PDF generation
│   ├── contact-handler.php
│   └── fingerprint.php
├── logs/
│   ├── visitors.log      # Visitor tracking
│   └── errors.log        # Error tracking
├── uploads/              # User uploaded files
├── vendor/               # Composer dependencies
├── index.php             # Main router
├── .htaccess             # Apache configuration
├── composer.json         # Composer config
└── README.md             # This file
```

---

## 🔧 Configuration

### Site Configuration (`config/constants.php`)

```php
// Site Information
define('SITE_NAME', 'resume.io');
define('SITE_AUTHOR', 'Shweta Darvhekar');
define('SITE_DESCRIPTION', 'Create professional resumes in minutes');

// Owner Information
define('OWNER_NAME', 'Shweta Darvhekar');
define('OWNER_COLLEGE', 'SRWC Raisoni College');

// Contact Information
define('CONTACT_EMAIL', 'shweta@resume.io');
define('CONTACT_PHONE', '+91 (XXX) XXX-XXXX');

// PDF Configuration
define('PDF_LIBRARY', 'dompdf');
define('PDF_FONT_SIZE', 11);
define('PDF_MARGIN_TOP', 10);
```

---

## 📊 Logging

### Visitor Logs
Location: `logs/visitors.log`

```json
{
  "timestamp": "2025-01-01 13:45:30",
  "ip_address": "192.168.1.100",
  "user_agent": "Mozilla/5.0...",
  "page": "/resume/?page=builder",
  "device": "Desktop",
  "browser": "Chrome"
}
```

### Error Logs
Location: `logs/errors.log`

```json
{
  "timestamp": "2025-01-01 13:45:30",
  "error_code": 500,
  "error_message": "Database connection failed",
  "error_file": "/resume/pages/builder.php",
  "error_line": 42
}
```

---

## 🎨 Themes

Each theme includes:
- Professional layout
- Responsive design
- All resume sections
- Print-friendly styling
- PDF support

### Theme Files
- `theme1-classic.php` - Classic Professional
- `theme2-modern.php` - Modern Minimal
- `theme3-corporate.php` - Corporate Blue
- `theme4-creative.php` - Creative Portfolio
- `theme5-dark.php` - Dark Mode
- `theme6-elegant.php` - Elegant Gold
- `theme7-tech.php` - Tech Startup
- `theme8-minimal.php` - Ultra Minimal
- `theme9-vibrant.php` - Vibrant Colors
- `theme10-executive.php` - Executive Premium

---

## 📥 PDF Generation

### Using DOMPDF

```php
require_once 'utils/pdf-generator.php';

$pdf = new PDFGenerator();
$pdf->generatePDF($html, 'resume.pdf');
```

### Supported Features
- All 10 themes
- Images and styling
- Page breaks
- Custom fonts
- Professional output

---

## 🔐 Security Features

✅ **Input Validation** - All user inputs validated
✅ **Output Escaping** - All output properly escaped
✅ **Session Management** - Secure session handling
✅ **File Upload Validation** - Type and size checks
✅ **Error Logging** - Errors logged, not displayed
✅ **HTTPS Ready** - Security headers included

---

## 📱 Responsive Design

- Desktop (1200px+)
- Tablet (768px - 1199px)
- Mobile (< 768px)
- Mobile hamburger menu
- Touch-friendly buttons

---

## 🚀 Deployment

### XAMPP (Local Development)
```bash
# Copy to htdocs
cp -r resume.io C:\xampp\htdocs\

# Access
http://localhost/resume/
```

### Production Server
```bash
# Clone repository
git clone https://github.com/YashDoifode1/resume.io.git

# Install dependencies
composer install

# Set permissions
chmod 755 logs/ uploads/

# Configure .htaccess
# Update BASE_URL in config/constants.php
```

---

## 🧪 Testing

### Test Visitor Logging
1. Visit any page
2. Check `logs/visitors.log`
3. Verify your visit is logged

### Test PDF Download
1. Go to Resume Builder
2. Fill in information
3. Click Preview Resume
4. Click Download PDF
5. PDF downloads successfully

### Test Error Pages
1. Visit non-existent page: `/resume/nonexistent`
2. See 404 error page
3. Click back button

---

## 🐛 Troubleshooting

### PDF Not Downloading
```bash
# Check DOMPDF installation
composer show | grep dompdf

# Reinstall if needed
composer require dompdf/dompdf
```

### Logs Not Created
```bash
# Check permissions
chmod 755 logs/

# Verify directory exists
ls -la logs/
```

### Session Errors
- Clear browser cookies
- Check PHP session configuration
- Verify session directory permissions

---

## 📚 Documentation

- `README.md` - Main documentation
- `FEATURES_IMPLEMENTED.md` - Feature details
- `PDF_SETUP.md` - PDF generation guide
- `INSTALLATION.md` - Installation guide
- `DOMPDF_QUICK_START.md` - Quick start guide

---

## 🤝 Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

This project is open source and available under the MIT License.

---

## 👨‍💻 Author

**Shweta Darvhekar**
- Email: shweta@resume.io
- College: SRWC Raisoni College
- GitHub: [@YashDoifode1](https://github.com/YashDoifode1)

---

## 🙏 Acknowledgments

- DOMPDF for PDF generation
- PHP community for excellent tools
- All contributors and testers

---

## 📞 Support

For issues, questions, or suggestions:
- Open an issue on GitHub
- Email: shweta@resume.io
- Check documentation files

---

## 🎯 Roadmap

- [ ] Database integration
- [ ] User authentication
- [ ] Resume templates marketplace
- [ ] AI-powered content suggestions
- [ ] Multi-language support
- [ ] Export to Word format
- [ ] LinkedIn integration
- [ ] Analytics dashboard

---

## ⭐ Star History

If you find this project helpful, please consider giving it a star! ⭐

---

**Made with ❤️ by Shweta Darvhekar**

**Last Updated**: January 1, 2025  
**Version**: 1.0  
**Status**: Production Ready ✅
