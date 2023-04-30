/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    // "./resources/**/*.vue",
  ],
  theme: {
    extend: {
        colors: {
        'grey-custom': '#eaeaea',
      },
    },
  },
  plugins: [],
}

// npx tailwindcss -i ./public/backend/css/tailwind.css -o ./public/backend/css/output.css --watch