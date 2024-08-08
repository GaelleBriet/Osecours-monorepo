<script setup lang="ts">
	import { onMounted, ref } from 'vue';
	import { useRoute } from 'vue-router';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import i18n from '@/Services/Translations';
	import { Document } from '@/Interfaces/Documents/Documents.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import DocumentsForm from '@/Views/Documents/DocumentsForm.vue';

	const t = i18n.global.t;
	const route = useRoute();
	const documentsStore = useDocumentsStore();
	const documentId = route.params.id;
	const currentDocument = ref<Document | null>(null);
  const currentTab = ref(0);

	const updateCurrentTab = (index) => {
		currentTab.value = index;
	};
	onMounted(async () => {
		// Logique pour récupérer les données du document à afficher
		currentDocument.value = await documentsStore.getDocument(documentId);
	});
	const loadDocumentData = async () => {
		currentDocument.value = await documentsStore.getDocument(documentId);
	};

	onMounted(async () => {
        loadDocumentData();
    });

    const handleDocumentSaved = () => {
        loadDocumentData();
    };
</script>

<template>
	<div class="container">
		<div class="flex flex-row justify-between mb-2">
			<div class="text-2xl mb-1">
				{{ getCapitalizedText(t('pages.documents.card')) }}:
				{{ currentDocument?.filename }}
			</div>
			<button
				id="back-btn"
				class="me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors duration-200 ease-in-out"
				@click="$router.go(-1)"
			>
				{{ getCapitalizedText(t('common.back')) }}
			</button>
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
		<div class="container">
			<DocumentsForm
				v-if="currentDocument"
				:document="currentDocument"
				:is-create-mode="false"
				@documentSaved="handleDocumentSaved"
			/>
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

	#back-btn {
		background-color: #d99962;
		color: #fff;
		&:hover {
			background-color: var(--color-withe);
			color: #d99962;
			outline: 1px solid #d99962;
		}
	}
</style>
