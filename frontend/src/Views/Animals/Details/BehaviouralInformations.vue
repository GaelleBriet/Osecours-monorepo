<script setup lang="ts">
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import BehaviourForm from '@/Views/Animals/Behaviour/BehaviourForm.vue';
	import BehaviourComments from '@/Views/Animals/Behaviour/BehaviourComments.vue';
	import { Animal } from '@/Interfaces/Animals/Animal.ts';
	import { ref } from 'vue';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { getNode } from '@formkit/core';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';

	const props = defineProps<{
		animal: Animal;
	}>();

	const animalsStore = useAnimalsStore();

	let animal = ref<Animal>({ ...props.animal });

	const t = i18n.global.t;
	const isEditMode = ref(false);

	// paramètres de la notification
	const notificationConfig = ref({
		show: false,
		title: '',
		message: '',
		type: 'info',
	});

	const onButtonClick = () => {
		isEditMode.value = !isEditMode.value;
	};

	const isFormValid = () => {
		let formId = ref('');
		let formNode = ref(null);
		formId.value = 'animal-behavioural-form';
		formNode.value = getNode(formId.value);
		return formNode.value?.context.state.valid;
	};

	const onSave = async () => {
		if (!isFormValid()) {
			notificationConfig.value = {
				show: true,
				title: getCapitalizedText(t('form.messages.warning')),
				message: getCapitalizedText(t('form.messages.check')),
				type: 'warning',
			};
			return;
		}

		const animalData = {
			...animal.value,
			children_friendly: animal.value.children_friendly,
			cats_friendly: animal.value.cats_friendly,
			dogs_friendly: animal.value.dogs_friendly,
			behavioral_comment: animal.value.behavioral_comment,
		};

		const updatedAnimal = await animalsStore.updateAnimal(animalData);

		if (updatedAnimal) {
			notificationConfig.value = {
				show: true,
				title: getCapitalizedText(t('common.success')),
				message: getCapitalizedText(t('pages.animals.messages.updateSuccess')),
				type: 'success',
			};
		}

		isEditMode.value = false;
	};
</script>

<template>
	<div class="animal-behavioural bg-osecours-beige-dark bg-opacity-10">
		<Form
			ref="animalBehaviouralForm"
			id="animal-behavioural-form"
			:actions="false"
		>
			<div
				class="h-full lg:h-full grid grid-cols-1 grid-rows-none md:grid-cols-2 md:grid-rows-none gap-0 flex-grow rounded-b-lg shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div class="px-2 py-2 w-full md:col-start-1">
					<BehaviourForm
						:editMode="isEditMode"
						:animal="animal"
						@update:children-agreements="animal.children_friendly = $event"
						@update:cats-agreements="animal.cats_friendly = $event"
						@update:dogs-agreements="animal.dogs_friendly = $event"
					/>
				</div>
				<div class="px-2 py-2 w-full md:col-start-1 md:row-start-2">
					<BehaviourComments
						:editMode="isEditMode"
						:animal="animal"
						@update:comments="animal.behavioral_comment = $event"
					/>
				</div>
				<div
					class="md:justify-end justify-end flex flex-row p-2 md:pb-4 md:col-start-2 md:row-start-3 items-end"
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
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
						:disabled="!isEditMode"
						@click.prevent="onSave"
					>
						{{ getCapitalizedText(t('common.register')) }}
					</button>
				</div>
			</div>
		</Form>
	</div>
</template>

<style scoped lang="postcss">
	.animal-behavioural {
		//max-height: calc(100% - 4rem);
		display: flex;
		flex-direction: column;
		//min-height: calc(100vh - 4rem);
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
