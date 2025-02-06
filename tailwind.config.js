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
            boxShadow: {
                'modals': '0 5px 10px 0 rgba(0,0,0,0.7)',
            },
            colors: {
                love: '#EC6161',
                blackSimple: '#24282F',
                blackBack: '#1E1E24',
                blackBack2: '#252626',

                google1: '#202124',
                google2: '#303134',
                google3: '#4d5156',
                google4: '#252527',
                blackActive: 'rgba(53,56,91,1)',
                ...defaultTheme.colors
            },
            fontFamily: {
                openSans: ['Open Sans'],
            },
            spacing: {
                '15': '3.75rem', /* 60px */
                '88': '22rem',   /* 352px */
                '92': '23rem',   /* 368px */
                '96': '24rem',   /* 384px */
                '100': '25rem',  /* 400px */
                '104': '26rem',  /* 416px */
                '112': '28rem',  /* 448px */
                '120': '30rem',  /* 480px */
                '128': '32rem',  /* 512px */
                '136': '34rem',  /* 544px */
                '144': '36rem',  /* 576px */
                '152': '38rem',  /* 608px */
                '160': '40rem',  /* 640px */
                '168': '42rem',  /* 672px */
                '176': '44rem',  /* 704px */
                '180': '45rem',  /* 720px */
                '184': '46rem',  /* 736px */
                '192': '48rem',  /* 768px */
                '200': '50rem',  /* 800px */
                '208': '52rem',  /* 832px */
                '216': '54rem',  /* 864px */
                '224': '56rem',  /* 896px */
                '232': '58rem',  /* 928px */
                '240': '60rem',  /* 960px */
                '248': '62rem',  /* 992px */
                '256': '64rem',  /* 1024px */
                '264': '66rem',  /* 1056px */
                '272': '68rem',  /* 1088px */
                '280': '70rem',  /* 1120px */
                '288': '72rem',  /* 1152px */
                '296': '74rem',  /* 1184px */
                '304': '76rem',  /* 1216px */
                '312': '78rem',  /* 1248px */
                '320': '80rem',  /* 1280px */
                '328': '82rem',  /* 1312px */
                '336': '84rem',  /* 1344px */
                '344': '86rem',  /* 1376px */
                '352': '88rem',  /* 1408px */
                '360': '90rem',  /* 1440px */
                '368': '92rem',  /* 1472px */
                '376': '94rem',  /* 1504px */
                '384': '96rem',  /* 1536px */
                '392': '98rem',  /* 1568px */
                '400': '100rem', /* 1600px */
                '408': '102rem', /* 1632px */
                '416': '104rem', /* 1664px */
                '424': '106rem', /* 1696px */
                '432': '108rem', /* 1728px */
                '440': '110rem', /* 1760px */
                '448': '112rem', /* 1792px */
                '456': '114rem', /* 1824px */
                '464': '116rem', /* 1856px */
                '472': '118rem', /* 1888px */
                '480': '120rem', /* 1920px */
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
                '4K': '2160px',
                '2K': '2560px',
                'FHD': '1920px',
                'HD': '1280px',
            }
        },
    },

    plugins: [forms],
};
