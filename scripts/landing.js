// Landing Page Interactivity Script

// ============================================
// MODAL MANAGEMENT
// ============================================

const loginModal = document.getElementById('loginModal');
const loginBtns = document.querySelectorAll('#loginBtn, #loginBtnHero');
const closeModalBtn = document.getElementById('closeModal');

// Open Login Modal
loginBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        loginModal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent body scroll
    });
});

// Close Modal
closeModalBtn.addEventListener('click', () => {
    closeModal();
});

// Close modal when clicking outside modal-content
loginModal.addEventListener('click', (e) => {
    if (e.target === loginModal) {
        closeModal();
    }
});

function closeModal() {
    loginModal.classList.remove('active');
    document.body.style.overflow = ''; // Restore body scroll
}

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && loginModal.classList.contains('active')) {
        closeModal();
    }
});

// ============================================
// HEADER SCROLL EFFECT
// ============================================

const header = document.getElementById('header');

window.addEventListener('scroll', () => {
    if (window.scrollY > 10) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// ============================================
// NAVIGATION ACTIVE STATE
// ============================================

const navLinks = document.querySelectorAll('.nav-link');
const navMenu = document.querySelector('.nav-menu');

// Set active nav link based on current section
window.addEventListener('scroll', () => {
    updateActiveNav();
});

function updateActiveNav() {
    const sections = document.querySelectorAll('section[id]');
    let currentSection = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        
        if (window.scrollY >= sectionTop - 100) {
            currentSection = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${currentSection}`) {
            link.classList.add('active');
        }
    });
}

// ============================================
// SMOOTH SCROLL FOR NAVIGATION LINKS
// ============================================

navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = link.getAttribute('href');
        const targetSection = document.querySelector(targetId);
        
        if (targetSection) {
            targetSection.scrollIntoView({ behavior: 'smooth' });
            
            // Update active state
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
            
            // Close mobile menu if open
            if (navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
            }
        }
    });
});

// ============================================
// MOBILE MENU TOGGLE
// ============================================

const menuToggle = document.querySelector('.menu-toggle');

if (menuToggle) {
    menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });
}

// Close mobile menu when clicking on a nav link
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        if (navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
        }
    });
});

// ============================================
// PAGE LOAD INITIALIZATION
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    // Set initial active nav state
    updateActiveNav();
    
    // Add animation delay to feature items
    const featureItems = document.querySelectorAll('.feature-item');
    featureItems.forEach((item, index) => {
        item.style.animation = `slideInLeft 0.5s ease-out ${index * 0.1}s backwards`;
    });
});

// ============================================
// ANIMATION: SLIDE IN LEFT
// ============================================

const styleSheet = document.createElement('style');
styleSheet.textContent = `
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(styleSheet);

// ============================================
// INTERSECTION OBSERVER FOR LAZY ANIMATIONS
// ============================================

const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.animation = 'slideUp 0.6s ease-out';
        }
    });
}, observerOptions);

// Observe hero content for animation
const heroContent = document.querySelector('.hero-content');
if (heroContent) {
    observer.observe(heroContent);
}

// ============================================
// ACCESSIBILITY: FOCUS MANAGEMENT
// ============================================

// Modal focus trap
function trapFocus(modal) {
    const focusableElements = modal.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];
    
    modal.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else {
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        }
    });
}

// Apply focus trap to modal
if (loginModal) {
    trapFocus(loginModal);
}

// ============================================
// UTILITY: DEBOUNCE FUNCTION
// ============================================

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ============================================
// RESPONSIVE ADJUSTMENTS
// ============================================

const ResizeObserver = window.ResizeObserver || null;

if (ResizeObserver) {
    const resizeObserver = new ResizeObserver(debounce(() => {
        updateActiveNav();
    }, 250));
    
    resizeObserver.observe(document.body);
}

// ============================================
// PRELOAD IMAGES
// ============================================

function preloadImages() {
    const images = document.querySelectorAll('img[src]');
    images.forEach(img => {
        const imageLoader = new Image();
        imageLoader.src = img.src;
    });
}

window.addEventListener('load', preloadImages);

// ============================================
// CONSOLE LOG - DEVELOPMENT
// ============================================

if (true) { // Set to true for debugging, false for production
    console.log('%c ENGINE - The Exam Portal Landing Page Loaded', 'color: #0a3d6f; font-size: 16px; font-weight: bold;');
    console.log('Theme Colors Loaded: Blue-only professional theme');
}
