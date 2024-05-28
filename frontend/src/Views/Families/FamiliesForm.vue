<script lang="ts" setup>
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { Members } from '@/Interfaces/Members.ts';
	import { ref } from 'vue';
	import { useRouter } from 'vue-router';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import FormText from '@/Components/Forms/FormText.vue';
	import FormNumber from '@/Components/Forms/FormNumber.vue';

	const props = defineProps<{
		family?: Members;
		isCreateMode?: boolean;
	}>();

	const t = i18n.global.t;
	const router = useRouter();
	const isEditMode = ref(false);
	const currentFamily = ref<Members>(props.family);
	// const createdFamily = ref<Members | null>(null);

	// paramètres de la notification
	const notificationConfig = ref({
		show: false,
		title: '',
		message: '',
		type: 'info',
	});

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
		notificationConfig.value = {
			show: true,
			title: getCapitalizedText(t('common.success')),
			message: getCapitalizedText(t('pages.families.messages.updateSuccess')),
			type: 'success',
		};
		isEditMode.value = false;
	};
</script>

<template>
	<div class="general-informations">
		<Form
			ref="myForm"
			:id="'families-form'"
			:submit-label="'edit-animal'"
			:actions="false"
		>
			<div
				class="h-full lg:h-full mt-2 grid grid-cols-1 grid-rows-none md:grid-cols-2 md:grid-rows-none gap-1 flex-grow bg-osecours-beige-dark bg-opacity-10 rounded-b-lg shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div class="px-2 w-full md:col-start-1">
					<FormText
						id="family-firstname"
						:model-value="!isCreateMode ? currentFamily.first_name : ''"
						:label="getCapitalizedText(t('pages.users.firstName'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Prénom'"
						:disabled="!isEditMode"
						:validation="'contains_alpha_spaces|length:0,100'"
						@update:modelValue="!isCreateMode ? currentFamily.first_name : ''"
					/>
				</div>
				<div class="px-2 w-full md:col-start-2">
					<FormText
						id="family-lastname"
						:model-value="!isCreateMode ? currentFamily.last_name : ''"
						:label="getCapitalizedText(t('pages.users.lastName'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Nom'"
						:disabled="!isEditMode"
						:validation="'contains_alpha_spaces|length:0,100'"
						@update:modelValue="!isCreateMode ? currentFamily.last_name : ''"
					/>
				</div>
				<div class="w-full px-2 md:col-start-1 md:row-start-2">
					<FormText
						id="family-email"
						:model-value="!isCreateMode ? currentFamily.email : ''"
						:label="getCapitalizedText(t('pages.users.email'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Email'"
						:disabled="!isEditMode"
						:validation="'contains_alpha_spaces|length:0,100'"
						@update:modelValue="!isCreateMode ? currentFamily.email : ''"
					/>
				</div>
				<div class="px-2 w-full md:col-start-2 md:row-start-2">
					<FormNumber
						id="family-phone"
						:model-value="!isCreateMode ? currentFamily.phone : ''"
						:label="getCapitalizedText(t('pages.users.phone'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Phone'"
						:disabled="!isEditMode"
						:validation="'number|length:0,10'"
						@update:modelValue="!isCreateMode ? currentFamily.phone : ''"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-3">
					<FormNumber
						id="family-child-count"
						:model-value="
							!isCreateMode ? currentFamily.existing_children_count : ''
						"
						:label="getCapitalizedText(t('pages.users.childrenCount'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Nombre d\'enfants'"
						:disabled="!isEditMode"
						:validation="'number|length:0,2'"
						@update:modelValue="
							!isCreateMode ? currentFamily.existing_children_count : ''
						"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-4">
					<FormNumber
						id="family-cat-count"
						:model-value="!isCreateMode ? currentFamily.existing_cat_count : ''"
						:label="getCapitalizedText(t('pages.users.catCount'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Nombre de chats'"
						:disabled="!isEditMode"
						:validation="'number|length:0,2'"
						@update:modelValue="
							!isCreateMode ? currentFamily.existing_cat_count : ''
						"
					/>
				</div>
				<div class="px-2 md:col-start-2 md:row-start-4">
					<FormNumber
						id="family-dog-count"
						:model-value="!isCreateMode ? currentFamily.existing_dog_count : ''"
						:label="getCapitalizedText(t('pages.users.dogCount'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'Nombre de chiens'"
						:disabled="!isEditMode"
						:validation="'number|length:0,2'"
						@update:modelValue="
							!isCreateMode ? currentFamily.existing_dog_count : ''
						"
					/>
				</div>
				<div
					:class="[
						'justify-between',
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
						v-tooltip="getCapitalizedText(t('common.notImplemented'))"
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
	</div>
</template>
<style scoped lang="postcss">
	.general-informations {
		display: flex;
		flex-direction: column;
		min-height: 100%;
	}

	form {
		display: flex;
		flex-grow: 1;
		flex-direction: column;
	}
</style>
