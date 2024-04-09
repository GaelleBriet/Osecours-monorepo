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

export const useAnimalsSettingsStore = defineStore('animalsSettings', {
	state: (): {
		allSpecies: Species[];
		species: Species | null;
	} => ({
		allSpecies: [],
		species: null,
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
		async getAllSpecies(): Promise<Species[]> {
			const species: Species[] | ErrorResponse = await getAllSpecies();
			if ('error' in species) {
				return [];
			} else {
				this.allSpecies = species;
				return species;
			}
		},
		async createSpecies(
			name: string,
			description: string,
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
	},
});
