import { User } from '@/Interfaces/User.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';
import { AxiosError, AxiosResponse } from 'axios';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';
// import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';

export const getMemberById = async () // id: string,
: Promise<Partial<User> | ErrorResponse> => {
	try {
		const response = {
			id: 1,
			firstName: 'John',
			lastName: 'Doe',
			email: 'john.doe@mail.fr',
			phone: '0612345678',
			existingCatCount: 0,
			existingDogCount: 0,
			existingChildrenCount: 0,
			adoptFamily: false,
			fosterFamily: true,
		};
		return response;
		// const response: AxiosResponse<User> = await axiosInstance.get<User>(
		// 	`${import.meta.env.VITE_USERS_API_URL}/${id}`,
		// );
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getMembers = async (
	associationId: string,
): Promise<User[] | ErrorResponse> => {
	try {
		// const members: User[] = [
		// 	{
		// 		id: 1,
		// 		firstName: 'John',
		// 		lastName: 'Doe',
		// 		email: 'john.doe@mail.fr',
		// 		phone: '0612345678',
		// 		existingCatCount: 0,
		// 		existingDogCount: 0,
		// 		existingChildrenCount: 0,
		// 		adoptFamily: false,
		// 		fosterFamily: true,
		// 	},
		// 	{
		// 		id: 2,
		// 		firstName: 'Jane',
		// 		lastName: 'Doe',
		// 		email: 'jane.doa@mail.fr',
		// 		phone: '0612345678',
		// 		existingCatCount: 0,
		// 		existingDogCount: 1,
		// 		existingChildrenCount: 0,
		// 		adoptFamily: true,
		// 		fosterFamily: false,
		// 	},
		// ];
		// return members;
		const { data }: AxiosResponse = await axiosInstance.get(
			`${import.meta.env.VITE_ASSOCIATION_USERS_API_URL.replace('{id}', associationId.toString())}`,
		);
		return data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getMembersByFamilyType = async (
	familyType: string,
	currentAssociationId: string,
): Promise<User[] | ErrorResponse> => {
	try {
		// const members: User[] = [
		// 	{
		// 		id: 1,
		// 		firstName: 'John',
		// 		lastName: 'Doe',
		// 		email: 'john.doe@mail.fr',
		// 		phone: '0612345678',
		// 		existingCatCount: 0,
		// 		existingDogCount: 0,
		// 		existingChildrenCount: 0,
		// 		adoptFamily: false,
		// 		fosterFamily: true,
		// 	},
		// 	{
		// 		id: 2,
		// 		firstName: 'Jane',
		// 		lastName: 'Doe',
		// 		email: 'jane.doa@mail.fr',
		// 		phone: '0612345678',
		// 		existingCatCount: 0,
		// 		existingDogCount: 1,
		// 		existingChildrenCount: 0,
		// 		adoptFamily: true,
		// 		fosterFamily: false,
		// 	},
		// ];
		// return members.filter((member: User) => {
		// 	if (familyType === 'foster') {
		// 		return member.fosterFamily;
		// 	} else if (familyType === 'adopt') {
		// 		return member.adoptFamily;
		// 	}
		// });
		const { data } = await axiosInstance.get(
			`${import.meta.env.VITE_USERS_ROLE_API_URL}`,
			{
				params: {
					role: familyType,
					currentAssociationId: currentAssociationId,
				},
			},
		);
		return data.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createMember = async () // member: User,
: Promise<User | ErrorResponse> => {
	try {
		const response: User = {
			id: 3,
			firstName: 'Jack',
			lastName: 'Doe',
			email: 'jack.doe@mail.fr',
			phone: '0612345678',
			existingCatCount: 0,
			existingDogCount: 0,
			existingChildrenCount: 0,
			adoptFamily: false,
			fosterFamily: true,
		};
		return response;
		// const response: AxiosResponse<User> = await axiosInstance.post<User>(
		// 	`${import.meta.env.VITE_USERS_API_URL}`,
		// 	member,
		// );
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const updateMember = async () // member: User,
: Promise<User | ErrorResponse> => {
	try {
		const response: User = {
			id: 3,
			firstName: 'Jack',
			lastName: 'Doe',
			email: 'jack.doe@mail.fr',
			phone: '0612345678',
			existingCatCount: 0,
			existingDogCount: 0,
			existingChildrenCount: 0,
			adoptFamily: false,
			fosterFamily: true,
		};
		return response;
		// const response: AxiosResponse<User> = await axiosInstance.put<User>(
		// 	`${import.meta.env.VITE_USERS_API_URL}/${member.id}`,
		// 	member,
		// );
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const deleteMember = async () // id: string
: Promise<boolean> => {
	try {
		const response: boolean = true;
		return response;
		// const response: AxiosResponse<boolean> = await axiosInstance.delete<boolean>(
		// 	`${import.meta.env.VITE_USERS_API_URL}/${id}`,
		// );
		// return response.data;
	} catch (error) {
		// const axiosError: AxiosError = error as AxiosError;
		return false;
	}
};
