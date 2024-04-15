<script setup lang="ts">
	import TabsComponent from '@/Components/TabsComponent.vue';
	import Species from '@/Views/Animals/Settings/Species.vue';
	import Coats from '@/Views/Animals/Settings/Coats.vue';
	import Breeds from '@/Views/Animals/Settings/Breeds.vue';
	import Colors from '@/Views/Animals/Settings/Colors.vue';
	import { ref } from 'vue';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const t = i18n.global.t;
	const currentTab = ref(0);
	const updateCurrentTab = (index) => {
		currentTab.value = index;
	};

	const tabDescriptions = [
		'paramétrage des espèces',
		'paramétrage des races',
		'paramétrage des robes',
		'paramétrage des couleurs',
	];
</script>

<template>
	<div class="container">
		<h1 class="mb-5">
			{{ getCapitalizedText(t('gestion des caractéristiques')) }}
		</h1>
		<template v-for="(text, index) in tabDescriptions">
			<p
				v-if="currentTab === index"
				:key="index"
				class="text-sm text-gray-700 mb-5"
			>
				{{ getCapitalizedText(text) }}
			</p>
		</template>
		<TabsComponent
			id="animalsTabsComponent"
			:tabs="[
				{ name: getCapitalizedText(t('espèces')) },
				{ name: getCapitalizedText(t('races')) },
				{ name: getCapitalizedText(t('robes')) },
				{ name: getCapitalizedText(t('couleurs')) },
			]"
			:activeColorClass="'bg-osecours-beige-dark bg-opacity-10 text-gray-700'"
			:secondaryColorClass="'text-gray-500 hover:text-gray-500'"
			@update:current-tab="updateCurrentTab"
		/>

		<div class="content">
			<template v-if="currentTab === 0"><Species /></template>
			<template v-if="currentTab === 1"><Breeds /></template>
			<template v-if="currentTab === 2"><Coats /></template>
			<template v-if="currentTab === 3"><Colors /></template>
		</div>
	</div>
</template>

<style scoped lang="postcss"></style>
