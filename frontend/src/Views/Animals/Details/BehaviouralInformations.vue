<script setup lang="ts">
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { ref } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';

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

	const onSave = () => {
		notificationConfig.value = {
			show: true,
			title: getCapitalizedText(t('common.success')),
			message: getCapitalizedText(t('common.saved')),
			type: 'warning',
		};
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
					<p class="mb-5">
						<span
							class="border-b-2 border-osecours-pink border-opacity-50 text-osecours-black text-lg"
							>Ententes de l'animal</span
						>
					</p>
				</div>
				<div class="px-2 py-2 w-full md:col-start-2">
					<p class="mb-5">
						<span
							class="border-b-2 border-osecours-pink border-opacity-50 text-osecours-black text-lg"
							>Comportement de l'animal</span
						>
					</p>
				</div>
				<div
					class="md:justify-end justify-end flex flex-row p-2 md:pb-4 md:col-start-2 md:row-start-3 md:items-end"
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

	form {
		display: flex;
		flex-grow: 1;
		flex-direction: column;
	}
</style>
