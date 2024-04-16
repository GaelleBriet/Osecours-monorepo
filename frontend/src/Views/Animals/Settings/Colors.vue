<script setup lang="ts">
	import { useAnimalsSettingsStore } from '@/Stores/AnimalsSettingsStore.ts';
	import { onMounted, ref } from 'vue';
	import { Color } from '@/Interfaces/Color.ts';
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';

	const t = i18n.global.t;
	const animalSettingsStore = useAnimalsSettingsStore();
	const colors = ref<Color[]>([]);

	onMounted(async () => {
		await animalSettingsStore.getAllColors();
		colors.value = animalSettingsStore.colors.map((color) => {
			return {
				...color,
				name: getCapitalizedText(t(`enums.animalsColors.${color.name}`)),
				description: color.description,
			};
		});
	});
</script>
<template>
	<div class="w-full p-0 relative -top-[68px]">
		<DataGridComponent
			:store="animalSettingsStore"
			:model-value="colors"
			:columns="[
				{ label: 'Couleurs', key: 'name' },
				{ label: 'Description', key: 'description' },
			]"
			:animals-chars="true"
		/>
	</div>
</template>
