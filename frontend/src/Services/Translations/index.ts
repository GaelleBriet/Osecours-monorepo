import fr from '@/Locales/fr.json';
import en from '@/Locales/en.json';

import { createI18n } from 'vue-i18n';
import {
	getFromStorage,
	setToStorage,
} from '@/Services/Helpers/LocalStorage.ts';
import { ref } from 'vue';

export type AvailableLanguagesInterface = 'fr-FR' | 'en-GB';

if (getFromStorage('locale') === null) {
	setToStorage('locale', 'fr-FR');
}
const locale = ref(
	(getFromStorage('locale') as AvailableLanguagesInterface) || 'fr-FR',
);

const i18n = createI18n({
	legacy: false,
	allowComposition: true,
	globalInjection: true,
	locale: locale.value,
	fallbackLocale: 'fr-FR',
	messages: {
		'fr-FR': fr,
		'en-GB': en,
	},
});

export function switchLanguage(newLocale: AvailableLanguagesInterface) {
	locale.value = newLocale;
	i18n.global.locale.value = newLocale;
	setToStorage('locale', newLocale);
}

export default i18n;
export { locale };
