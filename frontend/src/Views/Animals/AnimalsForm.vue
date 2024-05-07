<script setup lang="ts">
	import Form from '@/Components/Forms/Form.vue';
	import FormDate from '@/Components/Forms/FormDate.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import FormText from '@/Components/Forms/FormText.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { Animal } from '@/Interfaces/Animal.ts';
	import { AnimalAges, AnimalSizes, AnimalStatus } from '@/Enums/Animals.ts';
	import { BreedsForSelects } from '@/Interfaces/Breed.ts';
	import { CoatsForSelects } from '@/Interfaces/Coat.ts';
	import { ColorsForSelects } from '@/Interfaces/Color.ts';
	import { GendersForSelects } from '@/Interfaces/Gender.ts';
	import { SpeciesForSelects } from '@/Interfaces/Species.ts';
	import i18n from '@/Services/Translations';
	import router from '@/Router';
	import { generateOptionsFromEnum } from '@/Services/Helpers/Enums.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { onMounted, ref, watch } from 'vue';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { useAnimalsSettingsStore } from '@/Stores/AnimalsSettingsStore.ts';

	const animalsStore = useAnimalsStore();
	const animalSettingsStore = useAnimalsSettingsStore();

	const props = defineProps<{
		isCreateMode?: boolean;
		animal?: Animal;
	}>();

	const t = i18n.global.t;

	const isEditMode = ref(false);
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

	// Fonction générique pour formater les options des selects depuis les données des enums
	// @enumObject : l'enum à formater
	// @translationKey : la clé de traduction pour les labels des options
	// @defaultLabel : le label par défaut pour les selects
	// return : value = clé de l'enum, label = valeur de l'enum traduite
	const generateOptionsWithDefault = (
		enumObject: Record<string, unknown>,
		translationKey: string,
		defaultLabel: string,
	) => {
		const options = generateOptionsFromEnum(enumObject, translationKey);
		options.unshift({ value: '', label: defaultLabel });
		return options;
	};

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

	// Fonction générique pour formater les options des selects depuis les données de l'api
	// @items : les données de l'api
	// @translationKey : la clé de traduction pour les labels des options
	// return : value = id de l'item, label = name de l'item traduit
	const formatOptions = (
		items: { id: number; name: string }[],
		translationKey: string,
	) => {
		return items.map((item) => ({
			value: item.id.toString(),
			label: getCapitalizedText(t(`${translationKey}.${item.name}`)),
		}));
	};

	// @store : le store et la méthode à appeler
	// @translationKey : la clé de traduction pour les labels des options
	// @defaultLabel : le label par défaut pour les selects
	// return : les options formatées avec le label par défaut en premier
	const fetchDataAndFormatOptions = async (
		store: () => Promise<never>,
		translationKey: string,
	) => {
		const data = await store();
		const options = formatOptions(data, translationKey);
		return options;
	};

	const onButtonClick = () => {
		// en mode création : retour à la page précédente
		// en mode visualisation : basculer en mode édition
		if (!props.isCreateMode) {
			isEditMode.value = !isEditMode.value;
		} else {
			router.go(-1);
		}
	};

	const onSubmit = async () => {
		if (props.isCreateMode) {
			// on passe la race à l'objet animal créé
			createdAnimal.value.specie_id = selectedSpecies.value;

			newAnimal.value = await animalsStore.createAnimal(createdAnimal.value);
		}
		if (!props.isCreateMode) {
			const animalToUpdate = await animalsStore.updateAnimal(localAnimal.value);
		}

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
		}
		// Réinitialiser les valeurs du formulaire
		if (props.isCreateMode) {
			createdAnimal.value = {};
		} else {
			localAnimal.value = { ...props.animal };
			isEditMode.value = false;
		}
	};

	onMounted(async () => {
		// on appelle les fonctions pour récupérer les données de l'api pour les passer aux selects
		//@todo: ajouter les traductions de labels manquantes
		let breedsData = await fetchDataAndFormatOptions(
			animalSettingsStore.getAllBreeds,
			'enums.animalsBreeds'
		);

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
			'enums.animalsCoats'
		);

		coatsData.sort((a, b) => a.label.localeCompare(b.label));

		coatsData.unshift({ label: 'Sélectionner un pelage', value: null });

		coats.value = coatsData;

		let colorsData = await fetchDataAndFormatOptions(
			animalSettingsStore.getAllColors,
			'enums.animalsColors'
		);

		colorsData.sort((a, b) => a.label.localeCompare(b.label));

		colorsData.unshift({ label: 'Sélectionner une couleur', value: null });

		colors.value = colorsData;

		let gendersData = await fetchDataAndFormatOptions(
			animalSettingsStore.getAllGenders,
			'enums.animalsGenders'
		);

		gendersData.sort((a, b) => a.label.localeCompare(b.label));

		gendersData.unshift({ label: 'Sélectionner un genre', value: null });

		genders.value = gendersData;
	
		let speciesData = await fetchDataAndFormatOptions(
			animalSettingsStore.getAllSpecies,
			'enums.animalsSpecies'
		);

		speciesData.sort((a, b) => a.label.localeCompare(b.label));

		speciesData.unshift({ label: 'Sélectionner une espèce', value: null });

		species.value = speciesData;
	});

	onMounted(() => {
		if (props.isCreateMode) {
			isEditMode.value = true;
		}
	});

	watch(selectedSpecies, async (newValue) => {
		// on surveille le changement de l'espèce pour récupérer les races correspondantes
		if (newValue == 1) {
			breeds.value = formatOptions(
				await animalSettingsStore.getSpecificBreeds('cat'),
				'enums.animalsBreeds',
			);
			breeds.value.unshift({
				value: '',
				label: 'Sélectionner une race',
			});
		} else if (newValue == 2) {
			breeds.value = formatOptions(
				await animalSettingsStore.getSpecificBreeds('dog'),
				'enums.animalsBreeds',
			);
			breeds.value.unshift({
				value: '',
				label: 'Sélectionner une race',
			});
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
						:model-value="
							!isCreateMode ? localAnimal?.name : createdAnimal.name
						"
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
						:model-value="
							!isCreateMode ? localAnimal?.icad : createdAnimal.icad
						"
						:name="'animal-icad-number'"
						:label="getCapitalizedText(t('pages.animals.icad'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'ex: 123456123456789'"
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
							!isCreateMode ? localAnimal?.specie_id : selectedSpecies
						"
						:name="'animal-species'"
						:label="getCapitalizedText(t('pages.animals.species'))"
						:options="species"
						:disabled="!isEditMode"
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
