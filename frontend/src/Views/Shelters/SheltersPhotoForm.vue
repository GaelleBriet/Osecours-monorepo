<script lang="ts" setup>
import { Shelter } from '@/Interfaces/Shelter.ts';
import { ref, computed } from 'vue';
import Form from '@/Components/Forms/Form.vue';
import FormFile from '@/Components/Forms/FormFile.vue';
import FormTextArea from '@/Components/Forms/FormTextArea.vue';
import FormText from '@/Components/Forms/FormText.vue';
import i18n from '@/Services/Translations';
import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
import { setErrors } from '@formkit/vue'
import { useRouter } from 'vue-router';

const t = i18n.global.t;
const submittedPhotos = ref(false);
const showButtons = computed(() => {
	return submittedPhotos.value;
});

const props = defineProps<{
	shelter: Shelter;
}>();
const isEditMode = ref(false);

let localShelter = ref({ ...props.shelter });
console.log(localShelter)
const removePhoto = () => {
	// @todo  Logique pour supprimer une photo
};

const addPhoto = () => {
		// Set submittedPhotos to true if a file is selected
	const files = (event.target as HTMLInputElement).files;
	if (files && files.length > 0) {
		submittedPhotos.value = true;
	}
};

</script>
<template>
	<div class="shelter-documents h-full">
		<h1 class="text-base leading-6 text-gray-900 mb-2">
			Add a new photo
		</h1>
		<p class="my-2 text-sm text-gray-700">
			You can add multiple photos. All of them would have the same name and description.
		</p>
		<!-- @todo: changer l'info pour recuperer les photos du shelter'  -->
		<Form :id="`edit-shelter-photos${localShelter.id}`" :submit-label="'edit-shelter-photos'" :actions="false">
			<div class="h-full">
				<div class="col-span-2 lg:col-span-1 h-28 pb-4">
					<FormFile id="shelter-file" accept=".jpg,.jpeg,.png" file-item-icon="fileImage" :multiple="true"
						no-files-icon="fileImage" outer-class="h-full" wrapper-class="h-full" inner-class="h-full"
						@change="addPhoto($event)" />
				</div>
				<div>
					<div class="col-start-1 lg:row-start-1 pb-4">
						<FormText id="document-name"
							model-value="!isCreateMode ? document.filename : createdDocument.filename"
							label="getCapitalizedText(t('pages.documents.filename'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							placeholder="getCapitalizedText(t('pages.documents.filename'))" :disabled="!isEditMode"
							 />
					</div>
					<div class="col-start-1 lg:row-start-2 pb-4">
						<FormTextArea id="document-description"
							model-value="!isCreateMode ? document.description : createdDocument.description"
							label="getCapitalizedText(t('pages.animals.description'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							placeholder="getCapitalizedText(t('pages.documents.description'))" :disabled="!isEditMode"
							/>
					</div>
				</div>
				<div v-if="showButtons"
					class="col-span-2 lg:col-span-2 flex flex-row p-2 md:pb-4 md:col-start-2 md:row-start-7 md:items-end lg:col-start-3">
					<button id="edit-mode"
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded hover:bg-blue-600 transition-colors">
						{{
							!isEditMode
								? getCapitalizedText(t('common.cancel'))
								: getCapitalizedText(t('common.editMode'))
						}}
					</button>
					<button id="save-changes"
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
						:disabled="isEditMode" @click.prevent="onSubmit">
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
