import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import axios, { AxiosResponse } from 'axios';
import { Coat } from '@/Interfaces/Coat.ts';

const API_URL: string = 'http://localhost:8000/api';

export const getCoat = async (id: number): Promise<Coat | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.get(`${API_URL}/coats/${id}`);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getCoats = async (): Promise<Coat[] | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.get(`${API_URL}/coats/all`);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createCoat = async (
	name: string,
): Promise<Coat | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.post(`${API_URL}/coats`, {
			name: name,
		});
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const updateCoat = async (
	id: number,
	name: string,
): Promise<Coat | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.put(`${API_URL}/coats/${id}`, {
			name: name,
		});
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const deleteCoat = async (id: number): Promise<ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.delete(
			`${API_URL}/coats/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
