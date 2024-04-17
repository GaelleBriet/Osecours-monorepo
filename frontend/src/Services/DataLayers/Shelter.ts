import { Shelter } from '@/Interfaces/Shelter.ts';
import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import { AxiosResponse } from 'axios';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';

// const API_URL: string = 'http://localhost:8000/api';

export const getShelter = async () // id: number,
: Promise<Shelter | ErrorResponse> => {
	try {
		const response = {
			id: 1,
			name: 'Le refuge de Jade',
			siret: 'RC NANTES 234 987 456',
			description:
				'Pellentesque auctor neque nec urna. Curabitur at lacus ac velit ornare lobortis.',
			email: 'refugedeJade@jade.com',
			phone: '07 551 900 438',
		};
		return response;

		return response;
		// const response: AxiosResponse<Shelter> = await axiosInstance.get<Shelter>(
		// 	`${import.meta.env.VITE_SHELTERS_API_URL}/${id}`,
		// );
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getShelters = async (): Promise<Shelter[] | ErrorResponse> => {
	try {
		const shelters: Shelter[] = [
			{
				id: 1,
				name: 'Le refuge de Jade',
				siret: 'RC NANTES 234 987 456',
				description:
					'Pellentesque auctor neque nec urna. Curabitur at lacus ac velit ornare lobortis.',
				email: 'refugedeJade@jade.com',
				phone: '07 551 900 438',
			},
			{
				id: 2,
				name: "Chat d'oc Paris",
				siret: 'RC PARIS 234 987 456',
				description:
					'Duis leo. Curabitur at lacus ac velit ornare lobortis. Nam pretium turpis et arcu.',
				email: 'chatdocParis@chatdoc.com',
				phone: '07 223 272 118',
			},
			{
				id: 3,
				name: 'Solidarité Refuges',
				siret: 'RC MARSEILLE 234 987 456',
				description:
					'Praesent nec nisl a purus blandit viverra. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis lobortis massa imperdiet quam. Nam adipiscing.',
				email: 'solidariteRefuges@refuges.com',
				phone: '06 642 049 156',
			},
		];
		return shelters;
		// const response: AxiosResponse = await axiosInstance.get(`${import.meta.env.VITE_SHELTERS_API_URL}`);
		// return response.data;
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
