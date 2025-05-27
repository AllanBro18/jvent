/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Views/**/*.php",
    "./app/Views/**/*.html",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#1E1E2F",
        secondary: {
          main: "#3E4C59",
          second: "#4ADEDE"
        },
        tertiary: {
          hard: "#582CCB",
          soft: "#A259FF",
          
        }
      },
      fontFamily: {
        inter: ['Inter', 'sans-serif']
      }
    },
  },
  plugins: [],
}

