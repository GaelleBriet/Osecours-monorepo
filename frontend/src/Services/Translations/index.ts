import fr from '@/Locales/fr.json';
import en from '@/Locales/en.json';

import { createI18n } from 'vue-i18n';
import {
	getFromStorage,
	setToStorage,
} from '@/Services/Helpers/LocalStorage.ts';

export type AvailableLanguagesInterface = 'fr' | 'en';

if (getFromStorage('locale') === null) {
	setToStorage('locale', 'fr');
}
let locale = getFromStorage('locale') as AvailableLanguagesInterface;
if (!locale) {
	locale = 'fr';
}

const i18n = createI18n({
	legacy: true,
	globalInjection: true,
	locale,
	fallbackLocale: 'en',
	messages: {
		fr,
		en,
	},
});

export default i18n;
