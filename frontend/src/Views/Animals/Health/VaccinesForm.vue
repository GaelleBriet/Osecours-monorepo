<script lang="ts" setup>
	import FormDate from '@/Components/Forms/FormDate.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
	import { generateOptionsWithDefault } from '@/Services/Helpers/Enums.ts';
	import { Vaccines } from '@/Enums/Vaccines.ts';

	const vaccinesOptions = generateOptionsWithDefault(
		Vaccines,
		'enums.animalVaccines',
		'Choisir un vaccin',
	);
</script>
<template>
	<div class="">
		<FormSelect
			id="vaccine-type"
			:name="'vaccine'"
			:options="vaccinesOptions"
			:label="'Ajouter un vaccin'"
		/>
		<FormDate
			id="vaccine-date"
			name="vaccine-date"
			label="Date de vaccination"
			:required="true"
		/>
	</div>
</template>
