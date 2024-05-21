export function getFromStorage(key: string): unknown | null {
	const value = localStorage.getItem(key);
	try {
		return value !== 'undefined' && value !== null ? JSON.parse(value) : null;
	} catch {
		return value;
	}
}

export function setToStorage(key: string, value: unknown): void {
	localStorage.setItem(key, JSON.stringify(value));
}

export function removeFromStorage(key: string): void {
	localStorage.removeItem(key);
}
