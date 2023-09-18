import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import {defineConfig} from 'vite';

/** @type {import('tailwindcss').Config} */
export default defineConfig({
    darkMode: "false",
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/**/*.js',
        "./src/**/*.{vue,js,ts,jsx,tsx}",
    ],

    theme: {
        extend: {
        },
    },

    plugins: [forms],
});
