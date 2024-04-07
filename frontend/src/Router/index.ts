import { createRouter, createWebHistory } from 'vue-router';
import HomeViewController from '@/Controllers/Dashboard/HomeController.vue';
import LoginController from '@/Controllers/Login/LoginController.vue';
import { getFromStorage } from '@/Services/Helpers/LocalStorage.ts';
import AnimalsController from '@/Controllers/Animals/AnimalsController.vue';
import DogsController from '@/Controllers/Animals/DogsController.vue';
import CatsController from '@/Controllers/Animals/CatsController.vue';
import AnimalsDetails from '@/Views/Animals/AnimalsDetails.vue';
import SheltersController from '@/Controllers/Shelters/SheltersController.vue';
import ProfileController from '@/Controllers/Profile/ProfileController.vue';
import FamiliesController from '@/Controllers/Families/FamiliesController.vue';
import FamiliesDetails from '@/Views/Families/FamiliesDetails.vue';

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
		path: '/animals/:id',
		name: 'EditAnimal',
		component: AnimalsDetails,
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
		component: SheltersController,
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
		path: '/families',
		name: 'Families',
		component: FamiliesController,
	},
	{
		path: '/families/:id',
		name: 'EditFamilies',
		component: FamiliesDetails,
	},
	{
		path: '/profile',
		name: 'Profile',
		component: ProfileController,
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
