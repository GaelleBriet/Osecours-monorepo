<!-- <script setup lang="ts">
	import TabsComponent from '@/Components/TabsComponent.vue';
	import { ref } from 'vue';

	const currentTab = ref(0);

	const updateCurrentTab = (index) => {
		currentTab.value = index;
	};
</script>
<template>
	<div>
		<TabsComponent
			:tabs="[{ name: 'un' }, { name: 'deux' }]"
			@update:current-tab="updateCurrentTab"
		/>
		<div v-if="currentTab === 0">premier contenu</div>
		<div v-if="currentTab === 1">second contenu</div>
	</div>
</template> -->
<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { useSheltersStore } from '@/Stores/SheltersStore.ts';
	import { computed, onMounted } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import { useRouter } from 'vue-router';

	const t = i18n.global.t;
	const router = useRouter();
	const sheltersStore = useSheltersStore();
	//const shelters = computed(() => sheltersStore.shelters);

	const sheltersTransformed = computed(() => {
		return sheltersStore.shelters.map((shelter) => ({
			...shelter
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
				{ label: getCapitalizedText(t('pages.shelters.quantity')), key: 'animals' },
				{ label: getCapitalizedText(t('pages.shelters.phone')), key: 'phone'},
				]"
			@edit="editItem"
			@add="addItem"
		/>
	</div>
</template>

<style scoped></style>