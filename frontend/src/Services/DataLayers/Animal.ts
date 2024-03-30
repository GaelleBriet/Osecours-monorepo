import { Animal } from '@/Interfaces/Animal.ts';
import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import axios, { AxiosResponse } from 'axios';

const API_URL: string = 'http://localhost:8000/api';

export const getAnimal = async (
	id: number,
): Promise<Animal | ErrorResponse> => {
	try {
		if (id === 1) {
			const animal: Animal = {
				id: 1,
				name: 'Bobby',
				description: 'A very good friend',
				birthdate: '2020-01-01',
				catsFriendly: true,
				dogsFriendly: true,
				childrenFriendly: true,
				age: 4,
				behavioralComment: 'Very friendly and playful',
				sterilized: true,
				deceased: false,
				species: 'Dog',
				breed: 'Golden Retriever',
				status: 'Adoptable',
				icad: '123456789123458',
			};
			return animal;
		} else if (id === 2) {
			const animal: Animal = {
				id: 2,
				name: 'Spike',
				description: 'He loves to play',
				birthdate: '2018-04-28',
				catsFriendly: false,
				dogsFriendly: true,
				childrenFriendly: true,
				age: 6,
				behavioralComment: "Very friendly and playful, don't like cats",
				sterilized: true,
				deceased: false,
				species: 'Dog',
				breed: 'Labrador',
				status: 'Adoptable',
				icad: '2547896541235845',
			};
			return animal;
		}
		return { error: 'Animal not found' };
		// const response: AxiosResponse = await axios.get(`${API_URL}/animals/${id}`);
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getAnimals = async (): Promise<Animal[] | ErrorResponse> => {
	try {
		const animals: Animal[] = [
			{
				id: 1,
				name: 'Bobby',
				description: 'A very good friend',
				birthdate: '2020-01-01',
				catsFriendly: true,
				dogsFriendly: true,
				childrenFriendly: true,
				age: 4,
				behavioralComment: 'Very friendly and playful',
				sterilized: true,
				deceased: false,
				species: 'Dog',
				breed: 'Golden Retriever',
				status: 'Adoptable',
				icad: '123456789123458',
			},
			{
				id: 2,
				name: 'Spike',
				description: 'He loves to play',
				birthdate: '2018-04-28',
				catsFriendly: false,
				dogsFriendly: true,
				childrenFriendly: true,
				age: 6,
				behavioralComment: "Very friendly and playful, don't like cats",
				sterilized: true,
				deceased: false,
				species: 'Dog',
				breed: 'Labrador',
				status: 'Adoptable',
				icad: '2547896541235845',
			},
		];
		return animals;
		// const response: AxiosResponse = await axios.get(`${API_URL}/animals`);
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createAnimal = async (
	animal: Animal,
): Promise<Animal | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.post(
			`${API_URL}/animals`,
			animal,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
