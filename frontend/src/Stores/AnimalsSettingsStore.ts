import { defineStore } from 'pinia';
import { Species } from '@/Interfaces/Animals/Species.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';
import { Breed } from '@/Interfaces/Animals/Breed.ts';
import { Coat } from '@/Interfaces/Animals/Coat.ts';
import { Color } from '@/Interfaces/Animals/Color.ts';
import { Gender } from '@/Interfaces/Animals/Gender.ts';
import {
	createSpecies,
	deleteSpecies,
	getAllSpecies,
	getOneSpecies,
	updateSpecies,
} from '@/Services/DataLayers/Species.ts';
import {
	createBreed,
	deleteBreed,
	getAllBreeds,
	getOneBreed,
	getSpecificBreeds,
	updateBreed,
} from '@/Services/DataLayers/Breed.ts';
import {
	createCoat,
	deleteCoat,
	getCoat,
	getCoats,
	updateCoat,
} from '@/Services/DataLayers/Coat.ts';
import {
	createColor,
	deleteColor,
	getColor,
	getColors,
	getSpecificColors,
	updateColor,
} from '@/Services/DataLayers/Color.ts';
import { getGenders } from '@/Services/DataLayers/Gender.ts';

export const useAnimalsSettingsStore = defineStore('animalsSettings', {
	state: (): {
		allSpecies: Species[];
		species: Species | null;
		breeds: Breed[];
		breed: Breed | null;
		coats: Coat[];
		coat: Coat | null;
		colors: Color[];
		color: Color | null;
		catsBreeds: Breed[];
		dogsBreeds: Breed[];
		catsColors: Color[];
		dogsColors: Color[];
		genders: Gender[];
	} => ({
		allSpecies: [],
		species: null,
		breeds: [],
		breed: null,
		coats: [],
		coat: null,
		colors: [],
		color: null,
		catsBreeds: [],
		dogsBreeds: [],
		catsColors: [],
		dogsColors: [],
		genders: [],
	}),
	getters: {
		getCurrentSpecies(): Species | null {
			return this.species;
		},
	},
	actions: {
		async getOneSpecies(id: number): Promise<Species | null> {
			const species: Species | ErrorResponse = await getOneSpecies(id);
			if ('error' in species) {
				return null;
			} else {
				this.species = species;
				return species;
			}
		},
		async getOneBreed(id: number): Promise<Breed | null> {
			const breed: Breed | ErrorResponse = await getOneBreed(id);
			if ('error' in breed) {
				return null;
			} else {
				this.breed = breed;
				return breed;
			}
		},
		async getOneCoat(id: number): Promise<Coat | null> {
			const coat: Coat | ErrorResponse = await getCoat(id);
			if ('error' in coat) {
				return null;
			} else {
				this.coat = coat;
				return coat;
			}
		},
		async getOneColor(id: number): Promise<Color | null> {
			const color: Color | ErrorResponse = await getColor(id);
			if ('error' in color) {
				return null;
			} else {
				this.color = color;
				return color;
			}
		},
		async getAllSpecies(): Promise<Species[]> {
			const species: Species[] | ErrorResponse = await getAllSpecies();
			if ('error' in species) {
				return [];
			} else {
				this.allSpecies = species;
				return species;
			}
		},
		async getAllBreeds(): Promise<Breed[]> {
			const breeds: Breed[] | ErrorResponse = await getAllBreeds();
			if ('error' in breeds) {
				return [];
			} else {
				this.breeds = breeds;
				return breeds;
			}
		},
		async getAllCoats(): Promise<Coat[]> {
			const coats: Coat[] | ErrorResponse = await getCoats();
			if ('error' in coats) {
				return [];
			} else {
				this.coats = coats;
				return coats;
			}
		},
		async getAllColors(): Promise<Color[]> {
			const colors: Color[] | ErrorResponse = await getColors();
			if ('error' in colors) {
				return [];
			} else {
				this.colors = colors;
				return colors;
			}
		},
		async getAllGenders(): Promise<Gender[]> {
			const genders: Gender[] | ErrorResponse = await getGenders();
			if ('error' in genders) {
				return [];
			} else {
				this.genders = genders;
				return genders;
			}
		},
		async createSpecies(
			name: string,
			description?: string,
		): Promise<Species | null> {
			const species: Species | ErrorResponse = await createSpecies(
				name,
				description,
			);
			if ('error' in species) {
				return null;
			} else {
				this.species = species;
				return species;
			}
		},
		async createBreed(
			name: string,
			description?: string,
		): Promise<Breed | null> {
			const breed: Breed | ErrorResponse = await createBreed(name, description);
			if ('error' in breed) {
				return null;
			} else {
				this.breeds.push(breed);
				this.breed = breed;
				return breed;
			}
		},
		async createCoat(name: string, description?: string): Promise<Coat | null> {
			const coat: Coat | ErrorResponse = await createCoat(name, description);
			if ('error' in coat) {
				return null;
			} else {
				this.coats.push(coat);
				this.coat = coat;
				return coat;
			}
		},
		async createColor(
			name: string,
			description?: string,
		): Promise<Color | null> {
			const color: Color | ErrorResponse = await createColor(name, description);
			if ('error' in color) {
				return null;
			} else {
				this.colors.push(color);
				this.color = color;
				return color;
			}
		},
		async updateSpecies(
			id: number,
			name: string,
			description?: string,
		): Promise<Species | null> {
			const species: Species | ErrorResponse = await updateSpecies(
				id,
				name,
				description,
			);
			if ('error' in species) {
				return null;
			} else {
				this.species = species;
				return species;
			}
		},
		async updateBreed(
			id: number,
			name: string,
			description?: string,
		): Promise<Breed | null> {
			const breed: Breed | ErrorResponse = await updateBreed(
				id,
				name,
				description,
			);
			if ('error' in breed) {
				return null;
			} else {
				this.breed = breed;
				return breed;
			}
		},
		async updateCoat(
			id: number,
			name: string,
			description?: string,
		): Promise<Coat | null> {
			const coat: Coat | ErrorResponse = await updateCoat(
				id,
				name,
				description,
			);
			if ('error' in coat) {
				return null;
			} else {
				this.coat = coat;
				return coat;
			}
		},
		async updateColor(
			id: number,
			name: string,
			description?: string,
		): Promise<Color | null> {
			const color: Color | ErrorResponse = await updateColor(
				id,
				name,
				description,
			);
			if ('error' in color) {
				return null;
			} else {
				this.color = color;
				return color;
			}
		},
		async deleteSpecies(id: number): Promise<boolean> {
			const deletedSpecies: Species | ErrorResponse = await deleteSpecies(id);
			if ('error' in deletedSpecies) {
				return false;
			} else {
				// on rafraichit la liste des especes pour qu'elle ne contienne plus l'espece supprimee
				this.allSpecies = this.allSpecies.filter(
					(species: Species) => species.id !== id,
				);
				return true;
			}
		},
		async deleteBreed(id: number): Promise<boolean> {
			const deletedBreed: Breed | ErrorResponse = await deleteBreed(id);
			if ('error' in deletedBreed) {
				return false;
			} else {
				this.breeds = this.breeds.filter((breeds: Breed) => breeds.id !== id);
				return true;
			}
		},
		async deleteCoat(id: number): Promise<boolean> {
			const deletedCoat: Coat | ErrorResponse = await deleteCoat(id);
			if ('error' in deletedCoat) {
				return false;
			} else {
				this.coats = this.coats.filter((coats: Coat) => coats.id !== id);
				return true;
			}
		},
		async deleteColor(id: number): Promise<boolean> {
			const deletedColor: Color | ErrorResponse = await deleteColor(id);
			if ('error' in deletedColor) {
				return false;
			} else {
				this.colors = this.colors.filter((colors: Color) => colors.id !== id);
				return true;
			}
		},
		async getSpecificBreeds(species: string): Promise<Breed[]> {
			const breeds: Breed[] | ErrorResponse = await getSpecificBreeds(species);
			if ('error' in breeds) {
				return [];
			} else {
				if (species === 'dog') {
					this.dogsBreeds = breeds;
				}
				if (species === 'cat') {
					this.catsBreeds = breeds;
				}
				return breeds;
			}
		},
		async getSpecificColors(species: string): Promise<Breed[]> {
			const colors: Color[] | ErrorResponse = await getSpecificColors(species);
			if ('error' in colors) {
				return [];
			} else {
				if (species === 'dog') {
					this.dogsColors = colors;
				}
				if (species === 'cat') {
					this.catsColors = colors;
				}
				return colors;
			}
		},
	},
});
