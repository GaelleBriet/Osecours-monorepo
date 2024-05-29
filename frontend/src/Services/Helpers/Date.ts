export const formatDate = (
	date: Date | string,
	format: 'short' | 'medium' | 'long',
): string => {
	switch (format) {
		case 'short':
			return date.toLocaleString('fr-FR', {
				year: 'numeric',
				month: 'numeric',
				day: 'numeric',
			});
		case 'medium':
			return date.toLocaleString('fr-FR', {
				year: 'numeric',
				month: 'long',
				day: 'numeric',
			});
		case 'long':
			return date.toLocaleString('fr-FR', {
				weekday: 'long',
				year: 'numeric',
				month: 'long',
				day: 'numeric',
			});
		default:
			return date.toLocaleString();
	}
};
