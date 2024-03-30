export interface AxiosError {
	response?: {
		status?: number;
	};
}

export interface ErrorResponse {
	error: string;
}
