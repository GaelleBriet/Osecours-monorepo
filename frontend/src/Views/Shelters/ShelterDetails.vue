<script setup lang="ts">
	import TabsComponent from '@/Components/TabsComponent.vue';
	import GeneralInformations from '@/Views/Shelters/ShelterGeneralInformations.vue';
	import ShelterPhotos from '@/Views/Shelters/ShelterPhotos.vue';
	import { Shelter } from '@/Interfaces/Shelter.ts';
	import { onMounted, ref } from 'vue';
	import { useRoute } from 'vue-router';
	import { useSheltersStore } from '@/Stores/SheltersStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';

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
				{ name: getCapitalizedText(t('pages.documents.photos')) },
			]"
			:activeColorClass="'bg-osecours-beige-dark bg-opacity-10 text-gray-700'"
			:secondaryColorClass="'text-gray-500 hover:text-gray-500'"
			@update:current-tab="updateCurrentTab"
		/>
		<div class="content">
			<template v-if="currentTab === 0 && currentShelter">
				<GeneralInformations :shelter="currentShelter" />
			</template>
			<template v-if="currentTab === 1 && currentShelter">
				<ShelterPhotos :shelter="currentShelter" />
			</template>
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
