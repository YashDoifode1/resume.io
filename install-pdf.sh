#!/bin/bash

# Resume.io PDF Installation Script
# This script installs DOMPDF for PDF generation

echo ""
echo "========================================"
echo "  Resume.io - PDF Installation"
echo "========================================"
echo ""

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "ERROR: Composer is not installed or not in PATH"
    echo ""
    echo "Please install Composer from: https://getcomposer.org/download/"
    echo ""
    exit 1
fi

echo "Composer found!"
echo ""

# Check if we're in the right directory
if [ ! -f "composer.json" ]; then
    echo "ERROR: composer.json not found"
    echo "Please run this script from the resume.io root directory"
    echo ""
    exit 1
fi

echo "Installing DOMPDF..."
echo ""

# Install DOMPDF
composer require dompdf/dompdf

if [ $? -ne 0 ]; then
    echo ""
    echo "ERROR: Failed to install DOMPDF"
    echo ""
    exit 1
fi

echo ""
echo "========================================"
echo "  Installation Complete!"
echo "========================================"
echo ""
echo "DOMPDF has been successfully installed."
echo ""
echo "Next steps:"
echo "1. Go to Resume Builder"
echo "2. Fill in your information"
echo "3. Click 'Preview Resume'"
echo "4. Click 'Download PDF'"
echo ""
echo "Your resume will now download as a PDF!"
echo ""
