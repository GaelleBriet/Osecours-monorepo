import { AnimalGenders } from '@/Enums/Animals.ts';

export interface AnimalIdentification {
	id: number;
	identification_type: boolean;
	identification_date: Date | string;
	identification_number: string;
}

export interface AnimalDocument {
	id: number;
	file_name?: string;
	description?: string;
	url: string;
	document_type: AnimalDocumentType;
	document_date: Date | string;
}

export interface AnimalDocumentType {
	id: number;
	description?: string;
	type: string;
}

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
	color?: string;
	coat?: string;

	// icad?: AnimalIdentification;
	// documents?: AnimalDocument;
	// ageRange?: AnimalAges;
	// species: AnimalSpecies;
	// status?: AnimalStatus;
	// size?: AnimalSizes;
	gender?: AnimalGenders;
	icad: string;
	ageRange: number;
	species: number;
	status: number;
	size: number;
	// gender: number;
}
