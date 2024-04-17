import { Association } from '@/Interfaces/Associations.ts';
import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import { AxiosResponse } from 'axios';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';

// const API_URL: string = 'http://localhost:8000/api';

export const getAssociation = async (): Promise<
	Association | ErrorResponse
> => {
	try {
		const association = {
			id: 1,
			name: 'SPA',
			siret: 'RC NANTES 234 987 456',
			rib: 'FR20 3000 4500 5500 6066 7077 899',
			request_status: 2,
			// shelters: []
		};
		return association;
		// const response: AxiosResponse = await axiosInstance.get(`${import.meta.env.VITE_ASSOCIATIONS_API_URL}/${id}`);
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getAssociations = async (): Promise<
	Association[] | ErrorResponse
> => {
	try {
		const associations: Association[] = [
			{
				id: 1,
				name: 'Fondation Assistance aux Animaux',
				siret: 'RC NANTES 234 987 456',
				rib: 'FR20 3000 4500 5500 6066 7077 899',
				request_status: 2,
				// shelters: []
			},
			{
				id: 2,
				name: 'Fondation Toby',
				siret: 'RC PARIS 234 987 456',
				rib: 'FR22 5000 4522 0099 5646 9877 123',
				request_status: 5,
				// shelters: []
			},
			{
				id: 3,
				name: 'Solidarité Refuges',
				siret: 'RC MARSEILLE 234 987 456',
				rib: 'FR24 8000 7633 8800 1212 8768 321',
				request_status: 3,
				// shelters: []
			},
		];
		return associations;
		// const response: AxiosResponse = await axiosInstance.get(`${import.meta.env.VITE_ASSOCIATIONS_API_URL}`);
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createAssociation = async (
	association: Association,
): Promise<Association | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.post(
			`${import.meta.env.VITE_ASSOCIATIONS_API_URL}`,
			association,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const updateAssociation = async (
	association: Association,
): Promise<Association | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.put(
			`${import.meta.env.VITE_ASSOCIATIONS_API_URL}/${association.id}`,
			association,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const deleteAssociation = async (
	id: number,
): Promise<Association | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.delete(
			`${import.meta.env.VITE_ASSOCIATIONS_API_URL}/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
