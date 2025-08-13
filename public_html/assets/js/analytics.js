// Analytics utility for tracking user interactions with consent
class Analytics {
    constructor() {
        this.session = null;
        this.consent = {
            analytics: false,
            marketing: false,
            functional: true
        };
        this.apiUrl = 'api';
        
        this.initSession();
        this.setupPageTracking();
        this.setupInteractionTracking();
        this.loadConsent();
    }

    initSession() {
        const sessionId = this.generateSessionId();
        this.session = {
            sessionId,
            startTime: Date.now(),
            lastActivity: Date.now(),
            pageViews: 0,
            userConsent: false
        };

        // Get location data (with consent)
        this.getLocationData().then(location => {
            this.trackSession(location);
        });
    }

    generateSessionId() {
        return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    async getLocationData() {
        try {
            // Use a free IP geolocation service
            const response = await fetch('https://ipapi.co/json/');
            const data = await response.json();
            return {
                country: data.country_name,
                city: data.city
            };
        } catch (error) {
            console.warn('Could not get location data:', error);
            return { country: null, city: null };
        }
    }

    async trackSession(location) {
        if (!this.session) return;

        try {
            const response = await fetch(`${this.apiUrl}/analytics.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'session',
                    sessionId: this.session.sessionId,
                    userConsent: this.consent.analytics,
                    referrer: document.referrer,
                    landingPage: window.location.pathname,
                    country: location.country,
                    city: location.city
                })
            });

            if (!response.ok) {
                throw new Error('Analytics tracking failed');
            }
        } catch (error) {
            console.warn('Analytics tracking failed:', error);
        }
    }

    loadConsent() {
        const savedConsent = localStorage.getItem('cookieConsent');
        if (savedConsent) {
            this.consent = JSON.parse(savedConsent);
            if (this.session) {
                this.session.userConsent = this.consent.analytics;
            }
        }
    }

    updateConsent(newConsent) {
        this.consent = newConsent;
        if (this.session) {
            this.session.userConsent = newConsent.analytics;
        }
    }

    trackConsent(consentType, consentGiven) {
        if (!this.session) return;

        fetch(`${this.apiUrl}/analytics.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'consent',
                sessionId: this.session.sessionId,
                consentType,
                consentGiven
            })
        }).catch(error => {
            console.warn('Consent tracking failed:', error);
        });
    }

    trackPageView(pageUrl, pageTitle) {
        if (!this.consent.analytics || !this.session) return;

        const url = pageUrl || window.location.pathname;
        const title = pageTitle || document.title;
        const timeOnPage = Date.now() - this.session.lastActivity;

        this.session.pageViews++;
        this.session.lastActivity = Date.now();

        fetch(`${this.apiUrl}/analytics.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'pageview',
                sessionId: this.session.sessionId,
                pageUrl: url,
                pageTitle: title,
                timeOnPage: this.session.pageViews > 1 ? timeOnPage : 0
            })
        }).catch(error => {
            console.warn('Page view tracking failed:', error);
        });
    }

    trackInteraction(interactionType, elementId, elementText) {
        if (!this.consent.analytics || !this.session) return;

        fetch(`${this.apiUrl}/analytics.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'interaction',
                sessionId: this.session.sessionId,
                interactionType,
                elementId,
                elementText,
                pageUrl: window.location.pathname
            })
        }).catch(error => {
            console.warn('Interaction tracking failed:', error);
        });
    }

    trackContact(contactData) {
        fetch(`${this.apiUrl}/analytics.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'contact',
                ...contactData
            })
        }).catch(error => {
            console.warn('Contact tracking failed:', error);
        });
    }

    trackNewsletter(email) {
        fetch(`${this.apiUrl}/analytics.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'newsletter',
                email
            })
        }).catch(error => {
            console.warn('Newsletter tracking failed:', error);
        });
    }

    trackPerformance(metric, value) {
        if (!this.consent.analytics || !this.session) return;

        fetch(`${this.apiUrl}/analytics.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'performance',
                sessionId: this.session.sessionId,
                metric,
                value
            })
        }).catch(error => {
            console.warn('Performance tracking failed:', error);
        });
    }

    setupPageTracking() {
        // Track initial page view
        window.addEventListener('load', () => {
            setTimeout(() => this.trackPageView(), 1000);
        });

        // Track page changes in SPA-like navigation
        let currentPath = window.location.pathname;
        const observer = new MutationObserver(() => {
            if (window.location.pathname !== currentPath) {
                currentPath = window.location.pathname;
                this.trackPageView();
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        // Track page visibility changes
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible' && this.session) {
                this.session.lastActivity = Date.now();
            }
        });
    }

    setupInteractionTracking() {
        // Track clicks on important elements
        document.addEventListener('click', (event) => {
            const target = event.target;
            
            // Track button clicks
            if (target.tagName === 'BUTTON' || target.closest('button')) {
                const button = target.tagName === 'BUTTON' ? target : target.closest('button');
                this.trackInteraction('click', button.id, button.textContent?.trim());
            }
            
            // Track link clicks
            if (target.tagName === 'A' || target.closest('a')) {
                const link = target.tagName === 'A' ? target : target.closest('a');
                const href = link.href;
                
                if (href?.includes('mailto:')) {
                    this.trackInteraction('email_click', link.id, href);
                } else if (href?.includes('tel:')) {
                    this.trackInteraction('phone_click', link.id, href);
                } else {
                    this.trackInteraction('click', link.id, link.textContent?.trim());
                }
            }
        });

        // Track form submissions
        document.addEventListener('submit', (event) => {
            const form = event.target;
            this.trackInteraction('form_submit', form.id, form.action || 'form');
        });
    }

    endSession() {
        if (!this.session) return;

        const sessionDuration = Date.now() - this.session.startTime;
        
        fetch(`${this.apiUrl}/analytics.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'end_session',
                sessionId: this.session.sessionId,
                sessionDuration: Math.floor(sessionDuration / 1000)
            })
        }).catch(error => {
            console.warn('Session end tracking failed:', error);
        });
    }
}

// Create global analytics instance
const analytics = new Analytics();

// End session on page unload
window.addEventListener('beforeunload', () => {
    analytics.endSession();
});

// Make analytics available globally
window.analytics = analytics;