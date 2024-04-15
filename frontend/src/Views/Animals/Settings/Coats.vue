<script setup lang="ts">
	import { Coat } from '@/Interfaces/Coat.ts';
	import { onMounted, ref } from 'vue';
	import { useAnimalsSettingsStore } from '@/Stores/AnimalsSettingsStore.ts';
	import DataGridComponent from '@/Components/DataGridComponent.vue';

	const animalSettingsStore = useAnimalsSettingsStore();
	const coats = ref<Coat[]>([]);

	onMounted(async () => {
		await animalSettingsStore.getAllCoats();
		coats.value = animalSettingsStore.coats;
	});
</script>
<template>
	<div class="w-full p-0 relative -top-[35px]">
		<DataGridComponent
			:store="animalSettingsStore"
			:model-value="coats"
			:columns="[
				{ label: 'Robes', key: 'name' },
				{ label: 'Description', key: 'description' },
			]"
			:animals-chars="true"
		/>
	</div>
</template>
