# Mobile Responsive Design Guide

## Quick Reference

### Responsive Breakpoints

```css
/* Extra Small Devices (320px - 479px) */
@media (max-width: 480px) { }

/* Mobile (480px - 767px) */
@media (max-width: 767px) { }

/* Tablet (768px - 1023px) */
@media (max-width: 1023px) { }

/* Desktop (1024px+) */
/* Default styles */
```

---

## Mobile Features Implemented

### 1. Preview Page (`pages/preview.php`)

#### Desktop Layout (1024px+)
```
┌─────────────────────────────────────┐
│         Navbar                      │
├──────────────┬──────────────────────┤
│   Sidebar    │   Resume Preview     │
│  (280px)     │   (Flexible)         │
│              │                      │
│ • Themes     │   ┌──────────────┐   │
│ • Download   │   │ Resume       │   │
│              │   │ Content      │   │
│              │   │              │   │
└──────────────┴──────────────────────┘
```

#### Tablet Layout (768px - 1023px)
```
┌─────────────────────────────────────┐
│         Navbar                      │
├─────────────────────────────────────┤
│  Themes (2-column grid)             │
├─────────────────────────────────────┤
│   Resume Preview (Full Width)       │
│   ┌─────────────────────────────┐   │
│   │ Resume Content              │   │
│   │                             │   │
│   └─────────────────────────────┘   │
└─────────────────────────────────────┘
```

#### Mobile Layout (320px - 767px)
```
┌─────────────────────────────────────┐
│         Navbar                      │
├─────────────────────────────────────┤
│  Themes (1-column)                  │
│  • Classic                          │
│  • Modern                           │
│  • Corporate                        │
│  • ...                              │
├─────────────────────────────────────┤
│   Resume Preview (Full Width)       │
│   ┌─────────────────────────────┐   │
│   │ Resume Content              │   │
│   │                             │   │
│   └─────────────────────────────┘   │
└─────────────────────────────────────┘
```

---

## CSS Classes for Responsive Design

### Grid System
```css
.grid-cols-1  /* 1 column */
.grid-cols-2  /* 2 columns (tablet+) */
.grid-cols-3  /* 3 columns (desktop+) */
.grid-cols-4  /* 4 columns (desktop+) */
```

### Responsive Utilities
```css
.d-none        /* Display: none */
.d-block       /* Display: block */
.d-flex        /* Display: flex */
.d-grid        /* Display: grid */
```

### Text Utilities
```css
.text-center   /* Text align center */
.text-left     /* Text align left */
.text-right    /* Text align right */
```

---

## Mobile Optimization Checklist

### Forms
- [x] Font size 16px (prevents iOS zoom)
- [x] Adequate padding for touch
- [x] Full-width inputs on mobile
- [x] Clear labels
- [x] Proper spacing between fields

### Buttons
- [x] Minimum 44px height for touch
- [x] Adequate padding
- [x] Full-width on mobile
- [x] Clear visual feedback
- [x] Proper spacing

### Typography
- [x] Readable font sizes
- [x] Proper line height
- [x] Adequate contrast
- [x] Responsive headings
- [x] Mobile-optimized sizes

### Images
- [x] SVG placeholders (scalable)
- [x] Responsive sizing
- [x] Proper aspect ratios
- [x] Fast loading
- [x] Fallback support

### Navigation
- [x] Hamburger menu on mobile
- [x] Touch-friendly links
- [x] Clear hierarchy
- [x] Sticky header
- [x] Easy navigation

---

## Placeholder Image Generator

### Usage
```php
<?php
require_once 'utils/placeholder-generator.php';

// Get profile image or placeholder
$image = getProfileImage($uploadedImage, $fullName);
?>
<img src="<?php echo $image; ?>" alt="Profile">
```

### Features
- Generates gradient backgrounds
- Extracts initials from name
- Consistent colors per name
- SVG-based (lightweight)
- Data URI (no files needed)

### Example Output
```
User: "John Doe"
Color: Blue gradient
Initials: JD
Size: Scalable (100x100 to 500x500)
```

---

## Theme Responsiveness

### All Themes Include:
- Mobile-optimized spacing
- Responsive typography
- Touch-friendly layouts
- Print-friendly CSS
- Proper scaling

### Theme-Specific Mobile Adjustments:

#### Sidebar Theme
```css
/* Desktop: 2-column */
.resume-container {
    display: flex;
    gap: 30px;
}

/* Mobile: 1-column */
@media (max-width: 768px) {
    .resume-container {
        flex-direction: column;
    }
}
```

#### Timeline Theme
```css
/* Desktop: Timeline visible */
.timeline::before {
    display: block;
}

/* Mobile: Simplified */
@media (max-width: 768px) {
    .timeline {
        padding-left: 20px;
    }
}
```

---

## Testing on Mobile Devices

### Chrome DevTools
1. Press F12 to open DevTools
2. Click device toggle (Ctrl+Shift+M)
3. Select device or custom size
4. Test all breakpoints

### Real Devices
- iPhone (375px, 414px)
- iPad (768px, 1024px)
- Android phones (360px, 411px)
- Tablets (600px+)

### Breakpoints to Test
- 320px (extra small)
- 480px (small)
- 768px (tablet)
- 1024px (desktop)
- 1440px (large desktop)

---

## Performance Tips

### Mobile Optimization
1. **Minimize CSS** - Use variables
2. **Optimize Images** - Use SVG for icons
3. **Lazy Loading** - Load images on demand
4. **Caching** - Browser caching enabled
5. **Compression** - Gzip enabled

### Best Practices
- Mobile-first approach
- Progressive enhancement
- Touch-friendly sizes
- Readable fonts
- Fast loading

---

## Troubleshooting

### Issue: Text too small on mobile
**Solution**: Check font-size in mobile breakpoint
```css
@media (max-width: 768px) {
    body { font-size: 16px; }
}
```

### Issue: Buttons not clickable
**Solution**: Increase button size
```css
.btn {
    min-height: 44px;
    min-width: 44px;
}
```

### Issue: Layout breaks at certain width
**Solution**: Add intermediate breakpoint
```css
@media (max-width: 600px) {
    /* Custom styles */
}
```

### Issue: Images not scaling
**Solution**: Use max-width
```css
img {
    max-width: 100%;
    height: auto;
}
```

---

## Browser Support

### Supported Browsers
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile Safari (iOS 12+)
- Chrome Mobile (Android 9+)

### CSS Features Used
- CSS Grid
- Flexbox
- CSS Variables
- Media Queries
- SVG
- Gradients

---

## Future Enhancements

- [ ] Dark mode support
- [ ] Gesture support (swipe)
- [ ] Offline functionality
- [ ] PWA support
- [ ] Advanced animations
- [ ] Voice input

---

**Last Updated**: November 24, 2025  
**Version**: 1.0
