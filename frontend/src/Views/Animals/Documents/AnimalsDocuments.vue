<script lang="ts" setup>
	import { ref, onMounted } from 'vue';
	import { useRoute } from 'vue-router';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import DocumentsForm from '@/Views/Documents/DocumentsForm.vue';
	import { Document } from '@/Interfaces/Documents';

	const documentsStore = useDocumentsStore();
	const documents = ref<Document[]>([]);
	const route = useRoute();

	onMounted(async () => {
		documents.value = await documentsStore.getDocumentsByAnimal(
			route.params.id,
		);
	});
	console.log(documents);
	// const addPhoto = () => {
	// 	// @todo Logique pour ajouter une photo
	// };

	// const removePhoto = () => {
	// 	// @todo  Logique pour supprimer une photo
	// };
</script>
<template>
	<DocumentsForm
		:document="documents"
		:is-create-mode="false"
	/>
</template>
<style scoped lang="postcss">
	.animal-documents {
		//max-height: calc(100% - 4rem);
		display: flex;
		flex-direction: column;
		//min-height: calc(100vh - 4rem);
		min-height: 100%;
	}

	form {
		display: flex;
		flex-grow: 1;
		flex-direction: column;
	}
</style>
@/Interfaces/Documents/Documents
