<script lang="ts" setup>
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import VaccinesList from '@/Views/Animals/Health/VaccinesList.vue';
	import SizeWeight from '@/Views/Animals/Health/SizeWeight.vue';
	import VaccinesForm from '@/Views/Animals/Health/VaccinesForm.vue';
	import AddDocument from '@/Views/Animals/Health/AddDocument.vue';
	import { onMounted, ref, watch } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';

	const animalsStore = useAnimalsStore();
	const animal = ref({ ...animalsStore.animal });
	const animalVaccines = ref(animal.value.vaccines);
	const animalHealth = ref(animal.value.healthcares);
	let healthReport = ref('');
	let vaccineToAdd = ref({
		vaccine: '',
		date: '',
	});
	const currentAnimalId = ref(animalsStore.animal.id);
	const t = i18n.global.t;
	const isEditMode = ref(false);

	// paramètres de la notification
	const notificationConfig = ref({
		show: false,
		title: '',
		message: '',
		type: 'info',
	});

	const onButtonClick = () => {
		isEditMode.value = !isEditMode.value;
	};

	const onSave = () => {
		const result = addVaccine(
			vaccineToAdd.value.vaccine,
			currentAnimalId.value,
			healthReport.value,
			vaccineToAdd.value.date,
		);

		if (!result) {
			notificationConfig.value = {
				show: true,
				title: getCapitalizedText(t('common.error')),
				message: getCapitalizedText(t('pages.animals.messages.updateError')),
				type: 'error',
			};
		} else {
			notificationConfig.value = {
				show: true,
				title: getCapitalizedText(t('common.success')),
				message: getCapitalizedText(t('pages.animals.messages.updateSuccess')),
				type: 'success',
			};
		}
		isEditMode.value = false;
	};

	const addVaccine = async (
		vaccineToAdd: string,
		currentAnimalId: number,
		healthReport: string,
		vaccineDate: string,
	) => {
		if (!vaccineDate) {
			vaccineDate = new Date().toISOString();
		}
		if (!healthReport) {
			healthReport = `vaccine ${vaccineToAdd} added.`;
		}

		const updatedAnimal = await animalsStore.vaccineAnimal(
			vaccineToAdd,
			currentAnimalId,
		);

		const updatedHealth = await animalsStore.addAnimalHealth(
			prepareHealthCare(healthReport, vaccineDate, currentAnimalId),
		);

		if (updatedAnimal && updatedHealth) {
			animalVaccines.value = animalsStore.animal.vaccines;
			animalHealth.value.push(updatedHealth);
			return true;
		}
		return false;
	};

	const addAnimalHealth = async (healthReport: object) => {
		await animalsStore.addAnimalHealth(healthReport);
	};

	const prepareHealthCare = (
		healthReport: string,
		vaccineDate: string,
		currentAnimalId: number,
	) => {
		const healthCare = {
			report: healthReport,
			date: vaccineDate,
			animal_id: currentAnimalId,
		};
		return healthCare;
	};

	watch(
		() => animalHealth.value,
		(newValue) => {
			console.log('animalHealth', newValue);
		},
	);
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
				<div class="px-2 md:col-start-1 md:row-start-3">
					<AddDocument :edit-mode="isEditMode" />
				</div>
				<div
					class="md:justify-end justify-end flex flex-row p-2 md:pb-4 md:col-start-2 md:row-start-3 md:items-end"
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
