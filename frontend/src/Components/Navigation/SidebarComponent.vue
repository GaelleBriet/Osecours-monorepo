<script setup lang="ts">
	import {
		ChartPieIcon,
		DocumentDuplicateIcon,
		UsersIcon,
		UserIcon,
		ArrowLeftStartOnRectangleIcon,
		ClipboardIcon,
		BuildingStorefrontIcon,
		HeartIcon,
	} from '@heroicons/vue/24/outline';

	import { useUserStore } from '@/Stores/UserStore.ts';
	import { useRouter } from 'vue-router';

	import { computed, ref } from 'vue';

	import i18n from '@/Services/Translations/index.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const userStore = useUserStore();
	const router = useRouter();
	const route = router.currentRoute;
	const t = i18n.global.t;

	const currentActiveRoute = computed(() => {
		return (routePath: string) => route.value.path === routePath;
	});

	const dropdownOpen = ref(false);
	const associationName = userStore.user?.associationName;
	const logout = () => {
		userStore.logoutUser();
	};

	const toggleDropdown = () => {
		dropdownOpen.value = !dropdownOpen.value;
	};

	const navigation = [
		{
			name: getCapitalizedText(t('navigation.dashboard')),
			to: '/',
			icon: ChartPieIcon,
			count: '5',
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.organization')),
			to: '/organization',
			icon: ClipboardIcon,
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.shelters')),
			to: '/shelters',
			icon: BuildingStorefrontIcon,
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.members')),
			to: '/members',
			icon: UsersIcon,
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.animals')),
			to: '/animals',
			icon: HeartIcon,
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.documents')),
			to: '/documents',
			icon: DocumentDuplicateIcon,
			current: currentActiveRoute,
		},
	];
</script>
<template>
	<div
		id="sidebar"
		class="top-0 left-0 flex h-screen flex-col :sm:w-20 max-w-56 transition-width ease-in-out duration-1000"
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
							>
								<router-link
									:to="item.to"
									:class="[
										currentActiveRoute(item.to)
											? 'text-osecours-beige-dark'
											: 'text-osecours-black hover:text-osecours-beige-dark hover:bg-osecours-white',
										'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold',
									]"
								>
									<component
										:is="item.icon"
										:class="[
											item.current
												? 'text-osecours-beige-dark'
												: 'text-gray-400 group-hover:text-osecours-beige-dark',
											'h-5 w-5 shrink-0',
										]"
										aria-hidden="true"
									/>
									<span class="truncate">
										{{ item.name }}
										<span
											v-if="item.count"
											class="ml-auto w-9 min-w-max whitespace-nowrap rounded-full bg-osecours-white px-2.5 py-0.5 text-center text-xs font-medium leading-5 text-osecours-beige-darkring-1 ring-inset ring-gray-200"
											aria-hidden="true"
											>{{ item.count }}</span
										>
									</span>
								</router-link>
							</li>
						</ul>
					</li>
					<li class="relative -mx-6 mt-auto">
						<a
							href="#"
							class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-osecours-black hover:bg-gray-50"
							@click.prevent="toggleDropdown"
						>
							<img
								class="h-8 w-8 rounded-full bg-gray-50"
								src="@/Assets/Images/logo-osecours.svg"
								alt=""
							/>
							<span
								aria-hidden="true"
								class="sm:block hidden text-osecours-black"
								>{{ associationName }}</span
							>
						</a>

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
									Profil
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
									Déconnexion
								</a>
							</div>
						</div>
						<!--						icons visibles on small screens     -->
						<div
							v-if="dropdownOpen"
							class="absolute right-0 -top-20 z-20 w-auto sm:hidden h-20 flex flex-col items-center justify-center"
							style="bottom: 100%; transform: translateX(-50%)"
						>
							<!-- Icone Profil -->
							<a
								href="#"
								class="block p-2 text-gray-700 hover:bg-gray-100"
								role="menuitem"
								@click="openProfile"
							>
								<UserIcon class="h-6 w-6" />
							</a>
							<!-- Icone Déconnexion -->
							<a
								href="#"
								class="block p-2 text-gray-700 hover:bg-gray-100"
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
		margin: auto;
		bottom: 100%;
		left: 0;
	}
	.dropdown_menu a:hover {
		background-color: #eae8e8;
	}
	.dropdown_menu__separator {
		background-color: var(--color-beige-light);
	}
</style>
