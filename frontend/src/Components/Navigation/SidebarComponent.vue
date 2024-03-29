<script setup lang="ts">
	import {
		CalendarIcon,
		ChartPieIcon,
		DocumentDuplicateIcon,
		FolderIcon,
		HomeIcon,
		UsersIcon,
		UserIcon,
		ArrowLeftStartOnRectangleIcon,
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
			icon: HomeIcon,
			count: '5',
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.users')),
			to: '/team',
			icon: UsersIcon,
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.animals')),
			to: '/animals',
			icon: FolderIcon,
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.calendar')),
			to: '/calendar',
			icon: CalendarIcon,
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.documents')),
			to: '/documents',
			icon: DocumentDuplicateIcon,
			current: currentActiveRoute,
		},
		{
			name: getCapitalizedText(t('navigation.settings')),
			to: '/reports',
			icon: ChartPieIcon,
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
											? 'bg-gray-50 text-indigo-600'
											: 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50',
										'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold',
									]"
								>
									<component
										:is="item.icon"
										:class="[
											item.current
												? 'text-indigo-600'
												: 'text-gray-400 group-hover:text-indigo-600',
											'h-5 w-5 shrink-0',
										]"
										aria-hidden="true"
									/>
									<span class="truncate">
										{{ item.name }}
										<span
											v-if="item.count"
											class="ml-auto w-9 min-w-max whitespace-nowrap rounded-full bg-white px-2.5 py-0.5 text-center text-xs font-medium leading-5 text-gray-600 ring-1 ring-inset ring-gray-200"
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
							class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50"
							@click.prevent="toggleDropdown"
						>
							<img
								class="h-8 w-8 rounded-full bg-gray-50"
								src="@/Assets/Images/logo-osecours.svg"
								alt=""
							/>
							<span
								aria-hidden="true"
								class="sm:block hidden"
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
								<!--								class="sm:block hidden"-->
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
						<!--						buttons visibles on small screens     -->
						<div
							v-if="dropdownOpen"
							class="sm:block visible h-20 w-20 flex flex-col items-center justify-center"
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
