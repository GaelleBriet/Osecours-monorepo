<script lang="ts" setup>
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { computed, ref, onMounted } from 'vue';
	import { useRoute, useRouter } from 'vue-router';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import DocumentsForm from '@/Views/Documents/DocumentsForm.vue';
	import { Document } from '@/Interfaces/Documents/Documents.ts';
	import { useDocumentsSettingsStore } from '@/Stores/DocumentsSettingsStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import ModalComponent from '@/Components/ModalComponent.vue';
	import LoaderComponent from '@/Components/LoaderComponent.vue';

	const t = i18n.global.t;
	const documentsStore = useDocumentsStore();
	const doctypesStore = useDocumentsSettingsStore();
	const documents = ref<Document[]>([]);
	const doctypes = ref<Doctypes[]>([]);
	const route = useRoute();
	const router = useRouter();
	const showForm = ref(false);
	const showModal = ref(false);
	const documentToDelete = ref(null);

	const fetchDocuments = async () => {
		const docsByAnimal = await documentsStore.getDocumentsByAnimal(route.params.id);
		const allDocTypes = await doctypesStore.getAllDoctypes();
		documents.value = docsByAnimal;
		doctypes.value = allDocTypes;
	};

	const handleDocumentSaved = () => {
		fetchDocuments();
		showForm.value = false;
	};

	const getDoctypeNameById = (id: number): string | undefined => {
		const doctype = doctypes.value.find((doctype) => doctype.id === id);
		return doctype ? doctype.name : undefined;
	};

	const documentsTransformed = computed(() => {
		return documents.value.map((document) => {
			if (!document || !document.filename) {
				return {
					...document,
					doctype_name: 'Unknown Type',
					filename: 'Unknown Filename',
					size: 'Unknown Size'
				};
			}
			let modifiedFilename = document.filename.split('__')[0];
			let modifiedDoctype = getDoctypeNameById(document.doctype_id);

			// Determine the size to display MB or KB
			let sizeInMB = document.size / (1024 * 1024);
			let sizeFormatted;

			if (sizeInMB >= 1) {
				sizeFormatted = sizeInMB.toFixed(2) + ' MB';
			} else {
				let sizeInKB = document.size / 1024;
				sizeFormatted = sizeInKB.toFixed(2) + ' KB';
			}
			
			return {
				...document,
				doctype_name: getCapitalizedText(t(`enums.documentType.${modifiedDoctype}`)),
				filename: getCapitalizedText(modifiedFilename),
				size: sizeFormatted
			};
		});
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

	const openModal = (item: Document) => {
		documentToDelete.value = item;
		showModal.value = true;
	};

	const onConfirmDelete = async () => {
		if (documentToDelete.value) {
			await documentsStore.deleteDocument(documentToDelete.value.id);
			await fetchDocuments();
			showModal.value = false;
			documentToDelete.value = null;
		}
	};

	onMounted(async () => {
		await fetchDocuments();
	});

</script>
<template>
	<div class="container bg-osecours-beige-dark bg-opacity-10 h-full">        
		<DataGridComponent
			v-if="!documentsStore.isLoading"
			:availability="getCapitalizedText(t('pages.documents.noAvailable'))"
			:store="documentsStore" 
			:model-value="documentsTransformed"
			:description="getCapitalizedText(t('pages.documents.titleAnimal'))"
			:columns="[
				{ label: getCapitalizedText(t('common.name')), key: 'filename' },
				{ label: getCapitalizedText(t('pages.documents.type')), key: 'doctype_name' },
				{ label: getCapitalizedText(t('pages.animals.size')), key: 'size' },
				{ label: getCapitalizedText(t('pages.documents.date')), key: 'date' },
			]"
			@edit="editItem"
			@add="addItem"
			@delete="openModal"
			@documentSaved="handleDocumentSaved"
		/>
		<ModalComponent			
			v-if="showModal"
			:isOpen="showModal"
			:title="getCapitalizedText(t('pages.documents.messages.deleteDocument'))"
			:description="getCapitalizedText(t('pages.documents.messages.delete'))"
			:center="true"
			:confirmButton="true"
			:cancelButton="true"
			:confirmButtonText="getCapitalizedText(t('common.confirm'))"
			:cancelButtonText="getCapitalizedText(t('common.cancel'))"
			confirmButtonColor="rgb(151,166,166)"
			cancelButtonColor="rgb(242,138,128)"
			buttonOrder="confirm-cancel"
			@close="showModal = false"
			@confirm="onConfirmDelete"
		>
		</ModalComponent>
		<LoaderComponent
			class="h-full"
			v-if="documentsStore.isLoading"
		/>
    </div>
	<ModalComponent v-if="showForm" :isOpen="showForm" @close="showForm = false" :docForm="true">
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
