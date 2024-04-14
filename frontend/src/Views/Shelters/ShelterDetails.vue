<script setup lang="ts">
	import TabsComponent from '@/Components/TabsComponent.vue';
	import GeneralInformations from '@/Views/Shelters/GeneralInformations.vue';

	import { onMounted, ref } from 'vue';
	import { useRoute } from 'vue-router';
	import { useSheltersStore } from '@/Stores/SheltersStore.ts';
	import i18n from '@/Services/Translations';
	import { Shelter } from '@/Interfaces/Shelter.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const t = i18n.global.t;
	const route = useRoute();
	const sheltersStore = useSheltersStore();
	const shelterId = route.params.id;
	const currentTab = ref(0);
	const currentShelter = ref<Shelter | null>(null);

	const updateCurrentTab = (index) => {
		currentTab.value = index;
	};

	onMounted(async () => {
		// Logique pour récupérer les données du shelter à afficher
		currentShelter.value = await sheltersStore.getShelter(shelterId);
	});
</script>

<template>
	<div class="container">
		<div class="text-2xl mb-1">
			{{ getCapitalizedText(t('pages.shelters.card')) }}:
			{{ currentShelter?.name }}
		</div>
		<TabsComponent
			id="sheltersTabsComponent"
			:tabs="[
				{ name: getCapitalizedText(t('pages.animals.details')) },
				{ name: getCapitalizedText(t('common.other')) },
			]"
			@update:current-tab="updateCurrentTab"
		/>
		<div class="content">
			<template v-if="currentTab === 0 && currentShelter">
				<GeneralInformations :shelter="currentShelter" />
			</template>
			<template v-if="currentTab === 1 && currentShelter"></template>
		</div>
	</div>
</template>
<style scoped lang="postcss">
	.container {
		display: flex;
		flex-direction: column;
		height: 100%;
		padding: 0;
	}

	.content {
		flex-grow: 1;
		overflow-y: auto;
	}
</style>
