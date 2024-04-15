import { AxiosError, ErrorResponse } from '@/Interfaces/Requests.ts';

export const errorResponse = (error: AxiosError): ErrorResponse => {
	if (error.response) {
		switch (error.response.status) {
			case 400:
				return { error: 'Bad request.' };
			case 401:
				return { error: 'Unauthorized.' };
			case 500:
			default:
				return { error: 'Internal server error.' };
		}
	}
	return { error: 'Unknown error' };
};
