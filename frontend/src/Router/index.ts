import { createRouter, createWebHistory } from 'vue-router';
import HomeViewController from '@/Controllers/HomeController.vue';
import LoginController from '@/Controllers/LoginController.vue';
import { useUserStore } from '@/Stores/UserStore.ts';

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
	const userStore = useUserStore();
	if (to.name !== 'Login' && !userStore.isLoggedIn) {
		next({ name: 'Login' });
	} else {
		next();
	}
});

export default router;
