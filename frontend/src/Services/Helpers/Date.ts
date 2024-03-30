// const dateStr = '2021-12-31';
// const dateObj = new Date(dateStr);
// console.log(dateObj);

export const formatDate = (
	date: Date,
	format: 'short' | 'medium' | 'long',
): string => {
	switch (format) {
		case 'short':
			return date.toLocaleDateString('fr-FR', {
				year: 'numeric',
				month: 'numeric',
				day: 'numeric',
			});
		case 'medium':
			return date.toLocaleDateString('fr-FR', {
				year: 'numeric',
				month: 'long',
				day: 'numeric',
			});
		case 'long':
			return date.toLocaleDateString('fr-FR', {
				weekday: 'long',
				year: 'numeric',
				month: 'long',
				day: 'numeric',
			});
		default:
			return date.toLocaleDateString();
	}
};
