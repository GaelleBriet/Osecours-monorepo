<script setup lang="ts">
	import i18n from '@/Services/Translations/index.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const t = i18n.global.t;
</script>
<template>
	<div class="flex flex-col">
		<h1 class="text-center">Home View</h1>
		<h1>{{ getCapitalizedText(t('pages.home.welcomeMessage')) }}</h1>
		<p>This is the home view.</p>
	</div>
</template>
<style lang="css" scoped></style>
