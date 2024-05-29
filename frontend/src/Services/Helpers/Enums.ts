import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
import i18n from '@/Services/Translations/index.ts';

const t = i18n.global.t;

// prends en paramètre un enum
// retourne un tableau d'objets avec une valeur(number) et un label
// la valeur est la clé de l'enum et le label est la clé
export function enumToOptions<T extends Record<string, unknown>>(
	enumeration: T,
): { value: number; label: string }[] {
	return Object.keys(enumeration)
		.filter((key) => isNaN(Number(key))) // Filtre les clés pour ne garder que les chaînes
		.map((key) => ({
			value: enumeration[key] as number,
			label: key,
		}));
}

// prends en paramètre un enum et un chemin de traduction
// retourne un tableau d'objets avec une valeur(string) et un label
// la valeur est la clé de l'enum et le label est la traduction de la clé
export function generateOptionsFromEnum<T extends Record<string, unknown>>(
	enumType: T,
	translationPath: string,
): { value: string; label: string }[] {
	return enumToOptions(enumType).map(
		(option: {
			value: number;
			label: string;
		}): { value: string; label: string } => ({
			value: option.value.toString(),
			label: getCapitalizedText(
				t(`${translationPath}.${option.label.toLowerCase()}`),
			),
		}),
	);
}

// Fonction générique pour formater les options des selects depuis les données des enums
// @enumObject : l'enum à formater
// @translationKey : la clé de traduction pour les labels des options
// @defaultLabel : le label par défaut pour les selects
// return : value = clé de l'enum, label = valeur de l'enum traduite
export const generateOptionsWithDefault = (
	enumObject: Record<string, unknown>,
	translationKey: string,
	defaultLabel: string,
) => {
	const options = generateOptionsFromEnum(enumObject, translationKey);
	options.unshift({ value: '', label: defaultLabel });
	return options;
};
