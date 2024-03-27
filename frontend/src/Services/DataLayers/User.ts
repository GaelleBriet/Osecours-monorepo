import axios from 'axios';
import { User } from '@/Interfaces/User.ts';

const API_URL: string = 'https://localhost/api/user';

export const login = async (email: string, password: string): Promise<User> => {
	try {
		const response = await axios.post(`${API_URL}/login`, { email, password });
		return response.data;
	} catch (error) {
		console.error(error);
		throw error;
	}
};

export const getUser = async (id: number): Promise<User> => {
	try {
		const response = await axios.get(`${API_URL}/${id}`);
		return response.data;
	} catch (error) {
		console.error(error);
		throw error;
	}
};

export const getUsers = async (): Promise<User[]> => {
	try {
		const response = await axios.get(API_URL);
		return response.data;
	} catch (error) {
		console.error(error);
		throw error;
	}
};

export const createUser = async (userData: User): Promise<User> => {
	try {
		const response = await axios.post(API_URL, userData);
		return response.data;
	} catch (error) {
		console.error(error);
		throw error;
	}
};
