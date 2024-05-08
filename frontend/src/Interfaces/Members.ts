interface RelationInterface {
	associationId?: number | string;
	roleId?: number | string;
	userId?: number | string;
	createAt?: string;
	updateAt?: string;
}

export interface Members {
	id?: number | string;
	lastName?: string;
	firstName?: string;
	email?: string;
	emailVerifiedAt?: string;
	existingCatCount?: number;
	existingChildrenCount?: number;
	existingDogCount?: number;
	phone?: string;
	createAt?: string;
	updateAt?: string;
	deleteAt?: string;
	pivot?: RelationInterface;
}
