export interface Association {
	id: number | string;
	name: string;
}

export interface UserTokenScope {
	token?: string;
	scopes?: string;
}

export interface User {
	id?: number | string;
	associations?: Association[];
	firstName: string;
	lastName: string;
	phone: string;
	existingCatCount?: number;
	existingChildrenCount?: number;
	existingDogCount?: number;
	email: string;
	token?: string;
	scopes?: string;
	associationName?: string;
	associationId?: string;
	address?: string;
	city?: string;
	zipCode?: string;
	adoptFamily?: boolean;
	fosterFamily?: boolean;
	role?: string;
	password: string;
}
