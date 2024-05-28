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
	existing_cat_count?: number;
	existing_children_count?: number;
	existing_dog_count?: number;
	phone?: string;
	createAt?: string;
	updateAt?: string;
	deleteAt?: string;
	pivot?: RelationInterface;
	password?: string;
	role_id?: number | string;
	association_id?: number | string;
}
