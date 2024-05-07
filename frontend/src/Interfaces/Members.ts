interface RelationInterface {
	association_id?: number | string;
	role_id?: number | string;
	user_id?: number | string;
	createAt?: string;
	updateAt?: string;
}

export interface Members {
	id?: number | string;
	last_name?: string;
	first_name?: string;
	email?: string;
	emailVerifiedAt?: string;
	existingCatCount?: number;
	existingChildrenCount?: number;
	existingDogCount?: number;
	phone?: string;
	createAt?: string;
	updateAt?: string;
	pivot?: RelationInterface;
}
