/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./packages/*/Resources/Private/**/*.html",
    "./packages/*/Resources/Public/**/*.js",
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
          100: "#fff4e0",
          200: "#ffe1b3",
          300: "#ffd280",
          400: "#ffbe4d",
          500: "#ff9500" /* tertiary */,
          600: "#e67e00",
          700: "#cc6600",
          800: "#994d00",
          900: "#663300",
        },
      },
    },
  },
  plugins: [],
};
