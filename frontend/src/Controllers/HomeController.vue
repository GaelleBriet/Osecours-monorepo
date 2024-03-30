<script setup lang="ts">
	// import i18n from '@/Services/Translations/index.ts';
	import { useUserStore } from '@/Stores/UserStore.ts';
	import { getCapitalizedText } from '../Services/Helpers/TextFormat.ts';

	// const t = i18n.global.t;
	const userStore = useUserStore();
	const associationName = userStore.user?.associationName as string;
</script>
<template>
	<div class="flex flex-col">
		<h1 class="text-center">{{ getCapitalizedText(associationName) }}</h1>
		<img
			src="@/Assets/Images/dashboard.jpg"
			alt="dashboard"
			class="h-auto object-cover pt-36"
		/>
	</div>
</template>
<style lang="css" scoped></style>
