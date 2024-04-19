import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
import i18n from '@/Services/Translations';

const t = i18n.global.t;

// Fonction générique pour formater les options des selects depuis les données de l'api
// @items : les données de l'api
// @translationKey : la clé de traduction pour les labels des options
// return : value = id de l'item, label = name de l'item traduit
export const formatOptions = (
	items: { id: number; name: string }[],
	translationKey: string,
) => {
	return items.map((item) => ({
		value: item.id.toString(),
		label: getCapitalizedText(t(`${translationKey}.${item.name}`)),
	}));
};

// @store : le store et la méthode à appeler
// @translationKey : la clé de traduction pour les labels des options
// @defaultLabel : le label par défaut pour les selects
// return : les options formatées avec le label par défaut en premier
export const fetchDataAndFormatOptions = async <
	T extends { id: number; name: string },
>(
	store: () => Promise<T[]>,
	translationKey: string,
	defaultLabel: string,
) => {
	const data = await store();
	const options = formatOptions(data, translationKey);
	options.unshift({ value: '', label: defaultLabel });
	return options;
};
