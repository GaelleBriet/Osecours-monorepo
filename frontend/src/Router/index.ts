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
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes,
});

router.beforeEach((to, from, next) => {
	if (to.name !== 'Login' && getFromStorage('token') === null) {
		next({ name: 'Login' });
	} else {
		next();
	}
});

export default router;
