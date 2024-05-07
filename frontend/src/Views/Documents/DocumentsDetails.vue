<script setup lang="ts">
	import TabsComponent from '@/Components/TabsComponent.vue';
	import GeneralInformations from '@/Views/Documents/GeneralInformations.vue';

	import { onMounted, ref } from 'vue';
	import { useRoute } from 'vue-router';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import i18n from '@/Services/Translations';
	import { Document } from '@/Interfaces/Document.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const t = i18n.global.t;
	const route = useRoute();
	const documentsStore = useDocumentsStore();
	const documentId = route.params.id;
	const currentTab = ref(0);
	const currentDocument = ref<Document | null>(null);

	const updateCurrentTab = (index) => {
		currentTab.value = index;
	};
	onMounted(async () => {
		// Logique pour récupérer les données du document à afficher
		currentDocument.value = await documentsStore.getDocument(documentId);
	});
	console.log(documentId);
</script>

<template>
	<div class="container">
		<div class="text-2xl mb-1">
			{{ getCapitalizedText(t('pages.documents.card')) }}:
			{{ currentDocument?.filename }}
		</div>
		<TabsComponent
			id="documentsTabsComponent"
			name="DocumentsDetailsTabs"
			:tabs="[{ name: getCapitalizedText(t('pages.animals.details')) }]"
			:activeColorClass="'bg-osecours-beige-dark bg-opacity-10 text-gray-700'"
			:secondaryColorClass="'text-gray-500 hover:text-gray-500'"
			@update:current-tab="updateCurrentTab"
		/>
		<div class="content">
			<template v-if="currentTab === 0 && currentDocument">
				<GeneralInformations :document="currentDocument" />
			</template>
			<template v-if="currentTab === 1 && currentDocument"> </template>
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
