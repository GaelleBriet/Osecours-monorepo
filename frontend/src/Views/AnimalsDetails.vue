<script setup lang="ts">
	// Importez ou définissez les données des photos ici
	import { computed, onMounted, ref } from 'vue';
	import { useRoute } from 'vue-router';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import FormText from '@/Components/Forms/FormText.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import FormDate from '@/Components/Forms/FormDate.vue';
	import Form from '@/Components/Forms/Form.vue';

	const route = useRoute();
	const animalsStore = useAnimalsStore();
	const animalId = route.params.id;
	// const animal = computed(() => animalsStore.getCurrentAnimal);
	const animal = ref({
		id: 1,
		name: 'Bobby',
		description: 'A very good friend',
		birthdate: '2020-01-01',
		catsFriendly: true,
		dogsFriendly: true,
		childrenFriendly: true,
		age: 4,
		behavioralComment: 'Very friendly and playful',
		sterilized: true,
		deceased: false,
		species: 'Dog',
		breed: 'Golden Retriever',
		status: 'Adoptable',
		icad: '123456789123458',
	});
	console.log(animal.value);
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
		// Logique pour ajouter une photo
	};

	const removePhoto = (index) => {
		// Logique pour supprimer une photo
	};

	onMounted(async () => {
		// Logique pour récupérer les données de l'animal
		await animalsStore.getAnimal(animalId);
	});
</script>

<template>
	<div class="pb-6 flex flex-col">
		<Form
			:id="`edit-animal${animal.id}`"
			@submit="onSubmit"
			:submit-label="'edit-animal'"
			:actions="false"
		>
			<div
				class="h-full lg:h-full grid grid-cols-2 grid-rows-none lg:grid-cols-6 lg:grid-rows-17 gap-1 mt-3 flex-grow bg-osecours-beige_light bg-opacity-10 rounded-lg shadow-md p-2"
			>
				<div
					class="col-span-2 row-span-1 col-start-1 row-start-1 lg:col-start-1 lg:row-start-1 lg:col-span-6 lg:row-span-1 flex flex-col"
				>
					<div class="ps-1.5 text-2xl mb-1">
						Fiche Animal: {{ animal.name }}
					</div>
				</div>
				<div
					class="col-span-2 row-span-3 col-start-1 row-start-2 lg:col-span-4 lg:row-span-4 lg:row-start-2 lg:col-start-1"
				>
					<div class="mb-1 flex flex-col lg:flex-row justify-around">
						<div class="px-2 w-full lg:w-1/2">
							<FormText
								:id="'animal-icad-number'"
								:label="'Numéro I-CAD'"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="'ABCDEF123456789'"
							/>
						</div>
						<div class="px-2 w-full lg:w-1/2">
							<FormText
								:id="'animal-name'"
								:label="'Nom'"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="'Nom de l\'animal'"
							/>
						</div>
					</div>
					<div class="mb-1 flex flex-col lg:flex-row justify-around">
						<div class="w-full px-2 lg:w-1/2">
							<FormSelect
								:id="'animal-species'"
								:name="'animal-species'"
								:label="'Espèce'"
								:options="[
									{ value: 1, label: 'Chien' },
									{ value: 2, label: 'Chat' },
								]"
							/>
						</div>
						<div class="px-2 w-full lg:w-1/2">
							<FormText
								:id="'animal-breed'"
								:label="'Race'"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="'Race'"
							/>
						</div>
					</div>
					<div class="mb-1 flex flex-col justify-around">
						<div class="p-2">
							<FormTextArea
								:id="'animal-description'"
								:label="'Description'"
								class="w-full border border-gray-300 rounded shadow-sm"
								:placeholder="'Description de l\'animal'"
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
									:id="'animal-status'"
									:name="'animal-status'"
									:label="'Statut de l\'animal'"
									:options="[
										{ value: 1, label: 'Adopté' },
										{ value: 2, label: 'En famille d\'accueil' },
										{ value: 3, label: 'En refuge' },
									]"
								/>
							</div>
							<div class="px-2">
								<FormSelect
									:id="'animal-gender'"
									:name="'animal-gender'"
									:label="'Genre'"
									:options="[
										{ value: 1, label: 'Mâle' },
										{ value: 2, label: 'Femelle' },
									]"
								/>
							</div>
							<div class="px-2">
								<FormText
									:id="'animal-coat'"
									:label="'Robe'"
									class="w-full border border-gray-300 rounded shadow-sm"
									:placeholder="'Robe de l\'animal (type de poils)'"
								/>
							</div>
							<div class="px-2">
								<FormText
									:id="'animal-color'"
									:label="'Couleur'"
									class="w-full border border-gray-300 rounded shadow-sm"
									:placeholder="'Couleur de l\'animal'"
								/>
							</div>
							<div class="px-2">
								<FormSelect
									:id="'animal-size'"
									:name="'animal-size'"
									:label="'Taille'"
									:options="[
										{ value: 1, label: 'Petit' },
										{ value: 2, label: 'Moyen' },
										{ value: 3, label: 'Grand' },
									]"
								/>
							</div>
							<div class="px-2">
								<FormSelect
									:id="'animal-age-range'"
									:name="'animal-age-range'"
									:label="'Tranche d\'âge'"
									:options="[
										{ value: 1, label: 'Chiot/Chaton' },
										{ value: 2, label: 'Jeune' },
										{ value: 3, label: 'Adulte' },
										{ value: 4, label: 'Senior' },
									]"
								/>
							</div>
							<div class="p-2">
								<FormDate
									:id="'animal-date'"
									:model-value="animal.birthdate"
									:name="'animal-date'"
									:label="'Date de naissance'"
									:placeholder="'Sélectionner une date'"
									:overlay="true"
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
						>
							Mode édition
						</button>
						<button
							id="save-changes"
							class="w-1/2 me-1.5 px-4 py-2 bg-green-500 text-white lg:text-sm rounded hover:bg-green-600 transition-colors"
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
</style>
