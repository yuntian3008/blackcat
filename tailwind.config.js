
//const plugin = require('tailwindcss/plugin');

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
    extend: {},
  },
  variants: {
    extend: {
      animation: ['motion-reduce'],
      backgroundColor: ['checked'],
      borderColor: ['checked'],
      opacity: ['disabled'],
    },

  },
  plugins: [require('@tailwindcss/forms'),],
}
