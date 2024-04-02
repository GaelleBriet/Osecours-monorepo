import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import axios, { AxiosResponse } from 'axios';
import { Species } from '@/Interfaces/Species.ts';

const API_URL: string = 'http://localhost:8000/api';

export const getOneSpecies = async (
	id: number,
): Promise<Species | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.get(`${API_URL}/species/${id}`);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getAllSpecies = async (): Promise<Species[] | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.get(`${API_URL}/species/all`);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createSpecies = async (
	name: string,
	description: string,
): Promise<Species | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.post(`${API_URL}/species`, {
			name: name,
			description: description,
		});
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const updateSpecies = async (
	id: number,
	name: string,
	description: string,
): Promise<Species | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.put(
			`${API_URL}/species/${id}`,
			{
				name: name,
				description: description,
			},
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const deleteSpecies = async (
	id: number,
): Promise<Species | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.delete(
			`${API_URL}/species/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
