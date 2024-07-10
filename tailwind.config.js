/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js}"],
  theme: {
    container: {
      center: true,
      padding:'25px'
    },
    extend: {
      fontFamily: {
        jawa: ["JawaPalsu"],
      },
    },
  },
  plugins: [],
}