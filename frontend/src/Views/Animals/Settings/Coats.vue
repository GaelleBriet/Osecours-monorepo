<script setup lang="ts">
	import { Coat } from '@/Interfaces/Coat.ts';
	import { onMounted, ref } from 'vue';
	import { useAnimalsSettingsStore } from '@/Stores/AnimalsSettingsStore.ts';
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const t = i18n.global.t;
	const animalSettingsStore = useAnimalsSettingsStore();
	const coats = ref<Coat[]>([]);

	onMounted(async () => {
		await animalSettingsStore.getAllCoats();
		coats.value = animalSettingsStore.coats;
	});
</script>
<template>
	<div class="w-full p-0 relative -top-[68px]">
		<DataGridComponent
			:store="animalSettingsStore"
			:model-value="coats"
			:columns="[
				{ label: getCapitalizedText(t('pages.animals.coat')), key: 'name' },
				{
					label: getCapitalizedText(t('pages.animals.description')),
					key: 'description',
				},
			]"
			:animals-chars="true"
		/>
	</div>
</template>
