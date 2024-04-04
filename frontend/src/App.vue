<script setup lang="ts">
	import SidebarComponent from '@/Components/Navigation/SidebarComponent.vue';
	import LoginController from '@/Controllers/LoginController.vue';
</script>

<template>
	<div
		v-if="$route.name === 'Login'"
		class="h-full"
	>
		<LoginController />
	</div>
	<div
		class="flex h-screen"
		v-else
	>
		<div
			id="sidebar-container"
			class="w-full max-w-56 :sm:max-w-20 flex"
		>
			<SidebarComponent />
		</div>
		<div
			id="main-container"
			class="w-full h-full mx-auto py-4 px-5"
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
