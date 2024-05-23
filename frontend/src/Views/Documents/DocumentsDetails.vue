	<script setup lang="ts">
	import { onMounted, ref } from 'vue';
	import { useRoute } from 'vue-router';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import i18n from '@/Services/Translations';
	import { Document } from '@/Interfaces/Document.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import DocumentsForm from '@/Views/Documents/DocumentsForm.vue';

	const t = i18n.global.t;
	const route = useRoute();
	const documentsStore = useDocumentsStore();
	const documentId = route.params.id;
	const currentDocument = ref<Document | null>(null);

	onMounted(async () => {
		// Logique pour récupérer les données du document à afficher
		currentDocument.value = await documentsStore.getDocument(documentId);
	});
	console.log(currentDocument)
	</script>

	<template>
		<div class="container">
			<div class="text-2xl mb-1">
				{{ getCapitalizedText(t('pages.documents.card')) }}:
				{{ currentDocument?.filename }}
			</div>

			<div class="container">
				<DocumentsForm :document="currentDocument" :is-create-mode="false" />
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
