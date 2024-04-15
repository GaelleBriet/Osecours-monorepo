export interface Animal {
	id?: number;
	name?: string;
	description?: string;
	birthdate?: Date | string;
	catsFriendly?: boolean | null;
	dogsFriendly?: boolean | null;
	childrenFriendly?: boolean | null;
	age?: number | null;
	behavioralComment?: string;
	sterilized?: boolean;
	deceased?: boolean;
	breed?: string;

	icad?: string;
	//@todo waiting for the backend to be ready
	color?: string;
	coat?: string;
	gender?: number | string;
	ageRange?: number | string;
	specie_id?: number;
	status?: number | string;
	size?: number | string;
}

//
// export interface AnimalDocument {
// 	id: number;
// 	file_name?: string;
// 	description?: string;
// 	url: string;
// 	document_type: AnimalDocumentType;
// 	document_date: Date | string;
// }
//
// export interface AnimalDocumentType {
// 	id: number;
// 	description?: string;
// 	type: string;
// }
