@echo off
REM Resume.io PDF Installation Script
REM This script installs DOMPDF for PDF generation

echo.
echo ========================================
echo   Resume.io - PDF Installation
echo ========================================
echo.

REM Check if Composer is installed
where composer >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Composer is not installed or not in PATH
    echo.
    echo Please install Composer from: https://getcomposer.org/download/
    echo.
    pause
    exit /b 1
)

echo Composer found!
echo.

REM Check if we're in the right directory
if not exist "composer.json" (
    echo ERROR: composer.json not found
    echo Please run this script from the resume.io root directory
    echo.
    pause
    exit /b 1
)

echo Installing DOMPDF...
echo.

REM Install DOMPDF
composer require dompdf/dompdf

if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ERROR: Failed to install DOMPDF
    echo.
    pause
    exit /b 1
)

echo.
echo ========================================
echo   Installation Complete!
echo ========================================
echo.
echo DOMPDF has been successfully installed.
echo.
echo Next steps:
echo 1. Go to Resume Builder
echo 2. Fill in your information
echo 3. Click "Preview Resume"
echo 4. Click "Download PDF"
echo.
echo Your resume will now download as a PDF!
echo.
pause
