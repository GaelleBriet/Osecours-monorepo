<script lang="ts" setup>
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { ref } from 'vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import VaccinesList from '@/Views/Animals/Health/VaccinesList.vue';
	import SizeWeight from '@/Views/Animals/Health/SizeWeight.vue';
	import VaccinesForm from '@/Views/Animals/Health/VaccinesForm.vue';
	import AddDocument from '@/Views/Animals/Health/AddDocument.vue';
	import { animalHealthMock } from '@/Services/DatasMock/AnimalsHealthDatasMock.ts';

	// defineProps<{
	// 	animal: Animal;
	// }>();

	const animal = ref({ ...animalHealthMock });
	const animalVaccines = ref(animal.value.vaccines);
	const animalHealth = ref(animal.value.health);
	console.log(animalVaccines.value);

	// paramètres de la notification
	const notificationConfig = ref({
		show: false,
		title: '',
		message: '',
		type: 'info',
	});
</script>
<template>
	<div class="animal-health bg-osecours-beige-dark bg-opacity-10">
		<Form
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
					<VaccinesForm />
				</div>
				<div class="px-2 py-2 w-full md:col-start-2 md:row-start-2">
					<FormTextArea
						id="health-information"
						label="Informations de santé"
						placeholder="Ajouter une information de santé"
						:required="true"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-3">
					<AddDocument />
				</div>
				<div
					class="md:justify-end justify-end flex flex-row p-2 md:pb-4 md:col-start-2 md:row-start-3 md:items-end"
				>
					<button
						id="edit-mode"
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded hover:bg-blue-600 transition-colors"
					>
						blabla
					</button>
					<button
						id="save-changes"
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
					>
						button
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
		background-color: #d99962;
		color: #fff;
		&:hover {
			background-color: var(--color-withe);
			color: #d99962;
			outline: 1px solid #d99962;
		}
	}
	form {
		display: flex;
		flex-grow: 1;
		flex-direction: column;
	}
</style>
