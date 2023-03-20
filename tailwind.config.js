const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: ['class', '[data-mode="dark"]'],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'theme-wedding': "url('/public/storage/theme/login/wedding.png')",
                'theme-debutant': "url('/public/storage/theme/login/debutant.png')",
                'theme-confraternization': "url('/public/storage/theme/login/confraternization.png')",
                'theme-complete-logo-bgblack': "url('/public/storage/theme/login/logo-completo-bgblack.png')",

                'complete-logo-bgless': "url('/public/storage/logos/logo-completo-bgless.png')",
                'complete-logo-landscape-bgless': "url('/public/storage/logos/logo-completo-deitado-bgless.png')",
                'logo-txt-bgless': "url('/public/storage/logos/logo-txt-bgless.png')",
                'logo-img-bgless': "url('/public/storage/logos/logo-img-bgless.png')",
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('tailwind-scrollbar')({ nocompatible: true }),],
};
