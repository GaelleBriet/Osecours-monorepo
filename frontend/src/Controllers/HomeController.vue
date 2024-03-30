<script setup lang="ts">
	import i18n from '@/Services/Translations/index.ts';
	import { useUserStore } from '@/Stores/UserStore.ts';

	const t = i18n.global.t;
	const userStore = useUserStore();
	const associationName = userStore.user?.associationName;
</script>
<template>
	<div class="flex flex-col">
		<h1 class="text-center">{{ associationName }}</h1>
		<img
			src="@/Assets/Images/dashboard.jpg"
			alt="dashboard"
			class="h-auto object-cover pt-36"
		/>
	</div>
</template>
<style lang="css" scoped></style>
