<script setup lang="ts">
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

	import { onMounted, ref } from 'vue';
	import { useRoute } from 'vue-router';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { getCapitalizedText } from '../Services/Helpers/TextFormat.ts';
	import { generateOptionsFromEnum } from '@/Services/Helpers/Enums.ts';
	import i18n from '@/Services/Translations/index.ts';

	const t = i18n.global.t;
	const route = useRoute();
	const animalsStore = useAnimalsStore();
	const animalId = route.params.id;
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

	const animal = ref({
		id: 1,
		name: 'Bobby',
		description: 'A very good friend',
		birthdate: '2020-01-01',
		catsFriendly: true,
		dogsFriendly: true,
		childrenFriendly: true,
		ageRange: 3,
		behavioralComment: 'Very friendly and playful',
		sterilized: true,
		deceased: false,
		species: 1,
		breed: 'Golden Retriever',
		status: 2,
		icad: '123456789123458',
		gender: 2,
		size: 1,
		color: 'Golden',
		coat: 'Long',
	});

	const photos = ref([
		{
			id: 1,
			url: 'https://picsum.photos/id/237/200/300',
		},
		{
			id: 2,
			url: 'https://picsum.photos/id/200/200/300',
		},
		{
			id: 3,
			url: 'https://picsum.photos/id/219/200/300',
		},
		{
			id: 4,
			url: 'https://picsum.photos/id/275/200/300',
		},
		{
			id: 5,
			url: 'https://picsum.photos/id/237/200/300',
		},
		{
			id: 6,
			url: 'https://picsum.photos/id/200/200/300',
		},
		{
			id: 7,
			url: 'https://picsum.photos/id/219/200/300',
		},
	]);

	const addPhoto = () => {
		// @todo Logique pour ajouter une photo
	};

	const removePhoto = () => {
		// @todo  Logique pour supprimer une photo
	};

	const onSubmit = async () => {
		// Logique pour soumettre le formulaire quand l'api sera fonctionnelle
		// const animalToUpdate: Animal | null = await animalsStore.updateAnimal(
		// 	animal.value,
		// );
		const animalToUpdate = animal.value;
		// Si l'api à bien répondu, on affiche la notification
		// et on stop le mode edition
		//@todo: adapter le message suivant la réponse de l'api
		notificationConfig.value = {
			show: true,
			message: `L'animal ${animalToUpdate.name} a bien été mis à jour`,
			type: 'success',
		};
		isEditMode.value = false;
	};

	onMounted(async () => {
		// Logique pour récupérer les données de l'animal à afficher
		await animalsStore.getAnimal(animalId);
	});

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
	<div class="pb-6 flex flex-col">
		<Form
			:id="`edit-animal${animal.id}`"
			:submit-label="'edit-animal'"
			:actions="false"
		>
			<!--			@submit="onSubmit"-->
			<div
				class="h-full lg:h-full grid grid-cols-2 grid-rows-none lg:grid-cols-6 lg:grid-rows-17 gap-1 mt-3 flex-grow bg-osecours-beige_light bg-opacity-10 rounded-lg shadow-md p-2"
			>
				<div
					class="col-span-2 row-span-1 col-start-1 row-start-1 lg:col-start-1 lg:row-start-1 lg:col-span-6 lg:row-span-1 flex flex-col"
				>
					<div class="ps-1.5 text-2xl mb-1">
						{{ getCapitalizedText(t('pages.animals.card')) }}: {{ animal.name }}
					</div>
				</div>
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
								@update:model-value="animal.icad = $event"
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
								@update:model-value="animal.name = $event"
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
								@update:model-value="animal.species = $event"
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
								@update:model-value="animal.breed = $event"
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
								@update:model-value="animal.description = $event"
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
									@update:model-value="animal.status = $event"
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
									@update:model-value="animal.gender = $event"
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
									@update:model-value="animal.coat = $event"
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
									@update:model-value="animal.color = $event"
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
									@update:model-value="animal.size = $event"
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
									@update:model-value="animal.ageRange = $event"
								/>
							</div>
							<div class="p-2">
								<FormDate
									id="animal-date"
									:model-value="animal.birthdate"
									:name="'animal-date'"
									:label="getCapitalizedText(t('pages.animals.birthdate'))"
									:disabled="!isEditMode"
									@update:modelValue="animal.birthdate = $event"
								/>
							</div>
						</div>
					</div>
				</div>
				<div
					class="col-span-2 row-span-3 col-start-1 row-start-13 bg-opacity-10 lg:col-span-4 lg:row-span-3 lg:col-start-1 lg:row-start-6"
				>
					<div class="grid grid-cols-3 lg:grid-rows-2 lg:grid-cols-4 gap-4 p-2">
						<!-- Miniatures des photos -->
						<div
							v-for="(photo, index) in photos"
							:key="index"
							class="relative"
						>
							<img
								:src="photo.url"
								alt="Photo de l'animal"
								class="w-full h-28 object-cover rounded-lg shadow-md"
							/>
							<button
								class="absolute top-1 right-1 bg-osecours-pink text-osecours-white rounded-full p-1 w-5 h-5 flex items-center justify-center"
								@click="removePhoto(index)"
							>
								&times;
								<!-- Symbole de multiplication utilisé pour l'icône de suppression -->
							</button>
						</div>
						<!-- Bouton pour ajouter une photo -->
						<button
							class="w-full h-28 bg-gray-200 rounded-lg shadow-md flex justify-center items-center"
							@click="addPhoto"
						>
							<span>+</span>
						</button>
					</div>
				</div>
				<div
					class="px-2 col-span-2 row-span-1 col-start-1 row-start-16 lg:col-span-2 lg:row-span-1 lg:col-start-5 lg:row-start-8"
				>
					<div class="flex flex-row justify-between">
						<button
							id="edit-mode"
							class="w-1/2 me-1.5 px-4 py-2 bg-blue-500 text-white lg:text-sm rounded hover:bg-blue-600 transition-colors"
							@click.prevent="isEditMode = !isEditMode"
						>
							{{
								isEditMode
									? getCapitalizedText(t('common.cancel'))
									: getCapitalizedText(t('common.edit'))
							}}
						</button>
						<button
							id="save-changes"
							class="w-1/2 me-1.5 px-4 py-2 bg-green-500 text-white lg:text-sm rounded hover:bg-green-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
							:disabled="!isEditMode"
							@click.prevent="onSubmit"
						>
							Enregistrer
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
		background-color: rgba(217, 153, 98);
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
</style>
