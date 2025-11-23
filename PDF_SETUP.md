# PDF Generation Setup Guide

## Overview

resume.io now includes integrated PDF generation using **DOMPDF** or **mPDF**. The system automatically detects which library is available and uses it accordingly.

## Features

✅ **Automatic Library Detection** - Detects DOMPDF or mPDF automatically
✅ **All 10 Themes Supported** - Generate PDF in any theme
✅ **High-Quality Output** - Professional PDF generation
✅ **Fallback Support** - Browser print if no library installed
✅ **Error Handling** - Graceful error messages
✅ **Responsive PDFs** - Optimized for printing

## Installation

### Option 1: DOMPDF (Recommended)

DOMPDF is lightweight and easy to install.

#### Step 1: Install via Composer

```bash
cd c:\xampp\htdocs\resume
composer require dompdf/dompdf
```

#### Step 2: Verify Installation

Check if `vendor/autoload.php` exists:
```
c:\xampp\htdocs\resume\vendor\autoload.php
```

#### Step 3: Test PDF Generation

1. Go to Resume Builder
2. Fill in some information
3. Click "Preview Resume"
4. Click "📥 Download PDF"
5. PDF should download successfully

### Option 2: mPDF

mPDF offers more advanced features but is larger.

#### Step 1: Install via Composer

```bash
cd c:\xampp\htdocs\resume
composer require mpdf/mpdf
```

#### Step 2: Verify Installation

Check if `vendor/autoload.php` exists:
```
c:\xampp\htdocs\resume\vendor\autoload.php
```

#### Step 3: Test PDF Generation

Same as DOMPDF above.

### Option 3: Manual Installation (Without Composer)

If you don't have Composer installed:

#### For DOMPDF:

1. Download from: https://github.com/dompdf/dompdf/releases
2. Extract to: `c:\xampp\htdocs\resume\vendor\dompdf\`
3. The structure should be:
   ```
   vendor/
   └── dompdf/
       ├── autoload.php
       ├── src/
       └── lib/
   ```

#### For mPDF:

1. Download from: https://github.com/mpdf/mpdf/releases
2. Extract to: `c:\xampp\htdocs\resume\vendor\mpdf\`
3. The structure should be:
   ```
   vendor/
   └── mpdf/
       ├── autoload.php
       ├── src/
       └── vendor/
   ```

## System Requirements

### For DOMPDF:
- PHP 5.3.0+
- GD extension (for image processing)
- MB String extension
- DOM extension

### For mPDF:
- PHP 5.6.0+
- GD extension
- MB String extension
- DOM extension
- Zlib extension

### Check PHP Extensions

```bash
# Windows Command Prompt
php -m | findstr "gd mbstring dom zlib"

# Or check via PHP Info
# Create a file with: <?php phpinfo(); ?>
# Then view in browser
```

## Configuration

### Enable/Disable PDF Generation

Edit `config/constants.php`:

```php
// PDF Configuration
define('PDF_LIBRARY', 'dompdf'); // 'dompdf', 'mpdf', or 'html'
define('PDF_FONT_SIZE', 11);
define('PDF_MARGIN_TOP', 10);
define('PDF_MARGIN_BOTTOM', 10);
define('PDF_MARGIN_LEFT', 10);
define('PDF_MARGIN_RIGHT', 10);
```

## How It Works

### PDF Generation Flow

1. **User clicks "Download PDF"** on preview page
2. **System detects library** (DOMPDF, mPDF, or HTML)
3. **Theme HTML is generated** from session data
4. **HTML is wrapped** with proper PDF structure
5. **PDF is generated** using detected library
6. **File is downloaded** to user's computer

### Supported Themes

All 10 themes support PDF generation:

1. Classic Professional
2. Modern Minimal
3. Corporate Blue
4. Creative Portfolio
5. Dark Mode
6. Elegant Gold
7. Tech Startup
8. Ultra Minimal
9. Vibrant Colors
10. Executive Premium

## Troubleshooting

### Issue: "PDF library not installed"

**Symptoms**: Browser print dialog appears instead of PDF download

**Solutions**:
1. Install DOMPDF or mPDF using Composer
2. Verify `vendor/autoload.php` exists
3. Check PHP extensions are enabled
4. Restart web server

### Issue: "Class not found: Dompdf\Dompdf"

**Symptoms**: PHP error about missing class

**Solutions**:
1. Run `composer install` in project directory
2. Check `vendor/autoload.php` exists
3. Verify Composer installed correctly
4. Check file permissions

### Issue: "PDF downloads but is corrupted"

**Symptoms**: PDF file opens but shows errors

**Solutions**:
1. Check PHP memory limit: `memory_limit = 128M` (minimum)
2. Check max execution time: `max_execution_time = 30` (minimum)
3. Clear browser cache
4. Try different theme
5. Check error logs

### Issue: "Images not showing in PDF"

**Symptoms**: PDF generates but images are missing

**Solutions**:
1. Ensure GD extension is enabled
2. Check image file permissions
3. Verify image paths are correct
4. Try uploading image again

### Issue: "PDF takes too long to generate"

**Symptoms**: Page times out during PDF generation

**Solutions**:
1. Increase PHP timeout: `max_execution_time = 60`
2. Increase memory limit: `memory_limit = 256M`
3. Try simpler theme with fewer styles
4. Optimize images (reduce file size)

## Performance Tips

### Optimize PDF Generation

1. **Use DOMPDF** - Faster than mPDF for most cases
2. **Minimize CSS** - Remove unnecessary styles
3. **Optimize Images** - Use compressed images
4. **Increase Memory** - Set `memory_limit = 256M`
5. **Increase Timeout** - Set `max_execution_time = 60`

### PHP Configuration

Edit `php.ini`:

```ini
; Increase memory limit
memory_limit = 256M

; Increase execution time
max_execution_time = 60

; Enable GD extension
extension=gd

; Enable MB String
extension=mbstring

; Enable DOM
extension=dom
```

## Advanced Usage

### Programmatic PDF Generation

```php
<?php
require_once 'config/constants.php';
require_once 'utils/pdf-generator.php';

// Create PDF generator
$pdfGenerator = new PDFGenerator();

// Check if library is available
if ($pdfGenerator->isAvailable()) {
    echo "Using: " . $pdfGenerator->getLibrary();
} else {
    echo "No PDF library available";
}

// Generate PDF
$html = '<html><body>Hello World</body></html>';
$pdfGenerator->generatePDF($html, 'output.pdf');
?>
```

### Custom PDF Options

Edit `utils/pdf-generator.php` to customize:

```php
// DOMPDF Options
$options->set([
    'defaultFont' => 'Segoe UI',
    'isPhpEnabled' => false,
    'isRemoteEnabled' => true,
    'isFontSubsettingEnabled' => true,
]);

// mPDF Options
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'orientation' => 'P',
    'margin_left' => 10,
    'margin_right' => 10,
]);
```

## Browser Fallback

If no PDF library is installed, the system provides a fallback:

1. **HTML is displayed** in browser
2. **Print notice** is shown
3. **Browser print dialog** opens automatically
4. **User can save as PDF** using browser

This ensures PDF download always works!

## Security Considerations

✅ **Input Validation** - All user input is validated
✅ **Output Escaping** - All output is properly escaped
✅ **File Permissions** - Proper file permissions set
✅ **Error Logging** - Errors are logged, not displayed
✅ **No Remote Code** - PHP execution disabled in PDFs

## Composer Installation

If you don't have Composer installed:

### Download Composer

1. Visit: https://getcomposer.org/download/
2. Download `Composer-Setup.exe`
3. Run installer
4. Follow installation wizard

### Install DOMPDF

```bash
cd c:\xampp\htdocs\resume
composer require dompdf/dompdf
```

### Verify Installation

```bash
composer show
```

Should list `dompdf/dompdf` in the output.

## Support

### Getting Help

1. Check this guide for troubleshooting
2. Review error logs in `logs/` directory
3. Check PHP error logs
4. Visit DOMPDF docs: https://github.com/dompdf/dompdf
5. Visit mPDF docs: https://github.com/mpdf/mpdf

### Useful Commands

```bash
# Check installed packages
composer show

# Update packages
composer update

# Reinstall packages
composer install

# Check PHP version
php -v

# Check PHP extensions
php -m
```

## Summary

✅ **DOMPDF Integration** - Complete
✅ **mPDF Support** - Complete
✅ **Automatic Detection** - Complete
✅ **All 10 Themes** - Supported
✅ **Error Handling** - Implemented
✅ **Fallback Support** - Implemented

Your resume.io is now ready to generate professional PDFs! 🎉

---

**Version**: 1.0
**Last Updated**: 2025-01-01
**Status**: Production Ready
