import axios from 'axios';
import { User, UserTokenScope } from '@/Interfaces/User.ts';

const API_URL: string = 'http://localhost:8000/api';

export const login = async (email: string, password: string): Promise<User> => {
	try {
		if (!email || !password)
			throw new Error('Email and password are required.');

		const {
			data: { data },
		} = await axios.post(`${API_URL}/login`, { email, password });

		return data;
	} catch (error) {
		console.error(error);
		throw error;
	}
};

export const loginWithAssociation = async (
	email: string,
	password: string,
	associationId: number,
): Promise<UserTokenScope> => {
	try {
		const {
			data: { data },
		} = await axios.post(`${API_URL}/token/create`, {
			email,
			password,
			associationId,
		});

		return data;
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

// export const getUsers = async (): Promise<User[]> => {
// 	try {
// 		// const response = await axios.get(API_URL);
// 		const response = {
// 			data: [
// 				{
// 					firstName: 'Alice',
// 					lastName: 'Doe',
// 					phone: '1234567890',
// 					existingCatCount: 1,
// 					existingChildrenCount: 2,
// 					existingDogCount: 0,
// 					email: 'alice@example.com',
// 				},
// 				{
// 					firstName: 'Bob',
// 					lastName: 'Doe',
// 					phone: '0987654321',
// 					existingCatCount: 0,
// 					existingChildrenCount: 1,
// 					existingDogCount: 1,
// 					email: 'bob@example.com',
// 				},
// 			],
// 		};
// 		return response.data;
// 	} catch (error) {
// 		console.error(error);
// 		throw error;
// 	}
// };
//
// export const createUser = async (userData: User): Promise<User> => {
// 	try {
// 		const response = await axios.post(API_URL, userData);
// 		return response.data;
// 	} catch (error) {
// 		console.error(error);
// 		throw error;
// 	}
// };
