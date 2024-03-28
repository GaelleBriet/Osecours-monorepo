import '@formkit/themes/genesis';
import '@formkit/pro/genesis';

import { fr } from '@formkit/i18n';
import { genesisIcons } from '@formkit/icons';
import { defaultConfig } from '@formkit/vue';
import { rootClasses } from './formkit.theme';
import { createProPlugin, inputs } from '@formkit/pro';

const proPlugin = createProPlugin('fk-6b27f2e3237', inputs);
export default defaultConfig({
	plugins: [proPlugin],
	locales: { fr },
	locale: 'fr',
	config: {
		rootClasses: rootClasses,
	},
	icons: {
		...genesisIcons,
	},
});
