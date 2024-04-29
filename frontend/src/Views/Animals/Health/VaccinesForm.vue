<script lang="ts" setup>
	import FormDate from '@/Components/Forms/FormDate.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import { generateOptionsWithDefault } from '@/Services/Helpers/Enums.ts';
	import { Vaccines } from '@/Enums/Vaccines.ts';
	import { ref } from 'vue';

	const props = defineProps<{
		editMode: boolean;
	}>();

	const emit = defineEmits<{
		(e: 'update:vaccineType', value: string): void;
		(e: 'update:vaccineDate', value: string): void;
	}>();

	let vaccine = ref('');
	let date = ref('');

	const vaccinesOptions = generateOptionsWithDefault(
		Vaccines,
		'enums.animalVaccines',
		'Choisir un vaccin',
	);

	const updateVaccineType = (value: string) => {
		vaccine.value = value;
		emit('update:vaccineType', value);
	};

	const updateVaccineDate = (value: string) => {
		date.value = value;
		emit('update:vaccineDate', value);
	};
</script>
<template>
	<div class="">
		<p class="mb-5">
			<span
				class="border-b-2 border-osecours-pink border-opacity-50 text-osecours-black text-lg"
			>
				Ajouter un vaccin
			</span>
		</p>
		<FormSelect
			id="vaccine-type"
			:model-value="vaccinesOptions"
			:name="'vaccine'"
			:options="vaccinesOptions"
			:disabled="!props.editMode"
			@update:modelValue="updateVaccineType"
		/>
		<FormDate
			id="vaccine-date"
			name="vaccine-date"
			label="Date de vaccination"
			:disabled="!props.editMode"
			@update:modelValue="updateVaccineDate"
		/>
	</div>
</template>
