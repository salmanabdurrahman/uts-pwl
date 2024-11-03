/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./**/*.{html,js,php}',
		'./assets/**/*.{html,js,php}',
		'./node_modules/flowbite/**/*.js',
		'./node_modules/preline/dist/*.js',
	],
	// presets: [require('@acmecorp/base-tailwind-config')],
	theme: {
		extend: {
			// colors: {
			// 	blue: '#1fb6ff',
			// 	purple: '#7e5bef',
			// 	pink: '#ff49db',
			// 	orange: '#ff7849',
			// 	green: '#13ce66',
			// 	yellow: '#ffc82c',
			// 	'gray-dark': '#273444',
			// 	gray: '#8492a6',
			// 	'gray-light': '#d3dce6',
			// },
			fontFamily: {
				sans: ['Graphik', 'sans-serif'],
				serif: ['Merriweather', 'serif'],
				inter: ['Inter', 'sans-serif'],
			},
			spacing: {
				// 128: '32rem',
				// 144: '36rem',
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
