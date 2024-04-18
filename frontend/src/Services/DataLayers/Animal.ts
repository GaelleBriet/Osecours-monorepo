import { Animal } from '@/Interfaces/Animals/Animal.ts';
import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import { AxiosResponse } from 'axios';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';
import { RouteParamValue } from 'vue-router';

export const getAnimalById = async (
	id: string | RouteParamValue[], // id: number,
): Promise<Animal | ErrorResponse> => {
	try {
		// const response = {
		// 	id: 1,
		// 	name: 'Bobby',
		// 	description: 'A very good friend',
		// 	birthdate: '2020-01-01',
		// 	catsFriendly: true,
		// 	dogsFriendly: true,
		// 	childrenFriendly: true,
		// 	ageRange: 3,
		// 	behavioralComment: 'Very friendly and playful',
		// 	sterilized: true,
		// 	deceased: false,
		// 	species: 1,
		// 	breed: 'Golden Retriever',
		// 	status: 2,
		// 	icad: '123456789123458',
		// 	gender: 2,
		// 	size: 1,
		// 	color: 'Golden',
		// 	coat: 'Long',
		// };
		// return response;
		const { data } = await axiosInstance.get(
			`${import.meta.env.VITE_ANIMALS_API_URL}/${id}`,
		);
		return data.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getAnimals = async (): Promise<Animal[] | ErrorResponse> => {
	try {
		// const animals: Animal[] = [
		// 	{
		// 		id: 1,
		// 		name: 'Bobby',
		// 		description: 'A very good friend',
		// 		birthdate: '2020-01-01',
		// 		catsFriendly: true,
		// 		dogsFriendly: true,
		// 		childrenFriendly: true,
		// 		ageRange: 3,
		// 		behavioralComment: 'Very friendly and playful',
		// 		sterilized: true,
		// 		deceased: false,
		// 		species: 2,
		// 		breed: 'Golden Retriever',
		// 		status: 1,
		// 		icad: '123456789123458',
		// 		gender: 1,
		// 		size: 3,
		// 		color: 'Golden',
		// 		coat: 'Long',
		// 	},
		// 	{
		// 		id: 2,
		// 		name: 'Spike',
		// 		description: 'He loves to play',
		// 		birthdate: '2018-04-28',
		// 		catsFriendly: false,
		// 		dogsFriendly: true,
		// 		childrenFriendly: true,
		// 		ageRange: 3,
		// 		behavioralComment: "Very friendly and playful, don't like cats",
		// 		sterilized: true,
		// 		deceased: false,
		// 		species: 2,
		// 		breed: 'Labrador',
		// 		status: 3,
		// 		icad: '254789654123584',
		// 		gender: 1,
		// 		size: 3,
		// 		color: 'Black',
		// 		coat: 'Short',
		// 	},
		// 	{
		// 		id: 3,
		// 		name: 'Puffy',
		// 		description: 'A very good friend',
		// 		birthdate: '2019-02-15',
		// 		catsFriendly: true,
		// 		dogsFriendly: true,
		// 		childrenFriendly: true,
		// 		ageRange: 4,
		// 		behavioralComment: 'Very friendly and playful',
		// 		sterilized: true,
		// 		deceased: false,
		// 		species: 1,
		// 		breed: 'Persian',
		// 		status: 3,
		// 		icad: '123456789123458',
		// 		gender: 2,
		// 		size: 2,
		// 		color: 'White',
		// 		coat: 'Long',
		// 	},
		// ];
		// return animals;
		// @todo: Uncomment this code when the backend is ready
		const { data } = await axiosInstance.get(
			`${import.meta.env.VITE_ANIMALS_API_URL}/all`,
		);
		return data.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createAnimal = async (
	animal: Animal,
): Promise<Animal | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.post(
			`${import.meta.env.VITE_ANIMALS_API_URL}`,
			animal,
		);
		console.log('response', response.data);
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
		const response: AxiosResponse = await axiosInstance.put(
			`${import.meta.env.VITE_ANIMALS_API_URL}/${animal.id}`,
			animal,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const deleteAnimal = async (
	id: string,
): Promise<Animal | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.delete(
			`${import.meta.env.VITE_ANIMALS_API_URL}/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
