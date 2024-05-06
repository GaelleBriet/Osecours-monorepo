<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { computed, onMounted } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import { useRouter } from 'vue-router';

	const router = useRouter();
	const animalsStore = useAnimalsStore();
	const t = i18n.global.t;
	// const animals = computed(() => animalsStore.animals);

	// On transforme les données pour les afficher dans le tableau
	const animalsTransformed = computed(() => {
		return animalsStore.animals.map((animal) => {
			return {
				...animal,
				name: animal.name ? getCapitalizedText(animal.name) : '',
				identification: animal.identification?.number || '',
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
			params: { species: 'cat' },
		});
	};

	const deleteItem = (item) => {
		animalsStore.deleteAnimal(item.id);
	};

	onMounted(async () => {
		await animalsStore.getCats();
	});
</script>

<template>
	<div class="w-full p-0">
		<DataGridComponent
			:store="animalsStore"
			:model-value="animalsTransformed"
			:title="getCapitalizedText(t('navigation.cats'))"
			:description="getCapitalizedText(t('pages.animals.catsTitle'))"
			:columns="[
				{ label: getCapitalizedText(t('common.name')), key: 'name' },
				{
					label: getCapitalizedText(t('pages.animals.icad')),
					key: 'identification',
				},
				{ label: getCapitalizedText(t('pages.animals.breed')), key: 'breed' },
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
