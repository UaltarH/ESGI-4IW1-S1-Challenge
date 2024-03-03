/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'selector',
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        'primary': 'var(--primary-color)',
        'primary-dark': 'var(--primary-dark)',
        'secondary': 'var(--secondary-color)',
        'accent': 'var(--accent-color)',
        'white': 'var(--white)',
        'gray': 'var(--gray)',
        'light-gray': 'var(--light-gray)',
        'dark-gray': 'var(--dark-gray)',
        'error': 'var(--error)',
        'error-light': 'var(--error-light)',
        'warning': 'var(--warning)',
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
      },
      minHeight: {
        'cover': 'calc(100vh - 4rem)',
      },
    },
  },
  plugins: [],
}

