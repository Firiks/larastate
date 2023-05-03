/* eslint-disable */
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './storage/framework/views/*.php', // cached views
        './resources/views/**/*.blade.php', // blade views
        './resources/js/**/*.vue', // vue components
    ],
    theme: {
        extend: {},
    },
    darkMode: 'class',
    plugins: [
        require('@tailwindcss/forms'), // restyle form elements
    ],
}
