<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { computed, onMounted } from 'vue';
	import { useRouter } from 'vue-router';
	import { AnimalSpecies, AnimalStatus } from '@/Enums/Animals.ts';
	import i18n from '@/Services/Translations';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { generateOptionsFromEnum } from '@/Services/Helpers/Enums.ts';

	const t = i18n.global.t;
	const router = useRouter();
	const animalsStore = useAnimalsStore();
	// const animals = computed(() => animalsStore.animals);

	// on récupère les animaux depuis le store
	// on les transforme pour afficher les labels des enums
	const animalsTransformed = computed(() => {
		return animalsStore.animals;
		// return animalsStore.animals.map((animal) => ({
		// 	...animal,
		// 	species:
		// 		generateOptionsFromEnum(AnimalSpecies, 'enums.animalSpecies')[
		// 			animal.species - 1
		// 		]?.label || animal.species,
		// 	status:
		// 		generateOptionsFromEnum(AnimalStatus, 'enums.animalStatus')[
		// 			animal.status - 1
		// 		]?.label || animal.status,
		// }));
	});

	const editItem = (item) => {
		router.push({
			name: 'EditAnimal',
			params: { id: item.id },
		});
	};

	const addItem = () => {
		router.push({
			name: 'CreateAnimal',
		});
	};

	const deleteItem = (item) => {
		animalsStore.deleteAnimal(item.id);
	};

	onMounted(async () => {
		await animalsStore.getAnimals();
	});
</script>

<template>
	<div class="w-full p-0">
		<DataGridComponent
			:store="animalsStore"
			:model-value="animalsTransformed"
			:title="getCapitalizedText(t('navigation.animals'))"
			:description="getCapitalizedText(t('pages.animals.title'))"
			:columns="[
				{ label: getCapitalizedText(t('common.name')), key: 'name' },
				{ label: getCapitalizedText(t('pages.animals.icad')), key: 'icad' },
				{
					label: getCapitalizedText(t('pages.animals.species')),
					key: 'specie',
					visibility: { sm: true },
				},
				{ label: getCapitalizedText(t('pages.animals.breed')), key: 'bread' },
				{
					label: getCapitalizedText(t('pages.animals.status')),
					key: 'status',
					visibility: { md: true },
				},
			]"
			@edit="editItem"
			@add="addItem"
			@delete="deleteItem"
		/>
	</div>
</template>

<style scoped></style>
