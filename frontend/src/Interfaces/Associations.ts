import { AssociationsRequestStatus } from '@/Enums/Associations.ts';

export interface RequestStatus{
	id: number;
	name: string;
}

export interface Shelter{
	id: number;
	name: string;
	siret: string;
	email: string;
}

export interface AssociationDocumentType {
	id: number;
	description?: string;
	type: string;
}

export interface Association {
	id: number;
	name: string;
	siret: string;
	rib?: string;
	request_status?: AssociationsRequestStatus;
	//shelters: Shelter;
}
