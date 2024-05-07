import { beforeEach, describe, expect, it } from 'vitest';
import { mount } from '@vue/test-utils';
import LoginController from '../../src/Controllers/Login/LoginController.vue';
import i18n from '../../src/Services/Translations';
import { defaultConfig, plugin } from '@formkit/vue';
import formkitConfig from '../../formkit.config';

describe('mount component', async () => {
	const wrapper = mount(LoginController, {
		global: {
			plugins: [
				i18n,
				[plugin, defaultConfig(formkitConfig)],
				//createTestingPinia(),
			],
		},

		// props: {
		// 	value: [
		// 		{
		// 			id: 1,
		// 			name: '',
		// 		},
		// 	]
		// }
	});

	beforeEach(() => {
		// setUsers();
	});

	it('checks ...', () => {
		expect(wrapper.getCurrentComponent().isMounted).toBe(true);
	});
});
