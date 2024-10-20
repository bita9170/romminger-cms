/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./packages/*/Resources/Private/**/*.html",
    "./packages/*/ContentBlocks/**/*.html",
  ],
  darkMode: "class",
  theme: {
    extend: {
      aria: {
        current: 'current="page"',
      },
      colors: {
        primary: {
          100: "#e2e8f0",
          200: "#cfd7e6",
          300: "#a8b9d8",
          400: "#7a9bcd",
          500: "#172554" /* Primary */,
          600: "#1e2a47",
          700: "#1a213e",
          800: "#141c33",
          900: "#0e1728",
        },
        secondary: {
          100: "#f5f7f9",
          200: "#ebeff3",
          300: "#dfe4e9",
          400: "#d3d8df",
          500: "#d7dde4" /* secondary */,
          600: "#a7b0ba",
          700: "#808891",
          800: "#5a6168",
          900: "#33383e",
        },
        tertiary: {
          100: "#fff7ed",
          200: "#ffedd5",
          300: "#fed7aa",
          400: "#fdba74",
          500: "#fb923c", /* tertiary */
          600: "#f97316",
          700: "#ea580c",
          800: "#c2410c",
          900: "#9a3412",
        },
      },
    },
  },
  plugins: [],
};
