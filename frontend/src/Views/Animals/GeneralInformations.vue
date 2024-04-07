<script lang="ts" setup>
	import FormText from '@/Components/Forms/FormText.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import FormDate from '@/Components/Forms/FormDate.vue';
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';

	import {
		AnimalStatus,
		AnimalSpecies,
		AnimalGenders,
		AnimalSizes,
		AnimalAges,
	} from '@/Enums/Animals.ts';
	import { Animal } from '@/Interfaces/Animal.ts';

	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { ref } from 'vue';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { generateOptionsFromEnum } from '@/Services/Helpers/Enums.ts';

	const animalsStore = useAnimalsStore();

	const props = defineProps<{
		animal: Animal;
	}>();

	let localAnimal = ref({ ...props.animal });

	const t = i18n.global.t;
	const isEditMode = ref(false);

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

	const onSubmit = async () => {
		// Logique pour soumettre le formulaire quand l'api sera fonctionnelle
		const animalToUpdate = await animalsStore.updateAnimal(localAnimal.value);
		// const animalToUpdate = props.animal;
		// Si l'api à bien répondu, on affiche la notification
		// et on stop le mode edition
		//@todo: adapter le message suivant la réponse de l'api
		notificationConfig.value = {
			show: true,
			message: `L'animal ${animalToUpdate?.name} a bien été mis à jour`,
			type: 'success',
		};
		isEditMode.value = false;
	};

	// @todo: à compléter et décommenter quand l'api sera prête, et insérer les données dans les selects :options="speciesOptions"
	// const speciesOptions = ref<{ value: number; label: string }[]>([]);
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
</script>

<template>
	<div class="general-informations">
		<Form
			:id="`edit-animal${localAnimal.id}`"
			:submit-label="'edit-animal'"
			:actions="false"
		>
			<div
				class="h-full lg:h-full grid grid-cols-2 grid-rows-none lg:grid-cols-6 lg:grid-rows-17 gap-1 flex-grow bg-osecours-beige-dark bg-opacity-10 rounded-b-lg shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div
					class="col-span-2 row-span-3 col-start-1 row-start-2 lg:col-span-4 lg:row-span-4 lg:row-start-2 lg:col-start-1"
				>
					<div class="mb-1 flex flex-col lg:flex-row justify-around">
						<div class="px-2 w-full lg:w-1/2">
							<FormText
								id="animal-icad-number"
								:model-value="animal.icad"
								:name="'animal-icad-number'"
								:label="getCapitalizedText(t('pages.animals.icad'))"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="'123456123456789'"
								:validation="'number'"
								:disabled="!isEditMode"
								@update:model-value="localAnimal.icad = $event"
							/>
						</div>
						<div class="px-2 w-full lg:w-1/2">
							<FormText
								id="animal-name"
								:model-value="animal.name"
								:label="getCapitalizedText(t('common.name'))"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="'Nom de l\'animal'"
								:disabled="!isEditMode"
								@update:model-value="localAnimal.name = $event"
							/>
						</div>
					</div>
					<div class="mb-1 flex flex-col lg:flex-row justify-around">
						<div class="w-full px-2 lg:w-1/2">
							<FormSelect
								id="animal-species"
								:model-value="animal.species"
								:name="'animal-species'"
								:label="getCapitalizedText(t('pages.animals.species'))"
								:options="animalSpeciesOptions"
								:disabled="!isEditMode"
								@update:model-value="localAnimal.species = $event"
							/>
						</div>
						<div class="px-2 w-full lg:w-1/2">
							<FormText
								id="animal-breed"
								:model-value="animal.breed"
								:label="getCapitalizedText(t('pages.animals.breed'))"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="'Boxer, Berger Allemand ...'"
								:disabled="!isEditMode"
								@update:model-value="localAnimal.breed = $event"
							/>
						</div>
					</div>
					<div class="mb-1 flex flex-col justify-around">
						<div class="p-2">
							<FormTextArea
								id="animal-description"
								:model-value="animal.description"
								:label="getCapitalizedText(t('pages.animals.description'))"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="'Description de l\'animal'"
								:disabled="!isEditMode"
								@update:model-value="localAnimal.description = $event"
							/>
						</div>
					</div>
				</div>
				<div
					class="col-span-2 row-span-8 col-start-1 row-start-5 lg:col-span-2 lg:row-span-6 lg:row-start-2 lg:col-start-5"
				>
					<div class="flex flex-col h-full justify-between">
						<div class="mb-1 flex flex-col justify-around">
							<div class="px-2">
								<FormSelect
									id="animal-status"
									:model-value="animal.status"
									:name="'animal-status'"
									:label="getCapitalizedText(t('pages.animals.status'))"
									:options="animalStatusOptions"
									:disabled="!isEditMode"
									@update:model-value="localAnimal.status = $event"
								/>
							</div>
							<div class="px-2">
								<FormSelect
									id="animal-gender"
									:model-value="animal.gender"
									:name="'animal-gender'"
									:label="getCapitalizedText(t('pages.animals.gender'))"
									:options="animalGendersOptions"
									:disabled="!isEditMode"
									@update:model-value="localAnimal.gender = $event"
								/>
							</div>
							<div class="px-2">
								<FormText
									id="animal-coat"
									:model-value="animal.coat"
									:label="getCapitalizedText(t('pages.animals.coat'))"
									class="w-full border border-gray-300 rounded shadow-sm"
									:placeholder="'Robe de l\'animal (type de poils)'"
									:disabled="!isEditMode"
									@update:model-value="localAnimal.coat = $event"
								/>
							</div>
							<div class="px-2">
								<FormText
									id="animal-color"
									:model-value="animal.color"
									:label="getCapitalizedText(t('pages.animals.color'))"
									class="w-full border border-gray-300 rounded shadow-sm"
									:placeholder="'Couleur de l\'animal'"
									:disabled="!isEditMode"
									@update:model-value="localAnimal.color = $event"
								/>
							</div>
							<div class="px-2">
								<FormSelect
									id="animal-size"
									:model-value="animal.size"
									:name="getCapitalizedText(t('pages.animals.size'))"
									:label="getCapitalizedText(t('pages.animals.size'))"
									:options="animalSizeOptions"
									:disabled="!isEditMode"
									@update:model-value="localAnimal.size = $event"
								/>
							</div>
							<div class="px-2">
								<FormSelect
									id="animal-age-range"
									:model-value="animal.ageRange"
									:name="getCapitalizedText(t('pages.animals.ageRange'))"
									:label="getCapitalizedText(t('pages.animals.ageRange'))"
									:options="animalAgeRangeOptions"
									:disabled="!isEditMode"
									@update:model-value="localAnimal.ageRange = $event"
								/>
							</div>
							<div class="p-2">
								<FormDate
									id="animal-date"
									:model-value="animal.birthdate"
									:name="'animal-date'"
									:label="getCapitalizedText(t('pages.animals.birthdate'))"
									:disabled="!isEditMode"
									@update:modelValue="localAnimal.birthdate = $event"
								/>
							</div>
						</div>
					</div>
				</div>
				<div
					class="px-2 col-span-2 row-span-1 col-start-1 row-start-13 lg:col-span-2 lg:row-span-1 lg:col-start-5 lg:row-start-8"
				>
					<div class="flex flex-row justify-between">
						<button
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
