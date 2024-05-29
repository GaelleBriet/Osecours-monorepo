<script setup lang="ts">
	import FormText from '@/Components/Forms/FormText.vue';
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import FormPassword from '@/Components/Forms/FormPassword.vue';
	import { ref } from 'vue';
	import { useUserStore } from '@/Stores/UserStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';

	const userStore = useUserStore();
	const t = i18n.global.t;
	const isEditMode = ref(false);

	const notificationConfig = ref({
		show: false,
		message: '',
		type: 'info',
	});

	const user = ref(userStore.user);

	const onSubmit = async () => {
		notificationConfig.value = {
			show: true,
			message: getCapitalizedText(t('pages.users.profileUpdated')),
			type: 'success',
		};
		isEditMode.value = false;
	};
</script>
<template>
	<div class="general-informations">
		<h1 class="text-center text-osecours-black mt-4 mb-8">
			{{ getCapitalizedText(t('pages.users.personal')) }}
		</h1>
		<NotificationComponent
			:config="notificationConfig"
			@close="notificationConfig.show = false"
		/>
		<Form
			:id="'personal-informations-form'"
			:submit-label="'edit-profile'"
			:actions="false"
		>
			<div class="h-full flex-grow">
				<div class="md:flex md:flex-col md:max-w-[40em] md:mx-auto">
					<FormText
						:label="getCapitalizedText(t('form.name'))"
						v-model="user.lastName"
						:placeholder="getCapitalizedText(t('form.name'))"
						:disabled="!isEditMode"
						class="min-w-[110px]"
					/>
					<FormText
						:label="getCapitalizedText(t('form.firstName'))"
						v-model="user.firstName"
						:placeholder="getCapitalizedText(t('form.firstName'))"
						:disabled="!isEditMode"
						class="min-w-[110px]"
					/>
					<FormText
						:label="getCapitalizedText(t('form.email'))"
						v-model="user.email"
						:placeholder="getCapitalizedText(t('form.email'))"
						:disabled="!isEditMode"
						:validation="'email'"
						class="min-w-[110px]"
					/>
					<FormPassword
						:label="getCapitalizedText(t('form.password'))"
						v-model="user.password"
						:placeholder="getCapitalizedText(t('form.password'))"
						:disabled="!isEditMode"
						:validation="'password'"
						class="min-w-[110px]"
						id="user-password"
					/>
					<FormText
						:label="getCapitalizedText(t('form.phone'))"
						v-model="user.phoneNumber"
						:placeholder="getCapitalizedText(t('form.phone'))"
						:disabled="!isEditMode"
						class="min-w-[110px]"
					/>
					<FormText
						:label="getCapitalizedText(t('form.phone'))"
						v-model="user.phoneNumber"
						:placeholder="getCapitalizedText(t('form.phone'))"
						:disabled="!isEditMode"
						class="min-w-[110px]"
					/>

					@todo: add address

					<!--					<FormNumber-->
					<!--						:label="getCapitalizedText(t('pages.users.catCount'))"-->
					<!--						v-model="user.cats"-->
					<!--						:placeholder="getCapitalizedText(t('pages.users.catCount'))"-->
					<!--						:disabled="!isEditMode"-->
					<!--						class="min-w-[110px]"-->
					<!--						step="1"-->
					<!--					/>-->
					<!--					<FormNumber-->
					<!--						:label="getCapitalizedText(t('pages.users.dogCount'))"-->
					<!--						v-model="user.dogs"-->
					<!--						:placeholder="getCapitalizedText(t('pages.users.dogCount'))"-->
					<!--						:disabled="!isEditMode"-->
					<!--						class="min-w-[110px]"-->
					<!--						step="1"-->
					<!--					/>-->
					<!--					<FormNumber-->
					<!--						:label="getCapitalizedText(t('pages.users.childrenCount'))"-->
					<!--						v-model="user.children"-->
					<!--						:placeholder="getCapitalizedText(t('pages.users.childrenCount'))"-->
					<!--						:disabled="!isEditMode"-->
					<!--						class="min-w-[110px]"-->
					<!--						step="1"-->
					<!--					/>-->

					<!--					<div class="flex flex-col md:flex-row mt-5">-->
					<!--						<FormToggle-->
					<!--							:label="getCapitalizedText(t('pages.users.fosterFamily'))"-->
					<!--							v-model="user.fosterFamily"-->
					<!--							:disabled="!isEditMode"-->
					<!--							class="min-w-[110px]"-->
					<!--						/>-->
					<!--						<FormToggle-->
					<!--							:label="getCapitalizedText(t('pages.users.adoptFamily'))"-->
					<!--							v-model="user.adoptFamily"-->
					<!--							:disabled="!isEditMode"-->
					<!--							class="min-w-[110px]"-->
					<!--						/>-->
					<!--					</div>-->
				</div>
				<div class="">
					<div
						class="flex flex-col md:flex-row items-center md:max-w-[40em] md:mx-auto"
					>
						<button
							id="edit-mode"
							class="w-1/2 min-w-[110px] mb-3 md:mb-0 md:me-4 mt-4 px-4 md:mt-6 py-2 text-white lg:text-sm rounded transition-colors"
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
							class="w-1/2 min-w-[110px] px-4 py-2 md:mt-6 text-white lg:text-sm rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
							:disabled="!isEditMode"
							@click.prevent="onSubmit"
						>
							{{ getCapitalizedText(t('common.register')) }}
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
		display: flex;
		flex-direction: column;
		min-height: 100%;
	}

	form {
		display: flex;
		flex-grow: 1;
		flex-direction: column;
		height: 100%;
	}
</style>