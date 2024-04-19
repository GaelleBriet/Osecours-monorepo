<script lang="ts" setup>
	import FormText from '@/Components/Forms/FormText.vue';
	import FormFile from '@/Components/Forms/FormFile.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { onMounted, ref, computed } from 'vue';
	import i18n from '@/Services/Translations';
	import { Document } from '@/Interfaces/Document.ts';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import { useRoute } from 'vue-router';
	
	const route = useRoute();
	const documentId = route.params.id;
	const documentsStore = useDocumentsStore();
	const props = defineProps<{
		isCreateMode?: boolean;
		document?: Document;
	}>();

console.log(documentId)
	let localDocument = ref({ ...props.document });

	const t = i18n.global.t;
	const isEditMode = ref(false);
	let createdDocument = ref<Document>({});
	const showFileForm = computed(() => {
		return isEditMode.value;
	});

	const notificationConfig = ref({
		show: false,
		message: '',
		type: 'info',
	});

	const onSubmit = async () => {
		if (props.isCreateMode) {
			const newDocument = await documentsStore.createDocument(createdDocument.value);
		}
		if (!props.isCreateMode) {
			const documentToUpdate = await documentsStore.updateDocument(localDocument.value);
			// const documentToUpdate = props.document;
		}
		
		// Si l'api à bien répondu, on affiche la notification
		// et on stop le mode edition
		//@todo: adapter le message suivant la réponse de l'api
		notificationConfig.value = {
			show: true,
			message: !props.isCreateMode
				? `${getCapitalizedText(t('pages.documents.document'))} ${documentToUpdate?.name} ${getCapitalizedText(t('common.update'))}`
				: `${getCapitalizedText(t('pages.documents.document'))} ${documentToUpdate?.name} ${getCapitalizedText(t('common.creation'))}`,
			type: 'success',
		};
		isEditMode.value = false;
	};
	onMounted(() => {
		if (props.isCreateMode) {
			isEditMode.value = true;
		}
	});
	console.log(isEditMode)
</script>

<template>
	<div class="general-informations">
		<Form
			:id="!isCreateMode ? `edit-document${localDocument.id}` : 'create-document'"
			:submit-label="'edit-document'"
			:actions="false"
		>
			<div
				class="h-full lg:h-full grid lg:grid:cols-2 lg:grid-rows-1 bg-osecours-beige-dark bg-opacity-10 rounded-b-lg shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div className="grid lg:grid-cols-2 gap-4 lg:pb-10">
					<div v-if="showFileForm" class="lg:col-start-2 lg:row-start-1 lg:pb-0 pb-7">
						<FormFile
								id="documents-file"			
								:label="getCapitalizedText(t('pages.documents.file'))"									
								accept=".pdf,.doc,.docx,.xls,.xlsx,.rtf,.txt"
								:help="getCapitalizedText(t('pages.documents.help'))"
								file-item-icon="fileDoc"
								:multiple="true"
								no-files-icon="fileDoc"
								outer-class="h-full"
								wrapper-class="h-full"
								inner-class="h-full"
							/>  
					</div>
					<div>
						<div class="col-start-1 lg:row-start-1">
							<FormText
							id="document-name"
							:model-value="!isCreateMode ? document.filename : createdDocument.filename"
							:label="getCapitalizedText(t('pages.documents.filename'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="getCapitalizedText(t('pages.documents.filename'))"
							:disabled="!isEditMode"
							@update:model-value="
								!isCreateMode
										? (localAnimal.filename = $event)
										: (createdAnimal.filename = $event)"
							/>
						</div>
						<div class="col-start-1 lg:row-start-2">
							<FormTextArea
								id="document-description"						
								:model-value="!isCreateMode ? document.description : createdDocument.description"
								:label="getCapitalizedText(t('pages.animals.description'))"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="getCapitalizedText(t('pages.documents.description'))"
								:disabled="!isEditMode"
								@update:model-value="
								!isCreateMode
									? (localDocument.description = $event)
									: (createdDocument.description = $event)"
							/>
						</div>
					</div>
								
				</div>				
				<div
					class="my-1 lg:my-3 row-start-2 lg:row-start-2"
				>
					<div class="grid lg:grid-cols-2">
						<div class="flex flex-row justify-end lg:col-start-2">
							<button
								v-if="!isCreateMode"
								id="edit-mode"
								class="w-1/2 me-1.5 px-4 py-2 bg-blue-500 text-white lg:text-sm rounded hover:bg-blue-600 transition-colors"
								@click.prevent="isEditMode = !isEditMode"
							>
								{{
									isEditMode
										? getCapitalizedText(t('common.cancel'))
										: getCapitalizedText(t('common.editMode'))
								}}
							</button>
							<button
								id="save-changes"
								class="w-1/2 me-1.5 px-4 py-2 bg-green-500 text-white lg:text-sm rounded hover:bg-green-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
								:disabled="!isEditMode"
								@click.prevent="onSubmit"
							>
								{{ getCapitalizedText(t('common.register')) }}
							</button>
						</div>
					</div>
				</div>
			</div>
		</Form>
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

	.formkit-outer[data-disabled] {
		opacity: 0.8;
		pointer-events: none;
	}

	.general-informations {
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