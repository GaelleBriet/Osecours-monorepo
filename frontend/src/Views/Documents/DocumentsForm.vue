<script lang="ts" setup>
	import FormText from '@/Components/Forms/FormText.vue';
	import FormFile from '@/Components/Forms/FormFile.vue';
	import FormDate from '@/Components/Forms/FormDate.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { onMounted, ref, computed } from 'vue';
	import i18n from '@/Services/Translations';
	import { Document } from '@/Interfaces/Document.ts';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import { getNode } from '@formkit/core';
	import { useDocumentsSettingsStore } from '@/Stores/DocumentsSettingsStore.ts';
	import {
		fetchDataAndFormatOptions,
		formatOptions,
	} from '@/Services/Helpers/SelectOptions.ts';

	const documentSettingsStore = useDocumentsSettingsStore();

	const documentsStore = useDocumentsStore();
	const props = defineProps<{
		isCreateMode?: boolean;
		document?: Document;
	}>();

	let localDocument = ref({ ...props.document });
	import { useRoute } from 'vue-router';
	
	const route = useRoute();
	const id = route.params.id;
	const t = i18n.global.t;
	const isEditMode = ref(false);
	let createdDocument = ref<Document>({});
	const newDocument = ref<Document>({});
	const doctypes = ref<DoctypesForSelects[]>([]);
	const showFileForm = computed(() => {
		return isEditMode.value;
	});

	const notificationConfig = ref({
		show: false,
		message: '',
		type: 'info',
	});

	//extract the file extension from the MIME type
	const getFileExtensionFromMimeType = (mimeType: string): string | null => {
		const extensionMap: Record<string, string> = {
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document': 1, // 'docx',
			'application/msword': 2, //'doc',
			'application/vnd.ms-excel': 3, //'xls',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': 4, //'xlsx',
			'application/rtf': 5, // 'rtf',
			'application/pdf': 6, // 'pdf',
			'text/plain': 7, // 'txt',
		};

		return extensionMap[mimeType] || null;
	};
	
	onMounted(async () => {
		if (props.isCreateMode) {
			isEditMode.value = true;
		}
		console.log(props.isCreateMode)
		// on appelle les fonctions pour récupérer les données de l'api pour les passer aux selects
		doctypes.value = await fetchDataAndFormatOptions(
			documentSettingsStore.getAllDoctypes,
			'enums.documentType',
			'Sélectionner une type de document',
		);
		console.log(doctypes)
	
	});

	const onSubmit = async () => {
		// on récupère le formulaire pour vérifier s'il est valide
		let formId = ref('');
		let formNode = ref(null);
		formId.value = !props.isCreateMode
			? `edit-document${localDocument.value.id}`
			: 'create-document';
		formNode.value = getNode(formId.value);
		const isFormValid = formNode.value?.context.state.valid;
		// si le formulaire n'est pas valide, on affiche une notification
		if (!isFormValid) {
			notificationConfig.value = {
				show: true,
				title: 'Un ou plusieurs champs sont invalides',
				message: 'Veuillez vérifier les champs',
				type: 'warning',
			};
			return;
		}
		// on prépare les données de l'document pour l'envoi à l'api
		// Get MIME type of uploaded file
		const fileInputElement = document.getElementById('documents-file');
		const uploadedFile = (fileInputElement as HTMLInputElement).files[0];
		const fileSize = uploadedFile.size;
		const mimeType = uploadedFile.type;
		console.log((fileInputElement as HTMLInputElement))
		
		const documentData = props.isCreateMode
		? createdDocument.value
		: localDocument.value;
		
    	documentData.size = fileSize;
		documentData.mimetype_id = getFileExtensionFromMimeType(mimeType);
		documentData.doctype_id = 1;
		documentData.url = "test";
		console.log(documentData)
		if (!props.isCreateMode) {
			documentData.number = localDocument.value.identification?.number;
		} else {
			documentData.number = createdDocument.value.identification;
		}

		// on envoie les données à l'api
		newDocument.value = props.isCreateMode
			? await documentsStore.createDocument(documentData)
			: await documentsStore.createDocumentForAnimal(id,documentData);

		// on affiche une notification en fonction du résultat de la requête
		if (!newDocument.value) {
			notificationConfig.value = {
				show: true,
				title: 'Une erreur est survenue',
				message: 'Veuillez contacter le support',
				type: 'error',
			};
			return;
		} else if (newDocument.value) {
			notificationConfig.value = {
				show: true,
				title: 'Succès',
				message: !props.isCreateMode
					? `Le document ${localDocument.value?.name || ''} a bien été mis à jour`
					: `Le document ${createdDocument.value?.name || ''} a bien été créé`,
				type: 'success',
			};
			// on réinitialise les valeurs du formulaire
			if (props.isCreateMode) {
				createdDocument.value = {};
			} else {
				localDocument.value = { ...newDocument.value };
				isEditMode.value = false;
			}
		}
	};
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
							:model-value="!isCreateMode ? localDocument.filename : createdDocument.filename"
							:label="getCapitalizedText(t('pages.documents.filename'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="getCapitalizedText(t('pages.documents.filename'))"
							:disabled="!isEditMode"
							:validation="'required'"
							@update:model-value="
								!isCreateMode
										? (localDocument.filename = $event)
										: (createdDocument.filename = $event)"
							/>
						</div>
						<div class="col-start-1 lg:row-start-2">
							<FormTextArea
								id="document-description"						
								:model-value="!isCreateMode ? localDocument.description : createdDocument.description"
								:label="getCapitalizedText(t('pages.animals.description'))"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="getCapitalizedText(t('pages.documents.description'))"
								:disabled="!isEditMode"
								:validation="'required'"
								@update:model-value="
								!isCreateMode
									? (localDocument.description = $event)
									: (createdDocument.description = $event)"
							/>
						</div>
						<div class="col-start-1 lg:row-start-3">
							<FormSelect
								id="document-type"
								:model-value="
									!isCreateMode ? localDocument?.doctype_id : createdDocument.doctype_id
								"
								:name="'document-type'"
								:label="getCapitalizedText(t('pages.documents.type'))"
								:options="doctypes"
								:disabled="!isEditMode"
								:validation="'required'"
								:validation-visibility="'blur'"
								@update:model-value="!isCreateMode
									? (localDocument.doctype_id = $event)
									: (createdDocument.doctype_id = $event)
								"
							/>
						</div>
						<div class="col-start-1 lg:row-start-4">
							<FormDate
								id="document-date"
								:model-value="
									!isCreateMode ? localDocument?.date : createdDocumlocalDocument.date
								"
								:name="'document-date'"
								:label="getCapitalizedText(t('pages.documents.date'))"
								:disabled="!isEditMode"
								:validation="`date_before:${new Date(Date.now() + 24 * 60 * 60 * 1000).toISOString().split('T')[0]}`"
								:validation-visibility="'blur'"
								@update:modelValue="
									!isCreateMode
										? (localDocument.date = $event)
										: (createdDocumlocalDocument.date = $event)
								"
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