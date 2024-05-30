<script setup lang="ts">
	import { useAnimalsSettingsStore } from '@/Stores/AnimalsSettingsStore.ts';
	import { onMounted, ref } from 'vue';
	import { Species } from '@/Interfaces/Animals/Species.ts';
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import LoaderComponent from '@/Components/LoaderComponent.vue';

	const t = i18n.global.t;
	const animalSettingsStore = useAnimalsSettingsStore();
	// on initialise la liste des especes comme un tableau vide (attendu par le DataGridComponent)
	const species = ref<Species[]>([]);

	onMounted(async () => {
		// on récupère les especes depuis le store
		await animalSettingsStore.getAllSpecies();
		// on met à jour la liste des espèces et affiche leur traduction
		species.value = animalSettingsStore.allSpecies.map((species) => {
			return {
				...species,
				name: getCapitalizedText(t(`enums.animalSpecies.${species.name}`)),
				description: species.description,
			};
		});
	});
</script>
<template>
	<div class="w-full p-0 relative -top-[68px]">
		<DataGridComponent
			:store="animalSettingsStore"
			:model-value="species"
			:columns="[
				{ label: getCapitalizedText(t('pages.animals.species')), key: 'name' },
				{
					label: getCapitalizedText(t('pages.animals.description')),
					key: 'description',
				},
			]"
			:animals-chars="true"
		/>
		<LoaderComponent
			class="mt-5"
			v-if="animalSettingsStore.isLoading"
		/>
	</div>
</template>
