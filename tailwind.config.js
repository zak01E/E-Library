import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Outfit', 'Space Grotesk', ...defaultTheme.fontFamily.sans],
                display: ['Outfit', 'Space Grotesk', 'Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Space Grotesk', 'Outfit', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#ecfdf5',
                    100: '#d1fae5',
                    200: '#a7f3d0',
                    300: '#6ee7b7',
                    400: '#34d399',
                    500: '#10b981',
                    600: '#059669',
                    700: '#047857',
                    800: '#065f46',
                    900: '#064e3b',
                },
                secondary: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                },
                accent: {
                    amber: '#f59e0b',
                    emerald: '#10b981',
                    rose: '#f43f5e',
                    cyan: '#06b6d4',
                    violet: '#8b5cf6',
                    orange: '#f97316',
                },
                neutral: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                },
            },
            backgroundImage: {
                'gradient-primary': 'linear-gradient(135deg, var(--tw-gradient-stops))',
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                'medium': '0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                'large': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                'colored': '0 10px 25px -5px rgba(59, 130, 246, 0.4)',
                'glow': '0 0 30px rgba(59, 130, 246, 0.3)',
            },
            borderRadius: {
                'xl': '1rem',
                '2xl': '1.5rem',
                '3xl': '2rem',
            },
            animation: {
                // Existing animations
                'float': 'float 6s ease-in-out infinite',
                'float-delayed': 'float 6s ease-in-out infinite 2s',
                'float-slow': 'floatSlow 8s ease-in-out infinite',
                'pulse-glow': 'pulseGlow 2s ease-in-out infinite alternate',
                'fade-in': 'fadeIn 1s ease-out',
                'fade-in-up': 'fadeInUp 0.8s ease-out',
                'fade-in-down': 'fadeInDown 0.8s ease-out',
                'fade-in-left': 'fadeInLeft 0.8s ease-out',
                'fade-in-right': 'fadeInRight 0.8s ease-out',
                'scale-in': 'scaleIn 0.5s ease-out',
                'bounce-in': 'bounceIn 0.8s ease-out',
                'slide-up': 'slideUp 0.8s ease-out',
                'shimmer': 'shimmer 2s infinite',
                'loading-pulse': 'loadingPulse 1.5s ease-in-out infinite',
                'spin-slow': 'spin 2s linear infinite',

                // Next-gen motion animations
                'morph-in': 'morphIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'liquid': 'liquidMotion 3s cubic-bezier(0.87, 0, 0.13, 1) infinite',
                'elastic-scale': 'elasticScale 0.5s cubic-bezier(0.68, -0.6, 0.32, 1.6)',
                'breathe': 'breathe 4s cubic-bezier(0.785, 0.135, 0.15, 0.86) infinite',
                'glitch': 'glitch 2s infinite',
                'typewriter': 'typewriter 3s steps(40, end), blinkCursor 0.75s step-end infinite',
                'skeleton-loading': 'skeleton-loading 1.5s infinite',
                'pulse-ring': 'pulseRing 2s infinite',
                'particle-burst-1': 'particleBurst1 0.6s cubic-bezier(0.16, 1, 0.3, 1)',
                'particle-burst-2': 'particleBurst2 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.1s',
                'text-reveal-char': 'textRevealChar 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'micro-shake': 'shake 0.5s cubic-bezier(0.87, 0, 0.13, 1)',
            },
            backdropBlur: {
                'xs': '2px',
            },
            transitionDuration: {
                '400': '400ms',
                '600': '600ms',
            },
            transitionTimingFunction: {
                'bounce-in': 'cubic-bezier(0.68, -0.55, 0.265, 1.55)',
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },
        },
    },

    plugins: [
        forms,
        function({ addUtilities }) {
            const newUtilities = {
                '.text-shadow': {
                    textShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
                },
                '.text-shadow-lg': {
                    textShadow: '0 4px 8px rgba(0, 0, 0, 0.2)',
                },
                '.glass-effect': {
                    backdropFilter: 'blur(20px)',
                    backgroundColor: 'rgba(255, 255, 255, 0.1)',
                    border: '1px solid rgba(255, 255, 255, 0.2)',
                },
                '.glass-card': {
                    backdropFilter: 'blur(16px)',
                    backgroundColor: 'rgba(255, 255, 255, 0.8)',
                    border: '1px solid rgba(255, 255, 255, 0.3)',
                },
                '.neomorphism': {
                    backgroundColor: '#f1f5f9',
                    boxShadow: '20px 20px 60px rgba(163, 177, 198, 0.6), -20px -20px 60px rgba(255, 255, 255, 0.8)',
                },
                '.gradient-border': {
                    position: 'relative',
                    '&::before': {
                        content: '""',
                        position: 'absolute',
                        inset: '0',
                        padding: '2px',
                        background: 'linear-gradient(135deg, #3b82f6 0%, #a855f7 100%)',
                        borderRadius: 'inherit',
                        mask: 'linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0)',
                        maskComposite: 'xor',
                    },
                },

                // Next-gen motion utilities
                '.transition-smooth': {
                    transition: 'all 300ms cubic-bezier(0.16, 1, 0.3, 1)',
                },
                '.transition-bounce': {
                    transition: 'all 300ms cubic-bezier(0.68, -0.6, 0.32, 1.6)',
                },
                '.transition-elastic': {
                    transition: 'all 500ms cubic-bezier(0.175, 0.885, 0.32, 1.275)',
                },
                '.transition-snappy': {
                    transition: 'all 150ms cubic-bezier(0.4, 0, 0.2, 1)',
                },

                // Hover effects
                '.hover-lift-smooth:hover': {
                    transform: 'translateY(-8px) scale(1.02)',
                },
                '.hover-tilt-3d:hover': {
                    transform: 'perspective(1000px) rotateX(10deg) rotateY(10deg) translateZ(20px)',
                },
                '.hover-glow-pulse:hover': {
                    boxShadow: '0 0 30px rgba(59, 130, 246, 0.5), 0 0 60px rgba(59, 130, 246, 0.3)',
                    transform: 'scale(1.05)',
                },

                // Interactive states
                '.active-press:active': {
                    transform: 'scale(0.95)',
                },
                '.micro-bounce:active': {
                    transform: 'scale(0.95)',
                },

                // Scroll animations
                '.scroll-fade-in': {
                    opacity: '0',
                    transform: 'translateY(30px)',
                    transition: 'all 500ms cubic-bezier(0.16, 1, 0.3, 1)',
                },
                '.scroll-fade-in.in-view': {
                    opacity: '1',
                    transform: 'translateY(0)',
                },
                '.scroll-scale-in': {
                    opacity: '0',
                    transform: 'scale(0.8)',
                    transition: 'all 500ms cubic-bezier(0.16, 1, 0.3, 1)',
                },
                '.scroll-scale-in.in-view': {
                    opacity: '1',
                    transform: 'scale(1)',
                },
            };
            addUtilities(newUtilities);
        },
    ],
};