# DOMPDF Quick Start Guide

## 🚀 Get PDF Generation Working in 5 Minutes

### Step 1: Open Command Prompt (1 minute)

**Windows:**
1. Press `Win + R`
2. Type `cmd`
3. Press Enter

**Linux/Mac:**
1. Open Terminal

### Step 2: Navigate to Project (1 minute)

```bash
# Windows
cd C:\xampp\htdocs\resume

# Linux/Mac
cd /path/to/resume
```

### Step 3: Install DOMPDF (2 minutes)

**Option A: Using Installation Script (Easiest)**

```bash
# Windows
install-pdf.bat

# Linux/Mac
bash install-pdf.sh
```

**Option B: Using Composer**

```bash
composer require dompdf/dompdf
```

### Step 4: Test It (1 minute)

1. Open browser: `http://localhost/resume/`
2. Click "Resume Builder"
3. Fill in your name and job title
4. Click "Preview Resume"
5. Click "📥 Download PDF"
6. ✅ PDF downloads!

## ✅ That's It!

Your resume.io now generates professional PDFs!

## 📋 What Just Happened?

1. **DOMPDF Installed** - PDF generation library
2. **Autoloader Created** - `vendor/autoload.php`
3. **PDF Generator Ready** - `utils/pdf-generator.php`
4. **All 10 Themes** - Support PDF download
5. **Error Handling** - Graceful fallback if needed

## 🎨 Try All 10 Themes

In the Preview page, click any theme:

1. 📄 Classic Professional
2. ✨ Modern Minimal
3. 💼 Corporate Blue
4. 🎨 Creative Portfolio
5. 🌙 Dark Mode
6. ✨ Elegant Gold
7. 💻 Tech Startup
8. ⚪ Ultra Minimal
9. 🌈 Vibrant Colors
10. 👔 Executive Premium

Each theme generates a unique PDF!

## 🔧 Troubleshooting

### "Composer not found"

**Solution:** Install Composer from https://getcomposer.org/download/

### "Class not found: Dompdf\Dompdf"

**Solution:** Run `composer install` in project directory

### "PDF downloads but is blank"

**Solution:** 
1. Check PHP memory: `memory_limit = 256M`
2. Check PHP timeout: `max_execution_time = 60`
3. Restart web server

### "No PDF library available"

**Solution:** Run installation script or `composer require dompdf/dompdf`

## 📚 More Information

- **Full Setup Guide**: See `PDF_SETUP.md`
- **Integration Details**: See `PDF_INTEGRATION_SUMMARY.md`
- **General Help**: See `README.md`

## 🎉 You're Done!

Your resume.io is now generating professional PDFs with DOMPDF!

Start creating amazing resumes! 🚀

---

**Need help?** Check `PDF_SETUP.md` for detailed troubleshooting.
