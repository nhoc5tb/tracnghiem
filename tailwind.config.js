/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./application/views/nhocru/**/*.php',"./node_modules/flowbite/**/*.js"],   
  plugins: [
    require('flowbite/plugin')
  ],
}
