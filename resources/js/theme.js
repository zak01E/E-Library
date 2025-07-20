// Theme management - Simple and reliable approach
window.ThemeManager = {
    init() {
        // Get initial theme state
        this.darkMode = localStorage.getItem('darkMode') === 'true' || 
                       (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);
        
        // Apply theme immediately
        this.applyTheme();
        
        // Setup Alpine.js store when available
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                darkMode: this.darkMode,
                toggle: () => this.toggle()
            });
        });
    },
    
    toggle() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        this.applyTheme();
        
        // Update Alpine store if available
        if (window.Alpine && Alpine.store('theme')) {
            Alpine.store('theme').darkMode = this.darkMode;
        }
    },
    
    applyTheme() {
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        // Update icons
        this.updateIcons();
    },
    
    updateIcons() {
        const icons = document.querySelectorAll('#theme-icon, #theme-icon-nav');
        icons.forEach(icon => {
            if (this.darkMode) {
                icon.className = 'fas fa-sun text-sm';
            } else {
                icon.className = 'fas fa-moon text-sm';
            }
        });
    }
};

// Initialize immediately
window.ThemeManager.init();

// Update icons when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.ThemeManager.updateIcons();
});

// Make toggle function globally available
window.toggleTheme = () => window.ThemeManager.toggle();
