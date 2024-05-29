<script lang="ts" setup>
	import { Shelter } from '@/Interfaces/Shelter.ts';
	import { ref } from 'vue';
	import Form from '@/Components/Forms/Form.vue';

	const props = defineProps<{
		shelter: Shelter;
	}>();

	let localShelter = ref({ ...props.shelter });

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
</script>
<template>
	<div class="shelter-documents bg-osecours-beige-dark bg-opacity-10">
		<Form
			:id="`edit-shelter${localShelter.id}`"
			:submit-label="'edit-shelter'"
			:actions="false"
		>
			<div class="h-full">
				<div
					class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4 p-2 md:p-4"
				>
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
		</Form>
	</div>
</template>
<style scoped lang="postcss">
	.shelter-documents {
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
