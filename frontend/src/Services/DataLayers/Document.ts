import { Document } from '@/Interfaces/Documents/Documents.ts';
import { AxiosResponse } from 'axios';
import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { RouteParamValue } from 'vue-router';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';

let currentAssociation;
const userItem = localStorage.getItem('user');
if (userItem) {
	currentAssociation = JSON.parse(userItem);
}
let associationId: number;
if (
	currentAssociation &&
	currentAssociation.associations &&
	currentAssociation.associations[0]
) {
	associationId = currentAssociation.associations[0].id;
}

const sendDocumentRequest = async (
	method: 'post' | 'put',
	url: string,
	document: Document,
): Promise<Document | ErrorResponse> => {
	try {
		// Create a new FormData object
		const formData = new FormData();

		// Append all fields from the document to the FormData object
		for (const key in document) {
			if (Object.prototype.hasOwnProperty.call(document, key)) {
				formData.append(key, (document as never)[key]);
			}
		}

		const headers = formData.get('file') === 'undefined' ? "application/json" : "multipart/form-data";

		// Make the request using Axios
		const response: AxiosResponse = await axiosInstance[method](url, formData, {
			headers: {
				'Content-Type': headers,
			},
		});

		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getDocument = async (
	id: string | RouteParamValue[],
): Promise<Document | ErrorResponse> => {
	try {
		const { data } = await axiosInstance.get(
			`${import.meta.env.VITE_DOCUMENTS_API_URL}/${id}`,
		);
		return data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

//TODO: GET BY SHELTER, NOT BY ASSO
export const getDocumentsByShelter = async (): Promise<
	Document[] | ErrorResponse
> => {
	try {
		// const documents: Document[] = [
		//     {
		// 		id: 1,
		//         filename: 'example1.txt',
		//         description: 'This is the first example file.',
		//         size: '10 KB',
		//         url: 'https://example.com/files/example1.txt',
		//         date: '2024-04-17',
		//         mimeType: '3',
		//         docType: '2',
		//     },
		//     {
		// 		id: 2,
		//         filename: 'example2.jpg',
		//         description: 'This is the second example file.',
		//         size: '500 KB',
		//         url: 'https://example.com/files/example2.jpg',
		//         date: '2024-04-17',
		//         mimeType: '3',
		//         docType: '2',
		//     },
		//     {
		// 		id: 3,
		//         filename: 'example3.pdf',
		//         description: 'This is the third example file.',
		//         size: '2 MB',
		//         url: 'https://example.com/files/example3.pdf',
		//         date: '2024-04-17',
		//         mimeType: '3',
		//         docType: '2',
		//     },
		// ];
		// return documents;

		const { data } = await axiosInstance.get(
			`${import.meta.env.VITE_DOCUMENTS_API_URL}/find/shelters/${associationId}`,
		);
		return data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getDocumentsByAnimal = async (
	id: string | RouteParamValue[],
): Promise<Document[] | ErrorResponse> => {
	try {
		const { data } = await axiosInstance.get(
			`${import.meta.env.VITE_DOCUMENTS_API_URL}/find/animals/${id}`,
		);
		return data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getDocumentsByHealthcare = async (
	id: string | RouteParamValue[],
): Promise<Document[] | ErrorResponse> => {
	try {
		const { data } = await axiosInstance.get(
			`${import.meta.env.VITE_DOCUMENTS_API_URL}/find/healthcares/${id}`,
		);
		return data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createDocument = async (
	document: Document,
): Promise<Document | ErrorResponse> => {
	const url = `${import.meta.env.VITE_DOCUMENTS_API_URL}`;
	return await sendDocumentRequest('post', url, document);
};

export const createDocumentForHealthCare = async (
	id: string | RouteParamValue[],
	document: Document,
): Promise<Document | ErrorResponse> => {
	const url = `${import.meta.env.VITE_DOCUMENTS_API_URL}/store/healthcares/${id}`;
	return await sendDocumentRequest('post', url, document);
};

export const createDocumentForAnimal = async (
	id: string | RouteParamValue[],
	document: Document,
): Promise<Document | ErrorResponse> => {
	const url = `${import.meta.env.VITE_DOCUMENTS_API_URL}/store/animals/${id}`;
	return await sendDocumentRequest('post', url, document);
};

export const createDocumentForShelter = async (
	id: string | RouteParamValue[],
	document: Document,
): Promise<Document | ErrorResponse> => {
	const url = `${import.meta.env.VITE_DOCUMENTS_API_URL}/store/shelters/${id}`;
	return await sendDocumentRequest('post', url, document);
};

export const updateDocument = async (
	id: string | RouteParamValue[],
	document: Document,
): Promise<Document | ErrorResponse> => {
	const url = `${import.meta.env.VITE_DOCUMENTS_API_URL}/${id}`;
	return await sendDocumentRequest('put', url, document);
};

export const deleteDocument = async (
	id: string,
): Promise<Document | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axiosInstance.delete(
			`${import.meta.env.VITE_DOCUMENTS_API_URL}/${id}`,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};
