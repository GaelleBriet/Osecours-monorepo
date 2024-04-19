<script setup lang="ts">
	import { defineProps, withDefaults } from 'vue';

	withDefaults(
		defineProps<{
			id: string;
			submitLabel?: string;
			actions?: boolean;
			outerClass?: string;
		}>(),
		{
			actions: false,
		},
	);

	const emit = defineEmits<{
		(e: 'invalid'): void;
	}>();

	const submitForm = (e: KeyboardEvent) => {
		(e.target as HTMLInputElement).blur();
		(e.target as HTMLInputElement).focus();
	};

	const submitInvalid = () => {
		emit('invalid');
	};
</script>

<template>
	<FormKit
		:id="id"
		:submit-label="submitLabel"
		type="form"
		:actions="actions"
		@keydown.enter="submitForm"
		@submit-invalid="submitInvalid"
	>
		<slot> </slot>
		<!--		<FormKit-->
		<!--			:id="`${id}-submit`"-->
		<!--			:wrapper-class="{ 'd-none': true }"-->
		<!--			:outer-class="outerClass"-->
		<!--			type="submit"-->
		<!--		></FormKit>-->
	</FormKit>
</template>

<style scoped lang="css"></style>
