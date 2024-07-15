<script lang="ts" setup>
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import FormText from '@/Components/Forms/FormText.vue';
	import FormNumber from '@/Components/Forms/FormNumber.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import FormPassword from '@/Components/Forms/FormPassword.vue';
	import { Members } from '@/Interfaces/Members.ts';
	import { Role } from '@/Enums/Role.ts';
  import { ref } from 'vue';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { generateOptionsWithDefault } from '@/Services/Helpers/Enums.ts';
	import { getNode } from '@formkit/core';
	import { useMembersStore } from '@/Stores/MembersStore.ts';
	import { useUserStore } from '@/Stores/UserStore.ts';

	const props = defineProps<{
		family?: Members;
		role?: number | undefined;
		isCreateMode?: boolean;
		isEditMode?: boolean;
	}>();

	const t = i18n.global.t;
	const membersStore = useMembersStore();
	const userStore = useUserStore();

	let isEditMode = ref(false);
  let isCreateMode = ref(props.isCreateMode);
	const currentMember = ref<Members>(
		props.family ? props.family : ({} as Members),
	);
	let createdMember = ref<Members>({});
	let memberToCreate = ref<Members>({});
	let currentAssociationId = userStore.getCurrentUser?.associationId;
	let confirmPassword = ref('');

	// paramètres de la notification
	const notificationConfig = ref({
		show: false,
		title: '',
		message: '',
		type: 'info',
	});

	// const userRoleOptions = generateOptionsFromEnum(Role, 'enums.role');
	const userRoleOptions = generateOptionsWithDefault(
		Role,
		'enums.role',
		getCapitalizedText(t('form.selectRole')),
	);

	const isFormValid = () => {
		let formId = ref('');
		let formNode = ref(null);
		formId.value = !props.isCreateMode
			? `edit-member${currentMember.value.id}`
			: 'create-member';
		formNode.value = getNode(formId.value);
		return formNode.value?.context.state.valid;
	};

	const onButtonClick = () => {
		isEditMode.value = !isEditMode.value;
	};

	const onSubmit = async () => {
		notificationConfig.value = {
			show: true,
			title: getCapitalizedText(t('common.success')),
			message: getCapitalizedText(t('pages.members.messages.updateSuccess')),
			type: 'success',
		};
		isEditMode.value = false;
	};

	const onCreateMember = async () => {
		if (!isFormValid()) {
			notificationConfig.value = {
				show: true,
				title: getCapitalizedText(t('common.error')),
				message: getCapitalizedText(t('pages.members.messages.createError')),
				type: 'error',
			};
		} else {
			const newMember = await membersStore.createMember(
				prepareMemberToCreate(createdMember),
			);

			if (newMember) {
				notificationConfig.value = {
					show: true,
					title: getCapitalizedText(t('common.success')),
					message: getCapitalizedText(
						t('pages.members.messages.createSuccess'),
					),
					type: 'success',
				};
			}
		}
	};

	const prepareMemberToCreate = (createdMember) => {
		return (memberToCreate.value = {
			first_name: createdMember.value.first_name,
			last_name: createdMember.value.last_name,
			email: createdMember.value.email,
			phone: createdMember.value.phone,
			existing_children_count: createdMember.value.existing_children_count,
			existing_cat_count: createdMember.value.existing_cat_count,
			existing_dog_count: createdMember.value.existing_dog_count,
			password: createdMember.value.password,
			role_id: createdMember.value.role,
			association_id: currentAssociationId,
		});
	};
</script>

<template>
	<div class="general-informations">
		<Form
			ref="myForm"
			:id="!isCreateMode ? `edit-member-${currentMember.id}` : 'create-member'"
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
						id="member-firstname"
						:model-value="
							!isCreateMode
								? currentMember.first_name
								: createdMember?.first_name
						"
						:label="getCapitalizedText(t('pages.users.firstName'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="getCapitalizedText(t('pages.users.firstName'))"
						:disabled="!isEditMode && !isCreateMode"
						:validation="'contains_alpha_spaces|length:0,100|required'"
						@update:modelValue="
							!isCreateMode
								? (currentMember.first_name = $event)
								: (createdMember.first_name = $event)
						"
					/>
				</div>
				<div class="px-2 w-full md:col-start-2">
					<FormText
						id="member-lastname"
						:model-value="
							!isCreateMode ? currentMember.last_name : createdMember?.last_name
						"
						:label="getCapitalizedText(t('pages.users.lastName'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="getCapitalizedText(t('pages.users.lastName'))"
						:disabled="!isEditMode && !isCreateMode"
						:validation="'contains_alpha_spaces|length:0,100|required'"
						@update:modelValue="
							!isCreateMode
								? (currentMember.last_name = $event)
								: (createdMember.last_name = $event)
						"
					/>
				</div>
				<div class="w-full px-2 md:col-start-1 md:row-start-2">
					<FormText
						id="member-email"
						:model-value="
							!isCreateMode ? currentMember.email : createdMember?.email
						"
						:label="getCapitalizedText(t('pages.users.email'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'email@example.com'"
						:disabled="!isEditMode && !isCreateMode"
						:validation="'contains_alpha_spaces|length:0,100|required'"
						@update:modelValue="
							!isCreateMode
								? (currentMember.email = $event)
								: (createdMember.email = $event)
						"
					/>
				</div>
				<div class="px-2 w-full md:col-start-2 md:row-start-2">
					<FormNumber
						id="member-phone"
						:model-value="
							!isCreateMode ? currentMember.phone : createdMember?.phone
						"
						:label="getCapitalizedText(t('pages.users.phone'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="'060102030102'"
						:disabled="!isEditMode && !isCreateMode"
						:validation="'number|length:10,10|required'"
						@update:modelValue="
							!isCreateMode
								? (currentMember.phone = $event)
								: (createdMember.phone = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-3">
					<FormSelect
						id="member-role"
						name="role"
						:model-value="!isCreateMode ? role : createdMember?.role"
						:label="getCapitalizedText(t('pages.members.role'))"
						:options="userRoleOptions"
						class="w-full border border-gray-300 rounded shadow-sm"
						:disabled="!isCreateMode"
						:validation="'number|length:0,2|required'"
						@update:modelValue="
							!isCreateMode
								? (currentMember.role = $event)
								: (createdMember.role = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-2 md:row-start-3">
					<FormNumber
						id="member-child-count"
						:model-value="
							!isCreateMode
								? currentMember.existing_children_count
								: createdMember?.existing_children_count
						"
						:label="getCapitalizedText(t('pages.users.childrenCount'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="getCapitalizedText(t('pages.users.minZero'))"
						:disabled="!isEditMode && !isCreateMode"
						:validation="'number|length:0,2|required'"
						min="0"
						@update:modelValue="
							!isCreateMode
								? (currentMember.existing_children_count = $event)
								: (createdMember.existing_children_count = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-4">
					<FormNumber
						id="member-cat-count"
						:model-value="
							!isCreateMode
								? currentMember.existing_cat_count
								: createdMember?.existing_cat_count
						"
						:label="getCapitalizedText(t('pages.users.catCount'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="getCapitalizedText(t('pages.users.minZero'))"
						:disabled="!isEditMode && !isCreateMode"
						:validation="'number|length:0,2|required'"
						@update:modelValue="
							!isCreateMode
								? (currentMember.existing_cat_count = $event)
								: (createdMember.existing_cat_count = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-2 md:row-start-4">
					<FormNumber
						id="number-dog-count"
						:model-value="
							!isCreateMode
								? currentMember.existing_dog_count
								: createdMember?.existing_dog_count
						"
						:label="getCapitalizedText(t('pages.users.dogCount'))"
						class="w-full border border-gray-300 rounded shadow-sm"
						:placeholder="getCapitalizedText(t('pages.users.minZero'))"
						:disabled="!isEditMode && !isCreateMode"
						:validation="'number|length:0,2|required'"
						@update:modelValue="
							!isCreateMode
								? (currentMember.existing_dog_count = $event)
								: (createdMember.existing_dog_count = $event)
						"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-5">
					<FormPassword
            v-if="isCreateMode && !isEditMode"
						id="create-password"
						:name="'password'"
						:model-value="createdMember?.password"
						:label="getCapitalizedText(t('form.password'))"
						:confirm-label="getCapitalizedText(t('form.confirmPassword'))"
            :validation="isCreateMode ? [['required'], ['matches', /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/]] : ''"
            :show-confirm="isCreateMode"
						@update:modelValue="createdMember.password = $event"
						@update:passwordConfirmation="confirmPassword = $event"
					/>
				</div>
				<template v-if="!isCreateMode">
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
				</template>
				<template v-else>
					<div
						:class="[
							'justify-end',
							'flex flex-row p-2 md:pb-4 md:col-start-2 md:row-start-7 md:items-end ',
						]"
					>
						<button
							id="save-changes"
							type="submit"
							class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
							@click.prevent="onCreateMember"
						>
							{{ getCapitalizedText(t('common.register')) }}
						</button>
					</div>
				</template>
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
