import { Document } from '@/Interfaces/Documents';
import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';
import { errorResponse } from '@/Services/Requests/RequestsResponses.ts';
import axios, { AxiosResponse } from 'axios';
import axiosInstance from '@/Services/DataLayers/AxiosInstance.ts';


export const getDocument = async () //id: number,
: Promise<Document | ErrorResponse> => {
	try {
			const response = {
				id: 1,
                filename: 'example1.txt',
                description: 'This is the first example file.',
                size: '10 KB',
                url: 'https://example.com/files/example1.txt',
                date: '2024-04-17',
                mimeType: '3',
                docType: '2'
            };
			return response;
		
		// const response: AxiosResponse<Document> = await axiosInstance.get<Document>(
		// 	`${import.meta.env.VITE_DOCUMENTS_API_URL}/${id}`,
		// );
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const getDocuments = async (): Promise<Document[] | ErrorResponse> => {
	try {
		const documents: Document[] = [
            {
				id: 1,
                filename: 'example1.txt',
                description: 'This is the first example file.',
                size: '10 KB',
                url: 'https://example.com/files/example1.txt',
                date: '2024-04-17',
                mimeType: '3',
                docType: '2',
            },
            {
				id: 2,
                filename: 'example2.jpg',
                description: 'This is the second example file.',
                size: '500 KB',
                url: 'https://example.com/files/example2.jpg',
                date: '2024-04-17',
                mimeType: '3',
                docType: '2',
            },
            {
				id: 3,
                filename: 'example3.pdf',
                description: 'This is the third example file.',
                size: '2 MB',
                url: 'https://example.com/files/example3.pdf',
                date: '2024-04-17',
                mimeType: '3',
                docType: '2',
            },
        ];
		return documents;
		// const response: AxiosResponse = await axiosInstance.get(`${import.meta.env.VITE_DOCUMENTS_API_URL}`);
		// return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const createDocument = async (
	document: Document,
): Promise<Document | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.post(
			`${import.meta.env.VITE_DOCUMENTS_API_URL}`,
			document,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const updateDocument = async (
	document: Document,
): Promise<Document | ErrorResponse> => {
	try {
		const response: AxiosResponse = await axios.put(
			`${import.meta.env.VITE_DOCUMENTS_API_URL}/${document.id}`,
			document,
		);
		return response.data;
	} catch (error) {
		const axiosError: AxiosError = error as AxiosError;
		return errorResponse(axiosError);
	}
};

export const deleteDocument = async (
	id: number,
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