import { defineStore } from 'pinia';
import { Animal } from '@/Interfaces/Animal.ts';
import {
	createAnimal,
	deleteAnimal,
	getAnimalById,
	getAnimals,
} from '@/Services/DataLayers/Animal.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';
import { RouteParamValue } from 'vue-router';

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
		async getAnimal(id: string | RouteParamValue[]): Promise<Animal | null> {
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
			console.log('animals', animals);
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
					(animal: Animal) => animal.specie === 'Dog',
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
					(animal: Animal) => animal.specie === 'Cat',
				);
				this.animals = cats;
				return animals;
			}
		},
		async createAnimal(animal: Animal): Promise<Animal | null> {
			const animalToSend: Animal = this.initializeAnimalProperties(animal);
			console.log('animalToSend', animalToSend);
			const newAnimal: Animal | ErrorResponse =
				await createAnimal(animalToSend);
			if ('error' in newAnimal) {
				return null;
			} else {
				this.animals.push(newAnimal);
				return newAnimal;
			}
		},
		async deleteAnimal(id: string): Promise<boolean> {
			const animalToDelete: Animal | ErrorResponse = await deleteAnimal(id);
			if ('error' in animalToDelete) {
				return false;
			} else {
				this.animals = this.animals.filter(
					(animal: Animal) => animal.id !== id,
				);
				return true;
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
		initializeAnimalProperties(animal: Animal): Animal {
			return {
				...animal,
				name: animal.name || '',
				description: animal.description || '',
				birth_date: animal.birth_date ? new Date(animal.birth_date) : null,
				cats_friendly: animal.cats_friendly || null,
				dogs_friendly: animal.dogs_friendly || null,
				children_friendly: animal.children_friendly || null,
				// age: animal.age || null,
				behavioral_comment: animal.behavioral_comment || '',
				// icad: animal.icad || '',
				specie_id: animal.specie_id || undefined,
				gender_id: animal.gender_id || '', //gender_id
				color_id: animal.color_id || '', //color_id
				coat_id: animal.coat_id || '', //coat_id
				sizerange_id: animal.sizerange_id || '', //sizerange_id
				agerange_id: animal.agerange_id || '', //agerange_id
				breed_id: animal.breed_id || undefined,
				status: animal.status || '',
			};
		},
	},
});
