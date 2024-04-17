import { defineStore } from 'pinia';
import { Shelter } from '@/Interfaces/Shelters.ts';
import {
	createShelter,
	getShelter,
	getShelters,
	updateShelter,
	deleteShelter,
} from '@/Services/DataLayers/Shelter.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';

export const useSheltersStore = defineStore('shelters', {
	state: (): {
		shelters: Shelter[];
		shelter: Shelter | null;
	} => ({
		shelters: [],
		shelter: null,
	}),
	getters: {
		getCurrentShelter(): Shelter | null {
			return this.shelter;
		},
	},
	actions: {
		async getShelter(id: number): Promise<Shelter | null> {
			const shelter: Shelter | ErrorResponse = await getShelter(id);
			if ('error' in shelter) {
				return null;
			} else {
				this.shelter = shelter;
				return shelter;
			}
		},
		async getShelters(): Promise<Shelter[]> {
			const shelters: Shelter[] | ErrorResponse = await getShelters();
			if ('error' in shelters) {
				return [];
			} else {
				this.shelters = shelters;
				return shelters;
			}
		},
		async createShelter(shelter: Shelter): Promise<Shelter | null> {
			const newShelter: Shelter | ErrorResponse = await createShelter(shelter);
			if ('error' in newShelter) {
				return null;
			} else {
				this.shelters.push(newShelter);
				return newShelter;
			}
		},
		async updateShelter(shelter: Shelter): Promise<Shelter | null> {
			const updatedShelter: Shelter | ErrorResponse =
				await updateShelter(shelter);
			if ('error' in updatedShelter) {
				return null;
			} else {
				this.shelters.push(updatedShelter);
				return updatedShelter;
			}
		},
	},
});
