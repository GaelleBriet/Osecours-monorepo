import { Animal } from '@/Interfaces/Animals/Animal.ts';

export interface AnimalHealth {
	id?: number;
	date?: Date;
	report?: string;
	weight?: number;
	size?: number;
	animal?: Animal;
	document_id?: number;
}
