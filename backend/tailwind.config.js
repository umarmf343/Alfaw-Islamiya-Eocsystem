import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Vela Sans"', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'pulse-slow': 'pulse-slow 12s ease-in-out infinite',
            },
            keyframes: {
                'pulse-slow': {
                    '0%, 100%': { opacity: 0.35, transform: 'scale(0.95)' },
                    '50%': { opacity: 0.8, transform: 'scale(1.05)' },
                },
            },
        },
    },
    plugins: [forms, typography],
};
