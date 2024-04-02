import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import axios, { AxiosResponse } from 'axios';
import { Gender } from '@/Interfaces/Gender.ts';

const API_URL: string = 'http://localhost:8000/api';

export const getGender = async (
	id: number,
): Promise<Gender | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.get(`${API_URL}/gender/${id}`);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getGenders = async (): Promise<Gender | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.get(`${API_URL}/genders/all`);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createGender = async (
	name: string,
): Promise<Gender | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.post(`${API_URL}/genders`, {
			name: name,
		});
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const updateGender = async (
	id: number,
	name: string,
): Promise<Gender | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.put(
			`${API_URL}/
		}genders/${id}`,
			{
				name: name,
			},
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const deleteGender = async (id: number): Promise<ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.delete(
			`${API_URL}/genders/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
