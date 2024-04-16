<script lang="ts" setup>
	import FormText from '@/Components/Forms/FormText.vue';
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { onMounted, ref } from 'vue';
	import i18n from '@/Services/Translations';
	import { Association } from '@/Interfaces/Association.ts';
	import { useAssociationsStore } from '@/Stores/AssociationsStore.ts';

	const associationsStore = useAssociationsStore();

	const props = defineProps<{
		isCreateMode?: boolean;
		association?: Association;
	}>();

	let localAssociation = ref({ ...props.association });

	const t = i18n.global.t;
	const isEditMode = ref(false);
	let createdAssociation = ref<Association>({});

	const notificationConfig = ref({
		show: false,
		message: '',
		type: 'info',
	});

	const onSubmit = async () => {
		if (props.isCreateMode) {
			const newAssociation = await associationsStore.createAssociation(createdAssociation.value);
		}
		if (!props.isCreateMode) {
			const associationToUpdate = await associationsStore.updateAssociation(localAssociation.value);
			// const associationToUpdate = props.association;
		}
		
		// Si l'api à bien répondu, on affiche la notification
		// et on stop le mode edition
		//@todo: adapter le message suivant la réponse de l'api
		notificationConfig.value = {
			show: true,
			message: !props.isCreateMode
				? `${getCapitalizedText(t('pages.associations.association'))} ${associationToUpdate?.name} ${getCapitalizedText(t('common.update'))}`
				: `${getCapitalizedText(t('pages.associations.association'))} ${associationToUpdate?.name} ${getCapitalizedText(t('common.creation'))}`,
			type: 'success',
		};
		isEditMode.value = false;
	};

	onMounted(() => {
		if (props.isCreateMode) {
			isEditMode.value = true;
		}
	});
</script>

<template>
	<div class="general-informations">
		<Form
			:id="!isCreateMode ? `edit-association${localAssociation.id}` : 'create-association'"
			:submit-label="'edit-association'"
			:actions="false"
		>
			<div
				class="h-full lg:h-full grid lg:grid:cols-2 lg:grid-rows-2 bg-osecours-beige-dark bg-opacity-10 rounded-b-lg shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div className="grid lg:grid-cols-2 lg:grid-rows-2 gap-4">
					<div class="col-start-1 lg:row-start-1">
						<FormText
						id="association-name"
						:model-value="!isCreateMode ? association.name : createdAssociation.name"
						:label="getCapitalizedText(t('common.name'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Nom du association'"
						:disabled="!isEditMode"
						@update:model-value="
							!isCreateMode
									? (localAnimal.name = $event)
									: (createdAnimal.name = $event)"
						/>
					</div>

					<div class="lg:col-start-2 lg:row-start-1">
						<FormText
							id="association-siret"
							:model-value="!isCreateMode ? association.siret : createdAssociation.siret"
							:name="'association-siret'"
							:label="getCapitalizedText(t('pages.associations.siret'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="'123456123456789'"
							:disabled="!isEditMode"
							@update:model-value="
								!isCreateMode
									? (localAnimal.siret = $event)
									: (createdAnimal.siret = $event)"
						/>
					</div>
					<div class="col-start-1 lg:row-start-2">
						<FormText
							id="association-rib"
							:model-value="!isCreateMode ? association.rib : createdAssociation.rib"
							:name="'association-rib'"
							:label="getCapitalizedText(t('pages.associations.rib'))"
							:placeholder="'hello@mail.com'"
							:disabled="!isEditMode"
							@update:model-value="
								!isCreateMode
									? (localAnimal.rib = $event)
									: (createdAnimal.rib = $event)"
						/>
					</div>
					<div class="lg:col-start-1 lg:row-start-3 lg:col-span-2 ">
						<FormText
							id="association-address"
							:model-value="!isCreateMode ? association.address : createdAssociation.address"
							:label="getCapitalizedText(t('pages.associations.address'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="getCapitalizedText(t('pages.associations.address'))"
							:disabled="!isEditMode"
							@update:model-value="
								!isCreateMode
									? (localAnimal.address = $event)
									: (createdAnimal.address = $event)"
						/>
					</div>
					<div class="lg:col-start-1 lg:row-start-4 ">
						<FormText
							id="association-zipcode"
							:model-value="!isCreateMode ? association.zipcode : createdAssociation.zipcode"
							:label="getCapitalizedText(t('pages.associations.zipcode'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="getCapitalizedText(t('pages.associations.zipcode'))"
							:disabled="!isEditMode"
							@update:model-value="
								!isCreateMode
									? (localAnimal.zipcode = $event)
									: (createdAnimal.zipcode = $event)"
						/>
					</div>
					<div class="lg:col-start-2 lg:row-start-4 ">
						<FormText
							id="association-city"
							:model-value="!isCreateMode ? association.city : createdAssociation.city"
							:label="getCapitalizedText(t('pages.associations.city'))"
							class="w-full border border-gray-300 rounded shadow-sm"
							:placeholder="getCapitalizedText(t('pages.associations.city'))"
							:disabled="!isEditMode"
							@update:model-value="
								!isCreateMode
									? (localAnimal.city = $event)
									: (createdAnimal.city = $event)"
						/>
					</div>
				</div>				
				<div
					class="my-1 lg:my-3 row-start-2 lg:row-start-2"
				>
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
								class="w-1/2 me-1.5 px-4 py-2 bg-green-500 text-white lg:text-sm rounded hover:bg-green-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
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