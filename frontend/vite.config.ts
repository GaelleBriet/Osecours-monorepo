/// <reference types="vitest" />
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath } from 'node:url';

// https://vitejs.dev/config/
export default defineConfig({
	plugins: [vue()],
	resolve: {
		alias: {
			// '@': path.resolve(__dirname, './src', import.meta.url),
			'@': fileURLToPath(new URL('./src', import.meta.url)),
			'vue-i18n': 'vue-i18n/dist/vue-i18n.cjs.js',
		},
	},
	server: {
		watch: {
			usePolling: true,
		},
	},
	test: {
		globals: true,
		setupFiles: ['vitest.setup.ts'],
		environment: 'jsdom',
		// include: ['tests/**/*test.{ts,js}'],
		// mockReset: false,
	},
});
// , 'src/tests/unit.setup.ts'
// 'vitest-localstorage-mock',
