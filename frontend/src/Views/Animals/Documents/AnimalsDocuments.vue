<script lang="ts" setup>
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { computed, ref, onMounted } from 'vue';
	import { useRoute, useRouter } from 'vue-router';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import DocumentsForm from '@/Views/Documents/DocumentsForm.vue';
	import { Document } from '@/Interfaces/Documents';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import ModalComponent from '@/Components/ModalComponent.vue';

	const t = i18n.global.t;
	const documentsStore = useDocumentsStore();
	const documents = ref<Document[]>([]);
	const route = useRoute();
	const router = useRouter();
	const showForm = ref(false);

	const fetchDocuments = async () => {
		const docsByAnimal = await documentsStore.getDocumentsByAnimal(route.params.id);
		documents.value = docsByAnimal;
	};

	onMounted(async () => {
		fetchDocuments();
	});

	const handleDocumentSaved = () => {
		fetchDocuments();
		showForm.value = false;
	};

	const documentsTransformed = computed(() => {
		return documents.value.map((document) => ({
			...document
		}));
	});
	
	const editItem = (item) => {
		router.push({
			name: 'EditDocument',
			params: { id: item.id },
		});
	};

	const addItem = () => {
		showForm.value = true;
		return false;
	};

	const removeItem = (item) => {
		console.log(item.id)
		documentsStore.deleteDocument(item.id);
	};
</script>
<template>
	<div class="container bg-osecours-beige-dark bg-opacity-10 h-full">
		<DataGridComponent
			:store="documentsStore" 
			:model-value="documentsTransformed"
			:description="getCapitalizedText(t('pages.documents.titleAnimal'))"
			:columns="[
				{ label: getCapitalizedText(t('common.name')), key: 'filename' },
				{ label: getCapitalizedText(t('pages.documents.type')), key: 'mimeType' },
				{ label: getCapitalizedText(t('pages.animals.size')), key: 'size' },
				{ label: getCapitalizedText(t('pages.documents.date')), key: 'date' },
			]"
			@edit="editItem"
			@add="addItem"
			@delete="removeItem"
			@documentSaved="handleDocumentSaved"
		/>                
    </div>
	<ModalComponent :isOpen="showForm" @close="showForm = false">
		<DocumentsForm
			:is-create-mode="true"
			:is-photo-mode="false"
			@documentSaved="handleDocumentSaved"
		/>
	</ModalComponent>
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