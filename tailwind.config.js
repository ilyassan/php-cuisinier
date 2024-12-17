/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,php,js}"],
  theme: {
    extend: {
      colors: {
        "based": "#ffffff",
        "primary": "#FFD700",
        "secondary": "#333333",
        "tertiary": "#8D735F"
      }
    },
  },
  plugins: [],
}