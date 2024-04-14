<script lang="ts" setup>
	import FormText from '@/Components/Forms/FormText.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { ref } from 'vue';
	import i18n from '@/Services/Translations';
	import { Shelter } from '@/Interfaces/Shelter.ts';
	import { useSheltersStore } from '@/Stores/SheltersStore.ts';

	const sheltersStore = useSheltersStore();

	const props = defineProps<{
		shelter: Shelter;
	}>();

	let localShelter = ref({ ...props.shelter });

	const t = i18n.global.t;
	const isEditMode = ref(false);

	const notificationConfig = ref({
		show: false,
		message: '',
		type: 'info',
	});

	const photos = ref([
		{
			id: 1,
			url: 'https://picsum.photos/seed/picsum/200/300',
		},
		{
			id: 2,
			url: 'https://picsum.photos/seed/picsum/200/300',
		},
		{
			id: 3,
			url: 'https://picsum.photos/seed/picsum/200/300',
		},
		{
			id: 4,
			url: 'https://picsum.photos/seed/picsum/200/300',
		},
		{
			id: 5,
			url: 'https://picsum.photos/seed/picsum/200/300',
		},
		{
			id: 6,
			url: 'https://picsum.photos/seed/picsum/200/300',
		},
		{
			id: 7,
			url: 'https://picsum.photos/seed/picsum/200/300',
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
		const shelterToUpdate = await sheltersStore.updateShelter(localShelter.value);
		// const shelterToUpdate = props.shelter;
		// Si l'api à bien répondu, on affiche la notification
		// et on stop le mode edition
		//@todo: adapter le message suivant la réponse de l'api
		notificationConfig.value = {
			show: true,
			message: `Le shelter ${shelterToUpdate?.name} a bien été mis à jour`,
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
			:id="`edit-shelter${localShelter.id}`"
			:submit-label="'edit-shelter'"
			:actions="false"
		>
			<div
				class="h-full lg:h-full grid lg:grid:cols-2 lg:grid-rows-3 bg-osecours-beige-dark bg-opacity-10 rounded-b-lg shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div className="grid lg:grid-cols-2 lg:grid-rows-2 gap-4">
					<div class="col-start-1 lg:row-start-1">
						<FormText
						id="shelter-name"
						:model-value="shelter.name"
						:label="getCapitalizedText(t('common.name'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Nom du shelter'"
						:disabled="!isEditMode"
						@update:model-value="localShelter.name = $event"
						/>
					</div>

					<div class="lg:col-start-2 lg:row-start-1">
						<FormText
							id="shelter-siret"
							:model-value="shelter.siret"
							:name="'shelter-siret'"
							:label="getCapitalizedText(t('pages.shelters.siret'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="'123456123456789'"
							:disabled="!isEditMode"
							@update:model-value="localShelter.siret = $event"
						/>
					</div>
					<div class="col-start-1 lg:row-start-2">
						<FormText
							id="shelter-email"
							:model-value="shelter.email"
							:name="'shelter-email'"
							:label="getCapitalizedText(t('form.email'))"
							:placeholder="'hello@mail.com'"
							:disabled="!isEditMode"
							@update:model-value="localShelter.email = $event"
						/>
					</div>
					<div class="lg:col-start-2 lg:row-start-2">
						<FormText
							id="shelter-phone"
							:model-value="shelter.phone"
							:label="getCapitalizedText(t('pages.shelters.phone'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="'+34 07...'"
							:disabled="!isEditMode"
							@update:model-value="localShelter.phone = $event"
						/>
					</div>
					<div class="lg:col-span-2 lg:col-start-1 lg:row-start-3 ">
						<FormTextArea
							id="shelter-description"
							:model-value="shelter.description"
							:label="getCapitalizedText(t('pages.animals.description'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="'Description de l\'shelter'"
							:disabled="!isEditMode"
							@update:model-value="localShelter.description = $event"
						/>
					</div>
				</div>
				<div
					class="my-1 lg:row-start-2"
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
								alt="Photo du shelter"
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
					class="my-1 row-start-1 lg:row-start-3"
				>
					<div class="grid lg:grid-cols-2">
						<div class="flex flex-row justify-between lg:col-start-2">
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