<script setup lang="ts">
	import Form from '@/Components/Forms/Form.vue';
	import FormDate from '@/Components/Forms/FormDate.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import FormText from '@/Components/Forms/FormText.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { Animal } from '@/Interfaces/Animal.ts';
	import {
		AnimalAges,
		AnimalGenders,
		AnimalSizes,
		AnimalSpecies,
		AnimalStatus,
	} from '@/Enums/Animals.ts';
	import i18n from '@/Services/Translations';
	import { generateOptionsFromEnum } from '@/Services/Helpers/Enums.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { onMounted, ref } from 'vue';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { useAnimalsSettingsStore } from '@/Stores/AnimalsSettingsStore.ts';
	import { Breed } from '@/Interfaces/Breed.ts';

	const animalsStore = useAnimalsStore();
	const animalSettingsStore = useAnimalsSettingsStore();

	const props = defineProps<{
		isCreateMode?: boolean;
		animal?: Animal;
	}>();

	const t = i18n.global.t;
	const isEditMode = ref(false);
	let localAnimal = ref({ ...props.animal });
	let createdAnimal = ref<Animal>({});

	const notificationConfig = ref({
		show: false,
		message: '',
		type: 'info',
	});

	//@todo: à supprimer quand l'api sera prête (on utilisera un appel api à la place des enums)
	const animalSpeciesOptions = generateOptionsFromEnum(
		AnimalSpecies,
		'enums.animalSpecies',
	);
	const animalStatusOptions = generateOptionsFromEnum(
		AnimalStatus,
		'enums.animalStatus',
	);
	const animalGendersOptions = generateOptionsFromEnum(
		AnimalGenders,
		'enums.animalGenders',
	);
	const animalSizeOptions = generateOptionsFromEnum(
		AnimalSizes,
		'enums.animalSizes',
	);
	const animalAgeRangeOptions = generateOptionsFromEnum(
		AnimalAges,
		'enums.animalAges',
	);

	const breeds = ref<Breed[]>([]);

	const onSubmit = async () => {
		if (props.isCreateMode) {
			const newAnimal: Animal = await animalsStore.createAnimal(
				createdAnimal.value,
			);
		}
		if (!props.isCreateMode) {
			const animalToUpdate = await animalsStore.updateAnimal(localAnimal.value);
			// const animalToUpdate = props.animal;
		}
		// Si l'api à bien répondu, on affiche la notification
		// et on stop le mode edition
		//@todo: adapter le message suivant la réponse de l'api
		notificationConfig.value = {
			show: true,
			message: !props.isCreateMode
				? `L'animal ${localAnimal.value?.name} a bien été mis à jour`
				: `L'animal ${createdAnimal.value?.name} a bien été créé`,
			type: 'success',
		};
		isEditMode.value = false;
	};

	// @todo: à compléter et décommenter quand l'api sera prête, et insérer les données dans les selects :options="speciesOptions"
	//const speciesOptions = ref<{ value: number; label: string }[]>([]);
	// const coatsOptions = ref([]);
	// onMounted(async () => {
	// 	const results = await Promise.all([getAllSpecies(), getAllCoats()]);
	// 	[speciesOptions.value, coatsOptions.value] = results.map((result) =>
	// 		Array.isArray(result)
	// 			? result.map((item) => ({
	// 					value: item.id,
	// 					label: item.name,
	// 				}))
	// 			: [],
	// 	);
	// });
	onMounted(async () => {
		await animalSettingsStore.getAllBreeds();
		breeds.value = animalSettingsStore.breeds.map((breed) => {
			return {
				...breed,
				name: getCapitalizedText(t(`enums.animalsBreeds.${breed.name}`)),
				description: breed.description,
			};
		});
		console.log(breeds.value);
	});

	onMounted(() => {
		if (props.isCreateMode) {
			isEditMode.value = true;
		}
	});
</script>
<template>
	<div class="general-informations">
		<Form
			:id="!isCreateMode ? `edit-animal${localAnimal.id}` : 'create-animal'"
			:submit-label="'edit-animal'"
			:actions="false"
		>
			<div
				class="h-full lg:h-full grid grid-cols-1 grid-rows-none md:grid-cols-2 md:grid-rows-none gap-1 flex-grow bg-osecours-beige-dark bg-opacity-10 rounded-b-lg shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div class="px-2 w-full md:col-start-1">
					<FormText
						id="animal-name"
						:model-value="!isCreateMode ? animal.name : createdAnimal.name"
						:label="getCapitalizedText(t('common.name'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Nom de l\'animal'"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.name = $event)
								: (createdAnimal.name = $event)
						"
					/>
				</div>
				<div class="px-2 w-full md:col-start-2">
					<FormText
						id="animal-icad-number"
						:model-value="!isCreateMode ? animal.icad : createdAnimal.icad"
						:name="'animal-icad-number'"
						:label="getCapitalizedText(t('pages.animals.icad'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'123456123456789'"
						:validation="'number'"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.icad = $event)
								: (createdAnimal.icad = $event)
						"
					/>
				</div>

				<div class="w-full px-2 md:col-start-1 md:row-start-2">
					<FormSelect
						id="animal-species"
						:model-value="
							!isCreateMode ? animal.species : createdAnimal.specie_id
						"
						:name="'animal-species'"
						:label="getCapitalizedText(t('pages.animals.species'))"
						:options="animalSpeciesOptions"
						placeholder="Choisir une espèce"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.species = $event)
								: (createdAnimal.specie_id = $event)
						"
					/>
				</div>
				<div class="px-2 w-full md:col-start-2 md:row-start-2">
					<FormText
						id="animal-breed"
						:model-value="!isCreateMode ? animal.breed : createdAnimal.breed"
						:label="getCapitalizedText(t('pages.animals.breed'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Boxer, Berger Allemand ...'"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.breed = $event)
								: (createdAnimal.breed = $event)
						"
					/>
					<!--					<FormSelect-->
					<!--						id="animalBreed"-->
					<!--						:model-value="!isCreateMode ? animal.breed : createdAnimal.breed"-->
					<!--						:label="getCapitalizedText(t('pages.animals.breed'))"-->
					<!--						class="w-full border border-gray-300 rounded shadow-sm"-->
					<!--						:options="breeds"-->
					<!--						placeholder="'Boxer, Berger Allemand ...'"-->
					<!--						:disabled="!isEditMode"-->
					<!--						name="animalBreed"-->
					<!--						@update:model-value="-->
					<!--							!isCreateMode-->
					<!--								? (localAnimal.breed = $event)-->
					<!--								: (createdAnimal.breed = $event)-->
					<!--						"-->
					<!--					/>-->
				</div>
				<div class="p-2 md:col-start-1 md:row-start-7 md:flex md:items-end">
					<FormTextArea
						id="animal-description"
						:model-value="
							!isCreateMode ? animal.description : createdAnimal.description
						"
						:label="getCapitalizedText(t('pages.animals.description'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Description de l\'animal'"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.description = $event)
								: (createdAnimal.description = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-3">
					<FormSelect
						id="animal-status"
						:model-value="!isCreateMode ? animal.status : createdAnimal.status"
						:name="'animal-status'"
						:label="getCapitalizedText(t('pages.animals.status'))"
						:options="animalStatusOptions"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.status = $event)
								: (createdAnimal.status = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-4">
					<FormSelect
						id="animal-gender"
						:model-value="!isCreateMode ? animal.gender : createdAnimal.gender"
						:name="'animal-gender'"
						:label="getCapitalizedText(t('pages.animals.gender'))"
						:options="animalGendersOptions"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.gender = $event)
								: (createdAnimal.gender = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-2 md:row-start-4">
					<FormSelect
						id="animal-size"
						:model-value="!isCreateMode ? animal.size : createdAnimal.size"
						:name="getCapitalizedText(t('pages.animals.size'))"
						:label="getCapitalizedText(t('pages.animals.size'))"
						:options="animalSizeOptions"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.size = $event)
								: (createdAnimal.size = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-5">
					<FormText
						id="animal-coat"
						:model-value="!isCreateMode ? animal.coat : createdAnimal.coat"
						:label="getCapitalizedText(t('pages.animals.coat'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Robe de l\'animal (type de poils)'"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.coat = $event)
								: (createdAnimal.coat = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-2 md:row-start-5">
					<FormText
						id="animal-color"
						:model-value="!isCreateMode ? animal.color : createdAnimal.color"
						:label="getCapitalizedText(t('pages.animals.color'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Couleur de l\'animal'"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.color = $event)
								: (createdAnimal.color = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-6">
					<FormSelect
						id="animal-age-range"
						:model-value="
							!isCreateMode ? animal.ageRange : createdAnimal.ageRange
						"
						:name="getCapitalizedText(t('pages.animals.ageRange'))"
						:label="getCapitalizedText(t('pages.animals.ageRange'))"
						:options="animalAgeRangeOptions"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.ageRange = $event)
								: (createdAnimal.ageRange = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-2 md:row-start-6">
					<FormDate
						id="animal-date"
						:model-value="
							!isCreateMode ? animal.birthdate : createdAnimal.birthdate
						"
						:name="'animal-date'"
						:label="getCapitalizedText(t('pages.animals.birthdate'))"
						:disabled="!isEditMode"
						@update:modelValue="
							!isCreateMode
								? (localAnimal.birthdate = $event)
								: (createdAnimal.birthdate = $event)
						"
					/>
				</div>
				<div
					:class="[
						isCreateMode ? 'md:justify-end justify-end' : 'justify-between',
						'flex flex-row p-2 md:pb-4 md:col-start-2 md:row-start-7 md:items-end ',
					]"
				>
					<button
						v-if="!isCreateMode"
						id="edit-mode"
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded hover:bg-blue-600 transition-colors"
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
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
						:disabled="!isEditMode"
						@click.prevent="onSubmit"
					>
						{{ getCapitalizedText(t('common.register')) }}
					</button>
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
		background-color: #d99962;
		color: #fff;
		&:hover {
			background-color: var(--color-withe);
			color: #d99962;
			outline: 1px solid #d99962;
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
