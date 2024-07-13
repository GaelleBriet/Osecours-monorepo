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

	const t = i18n.global.t;
	const documentsStore = useDocumentsStore();
	const doctypesStore = useDocumentsSettingsStore();
	const documents = ref<Document[]>([]);
	const doctypes = ref<Doctypes[]>([]);
	const route = useRoute();
	const router = useRouter();
	const showForm = ref(false);

	const fetchDocuments = async () => {
		const docsByAnimal = await documentsStore.getDocumentsByAnimal(
			route.params.id,
		);
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
		return documents.value.map((document) => ({
			...document,
			doctype_name: getDoctypeNameById(document.doctype_id),
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
		documentsStore.deleteDocument(item.id);
	};

	onMounted(async () => {
		await fetchDocuments();
	});
</script>
<template>
	<div class="container bg-osecours-beige-dark bg-opacity-10 h-full">
		<DataGridComponent
			:store="documentsStore"
			:model-value="documentsTransformed"
			:description="getCapitalizedText(t('pages.documents.titleAnimal'))"
			:columns="[
				{ label: getCapitalizedText(t('common.name')), key: 'filename' },
				{
					label: getCapitalizedText(t('pages.documents.type')),
					key: 'doctype_name',
				},
				{ label: getCapitalizedText(t('pages.animals.size')), key: 'size' },
				{ label: getCapitalizedText(t('pages.documents.date')), key: 'date' },
			]"
			@edit="editItem"
			@add="addItem"
			@delete="removeItem"
			@documentSaved="handleDocumentSaved"
		/>
	</div>
	<ModalComponent
		:isOpen="showForm"
		@close="showForm = false"
	>
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
