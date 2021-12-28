
//const plugin = require('tailwindcss/plugin');
const path = require('path');
const colors = require('tailwindcss/colors');
module.exports = {
  purge: [
      './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
      './resources/views/*.blade.php',
      './resources/js/components/**/*.vue',
      './resources/js/components/*.vue',
  ],  
  theme: {
    extend: {
    },
  },
  variants: {
    extend: {
      animation: ['motion-reduce'],
      backgroundColor: ['checked'],
      borderColor: ['checked'],
      opacity: ['disabled'],
      cursor: ['disabled'],
      textOpacity: ['disabled'],
      textColor: ['disabled']
    },

  },
  plugins: [require('@tailwindcss/forms'),],
}
