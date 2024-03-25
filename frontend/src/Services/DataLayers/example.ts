// nommer le fichier avec le nom de la table
// ex: user.ts

import axios from 'axios';
import { User } from '@/Interfaces/example.ts';

const API_URL = 'https://api.example.com/users';

export const getUser = async (id: number) => {
	try {
		const response = await axios.get(`${API_URL}/${id}`);
		return response.data;
	} catch (error) {
		console.error(error);
	}
};

export const getUsers = async () => {
	try {
		const response = await axios.get(API_URL);
		return response.data;
	} catch (error) {
		console.error(error);
	}
};

export const createUser = async (userData: User) => {
	try {
		const response = await axios.post(API_URL, userData);
		return response.data;
	} catch (error) {
		console.error(error);
	}
};
