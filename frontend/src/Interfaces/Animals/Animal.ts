import { Identification } from '@/Interfaces/Animals/Identification.ts';
import { Species } from '@/Interfaces/Animals/Species.ts';
import { Breed } from '@/Interfaces/Animals/Breed.ts';
import { Gender } from '@/Interfaces/Animals/Gender.ts';
import { Color } from '@/Interfaces/Animals/Color.ts';
import { Coat } from '@/Interfaces/Animals/Coat.ts';
import { SizeRange } from '@/Interfaces/Animals/SizeRange.ts';
import { AgeRange } from '@/Interfaces/Animals/AgeRange.ts';

export interface Animal {
	id?: number | undefined;
	age?: number | null;
	agerange?: AgeRange;
	agerange_id?: number | string;
	behavioral_comment?: string;
	birth_date?: Date | null;
	breed?: Breed;
	breed_id?: number | string | undefined;
	cats_friendly?: boolean | null;
	children_friendly?: boolean | null;
	coat?: Coat;
	coat_id?: string;
	color?: Color;
	color_id?: string;
	deceased?: boolean;
	description?: string;
	dogs_friendly?: boolean | null;
	gender?: Gender;
	gender_id?: number | string;
	identification?: Identification;
	name?: string;
	number?: Identification | string;
	sizerange?: SizeRange;
	sizerange_id?: number | string;
	specie?: Species;
	specie_id: number;
	status?: number | string;
	sterilized?: boolean;
}
