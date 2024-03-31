<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { computed, onMounted } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';

	const t = i18n.global.t;
	const animalsStore = useAnimalsStore();
	const animals = computed(() => animalsStore.animals);

	onMounted(async () => {
		await animalsStore.getDogs();
	});
</script>

<template>
	<div class="w-full p-0">
		<DataGridComponent
			:store="animalsStore"
			:model-value="animals"
			:title="getCapitalizedText(t('navigation.dogs'))"
			:description="getCapitalizedText(t('pages.animals.dogsTitle'))"
			:columns="[
				{ label: 'Nom', key: 'name' },
				{ label: 'I-Cad', key: 'icad' },
				{ label: 'Race', key: 'breed' },
				{ label: 'Statut', key: 'status', visibility: { md: true } },
			]"
		/>
	</div>
</template>

<style scoped></style>
