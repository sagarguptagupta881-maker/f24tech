// Main JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeHeader();
    initializeMobileMenu();
    initializeContactForm();
    initializeSmoothScrolling();
    initializeAnimations();
    initializeCookieConsent();
});

// Header scroll effect
function initializeHeader() {
    const header = document.getElementById('header');
    const logoText = document.getElementById('logo-text');
    const navLinks = document.querySelectorAll('.nav-link');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');

    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
}

// Mobile menu functionality
function initializeMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // Close mobile menu when clicking on a link
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            });
        });
    }
}

// Contact form handling
function initializeContactForm() {
    const contactForm = document.getElementById('contact-form');
    const contactSuccess = document.getElementById('contact-success');

    if (contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(contactForm);
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.innerHTML = `
                <div class="spinner mr-2"></div>
                Sending...
            `;
            submitBtn.disabled = true;

            try {
                const response = await fetch('api/contact.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Show success message
                    contactForm.style.display = 'none';
                    contactSuccess.classList.remove('hidden');

                    // Track analytics
                    if (window.analytics) {
                        window.analytics.trackInteraction('form_submit', 'contact-form', 'Contact form submitted');
                    }

                    // Reset form after 5 seconds
                    setTimeout(() => {
                        contactForm.style.display = 'block';
                        contactSuccess.classList.add('hidden');
                        contactForm.reset();
                    }, 5000);
                } else {
                    throw new Error(result.error || 'Failed to send message');
                }
            } catch (error) {
                alert('Error: ' + error.message);
            } finally {
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
}

// Smooth scrolling for anchor links
function initializeSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Initialize animations on scroll
function initializeAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    // Observe elements with animation classes
    document.querySelectorAll('.card-hover, .service-card, .team-card, .blog-card').forEach(el => {
        observer.observe(el);
    });
}

// Cookie consent functionality
function initializeCookieConsent() {
    const cookieConsent = document.getElementById('cookie-consent');
    const acceptBtn = document.getElementById('accept-cookies');
    const rejectBtn = document.getElementById('reject-cookies');
    const customizeBtn = document.getElementById('customize-cookies');

    // Check if consent already given
    const consent = localStorage.getItem('cookieConsent');
    if (!consent && cookieConsent) {
        cookieConsent.classList.remove('hidden');
    }

    if (acceptBtn) {
        acceptBtn.addEventListener('click', function() {
            const consents = {
                analytics: true,
                marketing: true,
                functional: true
            };
            saveConsent(consents);
            cookieConsent.classList.add('hidden');
        });
    }

    if (rejectBtn) {
        rejectBtn.addEventListener('click', function() {
            const consents = {
                analytics: false,
                marketing: false,
                functional: true
            };
            saveConsent(consents);
            cookieConsent.classList.add('hidden');
        });
    }

    if (customizeBtn) {
        customizeBtn.addEventListener('click', function() {
            showCookieSettings();
        });
    }
}

// Save cookie consent
function saveConsent(consents) {
    localStorage.setItem('cookieConsent', JSON.stringify(consents));
    localStorage.setItem('cookieConsentDate', new Date().toISOString());
    
    // Update analytics consent
    if (window.analytics) {
        window.analytics.updateConsent(consents);
    }
}

// Show cookie settings modal
function showCookieSettings() {
    // This would show a modal with detailed cookie settings
    // For now, just show an alert
    alert('Cookie settings would be shown here in a modal');
}

// Newsletter subscription
function subscribeNewsletter(inputId = 'newsletter-email') {
    const emailInput = document.getElementById(inputId);
    const email = emailInput.value.trim();

    if (!email) {
        alert('Please enter your email address');
        return;
    }

    if (!isValidEmail(email)) {
        alert('Please enter a valid email address');
        return;
    }

    // Send to backend
    fetch('api/newsletter.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Thank you for subscribing to our newsletter!');
            emailInput.value = '';
            
            // Track analytics
            if (window.analytics) {
                window.analytics.trackNewsletter(email);
            }
        } else {
            alert('Error: ' + (data.error || 'Failed to subscribe'));
        }
    })
    .catch(error => {
        alert('Error: Failed to subscribe');
    });
}

// Utility functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Service filter functionality (for services page)
function filterServices(category) {
    const serviceCards = document.querySelectorAll('.service-card');
    const filterButtons = document.querySelectorAll('.filter-btn');

    // Update active button
    filterButtons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.category === category) {
            btn.classList.add('active');
        }
    });

    // Filter cards
    serviceCards.forEach(card => {
        if (category === 'all' || card.dataset.category === category) {
            card.style.display = 'block';
            card.classList.add('animate-fade-in');
        } else {
            card.style.display = 'none';
        }
    });
}

// Portfolio filter functionality
function filterPortfolio(category) {
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    const filterButtons = document.querySelectorAll('.portfolio-filter');

    // Update active button
    filterButtons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.category === category) {
            btn.classList.add('active');
        }
    });

    // Filter items
    portfolioItems.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = 'block';
            item.classList.add('animate-fade-in');
        } else {
            item.style.display = 'none';
        }
    });
}

// Form validation helpers
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('error');
            isValid = false;
        } else {
            input.classList.remove('error');
        }

        if (input.type === 'email' && input.value && !isValidEmail(input.value)) {
            input.classList.add('error');
            isValid = false;
        }
    });

    return isValid;
}

// Loading state management
function showLoading(element) {
    element.innerHTML = '<div class="spinner"></div> Loading...';
    element.disabled = true;
}

function hideLoading(element, originalText) {
    element.innerHTML = originalText;
    element.disabled = false;
}

// Error handling
function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ef4444;
        color: white;
        padding: 1rem;
        border-radius: 0.5rem;
        z-index: 1000;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    `;

    document.body.appendChild(errorDiv);

    setTimeout(() => {
        errorDiv.remove();
    }, 5000);
}

// Success message
function showSuccess(message) {
    const successDiv = document.createElement('div');
    successDiv.className = 'success-message';
    successDiv.textContent = message;
    successDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 1rem;
        border-radius: 0.5rem;
        z-index: 1000;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    `;

    document.body.appendChild(successDiv);

    setTimeout(() => {
        successDiv.remove();
    }, 5000);
}

// Performance monitoring
function trackPerformance() {
    if ('performance' in window) {
        window.addEventListener('load', () => {
            const perfData = performance.timing;
            const loadTime = perfData.loadEventEnd - perfData.navigationStart;
            
            if (window.analytics) {
                window.analytics.trackPerformance('page_load_time', loadTime);
            }
        });
    }
}

trackPerformance();