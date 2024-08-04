<script setup lang="ts">
	import Form from '@/Components/Forms/Form.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import FormText from '@/Components/Forms/FormText.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { onMounted, ref } from 'vue';
	import { Shelter } from '@/Interfaces/Shelter.ts';
	import { useSheltersStore } from '@/Stores/SheltersStore.ts';
	import { getNode } from '@formkit/core';
	import { useRoute } from 'vue-router';

	const route = useRoute();
	const sheltersStore = useSheltersStore();

	const props = defineProps<{
		isCreateMode?: boolean;
		shelter?: Shelter;
	}>();

	const t = i18n.global.t;
	const isEditMode = ref(false);
	let localShelter = ref({ ...props.shelter });
	let createdShelter = ref<Shelter>({});
	const newShelter = ref<Shelter>({});
	const id = route.params.id;

	const notificationConfig = ref({
		show: false,
		title: '',
		message: '',
		type: 'info',
	});

	const isFormValid = () => {
		let formId = ref('');
		let formNode = ref(null);
		formId.value = !props.isCreateMode
			? `edit-shelter${localShelter.value.id}`
			: 'create-shelter';
		formNode.value = getNode(formId.value);
		return formNode.value?.context.state.valid;
	};

	const onSubmit = async () => {
		// si le formulaire n'est pas valide, on affiche une notification
		if (!isFormValid()) {
			notificationConfig.value = {
				show: true,
				title: `${getCapitalizedText(t('form.messages.warning'))}`,
				message: `${getCapitalizedText(t('form.messages.check'))}`,
				type: 'warning',
			};
			return;
		}

		const formData = props.isCreateMode
			? createdShelter.value
			: localShelter.value;

		console.log(formData);
		
		if (props.isCreateMode) {
			newShelter.value = await sheltersStore.createShelter(createdShelter.value);
		}
		if (!props.isCreateMode) {
			newShelter.value = await sheltersStore.updateShelter(localShelter.value);
		}

		// newShelter.value = props.isCreateMode
		// 	? await sheltersStore.createShelter(id, formData)
		// 	: await sheltersStore.updateShelter(id, formData);

		// Si l'api à bien répondu, on affiche la notification
		// et on stop le mode edition
		//@todo: adapter le message suivant la réponse de l'api
		if (!newShelter.value) {
			notificationConfig.value = {
				show: true,
				title: `${getCapitalizedText(t('pages.animals.messages.errorGeneral'))}`,
				message: `${getCapitalizedText(t('pages.shelters.messages.updateShelterError'))}`,
				type: 'error',
			};
			return;
		} else if (newShelter.value) {
			notificationConfig.value = {
				show: true,
				title: `${getCapitalizedText(t('common.success'))}`,
				message: !props.isCreateMode
					? `${getCapitalizedText(t('pages.shelters.shelter'))} ${localShelter.value?.name} ${getCapitalizedText(t('common.update'))}`
					: `${getCapitalizedText(t('pages.shelters.shelter'))} ${createdShelter.value?.name} ${getCapitalizedText(t('common.creation'))}`,
				type: 'success',
			};
			// on réinitialise les valeurs du formulaire
			if (props.isCreateMode) {
				createdShelter.value = {};
			} else {
				localShelter.value = { ...newShelter.value };
				isEditMode.value = false;
			}
		}
	};

	onMounted(() => {
		if (props.isCreateMode) {
			isEditMode.value = true;
		}
	});
</script>
<template>
	<div
		class="shelter-general-informations bg-osecours-beige-dark bg-opacity-10"
	>
		<Form
			:id="!isCreateMode ? `edit-shelter${localShelter.id}` : 'create-shelter'"
			:submit-label="'edit-shelter'"
			:actions="false"
		>
			<div
				class="h-full lg:h-full grid lg:grid:cols-2 lg:grid-rows-3 rounded-b-lg flex-grow shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div className="grid lg:grid-cols-2 lg:grid-rows-2 gap-4">
					<div class="col-start-1 lg:row-start-1">
						<FormText
							id="shelter-name"
							:model-value="!isCreateMode ? shelter.name : createdShelter.name"
							:label="getCapitalizedText(t('common.name'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="getCapitalizedText(t('form.name'))"
							:disabled="!isEditMode"
							:validation="'contains_alpha_spaces|length:0,100'"
							@update:model-value="
								!isCreateMode
									? (localShelter.name = $event)
									: (createdShelter.name = $event)
							"
						/>
					</div>

					<div class="lg:col-start-2 lg:row-start-1">
						<FormText
							id="shelter-siret"
							:model-value="
								!isCreateMode ? shelter.siret : createdShelter.siret
							"
							:name="'shelter-siret'"
							:label="getCapitalizedText(t('pages.shelters.siret'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="'123456123456789'"
							:validation="[['matches', /^[0-9]{14}$/]]"
							:validation-visibility="'blur'"
							:disabled="!isEditMode"
							@update:model-value="
								!isCreateMode
									? (localShelter.siret = $event)
									: (createdShelter.siret = $event)
							"
						/>
					</div>
					<div class="col-start-1 lg:row-start-2">
						<FormText
							id="shelter-email"
							:model-value="
								!isCreateMode ? shelter.email : createdShelter.email
							"
							:name="'shelter-email'"
							:label="getCapitalizedText(t('form.email'))"
							:placeholder="'hello@mail.com'"
							:disabled="!isEditMode"
							@update:model-value="
								!isCreateMode
									? (localShelter.email = $event)
									: (createdShelter.email = $event)
							"
						/>
					</div>
					<div class="lg:col-start-2 lg:row-start-2">
						<FormText
							id="shelter-phone"
							:model-value="
								!isCreateMode ? shelter.phone : createdShelter.phone
							"
							:label="getCapitalizedText(t('pages.shelters.phone'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="'+34 07...'"
							:disabled="!isEditMode"
							@update:model-value="
								!isCreateMode
									? (localShelter.phone = $event)
									: (createdShelter.phone = $event)
							"
						/>
					</div>
					<div class="lg:col-span-2 lg:col-start-1 lg:row-start-3">
						<FormTextArea
							id="shelter-description"
							:model-value="
								!isCreateMode ? shelter.description : createdShelter.description
							"
							:label="getCapitalizedText(t('pages.animals.description'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="getCapitalizedText(t('pages.shelters.description'))"
							:disabled="!isEditMode"
							@update:model-value="
								!isCreateMode
									? (localShelter.description = $event)
									: (createdShelter.description = $event)
							"
						/>
					</div>
				</div>
				<div class="my-1 row-start-2 lg:row-start-2 grid items-end">
					<div class="grid lg:grid-cols-2">
						<div class="flex flex-row justify-end lg:col-start-2">
							<button
								v-if="!isCreateMode"
								id="edit-mode"
								class="w-1/2 me-1.5 px-4 py-2 bg-blue-500 text-white lg:text-sm rounded hover:bg-blue-600 transition-colors"
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
								class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded hover transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
								:disabled="!isEditMode"
								@click.prevent="onSubmit"
							>
								{{ getCapitalizedText(t('common.register')) }}
							</button>
						</div>
					</div>
				</div>
			</div>
		</Form>
	</div>
</template>

<style scoped lang="postcss">
	.shelter-general-informations {
		display: flex;
		flex-direction: column;
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
