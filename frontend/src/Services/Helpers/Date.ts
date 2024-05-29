// const dateStr = '2021-12-31';
// const dateObj = new Date(dateStr);
// console.log(dateObj);

export const formatDate = (
	date: Date | string,
	format: 'short' | 'medium' | 'long',
): string => {
	const dateObj = typeof date === 'string' ? new Date(date) : date;

	switch (format) {
		case 'short':
			return dateObj.toLocaleString('fr-FR', {
				year: 'numeric',
				month: 'numeric',
				day: 'numeric',
			});
		case 'medium':
			return dateObj.toLocaleString('fr-FR', {
				year: 'numeric',
				month: 'long',
				day: 'numeric',
			});
		case 'long':
			return dateObj.toLocaleString('fr-FR', {
				weekday: 'long',
				year: 'numeric',
				month: 'long',
				day: 'numeric',
			});
		default:
			return dateObj.toLocaleString();
	}
};
