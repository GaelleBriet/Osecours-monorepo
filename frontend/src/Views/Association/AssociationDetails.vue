<script setup lang="ts">
	import TabsComponent from '@/Components/TabsComponent.vue';
	import GeneralInformations from '@/Views/Association/GeneralInformation.vue';

	import { onMounted, ref } from 'vue';
	import { useRoute } from 'vue-router';
	import { useAssociationsStore } from '@/Stores/AssociationsStore.ts';
	import i18n from '@/Services/Translations';
	import { Association } from '@/Interfaces/Associations.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const t = i18n.global.t;
	const route = useRoute();
	const associationsStore = useAssociationsStore();
	const associationId = route.params.id;
	const currentTab = ref(0);
	const currentAssociation = ref<Association | null>(null);

	const updateCurrentTab = (index) => {
		currentTab.value = index;
	};

	onMounted(async () => {
		// Logique pour récupérer les données du association à afficher
		currentAssociation.value =
			await associationsStore.getAssociation(associationId);
	});
</script>

<template>
	<div class="container">
		<div class="text-2xl mb-1">
			{{ getCapitalizedText(t('pages.associations.card')) }}:
			{{ currentAssociation?.name }}
		</div>
		<TabsComponent
			id="associationsTabsComponent"
			:tabs="[{ name: getCapitalizedText(t('pages.animals.details')) }]"
			:activeColorClass="'bg-osecours-beige-dark bg-opacity-10 text-gray-700'"
			:secondaryColorClass="'text-gray-500 hover:text-gray-500'"
			@update:current-tab="updateCurrentTab"
		/>
		<div class="content">
			<template v-if="currentTab === 0 && currentAssociation">
				<GeneralInformations :association="currentAssociation" />
			</template>
			<template v-if="currentTab === 1 && currentAssociation"> </template>
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
