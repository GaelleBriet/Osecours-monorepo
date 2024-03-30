import { defineStore } from 'pinia';
import { Animal } from '@/Interfaces/Animal.ts';
import {
	createAnimal,
	getAnimal,
	getAnimals,
} from '@/Services/DataLayers/Animal.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';

export const useAnimalsStore = defineStore('animals', {
	state: (): {
		animals: Animal[];
		animal: Animal | null;
	} => ({
		animals: [],
		animal: null,
	}),
	getters: {
		getCurrentAnimal(): Animal | null {
			return this.animal;
		},
	},
	actions: {
		async getAnimal(id: number): Promise<Animal | null> {
			const animal: Animal | ErrorResponse = await getAnimal(id);
			if ('error' in animal) {
				return null;
			} else {
				this.animal = animal;
				return animal;
			}
		},
		async getAnimals(): Promise<Animal[]> {
			const animals: Animal[] | ErrorResponse = await getAnimals();
			if ('error' in animals) {
				return [];
			} else {
				this.animals = animals;
				return animals;
			}
		},
		async createAnimal(animal: Animal): Promise<Animal | null> {
			const newAnimal: Animal | ErrorResponse = await createAnimal(animal);
			if ('error' in newAnimal) {
				return null;
			} else {
				this.animals.push(newAnimal);
				return newAnimal;
			}
		},
	},
});
