import axios from 'axios';

const axiosInstance = axios.create({
	baseURL: import.meta.env.VITE_API_URL,
});

axiosInstance.interceptors.request.use(
	(config) => {
		// Récupérer le token du stockage local
		const token = localStorage.getItem('token');

		// Formater le token pour supprimer les guillemets
		const formattedToken = token ? token.replace(/^"|"$/g, '') : '';

		// Si un token est disponible, l'inclure dans les en-têtes de toutes les requêtes
		if (formattedToken) {
			config.headers['Authorization'] = `Bearer ${formattedToken}`;
		}

		return config;
	},
	(error) => {
		return Promise.reject(error);
	},
);
axiosInstance.defaults.headers['Content-Type'] = 'application/json';

export default axiosInstance;
