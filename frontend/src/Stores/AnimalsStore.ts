import { defineStore } from 'pinia';
import { Animal } from '@/Interfaces/Animal.ts';
import {
	createAnimal,
	getAnimalById,
	getAnimals,
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
			const animalToSend: Animal = this.initializeAnimalProperties(animal);
			console.log(animalToSend);
			const newAnimal: Animal | ErrorResponse =
				await createAnimal(animalToSend);
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
		initializeAnimalProperties(animal: Animal): Animal {
			console.log(animal);
			return {
				...animal,
				name: animal.name || '',
				description: animal.description || '',
				birth_date: animal.birthdate ? new Date(animal.birthdate) : null,
				cats_friendly: animal.catsFriendly || null,
				dogs_friendly: animal.dogsFriendly || null,
				children_friendly: animal.childrenFriendly || null,
				// age: animal.age || null,
				behavioral_comment: animal.behavioralComment || '',
				// icad: animal.icad || '',
				specie_id: animal.specie_id || undefined,
				gender: animal.gender || '', //gender_id
				color: animal.color || '', //color_id
				coat: animal.coat || '', //coat_id
				size: animal.size || '', //sizerange_id
				ageRange: animal.ageRange || '', //agerange_id
				breed: animal.breed || '',
				status: animal.status || '',
			};
		},
	},
});
