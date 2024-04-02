import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import axios, { AxiosResponse } from 'axios';
import { Color } from '@/Interfaces/Color.ts';

const API_URL: string = 'http://localhost:8000/api';

export const getColor = async (id: number): Promise<Color | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.get(`${API_URL}/colors/${id}`);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getColors = async (): Promise<Color[] | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.get(`${API_URL}/colors/all`);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createColor = async (
	name: string,
): Promise<Color | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.post(`${API_URL}/colors`, {
			name: name,
		});
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const updateColor = async (
	id: number,
	name: string,
): Promise<Color | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.put(`${API_URL}/colors/${id}`, {
			name: name,
		});
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const deleteColor = async (id: number): Promise<ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.delete(
			`${API_URL}/colors/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
