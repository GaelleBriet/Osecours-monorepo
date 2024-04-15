<script setup lang="ts">
	import { FormKit } from '@formkit/vue';
	import { defineProps, defineEmits } from 'vue';
	import { getNode } from '@formkit/core';

	const props = defineProps<{
		classes?: object;
		disabled?: boolean;
		id?: string;
		label?: string;
		modelValue?: boolean | undefined;
		name?: string;
		placeholder?: string;
		prefixIcon?: string;
		value?: string | number;
		offValueLabel?: string;
		onValueLabel?: string;
		valueLabelDisplay?: string;
		offValue?: string;
		onValue?: string;
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: string): void;
		(e: 'blur', event: Event): void;
	}>();

	const onBlur = (e: Event) => {
		const inputElement = e.target as HTMLInputElement;
		emit('update:modelValue', inputElement.value);
		if (!inputElement.id) return;
		const node = getNode(inputElement.id);
		if (!node) return;

		// apply dirty state on form submit which use blur event
		if (props.validationVisibility === 'dirty') {
			if (!node.context) return;
			node.context.state.dirty = true;
		}

		if (inputElement.value === '') {
			const innerWrapper = inputElement.closest('[data-complete]');
			if (innerWrapper) innerWrapper.removeAttribute('data-complete');
		}
		emit('blur', e);
	};
</script>
<template>
	<FormKit
		:id="id"
		:model-value="modelValue"
		:value="modelValue"
		:name="name"
		:placeholder="placeholder"
		:label="label"
		:off-value-label="offValueLabel"
		:on-value-label="onValueLabel"
		:value-label-display="valueLabelDisplay"
		:off-value="offValue"
		:onValue="onValue"
		:disabled="disabled"
		:classes="{
			inner: 'max-h-10',
			input: 'text-sm',
		}"
		type="toggle"
		@blur="onBlur"
	/>
</template>
<style scoped>
	.group {
		margin-bottom: 4px !important;
	}
</style>
