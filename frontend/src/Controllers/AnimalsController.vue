<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { computed, onMounted, ref } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import { useRouter } from 'vue-router';

	const t = i18n.global.t;
	const router = useRouter();
	const animalsStore = useAnimalsStore();
	const animals = computed(() => animalsStore.animals);

	const editItem = (item) => {
		router.push({
			name: 'EditAnimal',
			params: { id: item.id },
		});
	};

	onMounted(async () => {
		await animalsStore.getAnimals();
	});
</script>

<template>
	<div class="w-full p-0">
		<DataGridComponent
			:store="animalsStore"
			:model-value="animals"
			:title="getCapitalizedText(t('navigation.animals'))"
			:description="getCapitalizedText(t('pages.animals.title'))"
			:columns="[
				{ label: 'Nom', key: 'name' },
				{ label: 'I-Cad', key: 'icad' },
				{ label: 'Espèce', key: 'species', visibility: { sm: true } },
				{ label: 'Race', key: 'breed' },
				{ label: 'Statut', key: 'status', visibility: { md: true } },
			]"
			@edit="editItem"
		/>
	</div>
</template>

<style scoped></style>
