import { Association } from '@/Interfaces/Associations.ts';
import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import axios, { AxiosResponse } from 'axios';

const API_URL: string = 'http://localhost:8000/api';

export const getAssociation = async (
	id: number,
): Promise<Association | ErrorResponse> => {
	try {
		if (id === 1) {
			const association: Association = {
				id: 1,
				name: 'SPA',
				siret: 'RC NANTES 234 987 456',
                rib: 'FR20 3000 4500 5500 6066 7077 899',
                request_status: 2,
                // shelters: []
			};
			return association;
		} else if (id === 2) {
			const association: Association = {
				id: 2,
				name: 'Fondation Assistance aux Animaux',
				siret: 'RC NANTES 234 987 456',
                rib: 'FR20 3000 4500 5500 6066 7077 899',
                request_status: 5,
                // shelters: []
			};
			return association;
		}
		return { error: 'Association not found' };
		// const response: AxiosResponse = await axios.get(`${API_URL}/associations/${id}`);
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getAssociations = async (): Promise<Association[] | ErrorResponse> => {
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
				name: 'Fondation Assistance aux Animaux',
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
                request_status: 5,
                // shelters: []
			},
		];
		return associations;
		// const response: AxiosResponse = await axios.get(`${API_URL}/associations`);
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
		const response: AxiosResponse = await axios.post(
			`${API_URL}/associations`,
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
		const response: AxiosResponse = await axios.put(
			`${API_URL}/associations/${association.id}`,
			association,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
