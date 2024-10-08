<script lang="ts" setup>
	import Form from '@/Components/Forms/Form.vue';
	import ModalComponent from '@/Components/ModalComponent.vue';
	import DocumentsForm from '@/Views/Documents/DocumentsForm.vue';
	import { Document } from '@/Interfaces/Documents/Documents.ts';
	import { Animal } from '@/Interfaces/Animals/Animal.ts';
	import { ref, onMounted } from 'vue';
	import { useRoute, useRouter } from 'vue-router';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import LoaderComponent from '@/Components/LoaderComponent.vue';

	const props = defineProps<{
		animal: Animal;
	}>();

  const t = i18n.global.t;
	const showForm = ref(false);
	const documentsStore = useDocumentsStore();
	const documents = ref<Document[]>([]);
	const route = useRoute();
	const router = useRouter();
	const showModal = ref(false);
	const documentToDelete = ref<Document | null>(null);

	const fetchDocuments = async () => {
		const docsByAnimal = await documentsStore.getDocumentsByAnimal(
			route.params.id as string,
		);
		const imageDocs = docsByAnimal.filter((doc) => {
			const isImageDocType = doc.doctype_id === 2;
			const isImageUrl = /\.(jpg|jpeg|png|gif)$/i.test(doc.url);
			return isImageDocType && isImageUrl;
		});
		documents.value = imageDocs;
	};

	const handleDocumentSaved = () => {
		fetchDocuments();
		showForm.value = false;
	};

	const editItem = (item) => {
		router.push({
			name: 'EditDocument',
			params: { id: item.id },
		});
	};

	const addPhoto = () => {
		showForm.value = true;
	};

	const openModal = (event, item: Document) => {
		event.preventDefault()
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
	<div class="animal-documents bg-osecours-beige-dark bg-opacity-10 h-full">
		<Form
			:id="`edit-animal`"
			:submit-label="'edit-animal'"
			:actions="false"
			>
			<div 
				class="h-full"
				v-if="!documentsStore.isLoading"
			>
				<div
					class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4 p-2 md:p-4"
				>
					<!-- Miniatures des photos -->
					<div
						v-for="(photo, index) in documents"
						:key="index"
						class="relative"
					>
						<a
							:href="photo.url"
							target="_blank"
							rel="noopener noreferrer"
						>
							<img
								:src="photo.url"
								:alt="'Photo de ' + getCapitalizedText(props.animal.name)"
								class="w-full h-28 object-cover rounded-lg shadow-md"
							/>
						</a>
						<button
							class="absolute top-1 right-1 bg-osecours-pink text-osecours-white hover:bg-white hover:text-osecours-pink rounded-full p-1 w-5 h-5 flex items-center justify-center"
							@click="openModal($event, photo)"
						>
							&times;
							<!-- Symbole de multiplication utilisé pour l'icône de suppression -->
						</button>
						<button
							class="absolute top-7 right-1 bg-yellow-500 hover:bg-white text-osecours-white rounded-full p-1 w-5 h-5 flex items-center justify-center"
							@click="editItem(photo)"
						>
							<i class="icon-pencil hover:text-yellow-500 text-xs" />
						</button>
					</div>
					<button
						type="button"
						class="w-full h-28 bg-gray-200 hover:bg-gray-100 rounded-lg shadow-md flex justify-center items-center"
						@click="addPhoto()"
					>
						<span>+</span>
					</button>
				</div>
			</div>
			<ModalComponent
				:isOpen="showForm"
				:docForm="true"
				@close="showForm = false"
			>
				<DocumentsForm
					:is-create-mode="true"
					:is-photo-mode="true"
					@documentSaved="handleDocumentSaved"
				/>
			</ModalComponent>
		</Form>
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
</template>
<style scoped lang="postcss">
	#edit-mode {
		background-color: rgba(242, 138, 128);
		color: #fff;

		&:hover {
			background-color: var(--color-withe);
			color: #f28a80;
			outline: 1px solid #f28a80;
		}
	}

	#save-changes {
		background-color: rgb(199, 123, 51);
		color: #fff;

		&:hover {
			background-color: var(--color-withe);
			color: rgb(199, 123, 51);
			outline: 1px solid rgb(199, 123, 51);
		}
	}

	form {
		display: flex;
		flex-grow: 1;
		flex-direction: column;
	}
</style>
