/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    darkMode: "selector",
    theme: {
        extend: {},
    },
    plugins: [require("tailwindcss"), require("autoprefixer")],
};
