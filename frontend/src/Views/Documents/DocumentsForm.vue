<script lang="ts" setup>
	import FormText from '@/Components/Forms/FormText.vue';
	import FormFile from '@/Components/Forms/FormFile.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { DoctypesForSelects } from '@/Interfaces/Documents/Doctypes.ts';
	import { Document } from '@/Interfaces/Documents/Documents.ts';
	import i18n from '@/Services/Translations';
	import { onMounted, ref, computed } from 'vue';
	import { getNode } from '@formkit/core';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import { defineEmits } from 'vue';
	import { useRoute } from 'vue-router';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { useDocumentsSettingsStore } from '@/Stores/DocumentsSettingsStore.ts';
	import { fetchDataAndFormatOptions } from '@/Services/Helpers/SelectOptions.ts';

	const route = useRoute();
	const t = i18n.global.t;
	const documentSettingsStore = useDocumentsSettingsStore();
	const documentsStore = useDocumentsStore();

	const emit = defineEmits(['documentSaved']);

	const props = defineProps<{
		isCreateMode?: boolean;
		isPhotoMode?: boolean;
		document?: Document;
	}>();

	let localDocument = ref({ ...props.document });
	let createdDocument = ref<Document>({});
	const newDocument = ref<Document>({});
	const doctypes = ref<DoctypesForSelects[]>([]);
	const id = route.params.id;
	const isEditMode = ref(false);
	const showFileForm = computed(() => {
		return isEditMode.value;
	});
	const notificationConfig = ref({
		show: false,
		message: '',
		type: 'info',
	});
	console.log(localDocument)

	onMounted(async () => {
		if (props.isCreateMode) {
			isEditMode.value = true;
		}
		// on appelle les fonctions pour récupérer les données de l'api pour les passer aux selects
		doctypes.value = await fetchDataAndFormatOptions(
			documentSettingsStore.getAllDoctypes,
			'enums.documentType',
			`${getCapitalizedText(t('pages.documents.selectTypeDocs'))}`,
		);
	});

	const isFormValid = () => {
		let formId = ref('');
		let formNode = ref(null);
		formId.value = !props.isCreateMode
			? `edit-document${localDocument.value.id}`
			: 'create-document';
		formNode.value = getNode(formId.value);
		return formNode.value?.context.state.valid;
	};

	const onSubmit = async () => {
		// si le formulaire n'est pas valide, on affiche une notification
		if (!isFormValid) {
			notificationConfig.value = {
				show: true,
				title: `${getCapitalizedText(t('form.messages.warning'))}`,
				message: `${getCapitalizedText(t('form.messages.check'))}`,
				type: 'warning',
			};
			return;
		}

		// on prépare les données de l'document pour l'envoi à l'api
		const formData = props.isCreateMode
			? createdDocument.value
			: localDocument.value;
		const fileInput = document.getElementById('document-file');
		const files = fileInput?.files;
		const file = files[0];

		// formData.append('filename', localDocument.value.filename);
		// formData.append('description', localDocument.value.description);
		formData.file = file;

		const documentData = props.isCreateMode
			? createdDocument.value
			: localDocument.value;

		if (!props.isCreateMode) {
			documentData.number = localDocument.value.identification?.number;
		} else {
			documentData.number = createdDocument.value.identification;
		}

		// on envoie les données à l'api
		newDocument.value = props.isCreateMode
			? await documentsStore.createDocumentForAnimal(id, formData)
			: await documentsStore.updateDocument(id, formData);

		// on affiche une notification en fonction du résultat de la requête
		if (!newDocument.value) {
			notificationConfig.value = {
				show: true,
				title: `${getCapitalizedText(t('form.messages.errorGeneral'))}`,
				message: `${getCapitalizedText(t('pages.animals.messages.updateDocSuccess'))}`,
				type: 'error',
			};
			return;
		} else if (newDocument.value) {
			notificationConfig.value = {
				show: true,
				title: `${getCapitalizedText(t('common.success'))}`,
				message: !props.isCreateMode
					? `${getCapitalizedText(t('pages.animals.messages.updateDocSuccess'))}`
					: `${getCapitalizedText(t('pages.animals.messages.createDocSuccess'))}`,
				type: 'success',
			};
			// on réinitialise les valeurs du formulaire
			if (props.isCreateMode) {
				createdDocument.value = {};
			} else {
				localDocument.value = { ...newDocument.value };
				isEditMode.value = false;
			}
			emit('documentSaved');
		}
	};
</script>

<template>
	<div class="documents-view bg-osecours-beige-dark bg-opacity-10">
		<Form
			:id="
				!isCreateMode
					? `edit-document${localDocument.id ?? -1}`
					: 'create-document'
			"
			:submit-label="'edit-document'"
			:actions="false"
		>
			<div
				class="h-full lg:h-full grid lg:grid:cols-2 lg:grid-rows-2 bg-osecours-beige-dark bg-opacity-10 rounded-b-lg shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div className="grid lg:grid-cols-2 gap-4 lg:pb-10">
					<div
						v-if="showFileForm"
						class="lg:col-start-2 lg:row-start-1 lg:pb-0 pb-7"
					>
						<FormFile
							:id="'document-file'"
							:model-value="
								!isCreateMode ? localDocument.file : createdDocument.file
							"
							:label="
								isPhotoMode
									? getCapitalizedText(t('pages.documents.filePhotos'))
									: getCapitalizedText(t('pages.documents.file'))
							"
							:accept="
								isPhotoMode
									? '.jpg,.bmp,.png'
									: '.pdf,.doc,.docx,.jpg,.bmp,.png'
							"
							:help="getCapitalizedText(t('pages.documents.help'))"
							file-item-icon="fileDoc"
							:multiple="true"
							no-files-icon="fileDoc"
							outer-class="h-full"
							wrapper-class="h-full"
							inner-class="h-full"
							@update:modelValue="
								!isCreateMode
									? (localDocument.file = $event)
									: (createdDocument.file = $event)
							"
						/>
					</div>
					<div>
						<div class="col-start-1 lg:row-start-1">
							<FormText
								id="document-name"
								:model-value="
									!isCreateMode
										? localDocument.filename
										: createdDocument.filename
								"
								:label="getCapitalizedText(t('pages.documents.filename'))"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="getCapitalizedText(t('pages.documents.filename'))"
								:disabled="!isEditMode"
								:validation="'required'"
								@update:model-value="
									!isCreateMode
										? (localDocument.filename = $event)
										: (createdDocument.filename = $event)
								"
							/>
						</div>
						<div class="col-start-1 lg:row-start-2">
							<FormTextArea
								id="document-description"
								:model-value="
									!isCreateMode
										? localDocument.description
										: createdDocument.description
								"
								:label="getCapitalizedText(t('pages.animals.description'))"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="
									getCapitalizedText(t('pages.documents.description'))
								"
								:disabled="!isEditMode"
								:validation="'required'"
								@update:model-value="
									!isCreateMode
										? (localDocument.description = $event)
										: (createdDocument.description = $event)
								"
							/>
						</div>
						<div class="col-start-1 lg:row-start-3">
							<FormSelect
								id="document-type"
								:model-value="
									!isCreateMode
										? localDocument?.doctype_id
										: createdDocument.doctype
								"
								:name="'document-type'"
								:label="getCapitalizedText(t('pages.documents.type'))"
								:options="doctypes"
								:disabled="!isEditMode"
								:validation="'required'"
								:validation-visibility="'blur'"
								@update:model-value="
									!isCreateMode
										? (localDocument.doctype_id = $event)
										: (createdDocument.doctype = $event)
								"
							/>
						</div>
					</div>
				</div>
				<div class="my-1 lg:my-3 row-start-2 lg:row-start-2">
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
	.documents-view {
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
