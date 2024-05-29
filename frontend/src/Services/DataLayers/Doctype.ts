import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import { AxiosResponse } from 'axios';
import { Doctypes } from '@/Interfaces/Documents/Doctypes.ts';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';

export const getOneDoctypes = async (
	id: number,
): Promise<Doctypes | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.get(
			`${import.meta.env.VITE_DOCTYPES_API_URL}/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getAllDoctypes = async (): Promise<Doctypes[] | ErrorResponse> => {
	try {
		const doctype: Doctypes[] = [
			{
				id: 1,
				name: 'healthRecords',
				description: 'This is the first example filetype.',
			},
			{
				id: 2,
				name: 'photos',
				description: 'This is the second example filetype.',
			},
			{
				id: 3,
				name: 'adoptionPapers',
				description: 'This is the third example filetype.',
			},
		];
		return doctype;

		// const response: AxiosResponse = await axiosInstance.get(
		// 	`${import.meta.env.VITE_DOCTYPES_API_URL}/all`,
		// );
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createDoctypes = async (
	name: string,
	description?: string,
): Promise<Doctypes | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.post(
			`${import.meta.env.VITE_DOCTYPES_API_URL}`,
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

export const updateDoctypes = async (
	id: number,
	name: string,
	description?: string,
): Promise<Doctypes | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.put(
			`${import.meta.env.VITE_DOCTYPES_API_URL}/${id}`,
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

export const deleteDoctypes = async (
	id: number,
): Promise<Doctypes | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.delete(
			`${import.meta.env.VITE_DOCTYPES_API_URL}/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
