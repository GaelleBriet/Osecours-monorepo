<script setup lang="ts">
	import Form from '@/Components/Forms/Form.vue';
	import FormDate from '@/Components/Forms/FormDate.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import FormText from '@/Components/Forms/FormText.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { Animal } from '@/Interfaces/Animals/Animal.ts';
	import { AnimalAges, AnimalSizes, AnimalStatus } from '@/Enums/Animals.ts';
	import { BreedsForSelects } from '@/Interfaces/Animals/Breed.ts';
	import { CoatsForSelects } from '@/Interfaces/Animals/Coat.ts';
	import { ColorsForSelects } from '@/Interfaces/Animals/Color.ts';
	import { GendersForSelects } from '@/Interfaces/Animals/Gender.ts';
	import { SpeciesForSelects } from '@/Interfaces/Animals/Species.ts';
	import i18n from '@/Services/Translations';
	import { generateOptionsWithDefault } from '@/Services/Helpers/Enums.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { onMounted, ref, watch } from 'vue';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { useAnimalsSettingsStore } from '@/Stores/AnimalsSettingsStore.ts';
	import { getNode } from '@formkit/core';
	import { useRouter } from 'vue-router';
	import {
		fetchDataAndFormatOptions,
		formatOptions,
	} from '@/Services/Helpers/SelectOptions.ts';
	import LoaderComponent from '@/Components/LoaderComponent.vue';


	const animalsStore = useAnimalsStore();
	const animalSettingsStore = useAnimalsSettingsStore();
	const router = useRouter();
	const routeParams = router.currentRoute.value.params;

	const props = defineProps<{
		isCreateMode?: boolean;
		animal?: Animal;
	}>();

	const t = i18n.global.t;

	const isEditMode = ref(false);
	const isLoading = ref(true);
	let localAnimal = ref<Animal>({ ...props.animal });
	let createdAnimal = ref<Animal>({});
	const newAnimal = ref<Animal | null>(null);
	const selectedSpecies = ref(
		!props.isCreateMode ? props.animal?.specie_id : null,
	);

	const breeds = ref<BreedsForSelects[]>([]);
	const coats = ref<CoatsForSelects[]>([]);
	const colors = ref<ColorsForSelects[]>([]);
	const genders = ref<GendersForSelects[]>([]);
	const species = ref<SpeciesForSelects[]>([]);

	// paramètres de la notification
	const notificationConfig = ref({
		show: false,
		title: '',
		message: '',
		type: 'info',
	});

	// Initialisation des options des selects depuis les Enums
	const animalStatusOptions = generateOptionsWithDefault(
		AnimalStatus,
		'enums.animalStatus',
		'Choisir un statut',
	);
	const animalSizeOptions = generateOptionsWithDefault(
		AnimalSizes,
		'enums.animalSizes',
		'Choisir une taille',
	);
	const animalAgeRangeOptions = generateOptionsWithDefault(
		AnimalAges,
		'enums.animalAges',
		"Choisir une tranche d'âge",
	);

	const onButtonClick = () => {
		// en mode création : retour à la page précédente
		// en mode visualisation : basculer en mode édition
		if (!props.isCreateMode) {
			isEditMode.value = !isEditMode.value;
		} else {
			router.go(-1);
		}
	};

	const isFormValid = () => {
		let formId = ref('');
		let formNode = ref(null);
		formId.value = !props.isCreateMode
			? `edit-animal${localAnimal.value.id}`
			: 'create-animal';
		formNode.value = getNode(formId.value);
		return formNode.value?.context.state.valid;
	};

	const onSubmit = async () => {
		// si le formulaire n'est pas valide, on affiche une notification
		if (!isFormValid()) {
			notificationConfig.value = {
				show: true,
				title: 'Un ou plusieurs champs sont invalides',
				message: 'Veuillez vérifier les champs',
				type: 'warning',
			};
			return;
		}
		// on prépare les données de l'animal pour l'envoi à l'api
		const animalData = props.isCreateMode
			? createdAnimal.value
			: localAnimal.value;
		animalData.specie_id = selectedSpecies.value;

		if (!props.isCreateMode) {
			animalData.number = localAnimal.value.identification?.number;
		} else {
			animalData.number = createdAnimal.value.identification;
		}

		// on envoie les données à l'api
		newAnimal.value = props.isCreateMode
			? await animalsStore.createAnimal(animalData)
			: await animalsStore.updateAnimal(animalData);

		// on affiche une notification en fonction du résultat de la requête
		if (!newAnimal.value) {
			notificationConfig.value = {
				show: true,
				title: 'Une erreur est survenue',
				message: 'Veuillez contacter le support',
				type: 'error',
			};
			return;
		} else if (newAnimal.value) {
			notificationConfig.value = {
				show: true,
				title: 'Succès',
				message: !props.isCreateMode
					? `L'animal ${localAnimal.value?.name || ''} a bien été mis à jour`
					: `L'animal ${createdAnimal.value?.name || ''} a bien été créé`,
				type: 'success',
			};
			// on réinitialise les valeurs du formulaire
			if (props.isCreateMode) {
				createdAnimal.value = {};
			} else {
				localAnimal.value = { ...newAnimal.value };
				isEditMode.value = false;
			}
		}
	};

	// on construit le label du select avec un indicateur de champ obligatoire
	const addRequiredIndicator = (label: string, isRequired: boolean) => {
		if (isRequired) {
			return `${label} <span class="text-red-600"> *</span>`;
		}
		return label;
	};

	onMounted(async () => {
		if (props.isCreateMode) {
			isEditMode.value = true;
		}
		// on appelle les fonctions pour récupérer les données de l'api pour les passer aux selects
		try {
			let breedsData = await fetchDataAndFormatOptions(
				animalSettingsStore.getAllBreeds,
				'enums.animalsBreeds',
				'Sélectionner une race',
			);

			if (props.animal?.specie_id == 1 || routeParams.species == 'cat') {
				breeds.value = formatOptions(
					await animalSettingsStore.getSpecificBreeds('cat'),
					'enums.animalsBreeds',
				);
			} else if (props.animal?.specie_id == 2 || routeParams.species == 'dog') {
				breeds.value = formatOptions(
					await animalSettingsStore.getSpecificBreeds('dog'),
					'enums.animalsBreeds',
				);
			}
			// Tri des races par ordre alphabétique
			//  a.label.localeCompare(b.label) : Cela compare les deux valeurs de label en utilisant l'ordre alphabétique défini par la locale actuelle. Cette méthode renvoie un nombre négatif si a précède b dans l'ordre alphabétique, un nombre positif si b précède a, et zéro si les deux valeurs sont égales.
			// La fonction de comparaison retourne donc un nombre négatif, positif ou zéro en fonction de la comparaison entre a.label et b.label.
			// La méthode sort() utilise ensuite ces valeurs renvoyées par la fonction de comparaison pour réorganiser les éléments du tableau speciesData dans l'ordre alphabétique de leur propriété label.
			breedsData.sort((a, b) => a.label.localeCompare(b.label));
			// Insérer la valeur par défaut au début du tableau trié
			breedsData.unshift({ label: 'Sélectionner une race', value: null });
			breeds.value = breedsData;

			let coatsData = await fetchDataAndFormatOptions(
				animalSettingsStore.getAllCoats,
				'enums.animalsCoats',
				'Sélectionner un pelage',
			);
			coatsData.sort((a, b) => a.label.localeCompare(b.label));
			coatsData.unshift({ label: 'Sélectionner un pelage', value: null });
			coats.value = coatsData;

			let colorsData = await fetchDataAndFormatOptions(
				animalSettingsStore.getAllColors,
				'enums.animalsColors',
				'Sélectionner une couleur',
			);
			colorsData.sort((a, b) => a.label.localeCompare(b.label));
			colorsData.unshift({ label: 'Sélectionner une couleur', value: null });
			colors.value = colorsData;

			let gendersData = await fetchDataAndFormatOptions(
				animalSettingsStore.getAllGenders,
				'enums.animalGenders',
				'Sélectionner un genre',
			);
			gendersData.sort((a, b) => a.label.localeCompare(b.label));
			gendersData.unshift({ label: 'Sélectionner un genre', value: null });
			genders.value = gendersData;

			let speciesData = await fetchDataAndFormatOptions(
				animalSettingsStore.getAllSpecies,
				'enums.animalSpecies',
				'Sélectionner une espèce',
			);
			speciesData.sort((a, b) => a.label.localeCompare(b.label));
			speciesData.unshift({ label: 'Sélectionner une espèce', value: null });
			species.value = speciesData;
		} finally {
        isLoading.value = false;
      }
	});

	onMounted(() => {
		if (props.isCreateMode) {
			isEditMode.value = true;
		}
		if (routeParams.species == 'cat') {
			selectedSpecies.value = 1;
		} else if (routeParams.species == 'dog') {
			selectedSpecies.value = 2;
		}
	});

	watch(selectedSpecies, async () => {
		// on surveille le changement de l'espèce pour récupérer les races correspondantes
		if (selectedSpecies.value == 1) {
			breeds.value = formatOptions(
				await animalSettingsStore.getSpecificBreeds('cat'),
				'enums.animalsBreeds',
			);
			breeds.value.unshift({
				value: '',
				label: 'Sélectionner une race',
			});
		} else if (selectedSpecies.value == 2) {
			breeds.value = formatOptions(
				await animalSettingsStore.getSpecificBreeds('dog'),
				'enums.animalsBreeds',
			);
			breeds.value.unshift({
				value: '',
				label: 'Sélectionner une race',
			});
		} else if (selectedSpecies.value == 0) {
			breeds.value = await fetchDataAndFormatOptions(
				animalSettingsStore.getAllBreeds,
				'enums.animalsBreeds',
				'Sélectionner une race',
			);
		}
	});
</script>
<template>
	<div class="general-informations h-full lg:h-full bg-osecours-beige-dark bg-opacity-10">		
		<Form
			ref="myForm"
			:id="!isCreateMode ? `edit-animal${localAnimal.id}` : 'create-animal'"
			:submit-label="'edit-animal'"
			:actions="false"
		>
			<div
				v-if="!isLoading"
				class="grid grid-cols-1 grid-rows-none md:grid-cols-2 md:grid-rows-none gap-1 flex-grow rounded-b-lg shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div class="px-2 w-full md:col-start-1">
					<FormText
						id="animal-name"
						:model-value="
							!isCreateMode ? localAnimal?.name : createdAnimal.name
						"
						:label="getCapitalizedText(t('common.name'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Nom de l\'animal'"
						:disabled="!isEditMode"
						:validation="'contains_alpha_spaces|length:0,100'"
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
						:model-value="
							!isCreateMode
								? localAnimal.identification?.number
								: createdAnimal.identification?.number
						"
						:name="'animal-icad-number'"
						:label="getCapitalizedText(t('pages.animals.icad'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'ex: 123456123456789'"
						:help="'Doit contenir 6, 8 ou 15 caractères sans espaces'"
						:validation="[['matches', /^(?:.{6}|.{8}|.{15})$/]]"
						:validation-visibility="'blur'"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.identification.number = $event)
								: (createdAnimal.identification = $event)
						"
					/>
				</div>

				<div class="w-full px-2 md:col-start-1 md:row-start-2">
					<FormSelect
						id="animal-species"
						:model-value="selectedSpecies"
						:name="getCapitalizedText(t('pages.animals.species'))"
						:label="
							addRequiredIndicator(
								getCapitalizedText(t('pages.animals.species')),
								true,
							)
						"
						:options="species"
						:disabled="!isEditMode"
						:validation="'required'"
						:validation-visibility="'blur'"
						@update:model-value="selectedSpecies = $event"
					/>
				</div>
				<div class="px-2 w-full md:col-start-2 md:row-start-2">
					<FormSelect
						id="animalBreed"
						:model-value="
							!isCreateMode ? localAnimal?.breed_id : createdAnimal.breed_id
						"
						:label="getCapitalizedText(t('pages.animals.breed'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:options="breeds"
						:disabled="!isEditMode"
						name="animalBreed"
						@update:model-value="
							!isCreateMode
								? (localAnimal.breed_id = $event)
								: (createdAnimal.breed_id = $event)
						"
					/>
				</div>
				<div class="p-2 md:col-start-1 md:row-start-7 md:flex md:items-end">
					<FormTextArea
						id="animal-description"
						:model-value="
							!isCreateMode
								? localAnimal?.description
								: createdAnimal.description
						"
						:label="getCapitalizedText(t('pages.animals.description'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Description de l\'animal'"
						:disabled="!isEditMode"
						:validation="'length:0,1000'"
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
						:model-value="
							!isCreateMode ? localAnimal?.status : createdAnimal.status
						"
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
						:model-value="
							!isCreateMode ? localAnimal?.gender_id : createdAnimal.gender_id
						"
						:name="'animal-gender'"
						:label="getCapitalizedText(t('pages.animals.gender'))"
						:options="genders"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.gender_id = $event)
								: (createdAnimal.gender_id = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-2 md:row-start-4">
					<FormSelect
						id="animal-size"
						:model-value="
							!isCreateMode
								? localAnimal?.sizerange_id
								: createdAnimal.sizerange_id
						"
						:name="getCapitalizedText(t('pages.animals.size'))"
						:label="getCapitalizedText(t('pages.animals.size'))"
						:options="animalSizeOptions"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.sizerange_id = $event)
								: (createdAnimal.sizerange_id = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-5">
					<FormSelect
						id="animal-coat"
						:model-value="
							!isCreateMode ? localAnimal?.coat_id : createdAnimal.coat_id
						"
						:name="getCapitalizedText(t('pages.animals.coat'))"
						:label="getCapitalizedText(t('pages.animals.coat'))"
						:options="coats"
						:disabled="!isEditMode"
						class="w-full border border-gray-300 rounded shadow-sm"
						@update:model-value="
							!isCreateMode
								? (localAnimal.coat_id = $event)
								: (createdAnimal.coat_id = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-2 md:row-start-5">
					<FormSelect
						id="animal-color"
						:model-value="
							!isCreateMode ? localAnimal?.color_id : createdAnimal.color_id
						"
						:name="getCapitalizedText(t('pages.animals.color'))"
						:label="getCapitalizedText(t('pages.animals.color'))"
						:options="colors"
						:disabled="!isEditMode"
						class="w-full border border-gray-300 rounded shadow-sm"
						@update:model-value="
							!isCreateMode
								? (localAnimal.color_id = $event)
								: (createdAnimal.color_id = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-6">
					<FormSelect
						id="animal-age-range"
						:model-value="
							!isCreateMode
								? localAnimal?.agerange_id
								: createdAnimal.agerange_id
						"
						:name="getCapitalizedText(t('pages.animals.ageRange'))"
						:label="getCapitalizedText(t('pages.animals.ageRange'))"
						:options="animalAgeRangeOptions"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
								? (localAnimal.agerange_id = $event)
								: (createdAnimal.agerange_id = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-2 md:row-start-6">
					<FormDate
						id="animal-date"
						:model-value="
							!isCreateMode ? localAnimal?.birth_date : createdAnimal.birth_date
						"
						:name="'animal-date'"
						:label="getCapitalizedText(t('pages.animals.birthdate'))"
						:disabled="!isEditMode"
						:validation="`date_before:${new Date(Date.now() + 24 * 60 * 60 * 1000).toISOString().split('T')[0]}`"
						:validation-visibility="'blur'"
						@update:modelValue="
							!isCreateMode
								? (localAnimal.birth_date = $event)
								: (createdAnimal.birth_date = $event)
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
						type="submit"
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
						:disabled="!isEditMode"
						@click.prevent="onSubmit"
					>
						{{ getCapitalizedText(t('common.register')) }}
					</button>
				</div>
			</div>
		</Form>
		<LoaderComponent
			class="h-full"
			v-if="isLoading"
		/>
	</div>
</template>

<style scoped lang="postcss">
	.general-informations {
    /* max-height: calc(100% - 4rem); */
		display: flex;
		flex-direction: column;
  /* min-height: calc(100vh - 4rem);*/
  min-height: 100%;
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
