import { Shelter } from '@/Interfaces/Shelter.ts';
import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import { AxiosResponse } from 'axios';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';
import { RouteParamValue } from 'vue-router';

export const getShelter = async (
	 id: string | RouteParamValue[],
): Promise<Shelter | ErrorResponse> => {
	try {
		const { data } = await axiosInstance.get(
			`${import.meta.env.VITE_SHELTERS_API_URL}/${id}`,
		);
		return data.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getShelters = async (): Promise<Shelter[] | ErrorResponse> => {
	try {
		const { data } = await axiosInstance.get(
			`${import.meta.env.VITE_SHELTERS_API_URL}/all`,
		);
		return data.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createShelter = async (
	shelter: Shelter,
): Promise<Shelter | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.post(
			`${import.meta.env.VITE_SHELTERS_API_URL}`,
			shelter,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const updateShelter = async (
	shelter: Shelter,
): Promise<Shelter | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.put(
			`${import.meta.env.VITE_SHELTERS_API_URL}/${shelter.id}`,
			shelter,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const deleteShelter = async (
	id: number,
): Promise<Shelter | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.delete(
			`${import.meta.env.VITE_SHELTERS_API_URL}/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
