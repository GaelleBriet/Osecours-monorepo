<script setup lang="ts">
	import { useAnimalsSettingsStore } from '@/Stores/AnimalsSettingsStore.ts';
	import { Breed } from '@/Interfaces/Animals/Breed.ts';
	import { onMounted, ref } from 'vue';
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import LoaderComponent from '@/Components/LoaderComponent.vue';

	const t = i18n.global.t;
	const animalSettingsStore = useAnimalsSettingsStore();
	const breeds = ref<Breed[]>([]);

	onMounted(async () => {
		await animalSettingsStore.getAllBreeds();
		breeds.value = animalSettingsStore.breeds.map((breed) => {
			return {
				...breed,
				name: getCapitalizedText(t(`enums.animalsBreeds.${breed.name}`)),
				description: breed.description,
			};
		});
	});
</script>
<template>
	<div class="w-full p-0 relative -top-[68px]">
		<DataGridComponent
			v-if="!animalSettingsStore.isLoading"
			:store="animalSettingsStore"
			:model-value="breeds"
			:columns="[
				{ label: getCapitalizedText(t('pages.animals.breed')), key: 'name' },
				{
					label: getCapitalizedText(t('pages.animals.description')),
					key: 'description',
				},
			]"
			:animals-chars="true"
		/>
		<LoaderComponent
			class="h-screen"
			v-if="animalSettingsStore.isLoading"
		/>
	</div>
</template>
