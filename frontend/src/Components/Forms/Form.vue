<script setup lang="ts">
	import { submit } from '@formkit/icons';
	import { defineProps, withDefaults } from 'vue';

	// const props = defineProps<{
	// 	id: string;
	// 	submitLabel?: string;
	// 	actions: {
	// 		type: boolean;
	// 		default: false;
	// 	};
	// }>();

	const props = withDefaults(
		defineProps<{
			id: string;
			submitLabel?: string;
			actions?: boolean;
		}>(),
		{
			actions: false, // Définition de la valeur par défaut à false
		},
	);

	const submitForm = (e: KeyboardEvent) => {
		(e.target as HTMLInputElement).blur();
		(e.target as HTMLInputElement).focus();
	};
</script>

<template>
	<FormKit
		:id="id"
		:submit-label="submitLabel"
		type="form"
		:actions="actions"
		@keydown.enter="submitForm"
	>
		<!--		<FormKit-->
		<!--			:id="`${id}-submit`"-->
		<!--			type="submit"-->
		<!--		></FormKit>-->
		<slot></slot>
	</FormKit>
</template>

<style scoped lang="css"></style>
