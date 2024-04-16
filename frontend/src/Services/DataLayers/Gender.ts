import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import { AxiosResponse } from 'axios';
import { Gender } from '@/Interfaces/Gender.ts';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';

export const getGender = async (
	id: number,
): Promise<Gender | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.get(
			`${import.meta.env.VITE_GENDERS_API}/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getGenders = async (): Promise<Gender[] | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.get(
			`${import.meta.env.VITE_GENDERS_API}/all`,
		);
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
		const response: AxiosResponse = await axiosInstance.post(
			`${import.meta.env.VITE_GENDERS_API}`,
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

export const updateGender = async (
	id: number,
	name: string,
): Promise<Gender | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.put(
			`${import.meta.env.VITE_GENDERS_API}/${id}`,
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
		const response: AxiosResponse = await axiosInstance.delete(
			`${import.meta.env.VITE_GENDERS_API}/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
