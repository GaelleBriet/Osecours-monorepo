<script setup lang="ts">
	import FormText from '@/Components/Forms/FormText.vue';
	import Form from '@/Components/Forms/Form.vue';
	import FormPassword from '@/Components/Forms/FormPassword.vue';
	import FormSubmitButton from '@/Components/Forms/FormSubmitButton.vue';
	import FormCheckbox from '@/Components/Forms/FormCheckbox.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import AlertComponent from '@/Components/AlertComponent.vue';
	import { User } from '@/Interfaces/User.ts';
	import { Association } from '@/Interfaces/User.ts';
	import { useUserStore } from '@/Stores/UserStore.ts';
	import { ref, watch } from 'vue';
	import { useRouter } from 'vue-router';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { useI18n } from 'vue-i18n';
	import ModalComponent from '@/Components/ModalComponent.vue';

	const userStore = useUserStore();
	const router = useRouter();
	const { t } = useI18n();

	const email = ref('');
	const password = ref('');
	const selectedAssociation = ref(null);
	const selectOptions = ref([]);
	const associations = ref<Association[]>([]);
	const rememberMe = ref(localStorage.getItem('rememberMe') === 'true');
	const errorMessages = ref('');

	const showModal = ref(false);

	if (rememberMe.value) {
		email.value = localStorage.getItem('email') ?? '';
	}

	const onSubmit = async () => {
		const user: User = await userStore.loginUser(email.value, password.value);
		if (user.error) {
			errorMessages.value = getCapitalizedText(t('login.error'));
		}
		if (!user || user.associations?.length === 0) {
			await router.push({ name: 'Login' });
		}
		if (user && user.associations) {
			associations.value = user.associations;
			showModal.value = true;
		}
	};

	const handleAssociationChange = async (value: never) => {
		selectedAssociation.value = value;
	};

	const loginWithSelectedAssociation = async () => {
		const associationName = associations.value.find(
			(association) => association.id === Number(selectedAssociation.value),
		);
		if (selectedAssociation.value) {
			await userStore.loginWithAssociation(
				email.value,
				password.value,
				selectedAssociation.value,
				associationName ? associationName.name : '',
			);
			await router.push({ name: 'Home' });
		}
	};

	const onAssociationChange = async () => {
		if (selectedAssociation.value) {
			await loginWithSelectedAssociation();
		}
		showModal.value = false;
	};

	const getAssociations = () => {
		return [
			...associations.value.map((association) => {
				return {
					value: association.id.toString(),
					label: association.name,
				};
			}),
		];
	};

	watch(rememberMe, (newVal) => {
		if (newVal) {
			localStorage.setItem('rememberMe', 'true');
			localStorage.setItem('email', email.value);
		} else {
			localStorage.removeItem('rememberMe');
			localStorage.removeItem('email');
		}
	});

	watch(email, (newEmail) => {
		if (rememberMe.value) {
			localStorage.setItem('email', newEmail);
		}
	});

	watch(associations, () => {
		selectOptions.value = getAssociations();
	});
</script>

<template>
	<div class="flex min-h-full flex-1 ps-16 flex-row">
		<div
			class="flex flex-1 flex-col justify-center px-4 sm:px-6 lg:flex-none xl:px-48"
		>
			<div class="mx-auto w-full max-w-sm lg:w-96">
				<div>
					<img
						class="h-28 w-auto mx-auto"
						src="../../Assets/Images/logo-osecours.svg"
						alt="logo-osecours"
					/>
					<h2
						class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900 text-center"
					>
						{{ getCapitalizedText(t('login.description')) }}
					</h2>
				</div>

				<div class="mt-10">
					<div>
						<Form
							:id="'loginForm'"
							@submit="onSubmit"
							submit-label="login"
							:actions="false"
						>
							<div>
								<div class="mt-2">
									<FormText
										:model-value="email"
										:name="email"
										:id="'email'"
										:label="getCapitalizedText(t('form.email'))"
										:validation="'email|required'"
										:validation-visibility="'blur'"
										@update:model-value="email = $event"
									/>
								</div>
							</div>
							<div>
								<div class="mt-2">
									<FormPassword
										:model-value="password"
										:name="password"
										:id="'password'"
										:label="getCapitalizedText(t('form.password'))"
										:validation="[
											['required'],
											[
												'matches',
												/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,
											],
										]"
										:validation-visibility="'blur'"
										@update:model-value="password = $event"
									/>
								</div>
							</div>
							<div class="flex items-center justify-between">
								<div class="flex items-center">
									<FormCheckbox
										id="remember-me"
										name="remember-me"
										:label="getCapitalizedText(t('form.rememberMe'))"
										:model-value="rememberMe"
										@update:model-value="rememberMe = $event"
									></FormCheckbox>
								</div>
								<div class="text-sm leading-6">
									<a
										href="#"
										class="font-normal text-osecours-beige-dark hover:text-osecours-pink"
										>{{ getCapitalizedText(t('login.forgotPassword')) }}</a
									>
								</div>
							</div>

							<div class="min-h-[100px]">
								<AlertComponent
									v-if="errorMessages"
									:message="errorMessages"
									:error="true"
									@close="errorMessages = ''"
								/>
							</div>

							<div class="mt-2">
								<FormSubmitButton
									type="submit"
									@click="onSubmit"
									:label="getCapitalizedText(t('login.signIn'))"
								></FormSubmitButton>
							</div>

							<ModalComponent
								:is-open="showModal"
								:title="getCapitalizedText(t('login.selectAssociation'))"
								:center="true"
								:confirmButton="true"
								:cancelButton="true"
								@close="showModal = false"
								@confirm="onAssociationChange"
							>
								<template v-slot:beforeButtons>
									<!-- Association select input -->
									<div v-if="associations.length > 0">
										<div
											v-for="association in associations"
											:key="association.id"
										>
											<FormSelect
												:id="'association'"
												:name="'selectAssociation'"
												:options="selectOptions"
												:model-value="selectedAssociation"
												:placeholder="
													getCapitalizedText(t('login.selectAssociation'))
												"
												@update:model-value="handleAssociationChange"
											/>
										</div>
									</div>
								</template>
							</ModalComponent>
						</Form>
					</div>
				</div>
			</div>
		</div>
		<div class="relative hidden w-0 flex-1 lg:block">
			<img
				class="absolute inset-0 h-full w-full object-contain"
				src="../../Assets/Images/dog-sketch.jpg"
				alt=""
			/>
		</div>
	</div>
</template>
<style lang="postcss" scoped>
	button {
		background-color: rgba(217, 153, 98);
		color: #fff;
		&:hover {
			background-color: var(--color-withe);
			color: #d99962;
			outline: 1px solid #d99962;
		}
	}
</style>
