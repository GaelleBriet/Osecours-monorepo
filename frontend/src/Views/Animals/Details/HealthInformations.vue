<script lang="ts" setup>
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import VaccinesList from '@/Views/Animals/Health/VaccinesList.vue';
	import SizeWeight from '@/Views/Animals/Health/SizeWeight.vue';
	import VaccinesForm from '@/Views/Animals/Health/VaccinesForm.vue';
	import ModalComponent from '@/Components/ModalComponent.vue';
	import DocumentsForm from '@/Views/Documents/DocumentsForm.vue';
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { onMounted, ref, computed } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { animalHealthMock } from '@/Services/DatasMock/AnimalsHealthDatasMock.ts';
	import i18n from '@/Services/Translations';
	import { useRoute, useRouter } from 'vue-router';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';

	// defineProps<{
	// 	animal: Animal;
	// }>();

	const animal = ref({ ...animalHealthMock });
	const animalVaccines = ref(animal.value.vaccines);
	const animalHealth = ref(animal.value.health);
	let healthReport = ref('');
	let vaccineToAdd = ref({
		vaccine: '',
		date: '',
	});
	
	const documents = ref<Document[]>([]);
	const route = useRoute();
	const documentsStore = useDocumentsStore();
	const t = i18n.global.t;
	const isEditMode = ref(false);
	const router = useRouter();
	const showForm = ref(false);

	// paramètres de la notification
	const notificationConfig = ref({
		show: false,
		title: '',
		message: '',
		type: 'info',
	});

	
	onMounted(async () => {
		const docsByAnimal = await documentsStore.getDocumentsByAnimal(route.params.id as string);
    	const imageDocs = docsByAnimal.filter(doc => {
			return doc.doctype_id === 3;
		});
    	documents.value = imageDocs;
	});

	const documentsTransformed = computed(() => {
		return documents.value.map((document) => ({
			...document
		}));
	});

	const onButtonClick = () => {
		isEditMode.value = !isEditMode.value;
	};

	const editItem = (item) => {
		router.push({
			name: 'EditDocument',
			params: { id: item.id },
		});
	};

	const addItem = () => {
		showForm.value = true;
		console.log(showForm.value)
		return false;
	};

	const removeItem = (item) => {
		documentsStore.deleteDocument(item.id);
	};

	const onSave = () => {
		// animal.value.vaccines.push(vaccineToAdd.value);
		// animal.value.health = healthReport.value;
		// TODO: send animal health data to store
		notificationConfig.value = {
			show: true,
			title: getCapitalizedText(t('common.success')),
			message: getCapitalizedText(t('common.saved')),
			type: 'warning',
		};
		isEditMode.value = false;
	};
</script>
<template>
	<div class="animal-health bg-osecours-beige-dark bg-opacity-10">
		<Form
			ref="animalHealthForm"
			id="animal-health-form"
			:actions="false"
		>
			<div
				class="h-full lg:h-full grid grid-cols-1 grid-rows-none md:grid-cols-2 md:grid-rows-none gap-0 flex-grow rounded-b-lg shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div class="px-2 py-2 w-full md:col-start-1">
					<VaccinesList :vaccines="animalVaccines" />
				</div>
				<div class="px-2 py-2 w-full md:col-start-2">
					<SizeWeight :measures="animalHealth" />
				</div>

				<div class="w-full px-2 py-2 md:col-start-1 md:row-start-2">
					<VaccinesForm
						:edit-mode="isEditMode"
						@update:vaccineType="vaccineToAdd.vaccine = $event"
						@update:vaccineDate="vaccineToAdd.date = $event"
					/>
				</div>
				<div class="px-2 py-2 w-full md:col-start-2 md:row-start-2">
					<p class="mb-5">
						<span
							class="border-b-2 border-osecours-pink border-opacity-50 text-osecours-black text-lg"
						>
							Ajouter un commentaire
						</span>
					</p>
					<FormTextArea
						id="health-information"
						placeholder="Ajouter une information de santé"
						:disabled="!isEditMode"
						@update:modelValue="healthReport = $event"
					/>
				</div>

				<div class="px-2 pt-2 md:col-start-1 md:col-span-2 md:row-start-3">
					<p>
						<span
							class="border-b-2 border-osecours-pink border-opacity-50 text-osecours-black text-lg"
						>
							Health documents
						</span>
					</p>
					<DataGridComponent
						:store="documentsStore" 
						:model-value="documentsTransformed"
						:description="getCapitalizedText(t('pages.documents.titleHealthAnimal'))"
						:columns="[
							{ label: getCapitalizedText(t('common.name')), key: 'filename' },
							{ label: getCapitalizedText(t('pages.documents.type')), key: 'mimeType' },
							{ label: getCapitalizedText(t('pages.animals.size')), key: 'size' },
							{ label: getCapitalizedText(t('pages.documents.date')), key: 'date' },
						]"
						@edit="editItem"
						@add="addItem"
						@delete="removeItem"
					/>   
				</div>	
				<ModalComponent :isOpen="showForm" @close="showForm = false">
					<DocumentsForm
						:is-create-mode="true"
						:is-photo-mode="false"
					/>
				</ModalComponent>			
				<div
					class="md:justify-end justify-end flex flex-row p-2 md:pb-4 md:col-start-2 md:row-start-4 md:items-end"
				>
					<button
						id="edit-mode"
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded hover:bg-blue-600 transition-colors"
						@click.prevent="onButtonClick"
					>
						{{
							isEditMode
								? getCapitalizedText(t('common.cancel'))
								: getCapitalizedText(t('common.editMode'))
						}}
					</button>
					<button
						id="save-changes"
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
						:disabled="!isEditMode"
						@click.prevent="onSave"
					>
						{{ getCapitalizedText(t('common.register')) }}
					</button>
				</div>
			</div>
		</Form>
	</div>
</template>
<style scoped lang="postcss">
	.animal-health {
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
