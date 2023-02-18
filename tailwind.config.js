const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            amber: colors.amber,
            black: colors.black,
            blue: colors.sky,
            cyan: colors.cyan,
            emerald: colors.emerald,
            fuchsia: colors.fuchsia,
            gray: colors.neutral,
            blueGray: colors.neutral,
            coolGray: colors.neutral,
            warmGray: colors.neutral,
            green: colors.emerald,
            indigo: colors.indigo,
            lime: colors.lime,
            orange: colors.orange,
            pink: colors.pink,
            purple: colors.purple,
            red: colors.red,
            rose: colors.rose,
            sky: colors.sky,
            teal: colors.teal,
            violet: colors.violet,
            yellow: colors.amber,
            white: colors.white,
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    safelist: [
        {
            pattern: /(bg|ring|text|border)-(red|blue|yellow|green|gray|pink|purple|teal|orange|cyan)-(100|200|300|400|600)/
        }
    ],

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/line-clamp'),
        require('@tailwindcss/typography'),
        require('flowbite/plugin'),
    ],
};
