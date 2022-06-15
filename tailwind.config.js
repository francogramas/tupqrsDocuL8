const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    daisyui: {
        themes: [
          {
            tupqrs: {
            "primary": "#5D27B3",
            "secondary": "#463AA1",
            "accent": "#C149AD",
            "neutral": "#5D27B3",
            "base-100": "#FFFFFF",
            "info": "#93E6FB",
            "success": "#32D096",
            "warning": "#EFD8BD",
            "error": "#E58B8B",
            },
          },
        ]
    }
    ,
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            'titulo': '#392789ff',
            'contenido': '#9ba1b0ff',
            'morado': '#5d27b3ff',
            'white': '#ffffff',
            'purple': '#3f3cbb',
            'midnight': '#121063',
          },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require("daisyui")],
};
