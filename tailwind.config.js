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
            colors: {
                // Menambahkan warna Branding Batik Lasem
                'batik-red': '#8B0000',   // Merah Marun Gelap
                'batik-gold': '#D4AF37',  // Emas
                'batik-cream': '#FDFBF7', // Warna latar lembut (krem)
            },
            fontFamily: {
                // Kita akan pakai Font Serif yang elegan untuk Headings
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
        },
    },

    plugins: [forms],
};
