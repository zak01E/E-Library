/**
 * Book Filters JavaScript
 * Handles dynamic filtering for book lists
 */

document.addEventListener('DOMContentLoaded', function() {
    initializeBookFilters();
});

function initializeBookFilters() {
    // Find all filter forms
    const filterForms = document.querySelectorAll('form[action*="library"], form[action*="home"], form[action*="search"]');
    
    filterForms.forEach(form => {
        setupFormHandlers(form);
    });
}

function setupFormHandlers(form) {
    // Auto-submit on select change
    const selects = form.querySelectorAll('select');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            showLoadingState(form);
            form.submit();
        });
    });

    // Debounced search input
    const searchInput = form.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                showLoadingState(form);
                form.submit();
            }, 500);
        });
    }

    // Form submission loading state
    form.addEventListener('submit', function() {
        showLoadingState(form);
    });
}

function showLoadingState(form) {
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Chargement...';
        submitBtn.disabled = true;
        
        // Store original text for potential restoration
        submitBtn.dataset.originalText = originalText;
    }
}

function hideLoadingState(form) {
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn && submitBtn.dataset.originalText) {
        submitBtn.innerHTML = submitBtn.dataset.originalText;
        submitBtn.disabled = false;
    }
}

// Utility function to get URL parameters
function getUrlParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Utility function to update URL without page reload
function updateUrlParameter(key, value) {
    const url = new URL(window.location);
    if (value && value !== 'all') {
        url.searchParams.set(key, value);
    } else {
        url.searchParams.delete(key);
    }
    window.history.replaceState({}, '', url);
}
