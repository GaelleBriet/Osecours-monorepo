import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import { AxiosResponse } from 'axios';
import { Color } from '@/Interfaces/Color.ts';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';

export const getColor = async (id: number): Promise<Color | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.get(
			`${import.meta.env.VITE_COLORS_API_URL}/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getColors = async (): Promise<Color[] | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.get(
			`${import.meta.env.VITE_COLORS_API_URL}/all`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createColor = async (
	name: string,
	description?: string,
): Promise<Color | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.post(
			`${import.meta.env.VITE_COLORS_API_URL}`,
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

export const updateColor = async (
	id: number,
	name: string,
	description?: string,
): Promise<Color | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.put(
			`${import.meta.env.VITE_COLORS_API_URL}/${id}`,
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

export const deleteColor = async (id: number): Promise<ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.delete(
			`${import.meta.env.VITE_COLORS_API_URL}${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getSpecificColors = async (
	species: string,
): Promise<Color[] | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.get(
			`${import.meta.env.VITE_COLORS_API_URL}/all?species=${species}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
