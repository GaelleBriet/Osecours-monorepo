// exemple d'objet reçu de l'api
// {
// 	"id": 1,
// 	"name": "Nom de l'animal",
//   ...
// 	"species_id": 1,
// ou alors
// "species": {
// 	"id": 1,
// 		"name": "Chien"
// },
// }

export interface Animal {
	id: number;
	name?: string;
	description?: string;
	birthdate?: Date | string;
	catsFriendly?: boolean;
	dogsFriendly?: boolean;
	childrenFriendly?: boolean;
	age?: number;
	behavioralComment?: string;
	sterilized?: boolean;
	deceased?: boolean;
	breed?: string;

	icad: string;
	//@todo waiting for the backend to be ready
	color?: string;
	coat?: string;
	gender?: number;
	ageRange: number;
	species: number;
	status: number;
	size: number;
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
