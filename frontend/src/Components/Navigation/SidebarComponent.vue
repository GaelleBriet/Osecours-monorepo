<script setup lang="ts">
	import {
		ArrowLeftStartOnRectangleIcon,
		ChevronRightIcon,
	} from '@heroicons/vue/24/outline';
	import { computed, ref } from 'vue';

	import { useUserStore } from '@/Stores/UserStore.ts';
	import { useRouter } from 'vue-router';

	import i18n from '@/Services/Translations/index.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { getFromStorage } from '@/Services/Helpers/LocalStorage.ts';

	const userStore = useUserStore();
	const router = useRouter();
	const route = router.currentRoute;
	const t = i18n.global.t;

	const currentActiveRoute = computed(() => {
		return (routePath: string) => route.value && route.value.path === routePath;
	});

	const subMenuOpen = ref(false);
	const dropdownOpen = ref(false);
	const associationName = userStore.user?.associationName;
	const userEmail = getFromStorage('email');

	const logout = () => {
		userStore.logoutUser();
	};

	const toggleSubMenu = () => {
		subMenuOpen.value = !subMenuOpen.value;
	};

	const toggleDropdown = () => {
		dropdownOpen.value = !dropdownOpen.value;
	};

	const navigation = [
		{
			name: getCapitalizedText(t('navigation.dashboard')),
			to: '/',
			icon: 'icon-chart-bar',
			count: '5',
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.organization')),
			to: '/organization',
			icon: 'icon-refuge',
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.shelters')),
			to: '/shelters',
			icon: 'icon-coeur-mains',
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.members')),
			to: '/members',
			icon: 'icon-user',
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.animals')),
			to: '/animals',
			icon: 'icon-animaux-domestiques',
			current: currentActiveRoute,
			subMenu: [
				{
					name: getCapitalizedText(t('navigation.dogs')),
					to: '/animals/dogs',
					icon: 'icon-chien',
					current: currentActiveRoute,
				},
				{
					name: getCapitalizedText(t('navigation.cats')),
					to: '/animals/cats',
					icon: 'icon-chat',
					current: currentActiveRoute,
				},
				{
					name: getCapitalizedText(t('navigation.animalsSettings')),
					to: '/animals/settings',
					icon: 'icon-reglages',
					current: currentActiveRoute,
				},
			],
		},
		{
			name: getCapitalizedText(t('navigation.documents')),
			to: '/documents',
			icon: 'icon-fiche',
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.families')),
			to: '/families',
			icon: 'icon-famille',
			current: currentActiveRoute,
		},
	];

	const openProfile = () => {
		router.push('/profile');
		dropdownOpen.value = false;
	};
</script>
<template>
	<div
		id="sidebar"
		class="fixed top-0 left-0 flex h-screen flex-col :sm:w-20 max-w-56 transition-width ease-in-out duration-1000"
	>
		<!--		class:fixed-->
		<div
			class="flex flex-1 grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 py-6"
		>
			<div class="flex h-16 shrink-0 items-center">
				<img
					class="h-20 w-auto mx-auto"
					src="@/Assets/Images/logo-osecours.svg"
					alt="O'Secours"
				/>
			</div>
			<nav class="flex flex-1 flex-col">
				<ul
					role="list"
					class="flex flex-1 flex-col gap-y-7"
				>
					<li>
						<ul
							role="list"
							class="-mx-2 space-y-1"
						>
							<li
								v-for="item in navigation"
								:key="item.name"
								class="flex flex-col"
							>
								<div
									class="flex items-center hover:bg-osecours-white rounded-md"
								>
									<router-link
										:to="item.to"
										:class="[
											currentActiveRoute(item.to)
												? 'text-osecours-beige-dark'
												: 'text-osecours-black hover:text-osecours-beige-dark ',
											'group flex gap-x-3 p-2 text-sm leading-6 font-normal items-center',
										]"
									>
										<i
											:class="[item.icon, 'text-osecours-beige-dark text-lg']"
										/>
										<span class="truncate hidden sm:block">
											{{ item.name }}
											<span
												v-if="item.count"
												class="ml-auto w-9 min-w-max whitespace-nowrap rounded-full bg-osecours-white px-2.5 py-0.5 text-center text-xs font-medium leading-5 text-osecours-beige-darkring-1 ring-inset ring-gray-200"
												aria-hidden="true"
												>{{ item.count }}</span
											>
										</span>
									</router-link>
									<!--			arrow icon for subMenus						-->
									<span
										class="ml-auto"
										v-if="item.subMenu"
									>
										<ChevronRightIcon
											:class="[
												subMenuOpen
													? 'rotate-90 text-gray-500'
													: 'text-gray-400',
												'ml-auto h-5 w-5 shrink-0 cursor-pointer',
											]"
											aria-hidden="true"
											@click="toggleSubMenu"
										/>
									</span>
								</div>
								<!--			subMenu					-->
								<ul
									v-if="subMenuOpen && item.subMenu"
									class="pl-4"
								>
									<li
										v-for="subItem in item.subMenu"
										:key="subItem.name"
									>
										<router-link
											:to="subItem.to"
											:class="[
												subItem.current
													? 'flex flex-row items-center ps-10 py-2 text-sm hover:bg-gray-50'
													: 'flex items-center ps-5 py-2 text-sm text-gray-600 hover:bg-gray-50',
											]"
										>
											<i
												:class="[
													subItem.icon,
													'text-osecours-pink text-lg hidden sm:block me-2',
												]"
											/>
											<!-- icon if small screens -->
											<div class="sm:hidden">
												<i
													:class="[
														subItem.icon,
														'text-osecours-pink text-lg -ml-10',
													]"
												></i>
											</div>
											<!-- else name -->
											<div class="hidden sm:block">
												{{ subItem.name }}
											</div>
										</router-link>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li class="relative -mx-3 mt-auto">
						<div
							v-tooltip="userEmail"
							href="#"
							class="flex items-center gap-x-4 px-2 py-3 leading-6 text-osecours-black hover:bg-osecours-white rounded-md cursor-pointer"
							@click.prevent="toggleDropdown"
						>
							<img
								class="h-8 w-8 rounded-full bg-gray-50"
								src="@/Assets/Images/logo-osecours.svg"
								alt="association-logo"
							/>
							<span
								aria-hidden="true"
								class="sm:block hidden text-osecours-black hover:text-osecours-beige-dark text-sm leading-6 font-normal"
								>{{ associationName }}</span
							>
						</div>

						<!--			dropdwon menu  hidden on small screens   -->
						<div
							v-if="dropdownOpen"
							class="dropdown_menu sm:block hidden absolute right-0 z-10 mt-2 w-40 origin-bottom-right rounded-md shadow-lg ring-1 ring-black ring-opacity-10 focus:outline-none"
							tabindex="-1"
							role="menu"
							aria-orientation="vertical"
							aria-labelledby="options-menu"
						>
							<div
								class="py-1"
								role="none"
							>
								<a
									href="#"
									class="block px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-100"
									role="menuitem"
									tabindex="-1"
									id="options-menu-item-0"
									@click="openProfile"
								>
									{{ getCapitalizedText(t('common.profile')) }}
								</a>
								<hr class="dropdown_menu__separator my-1 border-0 h-0.5" />
								<a
									href="#"
									class="block px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-100"
									role="menuitem"
									tabindex="-1"
									id="options-menu-item-2"
									@click="logout"
								>
									{{ getCapitalizedText(t('logout.title')) }}
								</a>
							</div>
						</div>
						<!--						icons visibles on small screens     -->
						<div
							v-if="dropdownOpen"
							class="absolute flex flex-col items-center justify-center"
							style="bottom: 100%; transform: translateY(-20%)"
						>
							<!-- Icone Profil -->
							<a
								href="#"
								class="block p-2 text-gray-700 hover:bg-gray-100 hover:rounded hover:text-osecours-beige-dark sm:hidden"
								role="menuitem"
								@click="openProfile"
							>
								<i class="icon-user text-xl"></i>
							</a>
							<!-- Icone Déconnexion -->
							<a
								href="#"
								class="block p-2 text-gray-700 hover:bg-gray-100 hover:rounded hover:text-osecours-beige-dark sm:hidden"
								role="menuitem"
								@click="logout"
							>
								<ArrowLeftStartOnRectangleIcon class="h-6 w-6" />
							</a>
						</div>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</template>

<style lang="postcss" scoped>
	ul {
		list-style-type: none;
	}

	#sidebar,
	.truncate {
		@media (max-width: 640px) {
			width: 5rem;
		}
	}

	.dropdown_menu {
		background-color: #f1f1f1;
		padding-left: 5px;
		padding-right: 5px;
		margin: auto;
		bottom: 100%;
		left: 0;
	}
	.dropdown_menu a:hover {
		color: #d99962;
	}
	.dropdown_menu__separator {
		background-color: var(--color-beige-light);
	}
</style>
