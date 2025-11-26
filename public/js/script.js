// ============================================
// Navigation & Scroll Effects
// ============================================

// Navigation variables - initialized when DOM is ready
let navbar, navLinks, hamburger, navMenu, backToTop;

// Initialize navigation elements
function initNavigation() {
    navbar = document.getElementById('navbar');
    navLinks = document.querySelectorAll('.nav-link');
    hamburger = document.getElementById('hamburger');
    navMenu = document.getElementById('navMenu');
    backToTop = document.getElementById('backToTop');
    
    if (!navbar || !hamburger || !navMenu) {
        console.warn('Navigation elements not found');
        return;
    }
    
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }

        // Show/hide back to top button
        if (backToTop) {
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }

        // Update active nav link based on scroll position
        if (typeof updateActiveNavLink === 'function') {
            updateActiveNavLink();
        }
    });

    // Mobile menu toggle
    hamburger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        hamburger.classList.toggle('active');
    });

    // Close mobile menu when clicking on a link (but not language button)
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            // Don't close menu if clicking on language button
            if (!e.target.closest('.lang-toggle') && !e.target.closest('#langBtn')) {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
            }
        });
    });

    // Smooth scroll for navigation links (but not language button)
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            // Skip if this is the language button or its parent
            if (e.target.closest('.lang-toggle') || e.target.closest('#langBtn')) {
                return;
            }
            
            e.preventDefault();
            const targetId = link.getAttribute('href');
            if (targetId && targetId.startsWith('#')) {
                const targetSection = document.querySelector(targetId);
                if (targetSection) {
                    const offsetTop = targetSection.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
}

// Update active nav link
function updateActiveNavLink() {
    if (!navLinks || navLinks.length === 0) {
        navLinks = document.querySelectorAll('.nav-link');
    }
    
    const sections = document.querySelectorAll('section[id]');
    const scrollY = window.pageYOffset;

    sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 100;
        const sectionId = section.getAttribute('id');

        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            navLinks.forEach(link => {
                if (link.getAttribute('href') === `#${sectionId}`) {
                    navLinks.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                }
            });
        }
    });
}

// Back to top button - initialize in DOMContentLoaded
function initBackToTop() {
    const backToTopBtn = document.getElementById('backToTop');
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// ============================================
// Language Toggle
// ============================================

const html = document.documentElement;

// Get current language from HTML or default to Arabic
function getCurrentLang() {
    return html.getAttribute('lang') || 'ar';
}

// Initialize language toggle on page load
function initLanguageToggle() {
    // Store original Arabic text for all elements with data-en attribute
    document.querySelectorAll('[data-en]').forEach(element => {
        if (!element.hasAttribute('data-ar')) {
            element.setAttribute('data-ar', element.textContent);
        }
    });
    
    // Restore language from localStorage on page load
    const savedLang = localStorage.getItem('portfolio_lang');
    if (savedLang && (savedLang === 'ar' || savedLang === 'en')) {
        const currentHtmlLang = html.getAttribute('lang');
        if (currentHtmlLang !== savedLang) {
            toggleLanguage(savedLang);
        } else {
            // Initialize language button with current language
            updateLanguageButton(savedLang);
        }
    } else {
        // Initialize language button with current language from HTML
        const currentLang = getCurrentLang();
        updateLanguageButton(currentLang);
    }
    
    // Initialize language button click handler
    // Try multiple times to ensure the button is found
    let attempts = 0;
    const maxAttempts = 10;
    
    function setupLanguageButton() {
        const langBtn = document.getElementById('langBtn');
        if (langBtn) {
            // Remove old listeners by cloning
            const newBtn = langBtn.cloneNode(true);
            langBtn.parentNode.replaceChild(newBtn, langBtn);
            
            // Add click event listener with multiple methods
            newBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                handleLanguageToggle();
                return false;
            };
            
            newBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                handleLanguageToggle();
                return false;
            }, true);
            
            // Also handle clicks on the icon inside
            const icon = newBtn.querySelector('i');
            if (icon) {
                icon.style.pointerEvents = 'none'; // Allow clicks to pass through to button
            }
            
            console.log('Language button initialized successfully');
            return true;
        }
        return false;
    }
    
    function handleLanguageToggle() {
        const currentLang = getCurrentLang();
        const newLang = currentLang === 'ar' ? 'en' : 'ar';
        console.log('Language toggle triggered. Current:', currentLang, 'New:', newLang);
        toggleLanguage(newLang);
    }
    
    // Try to setup the button
    const intervalId = setInterval(() => {
        attempts++;
        if (setupLanguageButton() || attempts >= maxAttempts) {
            clearInterval(intervalId);
            if (attempts >= maxAttempts) {
                console.warn('Language button not found after', maxAttempts, 'attempts');
            }
        }
    }, 100);
}

// Language toggle will be initialized in main DOMContentLoaded event

function updateLanguageButton(lang) {
    const langBtn = document.getElementById('langBtn');
    if (langBtn) {
        langBtn.innerHTML = lang === 'ar' 
            ? '<i class="fas fa-language"></i> EN' 
            : '<i class="fas fa-language"></i> AR';
    }
}

function toggleLanguage(lang) {
    // Update HTML attributes
    html.setAttribute('lang', lang);
    html.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
    
    // Save to localStorage for persistence
    localStorage.setItem('portfolio_lang', lang);
    
    // Update button text
    updateLanguageButton(lang);
    
    // Update all text elements with data-en attribute
    document.querySelectorAll('[data-en]').forEach(element => {
        if (lang === 'en') {
            const enText = element.getAttribute('data-en');
            if (enText && enText.trim() !== '') {
                element.textContent = enText;
            }
        } else {
            // Restore original Arabic text (stored in a data attribute)
            const arText = element.getAttribute('data-ar');
            if (arText) {
                element.textContent = arText;
            }
        }
    });
    
    // Update navigation menu items
    updateNavigationLanguage(lang);
    
    // Update project and certificate modals if they're open
    updateModalLanguage(lang);
}

function updateNavigationLanguage(lang) {
    // Navigation items are now handled by data-en attributes, so this function is no longer needed
    // The toggleLanguage function already handles elements with data-en attributes
}

function updateModalLanguage(lang) {
    // Update project modal if open
    const projectModal = document.getElementById('projectModal');
    if (projectModal && projectModal.classList.contains('active')) {
        // Modal content is already handled by data-en attributes
    }
    
    // Update certificate modal if open
    const certModal = document.getElementById('certificateModal');
    if (certModal && certModal.classList.contains('active')) {
        // Modal content is already handled by data-en attributes
    }
}

// ============================================
// Skill Progress Bars Animation
// ============================================

const skillBars = document.querySelectorAll('.skill-progress');

function animateSkillBars() {
    skillBars.forEach(bar => {
        const progress = bar.getAttribute('data-progress');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    bar.style.width = progress + '%';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(bar);
    });
}

// Initialize skill bars animation
animateSkillBars();

// ============================================
// Scroll Reveal Animation
// ============================================

const revealElements = document.querySelectorAll('.section-header, .about-content, .skills-category, .project-card, .contact-content');

const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
            revealObserver.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
});

revealElements.forEach(element => {
    element.classList.add('reveal');
    revealObserver.observe(element);
});

// ============================================
// Contact Form Handling
// ============================================

const contactForm = document.getElementById('contactForm');

contactForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(contactForm);
    const data = Object.fromEntries(formData);
    
    // Here you would typically send the data to a server
    // For now, we'll just show a success message
    showNotification('تم إرسال الرسالة بنجاح!', 'success');
    
    // Reset form
    contactForm.reset();
});

function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        padding: 1rem 2rem;
        border-radius: 8px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 10000;
        animation: slideIn 0.3s ease-out;
    `;
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Add CSS animations for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// ============================================
// Typing Animation for Hero Title
// ============================================

function typeWriter(element, text, speed = 100) {
    let i = 0;
    element.textContent = '';
    
    function type() {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    
    type();
}

// Optional: Add typing effect to hero name
// Uncomment to enable
/*
const heroName = document.querySelector('.name');
if (heroName) {
    const originalText = heroName.textContent;
    setTimeout(() => {
        typeWriter(heroName, originalText, 150);
    }, 1000);
}
*/

// ============================================
// Parallax Effect for Hero Section
// ============================================

window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero');
    if (hero) {
        const heroContent = hero.querySelector('.hero-content');
        if (heroContent && scrolled < window.innerHeight) {
            heroContent.style.transform = `translateY(${scrolled * 0.5}px)`;
            heroContent.style.opacity = 1 - (scrolled / window.innerHeight) * 0.5;
        }
    }
});

// ============================================
// Project Card Hover Effects
// ============================================

// This will be initialized after DOM load

// ============================================
// Smooth Image Loading
// ============================================

const images = document.querySelectorAll('img');

images.forEach(img => {
    img.addEventListener('load', function() {
        this.style.opacity = '1';
    });
    
    // Add loading state
    if (!img.complete) {
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.3s';
    }
});

// Note: Initialization is done in the main DOMContentLoaded event listener below

// ============================================
// Performance Optimization
// ============================================

// Debounce function for scroll events
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

// Optimize scroll event listeners
const optimizedScrollHandler = debounce(() => {
    updateActiveNavLink();
}, 10);

window.addEventListener('scroll', optimizedScrollHandler);

// ============================================
// Add Loading Animation
// ============================================

window.addEventListener('load', () => {
    // Remove any loading spinners
    const loader = document.querySelector('.loader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.remove();
        }, 300);
    }
});

// ============================================
// Project Filter
// ============================================

const filterButtons = document.querySelectorAll('.filter-btn');
let projectCards = document.querySelectorAll('.project-card');

// Project card hover effects
projectCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
        if (!this.classList.contains('hidden')) {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        }
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});

filterButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Remove active class from all buttons
        filterButtons.forEach(btn => btn.classList.remove('active'));
        // Add active class to clicked button
        button.classList.add('active');
        
        const filterValue = button.getAttribute('data-filter');
        
        // Filter projects
        projectCards.forEach(card => {
            if (filterValue === 'all') {
                card.classList.remove('hidden');
            } else {
                const cardCategory = card.getAttribute('data-category');
                if (cardCategory === filterValue) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            }
        });
    });
});

// ============================================
// Project Details Modal
// ============================================

// Note: projectsData and certificatesData are defined in the Blade template (index.blade.php)
// They are passed from Laravel and available in the global scope
// Make sure they exist before using them



// Initialize project modal when DOM is ready
let projectModal, closeProjectModal, viewProjectButtons;
let currentGalleryIndex = 0;
let currentGalleryImages = [];

function initProjectModal() {
    projectModal = document.getElementById('projectModal');
    closeProjectModal = document.getElementById('closeProjectModal');
    viewProjectButtons = document.querySelectorAll('.view-project-details');
    
    if (!projectModal || !closeProjectModal) {
        console.warn('Project modal elements not found');
        return;
    }
    
    // Open project modal
    viewProjectButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const projectId = button.getAttribute('data-project-id');
            openProjectModal(projectId);
        });
    });
    
    // Close project modal
    if (closeProjectModal) {
        closeProjectModal.addEventListener('click', () => {
            projectModal.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
    
    const modalOverlay = projectModal.querySelector('.modal-overlay');
    if (modalOverlay) {
        modalOverlay.addEventListener('click', () => {
            projectModal.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
}

// Open project modal function
function openProjectModal(projectId) {
    // Check if projectsData exists
    if (typeof projectsData === 'undefined' || !projectsData) {
        console.error('projectsData is not defined. Make sure it is loaded from the Blade template.');
        return;
    }
    
    const project = projectsData[projectId];
    if (!project) {
        console.error('Project with ID ' + projectId + ' not found in projectsData');
        return;
    }
    
    const isArabic = document.documentElement.getAttribute('lang') === 'ar';
    
    const modalTitle = document.getElementById('modalProjectTitle');
    const modalCategory = document.getElementById('modalProjectCategory');
    const modalDescription = document.getElementById('modalProjectDescription');
    const modalLink = document.getElementById('modalProjectLink');
    
    if (modalTitle) modalTitle.textContent = isArabic ? (project.title || '') : (project.titleEn || project.title || '');
    if (modalCategory) modalCategory.textContent = project.category || '';
    if (modalDescription) modalDescription.textContent = isArabic ? (project.description || '') : (project.descriptionEn || project.description || '');
    
    // Show/hide visit website button based on link availability
    if (modalLink) {
        const projectLink = project.link || '';
        if (projectLink && projectLink !== '#' && projectLink.trim() !== '') {
            modalLink.href = projectLink;
            modalLink.style.display = 'flex';
        } else {
            modalLink.style.display = 'none';
        }
    }
    
    // Features
    const featuresList = document.getElementById('modalProjectFeatures');
    if (featuresList) {
        featuresList.innerHTML = '';
        
        // Get features based on language
        let features = isArabic ? (project.features || []) : (project.featuresEn || project.features || []);
        
        // Ensure it's an array
        if (!Array.isArray(features)) {
            features = [];
        }
        
        // Filter out empty values
        features = features.filter(feature => {
            const str = String(feature || '').trim();
            return str !== '' && str !== 'null' && str !== 'undefined';
        });
        
        // Display features
        if (features.length > 0) {
            features.forEach(feature => {
                const li = document.createElement('li');
                li.textContent = String(feature).trim();
                featuresList.appendChild(li);
            });
        }
    }
    
    // Technologies - Hidden
    // const techContainer = document.getElementById('modalProjectTech');
    // if (techContainer) {
    //     techContainer.innerHTML = '';
    //     const tech = project.tech || [];
    //     if (Array.isArray(tech)) {
    //         tech.forEach(techItem => {
    //             const tag = document.createElement('span');
    //             tag.className = 'tech-tag';
    //             tag.textContent = techItem;
    //             techContainer.appendChild(tag);
    //         });
    //     }
    // }
    
    // Gallery - Show first image only
    const gallerySection = document.querySelector('.project-detail-gallery');
    const galleryMainImage = document.getElementById('galleryMainImage');
    currentGalleryImages = Array.isArray(project.images) ? project.images : [];
    
    if (gallerySection && galleryMainImage) {
        if (currentGalleryImages.length === 0) {
            gallerySection.style.display = 'none';
            galleryMainImage.src = '';
        } else {
            gallerySection.style.display = 'block';
            // Show only the first image
            galleryMainImage.src = currentGalleryImages[0] || '';
            galleryMainImage.alt = `Project Image`;
        }
    }
    
    if (projectModal) {
        projectModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

// Gallery functions
function updateGallery() {
    const mainImage = document.getElementById('galleryMainImage');
    const thumbnails = document.getElementById('galleryThumbnails');
    
    if (!mainImage || !thumbnails) return;
    
    if (currentGalleryImages.length === 0) {
        mainImage.src = '';
        thumbnails.innerHTML = '';
        return;
    }
    
    if (currentGalleryIndex >= currentGalleryImages.length) {
        currentGalleryIndex = 0;
    }
    
    mainImage.src = currentGalleryImages[currentGalleryIndex];
    mainImage.alt = `Project Image ${currentGalleryIndex + 1}`;
    
    thumbnails.innerHTML = '';
    currentGalleryImages.forEach((img, index) => {
        const thumb = document.createElement('img');
        thumb.src = img;
        thumb.alt = `Thumbnail ${index + 1}`;
        if (index === currentGalleryIndex) {
            thumb.classList.add('active');
        }
        thumb.addEventListener('click', () => {
            currentGalleryIndex = index;
            updateGallery();
        });
        thumbnails.appendChild(thumb);
    });
}

// Initialize gallery navigation
function initGalleryNavigation() {
    const galleryPrev = document.getElementById('galleryPrev');
    const galleryNext = document.getElementById('galleryNext');
    
    if (galleryPrev) {
        galleryPrev.addEventListener('click', () => {
            currentGalleryIndex = (currentGalleryIndex - 1 + currentGalleryImages.length) % currentGalleryImages.length;
            updateGallery();
        });
    }
    
    if (galleryNext) {
        galleryNext.addEventListener('click', () => {
            currentGalleryIndex = (currentGalleryIndex + 1) % currentGalleryImages.length;
            updateGallery();
        });
    }
}

// ============================================
// Certificate Modal
// ============================================

// Initialize certificate modal when DOM is ready
let certificateModal, closeCertModal, viewCertButtons;

function initCertificateModal() {
    certificateModal = document.getElementById('certificateModal');
    closeCertModal = document.getElementById('closeCertModal');
    viewCertButtons = document.querySelectorAll('.btn-view-certificate');
    
    if (!certificateModal || !closeCertModal) {
        console.warn('Certificate modal elements not found');
        return;
    }
    
    viewCertButtons.forEach(button => {
        button.addEventListener('click', () => {
            const certId = button.getAttribute('data-cert-id');
            openCertificateModal(certId);
        });
    });
    
    closeCertModal.addEventListener('click', () => {
        certificateModal.classList.remove('active');
        document.body.style.overflow = '';
    });
    
    const modalOverlay = certificateModal.querySelector('.modal-overlay');
    if (modalOverlay) {
        modalOverlay.addEventListener('click', () => {
            certificateModal.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
}

function openCertificateModal(certId) {
    // Check if certificatesData exists
    if (typeof certificatesData === 'undefined' || !certificatesData) {
        console.error('certificatesData is not defined. Make sure it is loaded from the Blade template.');
        return;
    }
    
    const certificate = certificatesData[certId];
    if (!certificate) {
        console.error('Certificate with ID ' + certId + ' not found in certificatesData');
        return;
    }
    
    const isArabic = document.documentElement.getAttribute('lang') === 'ar';
    
    const modalCertTitle = document.getElementById('modalCertTitle');
    const modalCertImage = document.getElementById('modalCertImage');
    const downloadCertImage = document.getElementById('downloadCertImage');
    const downloadCertPdf = document.getElementById('downloadCertPdf');
    
    if (modalCertTitle) modalCertTitle.textContent = isArabic ? certificate.title : certificate.titleEn;
    if (modalCertImage) modalCertImage.src = certificate.image || '';
    if (downloadCertImage) downloadCertImage.href = certificate.imageDownload || '#';
    if (downloadCertPdf) downloadCertPdf.href = certificate.pdfDownload || '#';
    
    if (certificateModal) {
        certificateModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

// Close modals on ESC key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        if (projectModal) {
            projectModal.classList.remove('active');
        }
        if (certificateModal) {
            certificateModal.classList.remove('active');
        }
        document.body.style.overflow = '';
    }
});

// Initialize all features when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize language toggle first (most important)
    initLanguageToggle();
    
    // Initialize navigation
    initNavigation();
    initBackToTop();
    
    // Initialize modals
    initProjectModal();
    initCertificateModal();
    // initGalleryNavigation(); // Disabled - showing single image only
    
    // Set initial active nav link
    updateActiveNavLink();
    
    // Add fade-in animation to body
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s';
        document.body.style.opacity = '1';
    }, 100);
    
    console.log('Portfolio initialized successfully!');
});

// Fallback: If DOM is already loaded, initialize immediately
if (document.readyState === 'complete' || document.readyState === 'interactive') {
    setTimeout(() => {
        if (typeof initLanguageToggle === 'function') {
            initLanguageToggle();
        }
    }, 50);
}

