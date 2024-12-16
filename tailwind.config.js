import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                skyBlue: "#E9FFFE",
                darkerBlue: "#070F2B",
            },
            fontFamily: {
                sans: ["Outfit", ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
