# Landing Page Implementation Guide

## Quick Start

The landing page has been completely redesigned with a modern blue theme. Here's what's new:

### Files Created/Updated:
- ✅ `index.php` - Redesigned landing page structure
- ✅ `styles/theme.css` - Reusable CSS variable theme (blue-only)
- ✅ `styles/landing.css` - Landing page specific styling
- ✅ `scripts/landing.js` - Interactive functionality
- ✅ `DESIGN_DOCUMENTATION.md` - Complete design documentation

---

## What Changed

### Before
- Single-column centered layout
- Gradient animated background
- Direct "Login Now" link to `login.php`
- Limited branding (just "ENGINE" text)

### After
- Professional header with logo and navigation
- Two-column hero section (text + image)
- Login modal with role selection (Admin/Trainer/Student)
 - Complete brand integration with SPECANCIENS logo
- Blue-only professional theme
- Fully responsive design
- Accessibility-first approach

---

## How the Login Flow Works

### User Journey:

1. **Landing Page** → User clicks "Login" button or "Get Started"
2. **Modal Opens** → Shows 3 role options with icons:
   - 👔 Admin
   - 🎓 Trainer
   - 👨‍🎓 Student
3. **Modal Link** → Clicking a role links to `login.php?role=admin|trainer|student`
4. **Login Page** → Receives the role parameter (optional, can customize)

### Update Your `login.php` (Optional):

If you want to handle the role preselection on login page:

```php
<?php
// At the top of login.php
$selected_role = isset($_GET['role']) ? htmlspecialchars($_GET['role']) : '';

// Use $selected_role to pre-select the role dropdown or show relevant login form
?>
```

---

## CSS Theme Variables Reference

### Quick Copy-Paste for Dashboard Headers

**Admin Dashboard Header:**
```html
<style>
    .admin-header {
        background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary-light));
        color: var(--color-text-inverse);
        padding: var(--spacing-lg);
        border-radius: var(--radius-lg);
    }
</style>
```

**Trainer Dashboard Header:**
```html
<style>
    .trainer-header {
        background: linear-gradient(135deg, var(--color-primary-medium), var(--color-primary-lighter));
        color: var(--color-text-inverse);
        padding: var(--spacing-lg);
        border-radius: var(--radius-lg);
    }
</style>
```

**Student Dashboard Header:**
```html
<style>
    .student-header {
        background: var(--color-primary-light);
        color: var(--color-text-inverse);
        padding: var(--spacing-lg);
        border-radius: var(--radius-lg);
    }
</style>
```

### Common Theme Variables

```css
/* Colors */
var(--color-primary-dark)      /* #0a3d6f - Dark blue */
var(--color-primary-medium)    /* #1e5f96 - Medium blue */
var(--color-primary-light)     /* #3b82c4 - Light blue */
var(--color-primary-lightest)  /* #e3f2fd - Very light blue */

/* Text */
var(--color-text-primary)      /* #1e293b - Main text color */
var(--color-text-secondary)    /* #64748b - Secondary text */
var(--color-text-inverse)      /* #ffffff - White text */

/* Spacing */
var(--spacing-md)              /* 16px */
var(--spacing-lg)              /* 24px */
var(--spacing-xl)              /* 32px */

/* Other */
var(--radius-lg)               /* 12px border radius */
var(--shadow-lg)               /* Box shadow */
var(--transition-base)         /* 250ms smooth transition */
```

---

## Testing the Landing Page

### Local Development

1. Open browser: `http://localhost:8000` (or your port)
2. Test interactions:
   - Click "Login" button in header → Modal should open
   - Click role card (Admin/Trainer/Student) → Should navigate to login.php
   - Click X or outside modal → Should close
   - Press Escape → Should close modal
   - Scroll down → Header should gain shadow
   - Navigation links should highlight on scroll
   - Resize window → Should be responsive

### Mobile Testing

- Hero section stacks vertically
- Navigation collapses (mobile menu toggle)
- Modal is mobile-friendly
- Images scale properly
- Buttons are touch-friendly (large tap targets)

---

## Customization Guide

### Change Theme Colors

Edit `styles/theme.css`:

```css
:root {
    /* Change primary color throughout all pages */
    --color-primary-dark: #0a3d6f;      /* Change this */
    --color-primary-light: #3b82c4;     /* Change this */
    /* Rest of colors update automatically */
}
```

### Change Typography

Edit `styles/theme.css`:

```css
:root {
    --font-family-base: 'Your Font Name', sans-serif;
    --font-size-base: 16px;  /* Change base size */
}
```

### Change Spacing

Edit `styles/theme.css`:

```css
:root {
    --spacing-lg: 24px;      /* Change default spacing */
}
```

All pages using `theme.css` will automatically update!

---

## Integration Checklist

To fully integrate the landing page theme across your project:

- [ ] Link `theme.css` in `admin_dashboard.php` header
- [ ] Link `theme.css` in `trainer_dashboard.php` header
- [ ] Link `theme.css` in `student_dashboard.php` header
- [ ] Use theme variables in dashboard CSS files
- [ ] Test modal on landing page
- [ ] Test responsive design on mobile
- [ ] Update any hardcoded colors in existing styles to use variables
- [ ] Test cross-browser (Chrome, Firefox, Safari)

---

## File Dependencies

```
landing page (index.php)
├── styles/theme.css          ← Core color & spacing variables
├── styles/landing.css        ← Landing-specific styles
├── scripts/landing.js        ← Interactive functionality
├── images/SA Main logo.jpg   ← Brand logo
└── images/desktop image.jpg  ← Hero illustration
```

All other dashboard pages should also include `styles/theme.css` to maintain consistent theming.

---

## Accessibility Features

✅ **Included by default:**
- WCAG 2.1 AA color contrast compliance
- Keyboard navigation (Tab, Enter, Escape)
- Focus indicators on interactive elements
- Modal focus trap (Tab keeps focus within modal)
- Semantic HTML structure
- Image alt text
- Smooth animations (respects prefers-reduced-motion)

---

## Performance Notes

- No external libraries required
- Pure HTML/CSS/JS implementation
- Minimal JavaScript (~300 lines)
- CSS Grid for responsive layout
- Hardware-accelerated animations
- ~20KB total assets (excluding images)

---

## Browser Support

✅ Modern browsers:
- Chrome/Edge 88+
- Firefox 85+
- Safari 14+
- Mobile browsers (iOS Safari 12+, Chrome Android)

❌ Older browsers:
- IE 11 (CSS Grid not fully supported)
- Very old mobile browsers

---

## Troubleshooting

### Modal doesn't open?
- Check if `scripts/landing.js` is loaded
- Check browser console for errors
- Verify jQuery is not conflicting (if used elsewhere)

### CSS variables not applying?
- Ensure `styles/theme.css` is linked BEFORE other CSS
- Check that CSS custom properties syntax is correct: `var(--variable-name)`

### Landing page styling not applied?
- Verify both CSS files are linked:
  - `styles/theme.css`
  - `styles/landing.css`
- Check file paths are relative to your project root
- Clear browser cache (Ctrl+Shift+Delete)

### Images not showing?
- Verify image paths in `index.php`:
  - Logo: `images/SA Main logo.jpg`
  - Hero: `images/desktop image.jpg`
- Check image files exist in `images/` folder

---

## Next Steps

1. **Test the landing page** at `http://localhost:8000`
2. **Update login.php** to handle role parameter (if needed)
3. **Integrate theme** into other dashboard pages
4. **Customize colors** in `theme.css` to match your branding
5. **Deploy** to production

---

**Version:** 1.0  
**Created:** February 9, 2026  
**Theme:** SPECANCIENS - Professional Blue
