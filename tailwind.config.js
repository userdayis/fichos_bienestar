import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'Liberation Mono', 'Courier New', 'monospace'],
            },
            colors: {
                sena: {
                    DEFAULT: '#39A900',
                    light: '#53C31A',
                    dark: '#2A7F00',
                },
                theme: {
                    bg: '#14251a',
                    panel: '#203928',
                    mustard: '#e6ad43',
                    cream: '#efece1',
                    'ticket-bg': '#efeae0',
                }
            }
        },
    },

    plugins: [forms],
};
