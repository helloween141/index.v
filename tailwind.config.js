module.exports = {
    darkMode: 'class',
    content: [
        './index.html',
        './Modules/Vpanel/Resources/**/*.{vue,js,jsx,tsx}',
        './node_modules/flowbite/**/*.js',
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('flowbite/plugin')
    ],
}
