/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
  ],
  theme: {
    extend: {},
  },
  corePlugins: {
    preflight: false, // Wajib false agar tidak merusak CSS klien
  }
}