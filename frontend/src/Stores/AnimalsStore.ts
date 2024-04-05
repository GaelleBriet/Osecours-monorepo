import { defineStore } from 'pinia';
import { Animal } from '@/Interfaces/Animal.ts';
import {
	createAnimal,
	getAnimalById,
	getAnimals,
	updateAnimal,
} from '@/Services/DataLayers/Animal.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';

export const useAnimalsStore = defineStore('animals', {
	state: (): {
		animals: Animal[];
		animal: Animal | null;
		dogs: Animal[];
		cats: Animal[];
	} => ({
		animals: [],
		dogs: [],
		cats: [],
		animal: null,
	}),
	getters: {
		getCurrentAnimal(): Animal | null {
			return this.animal;
		},
	},
	actions: {
		async getAnimal(id: number): Promise<Animal | null> {
			const animal: Animal | ErrorResponse = await getAnimalById(id);
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
		async getDogs(): Promise<Animal[]> {
			const animals: Animal[] | ErrorResponse = await getAnimals();
			if ('error' in animals) {
				return [];
			} else {
				const dogs: Animal[] = animals.filter(
					(animal: Animal) => animal.species === 1,
				);
				this.animals = dogs;
				return animals;
			}
		},
		async getCats(): Promise<Animal[]> {
			const animals: Animal[] | ErrorResponse = await getAnimals();
			if ('error' in animals) {
				return [];
			} else {
				const cats: Animal[] = animals.filter(
					(animal: Animal) => animal.species === 2,
				);
				this.animals = cats;
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
		async updateAnimal(animal: Animal): Promise<Animal | null> {
			const updatedAnimal = animal;
			return updatedAnimal;
			// @todo: Uncomment this code when the backend is ready
			// const updatedAnimal: Animal | ErrorResponse = await updateAnimal(animal);
			// if ('error' in updatedAnimal) {
			// 	return null;
			// } else {
			// 	this.animals.push(updatedAnimal);
			// 	return updatedAnimal;
			// }
		},
	},
});
