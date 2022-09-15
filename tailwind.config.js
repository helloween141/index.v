module.exports = {
    darkMode: 'class',
    content: [
        './node_modules/flowbite/**/*.js',
        './index.html',
        './Modules/Vpanel/Resources/**/*.{vue,js,jsx,tsx}'
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('flowbite/plugin')
    ],
}
