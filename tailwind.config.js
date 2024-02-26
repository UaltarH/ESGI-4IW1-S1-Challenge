/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        // 'primary': '#160F29',
        // 'secondary': '#246A73',
        // 'accent': '#368F8B',
        // 'bg': '#F3DFC1',
        // 'bg-variant': '#DDBEA8',
        'primary': 'var(--primary-color)',
        'secondary': 'var(--secondary-color)',
        'accent': 'var(--accent-color)',
        'white': 'var(--white)',
      },
      fontFamily: {
        'body': ['Popping', 'sans-serif'],
      },
      flex : {
        '2': '2 2 0%',
      },
    },
  },
  plugins: [],
}

