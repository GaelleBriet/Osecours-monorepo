import { createRouter, createWebHistory } from 'vue-router';
import { getFromStorage } from '@/Services/Helpers/LocalStorage.ts';
import HomeViewController from '@/Controllers/Dashboard/HomeController.vue';
import LoginController from '@/Controllers/Login/LoginController.vue';
import AnimalsController from '@/Controllers/Animals/Grids/AnimalsController.vue';
import DogsController from '@/Controllers/Animals/Grids/DogsController.vue';
import CatsController from '@/Controllers/Animals/Grids/CatsController.vue';
import AnimalsDetails from '@/Controllers/Animals/AnimalsDetailsController.vue';
import ShelterDetails from '@/Controllers/Shelters/ShelterDetails.vue';
import AssociationController from '@/Controllers/Association/AssociationController.vue';
import SheltersController from '@/Controllers/Shelters/SheltersController.vue';
import ProfileController from '@/Controllers/Profile/ProfileController.vue';
import FamiliesController from '@/Controllers/Families/FamiliesController.vue';
import CreateAnimal from '@/Views/Animals/CreateAnimal.vue';
import CreateAssociation from '@/Views/Association/CreateAssociation.vue';
import AssociationDetails from '@/Controllers/Association/AssociationDetails.vue';
import CreateShelters from '@/Views/Shelters/CreateShelter.vue';
import FamiliesDetails from '@/Views/Families/FamiliesDetails.vue';
import SettingsController from '@/Controllers/Animals/Grids/SettingsController.vue';
import DocumentsController from '@/Controllers/Documents/DocumentsController.vue';
import CreateDocument from '@/Views/Documents/CreateDocument.vue';
import DocumentsDetails from '@/Views/Documents/DocumentsDetails.vue';
import MembersController from '@/Controllers/Members/MembersController.vue';
import MembersDetails from '@/Views/Members/MembersDetails.vue';
import FamiliesCreateForm from '@/Views/Families/FamiliesCreateForm.vue';
import MembersCreateForm from '@/Views/Members/MembersCreateForm.vue';

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
	{
		path: '/animals',
		name: 'Animals',
		component: AnimalsController,
	},
	{
		path: '/animals/add',
		name: 'CreateAnimal',
		component: CreateAnimal,
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
		path: '/animals/settings',
		name: 'AnimalsSettings',
		component: SettingsController,
	},
	{
		path: '/organization',
		name: 'Organization',
		component: AssociationController,
	},
	{
		path: '/organization/:id',
		name: 'EditAssociation',
		component: AssociationDetails,
	},
	{
		path: '/organization/add',
		name: 'CreateAssociation',
		component: CreateAssociation,
	},
	{
		path: '/shelters',
		name: 'Shelters',
		component: SheltersController,
	},
	{
		path: '/shelters/add',
		name: 'CreateShelters',
		component: CreateShelters,
	},
	{
		path: '/shelters/:id',
		name: 'EditShelter',
		component: ShelterDetails,
	},
	{
		path: '/members',
		name: 'Members',
		component: MembersController,
	},
	{
		path: '/members/:id',
		name: 'EditMembers',
		component: MembersDetails,
	},
	{
		path: '/members/add/',
		name: 'AddMembers',
		component: MembersCreateForm,
	},
	{
		path: '/documents',
		name: 'Documents',
		component: DocumentsController,
	},
	{
		path: '/documents/add/',
		name: 'CreateDocument',
		component: CreateDocument,
	},
	{
		path: '/documents/:id',
		name: 'EditDocument',
		component: DocumentsDetails,
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
		path: '/families/add',
		name: 'CreateFamily',
		component: FamiliesCreateForm,
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
		return true;
	}
	if (to.name !== 'Login') {
		// si le token est absent et que la route n'est pas Login
		// on redirige vers la page de login
		return { name: 'Login' };
	}
});

export default router;
