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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // WAJIB DITAMBAHKAN AGAR WARNA GELAPNYA MUNCUL
            colors: {
                brand: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    600: '#0284c7', 
                    700: '#0369a1',
                    900: '#0c4a6e',
                    950: '#111827', // Ini kode warna gelap persis di fotomu
                }
            }
        },
    },

    plugins: [forms],
};