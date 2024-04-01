export function enumToOptions(
	enumeration: any,
): { value: number; label: string }[] {
	return Object.keys(enumeration)
		.filter((key) => isNaN(Number(key))) // Filtre les clés pour ne garder que les chaînes
		.map((key) => ({
			value: enumeration[key],
			label: key,
		}));
}
