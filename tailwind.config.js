/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        'primary': 'var(--primary-color)',
        'secondary': 'var(--secondary-color)',
        'accent': 'var(--accent-color)',
        'white': 'var(--white)',
        'gray': 'var(--gray)',
      },
      fontFamily: {
        'body': ['Poppins', 'sans-serif'],
      },
      flex : {
        '2': '2 2 0%',
      },
      width: {
      },
      lineHeight: {
        '12': '3rem',
        '16': '4rem',
      }
    },
  },
  plugins: [],
}

