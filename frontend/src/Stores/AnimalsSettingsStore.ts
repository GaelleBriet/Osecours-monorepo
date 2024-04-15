import { defineStore } from 'pinia';
import { Species } from '@/Interfaces/Species.ts';
import {
	createSpecies,
	deleteSpecies,
	getAllSpecies,
	getOneSpecies,
	updateSpecies,
} from '@/Services/DataLayers/Species.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';
import { Breed } from '@/Interfaces/Breed.ts';
import {
	createBreed,
	deleteBreed,
	getAllBreeds,
	getOneBreed,
	updateBreed,
} from '@/Services/DataLayers/Breed.ts';

export const useAnimalsSettingsStore = defineStore('animalsSettings', {
	state: (): {
		allSpecies: Species[];
		species: Species | null;
		breeds: Breed[];
		breed: Breed | null;
	} => ({
		allSpecies: [],
		species: null,
		breeds: [],
		breed: null,
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
	},
});
