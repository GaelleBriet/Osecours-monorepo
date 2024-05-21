<script setup lang="ts">
	import { FormKit } from '@formkit/vue';
	import { defineProps, defineEmits } from 'vue';

	defineProps<{
		id: string;
		modelValue?: string | undefined;
		value?: string | number;
		name?: string;
		label?: string;
		placeholder?: string;
		help?: string;
		validation?: string | never[];
		classes?: object;
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: string): void;
	}>();

	const onInput = (value: string) => {
		emit('update:modelValue', value);
	};
</script>
<template>
	<FormKit
		:id="id"
		:model-value="modelValue"
		:value="modelValue"
		:name="name"
		:label="label"
		:placeholder="placeholder"
		:help="help"
		:validation="validation"
		:classes="{
			inner: 'max-h-10',
			input: 'text-sm',
		}"
		type="date"
		@input="onInput($event)"
	/>
</template>

<style scoped>
	.group {
		margin-bottom: 4px !important;
	}
</style>
