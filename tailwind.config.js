/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#effbf6',
                    100: '#d8f4e8',
                    200: '#b5e7d1',
                    300: '#84d3b0',
                    400: '#4bb286',
                    500: '#228b5f',
                    600: '#166e4b',
                    700: '#14583d',
                    800: '#134633',
                    900: '#113a2c',
                },
                ink: '#112418',
            },
            boxShadow: {
                panel: '0 24px 60px rgba(17, 36, 24, 0.14)',
            },
        },
    },
    plugins: [],
};
