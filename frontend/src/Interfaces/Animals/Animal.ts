import { Identification } from '@/Interfaces/Animals/Identification.ts';
import { Species } from '@/Interfaces/Animals/Species.ts';
import { Breed } from '@/Interfaces/Animals/Breed.ts';
import { Gender } from '@/Interfaces/Animals/Gender.ts';
import { Color } from '@/Interfaces/Animals/Color.ts';
import { Coat } from '@/Interfaces/Animals/Coat.ts';
import { SizeRange } from '@/Interfaces/Animals/SizeRange.ts';
import { AgeRange } from '@/Interfaces/Animals/AgeRange.ts';

export interface Animal {
	id?: number;
	name?: string;
	description?: string;
	birth_date?: Date | null;
	cats_friendly?: boolean | null;
	dogs_friendly?: boolean | null;
	children_friendly?: boolean | null;
	age?: number | null;
	behavioral_comment?: string;
	sterilized?: boolean;
	deceased?: boolean;

	breed_id?: number | string;
	specie_id?: number;
	gender_id?: number | string;
	color_id?: string;
	coat_id?: string;
	sizerange_id?: number | string;
	agerange_id?: number | string;

	identification?: Identification;

	breed?: Breed;
	specie?: Species;
	gender?: Gender;
	color?: Color;
	coat?: Coat;
	sizerange?: SizeRange;
	agerange?: AgeRange;

	status?: number | string;
}
