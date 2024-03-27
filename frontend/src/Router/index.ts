import { createRouter, createWebHistory } from 'vue-router';
import HelloWorld from '@/Views/HelloWorldView.vue';
import HomeViewController from '@/Controllers/HomeViewController.vue';

const routes = [
	{
		path: '/',
		name: 'Home',
		component: HomeViewController,
	},
	{
		path: '/hello-world',
		name: 'HelloWorld',
		component: HelloWorld,
		props: true,
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes,
});

export default router;
