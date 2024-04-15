<script setup lang="ts">
	import { useAnimalsSettingsStore } from '@/Stores/AnimalsSettingsStore.ts';
	import { Breed } from '@/Interfaces/Breed.ts';
	import { onMounted, ref } from 'vue';
	import DataGridComponent from '@/Components/DataGridComponent.vue';

	const animalSettingsStore = useAnimalsSettingsStore();
	const breeds = ref<Breed[]>([]);

	onMounted(async () => {
		await animalSettingsStore.getAllBreeds();
		breeds.value = animalSettingsStore.breeds;
	});
</script>
<template>
	<div class="w-full p-0 relative -top-[68px]">
		<DataGridComponent
			:store="animalSettingsStore"
			:model-value="breeds"
			:columns="[
				{ label: 'Race', key: 'name' },
				{ label: 'Description', key: 'description' },
			]"
			:animals-chars="true"
		/>
	</div>
</template>
