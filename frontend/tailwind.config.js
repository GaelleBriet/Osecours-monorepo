/** @type {import('tailwindcss').Config} */
export default {
	darkMode: false,
	content: [
		'./index.html',
		'./src/**/*.{vue,js,ts,jsx,tsx}',
		'./formkit.theme.ts',
	],
	theme: {
		extend: {
			transitionProperty: {
				width: 'width',
			},
			colors: {
				'osecours-grey': '#97a6a6',
				'osecours-beige_light': '#f2d0a7',
				'osecours-beige-dark': '#d99962',
				'osecours-pink': '#f28a80',
				'osecours-black': '#0d0d0d',
				'osecours-white': '#f2f2f2',
			},
		},
		screens: {
			sm: '640px',
			// => @media (min-width: 640px) { ... }

			md: '768px',
			// => @media (min-width: 768px) { ... }

			lg: '1024px',
			// => @media (min-width: 1024px) { ... }

			xl: '1280px',
			// => @media (min-width: 1280px) { ... }

			'2xl': '1536px',
			// => @media (min-width: 1536px) { ... }
		},
		container: {
			padding: '2rem',
		},
	},
	plugins: [
		require('@tailwindcss/forms'),
		require('@tailwindcss/typography'),
		require('@tailwindcss/aspect-ratio'),
		require('@tailwindcss/container-queries'),
	],
};
