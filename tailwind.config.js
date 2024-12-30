import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/**/*.js',
    ],

    theme: {
        screens: {
            '4K': '2160px',
            '2K': '2560px',
            'FHD': '1920px',
            'HD': '1280px',
            ...defaultTheme.screens
        },
        extend: {
            keyframes: {
                shine: {
                    '0%': { backgroundPosition: '300% 50%' },
                    '100%': { backgroundPosition: '0% 0%' },
                },
            },
            animation: {
                shine: 'shine 4s linear infinite',
            },
            colors: {
                love: '#EC6161',
                blackSimple: '#24282F',
                blackBack: '#1E1E24',
                blackActive: 'rgba(53,56,91,1)',
                // box-shadow: 0px 2px 4px rgba(0,0,0,0.2), 0px 0px 6px rgba(0,0,0,0.1);``
                darkblue: 'rgba(6,1,54,0.9)',
                darkblue2: 'rgba(6,1,54,1)',
                darkblue3: 'rgb(0,0,35)',
                ...defaultTheme.colors
            },
            fontFamily: {
                openSans: ['Open Sans', 'Raleway'],
            },
            spacing: {
                '15': '3.75rem', /* 60px */
                '112': '28rem', /* 448pxpx */
                '128': '32rem', /* 512px */
                '144': '36rem', /* 576pxpx */
                '4K': '2160px',
                '2K': '2560px',
                'FHD': '1920px',
                'HD': '1280px',
                '100%': '100%',
                '95%': '95%',
                '90%': '90%',
                '85%': '85%',
                '80%': '80%',
                '75%': '75%',
                '70%': '70%',
                '65%': '65%',
                '60%': '60%',
                '55%': '55%',
                '50%': '50%',
                '45%': '45%',
                '40%': '40%',
                '35%': '35%',
                '30%': '30%',
                '25%': '25%',
                '20%': '20%',
                '15%': '15%',
                '10%': '10%',
                '5%': '5%',
            }
        },
    },

    plugins: [forms],
};
