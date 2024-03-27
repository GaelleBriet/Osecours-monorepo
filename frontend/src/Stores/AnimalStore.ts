import { defineStore } from 'pinia';

export const useAnimalStore = defineStore('animal', {
	state: (): { animals: string[] } => ({
		animals: [],
	}),
	getters: {
		totalAnimals(): number {
			return this.animals.length;
		},
	},
	actions: {
		async fetchAnimals() {
			this.animals = ['Dog', 'Cat', 'Bird'];
		},
	},
});
