import { createRouter, createWebHistory } from 'vue-router';
import HomeViewController from '@/Controllers/HomeController.vue';
import LoginController from '@/Controllers/LoginController.vue';
import { getFromStorage } from '@/Services/Helpers/LocalStorage.ts';
import AnimalsController from '@/Controllers/AnimalsController.vue';
import DogsController from '@/Controllers/DogsController.vue';
import CatsController from '@/Controllers/CatsController.vue';

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
		// props: { default: true },
	},
	{
		path: '/animals',
		name: 'Animals',
		component: AnimalsController,
	},
	{
		path: '/animals/cats',
		name: 'Cats',
		component: CatsController,
	},
	{
		path: '/animals/dogs',
		name: 'Dogs',
		component: DogsController,
	},
	{
		path: '/organization',
		name: 'Organization',
		component: HomeViewController,
	},
	{
		path: '/shelters',
		name: 'Shelters',
		component: HomeViewController,
	},
	{
		path: '/members',
		name: 'Members',
		component: HomeViewController,
	},
	{
		path: '/documents',
		name: 'Documents',
		component: HomeViewController,
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
		console.log('1- token is present');
		return true;
	}
	if (to.name !== 'Login') {
		// si le token est absent et que la route n'est pas Login
		// on redirige vers la page de login
		console.log('2- token is not present');
		return { name: 'Login' };
	}
});

export default router;
