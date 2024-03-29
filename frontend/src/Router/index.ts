import { createRouter, createWebHistory } from 'vue-router';
import HomeViewController from '@/Controllers/HomeController.vue';
import LoginController from '@/Controllers/LoginController.vue';
import { getFromStorage } from '@/Services/Helpers/LocalStorage.ts';

const routes = [
	{
		path: '/',
		name: 'Home',
		component: HomeViewController,
	},
	{
		path: '/login',
		name: 'Login',
		component: LoginController,
		props: { default: true },
	},
	{
		path: '/:pathMatch(.*)*',
		redirect: '/login',
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes,
});

router.beforeEach((to) => {
	const token = getFromStorage('token');
	// const userLoggedIn = useUserStore().isLoggedIn;
	// const user = useUserStore().user;

	if (token !== null) {
		// si le token est présent on laisse passer
		return true;
	} else if (to.name !== 'Login') {
		// si le token est absent et que la route n'est pas Login
		// on redirige vers la page de login
		return { name: 'Login' };
	}
});

export default router;
