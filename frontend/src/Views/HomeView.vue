<script setup lang="ts">
	import DemoView from '@/Views/DemoView.vue';
	import i18n from '@/Services/Translations/index.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const t = i18n.global.t;
</script>

<template>
	<h1>{{ getCapitalizedText(t('pages.home.welcomeMessage')) }}</h1>
	<p><strong>Current route path:</strong> {{ $route.fullPath }}</p>
	<nav>
		<RouterLink :to="{ name: 'HelloWorld', props: { msg: 'Hello World' } }"
			>Go to Hello world</RouterLink
		>
	</nav>
	<DemoView :msg="'Message in a props'" />
</template>

<style scoped></style>
