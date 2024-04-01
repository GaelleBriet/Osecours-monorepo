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
				ageRange: 3,
				behavioralComment: 'Very friendly and playful',
				sterilized: true,
				deceased: false,
				species: 1,
				breed: 'Golden Retriever',
				status: 1,
				icad: '123456789123458',
				gender: 1,
				size: 3,
				color: 'Golden',
				coat: 'Long',
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
				ageRange: 3,
				behavioralComment: "Very friendly and playful, don't like cats",
				sterilized: true,
				deceased: false,
				species: 1,
				breed: 'Labrador',
				status: 3,
				icad: '254789654123584',
				gender: 1,
				size: 3,
				color: 'Black',
				coat: 'Short',
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
				ageRange: 3,
				behavioralComment: 'Very friendly and playful',
				sterilized: true,
				deceased: false,
				species: 1,
				breed: 'Golden Retriever',
				status: 1,
				icad: '123456789123458',
				gender: 1,
				size: 3,
				color: 'Golden',
				coat: 'Long',
			},
			{
				id: 2,
				name: 'Spike',
				description: 'He loves to play',
				birthdate: '2018-04-28',
				catsFriendly: false,
				dogsFriendly: true,
				childrenFriendly: true,
				ageRange: 3,
				behavioralComment: "Very friendly and playful, don't like cats",
				sterilized: true,
				deceased: false,
				species: 1,
				breed: 'Labrador',
				status: 3,
				icad: '254789654123584',
				gender: 1,
				size: 3,
				color: 'Black',
				coat: 'Short',
			},
			{
				id: 3,
				name: 'Puffy',
				description: 'A very good friend',
				birthdate: '2019-02-15',
				catsFriendly: true,
				dogsFriendly: true,
				childrenFriendly: true,
				ageRange: 4,
				behavioralComment: 'Very friendly and playful',
				sterilized: true,
				deceased: false,
				species: 2,
				breed: 'Persian',
				status: 3,
				icad: '123456789123458',
				gender: 2,
				size: 2,
				color: 'White',
				coat: 'Long',
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

export const updateAnimal = async (
	animal: Animal,
): Promise<Animal | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.put(
			`${API_URL}/animals/${animal.id}`,
			animal,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
