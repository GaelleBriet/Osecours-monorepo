import axios from 'axios';

const axiosInstance = axios.create({
	baseURL: import.meta.env.VITE_API_URL,
	withCredentials: true,
	withXSRFToken: true,
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

		// // Récupérer la valeur du cookie XSRF-TOKEN
		// const xsrfToken = axios.defaults.xsrfCookieName ? axios.defaults.withCredentials && getCookie(axios.defaults.xsrfCookieName) : undefined;
		//
		// // Si un jeton CSRF est disponible, l'inclure dans l'en-tête X-XSRF-TOKEN de toutes les requêtes
		// if (xsrfToken) {
		// 	config.headers['X-XSRF-TOKEN'] = xsrfToken;
		// }

		return config;
	},
	(error) => {
		return Promise.reject(error);
	},
);
axiosInstance.defaults.headers['Content-Type'] = 'application/json';
axiosInstance.defaults.headers['Accept'] = 'application/json';
axiosInstance.defaults.headers['X-Requested-With'] = 'XMLHttpRequest';
axiosInstance.defaults.headers['Access-Control-Allow-Origin'] = 'https://www.osecours-asso.fr';

// // Fonction pour récupérer la valeur d'un cookie
// function getCookie(name) {
// 	const value = `; ${document.cookie}`;
// 	const parts = value.split(`; ${name}=`);
// 	if (parts.length === 2) return parts.pop().split(';').shift();
// }

export default axiosInstance;
