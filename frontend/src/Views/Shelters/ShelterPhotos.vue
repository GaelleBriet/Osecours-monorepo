<script lang="ts" setup>
import { Shelter } from '@/Interfaces/Shelter.ts';
import { ref } from 'vue';
import Form from '@/Components/Forms/Form.vue';
import ModalComponent from '@/Components/ModalComponent.vue';
import SheltersPhotoForm from '@/Views/Shelters/SheltersPhotoForm.vue';

const props = defineProps<{
	shelter: Shelter;
}>();

const showForm = ref(false);
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
	showForm.value = true;
	return false;
};
const removePhoto = () => {
	// @todo  Logique pour supprimer une photo
};
</script>

<template>
	<div class="shelter-documents bg-osecours-beige-dark bg-opacity-10 h-full">
		<Form :id="`edit-shelter${localShelter.id}`" :submit-label="'edit-shelter'" :actions="false">
			<div class="h-full">
				<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4 p-2 md:p-4">
					<!-- Miniatures des photos -->
					<div v-for="(photo, index) in photos" :key="index" class="relative">
						<img :src="photo.url" alt="Photo du shelter"
							class="w-full h-28 object-cover rounded-lg shadow-md" />
						<button
							class="absolute top-1 right-1 bg-osecours-pink text-osecours-white rounded-full p-1 w-5 h-5 flex items-center justify-center"
							@click="removePhoto(index)">
							&times;
							<!-- Symbole de multiplication utilisé pour l'icône de suppression -->
						</button>
					</div>
					<button type="button" class="w-full h-28 bg-gray-200 rounded-lg shadow-md flex justify-center items-center"
						@click="addPhoto()">
						<span>+</span>
					</button>
					<ModalComponent :isOpen="showForm" @close="showForm = false">
						<SheltersPhotoForm :shelter="shelter" />
					</ModalComponent>
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

form {
	display: flex;
	flex-grow: 1;
	flex-direction: column;
}
</style>
