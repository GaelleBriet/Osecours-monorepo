<script lang="ts" setup>
	const props = defineProps<{
		editMode: boolean;
	}>();
</script>
<template>
	<div>
		<p>Ajouter un document, une ordonnance ...</p>
		<FormKit
			type="file"
			label="Documents"
			accept=".jpg,.png,.pdf"
			help="Select as many documents as you would like."
			multiple="true"
			:disabled="!props.editMode"
		/>
	</div>
</template>
