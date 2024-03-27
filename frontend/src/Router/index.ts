import { createRouter, createWebHistory } from 'vue-router';
import HomeViewController from '@/Controllers/HomeViewController.vue';

const routes = [
	{
		path: '/',
		name: 'Home',
		component: HomeViewController,
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes,
});

export default router;
