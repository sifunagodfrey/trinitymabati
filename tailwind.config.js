import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {

    // -------------------
    // Dark Mode Strategy
    // -------------------
    darkMode: 'class',

    // -------------------
    // Content Paths
    // -------------------
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',

        // -------------------
        // Application UI (PRIMARY)
        // -------------------
        './platform/**/*.blade.php',

        // -------------------
        // Frontend Views
        // -------------------
        './resources/views/**/*.blade.php',

        // -------------------
        // JS / Vue
        // -------------------
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    // -------------------
    // Theme Customization
    // -------------------
    theme: {
        extend: {

            // -------------------
            // Fonts
            // -------------------
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            // -------------------
            // Color System (CSS Variables - HEX based)
            // -------------------
            colors: {
                primary: "var(--primary-color)",
                'primary-dark': "var(--primary-dark)",
                'primary-light': "var(--primary-light)",
                secondary: "var(--secondary-color)",
                'secondary-dark': "var(--secondary-dark)",
                'secondary-light': "var(--secondary-light)",
                tertiary: "var(--tertiary-color)",
                'tertiary-dark': "var(--tertiary-dark)",
                'tertiary-light': "var(--tertiary-light)",
                background: "var(--background-color)",
                text: "var(--text-color)",

                // UI support colors
                muted: "var(--muted-color)",
                border: "var(--border-color)",
            },

            // -------------------
            // Optional UI Enhancements
            // -------------------
            transitionProperty: {
                width: 'width',
            },
        },
    },

    // -------------------
    // Plugins
    // -------------------
    plugins: [
        forms,
    ],
};
