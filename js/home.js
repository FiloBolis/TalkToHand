// TalkToHand Home Dashboard JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });

    // Initialize components
    initializeCounters();
    initializeFeatureCards();
    initializeNotifications();
    initializeUserInteractions();
});

/**
 * Initialize animated counters for statistics
 */
function initializeCounters() {
    const counters = document.querySelectorAll('[data-counter]');
    
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    counters.forEach(counter => observer.observe(counter));
}

/**
 * Animate counter from 0 to target value
 */
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-counter'));
    const duration = 2000; // 2 seconds
    const start = performance.now();
    const startVal = 0;

    function updateCounter(currentTime) {
        const elapsed = currentTime - start;
        const progress = Math.min(elapsed / duration, 1);
        
        // Easing function for smooth animation
        const easeOutQuart = 1 - Math.pow(1 - progress, 4);
        const current = Math.floor(startVal + (target - startVal) * easeOutQuart);
        
        element.textContent = current.toLocaleString();
        
        if (progress < 1) {
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target.toLocaleString();
        }
    }
    
    requestAnimationFrame(updateCounter);
}

/**
 * Initialize feature cards interactions
 */
function initializeFeatureCards() {
    const featureCards = document.querySelectorAll('.feature-card');
    
    featureCards.forEach(card => {
        const button = card.querySelector('.btn');
        
        if (button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const feature = this.closest('.feature-card').querySelector('h5').textContent;
                handleFeatureClick(feature, this);
            });
        }

        // Add parallax effect on scroll
        window.addEventListener('scroll', () => {
            const rect = card.getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
            
            if (isVisible) {
                const scrolled = window.pageYOffset;
                const parallax = scrolled * 0.1;
                card.style.transform = `translateY(${parallax}px)`;
            }
        });
    });
}

/**
 * Handle feature card clicks
 */
function handleFeatureClick(feature, button) {
    const originalText = button.textContent;
    button.textContent = 'Caricamento...';
    button.disabled = true;
    
    trackEvent('feature_clicked', { feature });
    
    setTimeout(() => {
        button.textContent = originalText;
        button.disabled = false;
        
        // Redirect to chats page for all features
        window.location.href = 'chats.php';
    }, 1000);
}

/**
 * Initialize notification system
 */
function initializeNotifications() {
    // Create notification container if it doesn't exist
    if (!document.getElementById('notificationContainer')) {
        const container = document.createElement('div');
        container.id = 'notificationContainer';
        container.className = 'position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
}

/**
 * Show notification toast
 */
function showNotification(message, type = 'info', duration = 4000) {
    const container = document.getElementById('notificationContainer');
    const id = 'notification-' + Date.now();
    
    const icons = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-circle',
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };
    
    const colors = {
        success: 'success',
        error: 'danger',
        warning: 'warning',
        info: 'primary'
    };
    
    const toast = document.createElement('div');
    toast.id = id;
    toast.className = `toast align-items-center text-bg-${colors[type]} border-0 mb-2`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
                <i class="${icons[type]} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    container.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: duration
    });
    
    bsToast.show();
    
    // Remove from DOM after hiding
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

/**
 * Initialize user interactions
 */
function initializeUserInteractions() {
    // Handle main chat button
    const openChatsBtn = document.getElementById('openChatsBtn');
    if (openChatsBtn) {
        openChatsBtn.addEventListener('click', function() {
            showLoadingState();
            setTimeout(() => {
                hideLoadingState();
                window.location.href = 'chats.php';
            }, 1000);
        });
    }

    // Handle feature card buttons
    const textChatBtn = document.getElementById('textChatBtn');
    const groupChatBtn = document.getElementById('groupChatBtn');
    
    if (textChatBtn) {
        textChatBtn.addEventListener('click', function() {
            window.location.href = 'chats.php';
        });
    }
    
    if (groupChatBtn) {
        groupChatBtn.addEventListener('click', function() {
            window.location.href = 'chats.php';
        });
    }

    // Handle tips section interaction
    const tipsButton = document.querySelector('.tips-card .btn');
    if (tipsButton) {
        tipsButton.addEventListener('click', function() {
            showNotification('Funzionalità in arrivo!', 'info');
        });
    }

    // Add smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
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

/**
 * Show loading state
 */
function showLoadingState() {
    document.body.classList.add('loading');
    
    // Create overlay
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
    overlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
    overlay.style.zIndex = '9999';
    overlay.innerHTML = `
        <div class="text-center text-white">
            <div class="spinner-border mb-3" role="status">
                <span class="visually-hidden">Caricamento...</span>
            </div>
            <div>Caricamento chat...</div>
        </div>
    `;
    
    document.body.appendChild(overlay);
}

/**
 * Hide loading state
 */
function hideLoadingState() {
    document.body.classList.remove('loading');
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.remove();
    }
}

/**
 * Track user events for analytics
 */
function trackEvent(eventName, properties = {}) {
    // Here you would integrate with your analytics service
    console.log('Event tracked:', eventName, properties);
    
    // Example: Google Analytics 4
    if (typeof gtag !== 'undefined') {
        gtag('event', eventName, properties);
    }
    
    // Example: Custom analytics
    if (typeof analytics !== 'undefined') {
        analytics.track(eventName, properties);
    }
}

/**
 * Handle keyboard shortcuts
 */
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + Enter to open chats
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
        e.preventDefault();
        window.location.href = 'chats.php';
    }
});

/**
 * Initialize service worker for offline functionality
 */
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('ServiceWorker registration successful');
            })
            .catch(function(err) {
                console.log('ServiceWorker registration failed');
            });
    });
}

/**
 * Handle online/offline status
 */
window.addEventListener('online', function() {
    showNotification('Connessione ristabilita!', 'success');
});

window.addEventListener('offline', function() {
    showNotification('Connessione persa. Alcune funzionalità potrebbero non essere disponibili.', 'warning', 0);
});

/**
 * Initialize performance monitoring
 */
function initializePerformanceMonitoring() {
    // Monitor page load performance
    window.addEventListener('load', function() {
        setTimeout(function() {
            const perfData = performance.getEntriesByType('navigation')[0];
            const loadTime = perfData.loadEventEnd - perfData.loadEventStart;
            
            trackEvent('page_performance', {
                load_time: loadTime,
                dom_interactive: perfData.domInteractive,
                dom_complete: perfData.domComplete
            });
        }, 0);
    });
}

// Initialize performance monitoring
initializePerformanceMonitoring();

/**
 * Utility function to debounce events
 */
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            timeout = null;
            if (!immediate) func(...args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func(...args);
    };
}

/**
 * Utility function to throttle events
 */
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Export functions for use in other modules
window.TalkToHand = {
    showNotification,
    trackEvent,
    showLoadingState,
    hideLoadingState,
    debounce,
    throttle
};