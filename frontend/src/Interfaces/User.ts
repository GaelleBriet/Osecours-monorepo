export interface User {
	firstName: string;
	lastName: string;
	phone: string;
	existingCatCount: number;
	existingChildrenCount: number;
	existingDogCount: number;
	email: string;
	// `password` n'est pas inclus car il doit rester privé et n'est pas typiquement envoyé ou reçu du frontend.
	emailVerifiedAt?: Date; // Optionnel car pas toujours présent, type ajusté à `Date`.
	// `rememberToken` est également omis pour des raisons de sécurité.
}
