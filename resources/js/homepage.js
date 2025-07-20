// E-Library Homepage Interactive Features

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all homepage features
    initScrollAnimations();
    initCounterAnimations();
    initSmoothScrolling();
    initParallaxEffects();
    initSearchEnhancements();
    initBookCarousel();
});

// Scroll-triggered animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                entry.target.style.opacity = '1';
            }
        });
    }, observerOptions);

    // Observe all sections
    document.querySelectorAll('section').forEach(section => {
        section.style.opacity = '0';
        observer.observe(section);
    });
}

// Animated counters
function initCounterAnimations() {
    const counters = document.querySelectorAll('[x-data*="books"]');
    
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Trigger Alpine.js counter animation
                const alpineData = Alpine.$data(entry.target);
                if (alpineData && typeof alpineData.animateCounters === 'function') {
                    alpineData.animateCounters();
                }
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
}

// Smooth scrolling for navigation links
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.offsetTop;
                const offsetPosition = elementPosition - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Parallax effects for hero section
function initParallaxEffects() {
    const hero = document.querySelector('.gradient-bg');
    const floatingElements = document.querySelectorAll('.animate-float');

    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;

        if (hero) {
            hero.style.transform = `translateY(${rate}px)`;
        }

        floatingElements.forEach((element, index) => {
            const speed = 0.2 + (index * 0.1);
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
}

// Enhanced search functionality
function initSearchEnhancements() {
    const searchInput = document.querySelector('input[name="q"]');
    const searchForm = document.querySelector('form[action*="search"]');

    if (searchInput) {
        // Add search suggestions (mock data)
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

        // Create suggestions dropdown
        const suggestionsContainer = document.createElement('div');
        suggestionsContainer.className = 'absolute top-full left-0 right-0 bg-white rounded-b-2xl shadow-lg z-10 hidden';
        searchForm.appendChild(suggestionsContainer);

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length > 2) {
                const filteredSuggestions = suggestions.filter(s => 
                    s.toLowerCase().includes(query)
                );
                
                if (filteredSuggestions.length > 0) {
                    suggestionsContainer.innerHTML = filteredSuggestions
                        .slice(0, 5)
                        .map(suggestion => 
                            `<div class="px-6 py-3 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0" onclick="selectSuggestion('${suggestion}')">${suggestion}</div>`
                        ).join('');
                    suggestionsContainer.classList.remove('hidden');
                } else {
                    suggestionsContainer.classList.add('hidden');
                }
            } else {
                suggestionsContainer.classList.add('hidden');
            }
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchForm.contains(e.target)) {
                suggestionsContainer.classList.add('hidden');
            }
        });
    }
}

// Global function for suggestion selection
window.selectSuggestion = function(suggestion) {
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput) {
        searchInput.value = suggestion;
        document.querySelector('.absolute.top-full').classList.add('hidden');
        searchInput.form.submit();
    }
};

// Enhanced book carousel
function initBookCarousel() {
    const carousel = document.querySelector('[x-data*="currentSlide"]');
    if (!carousel) return;

    // Auto-play carousel
    let autoPlayInterval = setInterval(() => {
        const alpineData = Alpine.$data(carousel);
        if (alpineData) {
            alpineData.currentSlide = alpineData.currentSlide < alpineData.totalSlides - 1 
                ? alpineData.currentSlide + 1 
                : 0;
        }
    }, 5000);

    // Pause auto-play on hover
    carousel.addEventListener('mouseenter', () => {
        clearInterval(autoPlayInterval);
    });

    carousel.addEventListener('mouseleave', () => {
        autoPlayInterval = setInterval(() => {
            const alpineData = Alpine.$data(carousel);
            if (alpineData) {
                alpineData.currentSlide = alpineData.currentSlide < alpineData.totalSlides - 1 
                    ? alpineData.currentSlide + 1 
                    : 0;
            }
        }, 5000);
    });

    // Touch/swipe support for mobile
    let startX = 0;
    let endX = 0;

    carousel.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
    });

    carousel.addEventListener('touchend', (e) => {
        endX = e.changedTouches[0].clientX;
        handleSwipe();
    });

    function handleSwipe() {
        const alpineData = Alpine.$data(carousel);
        if (!alpineData) return;

        const swipeThreshold = 50;
        const diff = startX - endX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe left - next slide
                alpineData.currentSlide = alpineData.currentSlide < alpineData.totalSlides - 1 
                    ? alpineData.currentSlide + 1 
                    : 0;
            } else {
                // Swipe right - previous slide
                alpineData.currentSlide = alpineData.currentSlide > 0 
                    ? alpineData.currentSlide - 1 
                    : alpineData.totalSlides - 1;
            }
        }
    }
}

// Scroll to top functionality
window.addEventListener('scroll', function() {
    const scrollToTopBtn = document.getElementById('scrollToTop');
    if (scrollToTopBtn) {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.remove('opacity-0', 'invisible');
            scrollToTopBtn.classList.add('opacity-100', 'visible');
        } else {
            scrollToTopBtn.classList.add('opacity-0', 'invisible');
            scrollToTopBtn.classList.remove('opacity-100', 'visible');
        }
    }
});

window.scrollToTop = function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
};

// Performance optimization: Lazy load images
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('opacity-0');
                img.classList.add('opacity-100');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => {
        img.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        imageObserver.observe(img);
    });
}

// Initialize lazy loading
initLazyLoading();

// Add loading states for buttons
document.querySelectorAll('button[type="submit"], a[href*="search"]').forEach(element => {
    element.addEventListener('click', function() {
        if (this.tagName === 'BUTTON' || this.href.includes('search')) {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Recherche...';
            this.disabled = true;
            
            // Re-enable after 3 seconds (fallback)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 3000);
        }
    });
});
