/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./packages/*/Resources/Private/**/*.html",
    "./packages/*/ContentBlocks/**/*.html",
  ],
  theme: {
    extend: {
      aria: {
        current: 'current="page"',
      },
      colors: {
        primary: {
          100: "#fce8d4",
          200: "#fac5a2",
          300: "#f79f6e",
          400: "#f47a3a",
          500: "#ed7c1d", // Primary
          600: "#db6905",
          700: "#b25404",
          800: "#8a4003",
          900: "#642f02",
        },
        secodary: {
          100: "#e1e9f1",
          200: "#b3c8dc",
          300: "#86a6c8",
          400: "#5875b3",
          500: "#1d4f7e", // Secondary
          600: "#163e65",
          700: "#102e4c",
          800: "#091e33",
          900: "#051622",
        },
      },
    },
  },
  plugins: [],
};
