import { AxiosResponse } from 'axios';
import { User, UserTokenScope } from '@/Interfaces/User.ts';
import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';

export interface UserWithError extends User {
	error?: string;
}

export const login = async (
	email: string,
	password: string,
): Promise<User | ErrorResponse> => {
	try {
		const {
			data: { data },
		} = await axiosInstance.post(`${import.meta.env.VITE_LOGIN_API_URL}`, {
			email,
			password,
		});
		console.log(data);
		return data;
	} catch (error) {
		console.log(error);
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const loginWithAssociation = async (
	email: string,
	password: string,
	association_id: string,
): Promise<UserTokenScope | ErrorResponse> => {
	try {
		const { data } = await axiosInstance.post(
			`${import.meta.env.VITE_TOKEN_API_URL}`,
			{
				email,
				password,
				association_id,
			},
		);
		return data.data;
	} catch (error) {
		console.error(error);
		throw error;
	}
};

export const getUser = async (id: number): Promise<User | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.get(
			`${import.meta.env.VITE_USERS_API_URL}/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getUsers = async (): Promise<User[] | ErrorResponse> => {
	try {
		const users: AxiosResponse = await axiosInstance.get(
			`${import.meta.env.VITE_USERS_API_URL}`,
		);
		return users.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
