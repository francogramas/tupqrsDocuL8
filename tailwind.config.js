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
          "light", "dark", "cupcake", "bumblebee", "emerald", "corporate", "synthwave", "retro", "cyberpunk", "valentine", "halloween", "garden", "forest", "aqua", "lofi", "pastel", "fantasy", "wireframe", "black", "luxury", "dracula", "cmyk", "autumn", "business", "acid", "lemonade", "night", "coffee", "winter"
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
            'contenido': '#9499a5',
            'morado': '#5d27b3ff',
            'white': '#ffffff',
            'purple': '#3f3cbb',
            'midnight': '#121063',
            'gray-50': '#f9fafb',
            'gray-100': '#f3f4f6',
            'gray-200': '#e5e7eb',
            'gray-300': '#d1d5db',
            'gray-400': '#9ca3af',
            'gray-500': '#6b7280',
            'gray-600': '#4b5563',
            'gray-700': '#374151',
            'gray-800': '#1f2937',
            'gray-900': '#111827',
          },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require("daisyui")],
};
