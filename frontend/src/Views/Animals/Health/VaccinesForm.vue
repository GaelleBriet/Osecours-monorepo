<script lang="ts" setup>
	import FormDate from '@/Components/Forms/FormDate.vue';
	import FormSelect from '@/Components/Forms/FormSelect.vue';
</script>
<template>
	<div class="">
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
</template>
