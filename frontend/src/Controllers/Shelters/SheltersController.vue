<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { computed, onMounted } from 'vue';
	import { useRouter } from 'vue-router';
	import { useSheltersStore } from '@/Stores/SheltersStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';

	const t = i18n.global.t;
	const router = useRouter();
	const sheltersStore = useSheltersStore();

	const sheltersTransformed = computed(() => {
		return sheltersStore.shelters.map((shelter) => ({
			...shelter,
		}));
	});

	const editItem = (item) => {
		router.push({
			name: 'EditShelter',
			params: { id: item.id },
		});
	};

	const addItem = () => {
		router.push({
			name: 'CreateShelters',
		});
	};

	onMounted(async () => {
		await sheltersStore.getShelters();
	});
</script>

<template>
	<div class="w-full p-0">
		<DataGridComponent
			:store="sheltersStore"
			:model-value="sheltersTransformed"
			:title="getCapitalizedText(t('navigation.shelters'))"
			:description="getCapitalizedText(t('pages.shelters.title'))"
			:columns="[
				{ label: getCapitalizedText(t('common.name')), key: 'name' },
				{
					label: getCapitalizedText(t('pages.shelters.quantity')),
					key: 'animals',
				},
				{ label: getCapitalizedText(t('pages.shelters.phone')), key: 'phone' },
			]"
			@edit="editItem"
			@add="addItem"
		/>
	</div>
</template>

<style scoped></style>
