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

    theme: {
        extend: {
            // ═══════════════════════════════════════
            // COLOR PALETTE — Giri Adiwarna
            // ═══════════════════════════════════════
            colors: {
            // ── DARK (existing) ──
            'bg-primary':   '#1E2328',
            'bg-secondary': '#2A2E34',
            'bg-card':      '#3B3F46',

            // ── GOLD (existing) ──
            'gold': {
                DEFAULT: '#F5B301',
                hover:   '#FEB053',
                light:   '#FFD166',
                dark:    '#C28A00',
            },

            // ── LIGHT (BARU — buat dashboard content) ──
            'light-bg':     '#F5F7FA',
            'light-card':   '#FFFFFF',
            'light-border': '#E5E7EB',
            'light-text':   '#1E2328',
            'light-muted':  '#6B7280',
            'light-hover':  '#F9FAFB',

            // ── Text (existing) ──
            'text-primary': '#FFFFFF',
            'text-muted':   '#A0A4AB',
            'border-dark':  '#4A4F57',
        },

            // ═══════════════════════════════════════
            // FONTS
            // ═══════════════════════════════════════
            fontFamily: {
                sans:    ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Poppins', ...defaultTheme.fontFamily.sans],
            },

            // ═══════════════════════════════════════
            // ANIMATIONS
            // ═══════════════════════════════════════
            keyframes: {
                'fade-in': {
                    '0%':   { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                'slide-up': {
                    '0%':   { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'slide-down': {
                    '0%':   { opacity: '0', transform: 'translateY(-20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'glow': {
                    '0%, 100%': { boxShadow: '0 0 20px rgba(245, 179, 1, 0.3)' },
                    '50%':      { boxShadow: '0 0 40px rgba(245, 179, 1, 0.6)' },
                },
            },
            animation: {
                'fade-in':    'fade-in 0.6s ease-out',
                'slide-up':   'slide-up 0.6s ease-out',
                'slide-down': 'slide-down 0.6s ease-out',
                'glow':       'glow 2s ease-in-out infinite',
            },

            // ═══════════════════════════════════════
            // SPACING & SIZING
            // ═══════════════════════════════════════
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },

            // ═══════════════════════════════════════
            // BORDER RADIUS
            // ═══════════════════════════════════════
            borderRadius: {
                'xl':  '0.875rem',
                '2xl': '1.25rem',
                '3xl': '1.75rem',
            },
        },
    },

    plugins: [forms],
};