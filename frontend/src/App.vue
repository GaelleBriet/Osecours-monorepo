<script setup lang="ts">
	import SidebarComponent from '@/Components/Navigation/SidebarComponent.vue';
	import { useUserStore } from '@/Stores/UserStore';

	const userStore = useUserStore();
</script>

<template>
	<div class="flex h-screen">
		<div v-if="userStore.isLoggedIn">
			<div
				id="sidebar-container"
				class="w-full max-w-48 :sm:max-w-20"
			>
				<SidebarComponent />
			</div>
			<div
				id="main-container"
				class="w-full h-full container mx-auto pt-12 px-12"
			>
				<RouterView class="flex-grow" />
			</div>
		</div>
		<div
			v-else
			class="w-full h-full mx-auto"
		>
			<RouterView class="flex-grow" />
		</div>
	</div>
</template>

<style scoped lang="css">
	#sidebar-container {
		@media (max-width: 640px) {
			max-width: 5rem;
		}
	}
</style>
