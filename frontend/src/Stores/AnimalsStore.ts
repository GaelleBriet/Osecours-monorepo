import { defineStore } from 'pinia';
import {
	addAnimalHealth,
	createAnimal,
	deleteAnimal,
	getAnimalById,
	getAnimals,
	updateAnimal,
	vaccineAnimal,
} from '@/Services/DataLayers/Animal.ts';
import { Animal } from '@/Interfaces/Animals/Animal.ts';
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
		animalsQuantity(): number {
			return this.animals.length;
		},
		catsQuantity(): number {
			return this.cats.length;
		},
		dogsQuantity(): number {
			return this.dogs.length;
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
					(animal: Animal) => animal.specie_id === 2,
				);
				this.animals = dogs;
				this.dogs = dogs;
				return animals;
			}
		},
		async getCats(): Promise<Animal[]> {
			const animals: Animal[] | ErrorResponse = await getAnimals();
			if ('error' in animals) {
				return [];
			} else {
				const cats: Animal[] = animals.filter(
					(animal: Animal) => animal.specie_id === 1,
				);
				this.animals = cats;
				this.cats = cats;
				return animals;
			}
		},
		async createAnimal(animal: Animal): Promise<Animal | null> {
			const animalToSend: Animal =
				this.initializeCreatedAnimalProperties(animal);
			const newAnimal: Animal | ErrorResponse =
				await createAnimal(animalToSend);
			if ('error' in newAnimal) {
				return null;
			} else {
				this.animals.push(newAnimal);
				return newAnimal;
			}
		},
		async deleteAnimal(id: number | undefined): Promise<boolean> {
			const animalToDelete: Animal | ErrorResponse = await deleteAnimal(id);
			if ('error' in animalToDelete) {
				return false;
			} else {
				this.animals = this.animals.filter(
					(animal: Animal) => animal.id !== Number(id),
				);
				return true;
			}
		},
		async updateAnimal(animal: Animal): Promise<Animal | null> {
			const animalToSend: Animal =
				this.initializeUpdatedAnimalProperties(animal);
			const updatedAnimal: Animal | ErrorResponse =
				await updateAnimal(animalToSend);
			if ('error' in updatedAnimal) {
				return null;
			} else {
				this.animals.push(updatedAnimal);
				this.animal = updatedAnimal;
				return updatedAnimal;
			}
		},
		async vaccineAnimal(vaccineId: string, animalId: number): Promise<boolean> {
			const animalVaccine: Animal | ErrorResponse = await vaccineAnimal(
				vaccineId,
				animalId,
			);
			if (animalVaccine && 'error' in animalVaccine) {
				return false;
			} else {
				if (animalVaccine) {
					this.animal.vaccines = animalVaccine;
				}
				return true;
			}
		},
		async addAnimalHealth(animalHealthcare: object): Promise<boolean> {
			const animalHealth: Animal | ErrorResponse =
				await addAnimalHealth(animalHealthcare);
			if ('error' in animalHealth) {
				return false;
			} else {
				console.log('animalHealthStore', animalHealth);
				this.animal.healthcares.push(animalHealth);
				return true;
			}
		},
		initializeCreatedAnimalProperties(animal: Animal): Animal {
			return {
				...animal,
				name: animal.name || '',
				description: animal.description || '',
				birth_date: animal.birth_date ? new Date(animal.birth_date) : null,
				specie_id: animal.specie_id,
				gender_id: animal.gender_id || '',
				color_id: animal.color_id || '',
				coat_id: animal.coat_id || '',
				sizerange_id: animal.sizerange_id || '',
				agerange_id: animal.agerange_id || '',
				breed_id: animal.breed_id || undefined,
				number: animal.identification?.number
					? animal.identification.number
					: animal.identification,
			};
		},
		initializeUpdatedAnimalProperties(animal: Animal): Animal {
			return {
				...animal,
				name: animal.name || '',
				description: animal.description || '',
				birth_date: animal.birth_date ? new Date(animal.birth_date) : null,
				specie_id: animal.specie_id,
				gender_id: animal.gender_id || '',
				color_id: animal.color_id || '',
				coat_id: animal.coat_id || '',
				sizerange_id: animal.sizerange_id || '',
				agerange_id: animal.agerange_id || '',
				breed_id: animal.breed_id || undefined,
				number: animal.identification?.number
					? animal.identification.number
					: '',
				children_friendly: animal.children_friendly || null,
				dogs_friendly: animal.dogs_friendly || null,
				cats_friendly: animal.cats_friendly || null,
			};
		},
	},
});
