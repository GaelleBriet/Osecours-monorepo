import { createRouter, createWebHistory } from 'vue-router';
import HelloWorld from '@/Views/HelloWorldView.vue';
import Home from '@/Views/HomeView.vue';

const routes = [
	{
		path: '/',
		name: 'Home',
		component: Home,
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
