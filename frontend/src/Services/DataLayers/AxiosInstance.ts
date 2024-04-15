import axios from 'axios';

const axiosInstance = axios.create({
	baseURL: import.meta.env.VITE_API_URL,
});

// Récupérer le token du stockage local
const token = localStorage.getItem('token');

// Si un token est disponible, l'inclure dans les en-têtes de toutes les requêtes
if (token) {
	axiosInstance.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

export default axiosInstance;
