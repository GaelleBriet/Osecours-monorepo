import { Animal } from '@/Interfaces/Animals/Animal.ts';
import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import { AxiosResponse } from 'axios';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';
import { RouteParamValue } from 'vue-router';

export const getAnimalById = async (
	id: string | RouteParamValue[],
): Promise<Animal | ErrorResponse> => {
	try {
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
		console.log('response', response.data);
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
