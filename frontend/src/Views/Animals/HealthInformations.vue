<script lang="ts" setup>
	import { Animal } from '@/Interfaces/Animal.ts';
	import Form from '@/Components/Forms/Form.vue';
	import NotificationComponent from '@/Components/NotificationComponent.vue';
	import { ref } from 'vue';
	import FormText from '@/Components/Forms/FormText.vue';
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import FormDate from '@/Components/Forms/FormDate.vue';

	const props = defineProps<{
		animal: Animal;
	}>();

	// paramètres de la notification
	const notificationConfig = ref({
		show: false,
		title: '',
		message: '',
		type: 'info',
	});
</script>
<template>
	<div class="animal-health bg-osecours-beige-dark bg-opacity-10">
		<Form
			id="animal-health-form"
			:actions="false"
		>
			<div
				class="h-full lg:h-full grid grid-cols-1 grid-rows-none md:grid-cols-2 md:grid-rows-none gap-1 flex-grow rounded-b-lg shadow-md p-2"
			>
				<NotificationComponent
					:config="notificationConfig"
					@close="notificationConfig.show = false"
				/>
				<div class="px-2 w-full md:col-start-1">
					<p>Statut vaccinal</p>
					<ul>
						<div class="my-2">
							<p class="text-osecours-black">vaccin 1</p>
							<p>Date:<span class="text-gray-500"> xx/xx/xxx</span></p>
							<p>Rappel:<span class="text-gray-500"> xx/xx/xxx</span></p>
						</div>
						<div class="mb-2">
							<p class="text-osecours-black">vaccin 2</p>
							<p>Date:<span class="text-gray-500"> xx/xx/xxx</span></p>
							<p>Rappel:<span class="text-gray-500"> xx/xx/xxx</span></p>
						</div>
						<li>...</li>
					</ul>
				</div>
				<div class="px-2 w-full md:col-start-2 bg-osecours-white">
					<p>Dernières mesures connues</p>
					<div class="my-2">
						<p>Date:<span class="text-gray-500"> xx/xx/xxx</span></p>
						<p class="text-osecours-black">
							Poids<span class="text-gray-500"> xx.x kg</span>
						</p>
						<p class="text-osecours-black">
							Taille<span class="text-gray-500"> xx.x kg</span>
						</p>
					</div>
					<div class="mb-2">
						<p>Date:<span class="text-gray-500"> xx/xx/xxx</span></p>
						<p class="text-osecours-black">
							Poids<span class="text-gray-500"> xx.x kg</span>
						</p>
						<p class="text-osecours-black">
							Taille<span class="text-gray-500"> xx.x kg</span>
						</p>
					</div>
				</div>

				<div class="w-full px-2 md:col-start-1 md:row-start-2 bg-osecours-pink">
					<FormSelect
						id="vaccine-type"
						name="vaccine"
						options=""
						label="Ajouter un vaccin"
					/>
					<FormDate
						id="vaccine-date"
						name="vaccine-date"
						label="Date de vaccination"
						:required="true"
					/>
				</div>
				<div class="px-2 w-full md:col-start-2 md:row-start-2 bg-amber-200">
					<p>Ajouter des informations ...</p>
					<FormTextArea
						id="health-information"
						label="Informations de santé"
						placeholder="Ajouter une information de santé"
						:required="true"
					/>
				</div>
				<div class="px-2 md:col-start-1 md:row-start-3 bg-emerald-200">
					<p>Ajouter un document, une ordonnance ...</p>
					<FormKit
						type="file"
						label="Documents"
						accept=".jpg,.png,.pdf"
						help="Select as many documents as you would like."
						multiple="true"
					/>
				</div>
				<div
					class="md:justify-end justify-end flex flex-row p-2 md:pb-4 md:col-start-2 md:row-start-3 md:items-end bg-fuchsia-300"
				>
					<button
						id="edit-mode"
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded hover:bg-blue-600 transition-colors"
					>
						blabla
					</button>
					<button
						id="save-changes"
						class="w-1/2 me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
					>
						button
					</button>
				</div>
			</div>
		</Form>
	</div>
</template>
<style scoped lang="postcss">
	.animal-health {
		//max-height: calc(100% - 4rem);
		display: flex;
		flex-direction: column;
		//min-height: calc(100vh - 4rem);
		min-height: 100%;
	}
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
	form {
		display: flex;
		flex-grow: 1;
		flex-direction: column;
	}
</style>
