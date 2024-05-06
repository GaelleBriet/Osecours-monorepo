<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { computed, onMounted } from 'vue';
	import { useRouter } from 'vue-router';
	import i18n from '@/Services/Translations';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const t = i18n.global.t;
	const router = useRouter();
	const animalsStore = useAnimalsStore();

	// On transforme les données pour les afficher dans le tableau
	const animalsTransformed = computed(() => {
		return animalsStore.animals.map((animal) => {
			return {
				...animal,
				name: animal.name ? getCapitalizedText(animal.name) : '',
				identification: animal.identification?.number || '',
				specie:
					getCapitalizedText(t(`enums.animalSpecies.${animal.specie?.name}`)) ||
					'',
				breed: animal.breed?.name
					? getCapitalizedText(t(`enums.animalsBreeds.${animal.breed?.name}`))
					: '',
			};
		});
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
				{
					label: getCapitalizedText(t('pages.animals.icad')),
					key: 'identification',
				},
				{
					label: getCapitalizedText(t('pages.animals.species')),
					key: 'specie',
					visibility: { sm: true },
				},
				{
					label: getCapitalizedText(t('pages.animals.breed')),
					key: 'breed',
				},
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
