<script setup lang="ts">
	import { useAnimalsSettingsStore } from '@/Stores/AnimalsSettingsStore.ts';
	import { onMounted, ref } from 'vue';
	import { Species } from '@/Interfaces/Species.ts';
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import i18n from '@/Services/Translations';

	const t = i18n.global.t;
	const animalSettingsStore = useAnimalsSettingsStore();
	// on initialise la liste des especes comme un tableau vide (attendu par le DataGridComponent)
	const species = ref<Species[]>([]);

	onMounted(async () => {
		// on récupère les especes depuis le store
		await animalSettingsStore.getAllSpecies();
		// on met à jour la liste des especes
		species.value = animalSettingsStore.allSpecies.map((species) => {
			return {
				...species,
				name: t(species.name),
				description: t(species.description),
			};
		});
		console.log(species.value);
	});
</script>
<template>
	<div class="w-full p-0 relative -top-[68px]">
		<DataGridComponent
			:store="animalSettingsStore"
			:model-value="species"
			:columns="[
				{ label: 'Espèce', key: 'name' },
				{ label: 'Description', key: 'description' },
			]"
			:animals-chars="true"
		/>
	</div>
</template>
