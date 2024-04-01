import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
import i18n from '@/Services/Translations/index.ts';

const t = i18n.global.t;

// prends en paramètre un enum
// retourne un tableau d'objets avec une valeur et un label
// la valeur est la clé de l'enum et le label est la clé
export function enumToOptions<T extends Record<string, any>>(
	enumeration: T,
): { value: number; label: string }[] {
	return Object.keys(enumeration)
		.filter((key) => isNaN(Number(key))) // Filtre les clés pour ne garder que les chaînes
		.map((key) => ({
			value: enumeration[key],
			label: key,
		}));
}

// prends en paramètre un enum et un chemin de traduction
// retourne un tableau d'objets avec une valeur et un label
// la valeur est la clé de l'enum et le label est la traduction de la clé
export function generateOptionsFromEnum<T>(
	enumType: T,
	translationPath: string,
): { value: string; label: string }[] {
	return enumToOptions(enumType).map((option) => ({
		value: option.value.toString(),
		label: getCapitalizedText(t(`${translationPath}.${option.label}`)),
	}));
}
