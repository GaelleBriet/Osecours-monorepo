export interface Animal {
	id?: number;
	name?: string;
	description?: string;
	birthdate?: Date | null;
	cats_friendly?: boolean | null;
	dogs_friendly?: boolean | null;
	children_friendly?: boolean | null;
	age?: number | null;
	behavioral_comment?: string;
	sterilized?: boolean;
	deceased?: boolean;
	breed?: string;

	icad?: string;
	//@todo waiting for the backend to be ready
	color_id?: string;
	coat_id?: string;
	gender_id?: number | string;
	agerange_id?: number | string;
	specie_id?: number;
	status?: number | string;
	sizerange_id?: number | string;
	breed_id?: number | string;
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
