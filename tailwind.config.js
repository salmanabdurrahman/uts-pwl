/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./index.php',
		'./admin/**/*.{html,js,php}',
		'./user/**/*.{html,js,php}',
		'./pages/**/*.{html,js,php}',
		'./assets/**/*.{html,js,php}',
		'./node_modules/flowbite/**/*.js',
		'./node_modules/preline/dist/*.js',
	],
	theme: {
		extend: {
			fontFamily: {
				sans: ['Graphik', 'sans-serif'],
				serif: ['Merriweather', 'serif'],
				inter: ['Inter', 'sans-serif'],
			},
			spacing: {
				'8xl': '96rem',
				'9xl': '128rem',
			},
			borderRadius: {
				'4xl': '2rem',
			},
			container: {
				center: true,
			},
		},
	},
	plugins: [
		require('flowbite/plugin'),
		require('preline/plugin'),
		require('@tailwindcss/forms'),
	],
};
