// E-Library Optimized Homepage - Performance First
// Removed all heavy animations and effects for maximum performance

document.addEventListener('DOMContentLoaded', function() {
    // Initialize only essential features
    initSmoothScrolling();
    initSearchEnhancements();
    initBookCarousel();
});

// Smooth scrolling for navigation links (simplified)
function initSmoothScrolling() {
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

// Enhanced search functionality (simplified)
function initSearchEnhancements() {
    const searchInput = document.querySelector('input[name="q"]');
    
    if (searchInput) {
        // Simple search suggestions without heavy DOM manipulation
        const suggestions = [
            'Programmation JavaScript',
            'Histoire de France',
            'Psychologie positive',
            'Écologie moderne',
            'Art contemporain',
            'Sciences physiques',
            'Littérature française',
            'Développement personnel'
        ];

        // Simple autocomplete without complex animations
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length > 2) {
                const matches = suggestions.filter(s => 
                    s.toLowerCase().includes(query)
                ).slice(0, 3);
                
                // Simple console log instead of DOM manipulation for performance
                if (matches.length > 0) {
                    console.log('Search suggestions:', matches);
                }
            }
        });

        // Enter key search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    }
}

// Simple book carousel (no auto-play, no complex animations)
function initBookCarousel() {
    // Carousel functionality is handled by Alpine.js
    // No additional JavaScript needed for performance
}

// Scroll to top functionality (simplified)
window.addEventListener('scroll', function() {
    const scrollToTopBtn = document.getElementById('scrollToTop');
    if (scrollToTopBtn) {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.style.display = 'block';
        } else {
            scrollToTopBtn.style.display = 'none';
        }
    }
});

// Simple scroll to top function
window.scrollToTop = function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
};

// Simple keyboard navigation for accessibility
document.addEventListener('keydown', function(e) {
    // Escape key to close modals/dropdowns
    if (e.key === 'Escape') {
        const openDropdowns = document.querySelectorAll('[x-show="true"]');
        openDropdowns.forEach(dropdown => {
            // Trigger Alpine.js to close
            dropdown.click();
        });
    }
});

// Performance: Removed all heavy animations and effects:
// - No parallax effects
// - No particle systems
// - No complex scroll triggers
// - No magnetic elements
// - No morphing shapes
// - No text reveal animations
// - No micro-interactions
// - No cursor trails
// - No sound effects
// - No gesture support
// - No performance optimizations (they were causing overhead)

console.log('E-Library homepage loaded - Performance optimized version');
