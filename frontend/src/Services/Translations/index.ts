import fr from '@/Locales/fr.json';
import en from '@/Locales/en.json';

import { createI18n } from 'vue-i18n';
import {
	getFromStorage,
	setToStorage,
} from '@/Services/Helpers/LocalStorage.ts';

export type AvailableLanguagesInterface = 'fr-FR' | 'en-GB';

if (getFromStorage('locale') === null) {
	setToStorage('locale', 'fr-FR');
}
let locale = getFromStorage('locale') as AvailableLanguagesInterface;
if (!locale) {
	locale = 'fr-FR';
}

const i18n = createI18n({
	legacy: false,
	allowComposition: true,
	globalInjection: true,
	locale,
	fallbackLocale: 'fr-FR',
	messages: {
		'fr-FR': fr,
		'en-GB': en,
	},
});

export default i18n;
