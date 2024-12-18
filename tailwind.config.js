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
                darkerBlue: "#070F2B",
                blueBlue: "#1B1E3D",
                greyishBlue: "#535C91",
                purpleBlue: "#9290C3",
                skyBlue: "#E9FFFE",
            },
            fontFamily: {
                sans: ["Outfit", ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
