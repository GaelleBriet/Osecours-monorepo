<script setup lang="ts">
	import { FormKit } from '@formkit/vue';
	import { defineProps, defineEmits, ref } from 'vue';
	import { getNode } from '@formkit/core';

	const props = defineProps<{
		classes?: object;
		disabled?: boolean;
		id?: string;
		label?: string;
		modelValue?: string | undefined;
		name?: string;
		placeholder?: string;
		prefixIcon?: string;
		validation?: string | never[];
		validationVisibility?: string;
		value?: string | number;
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: string): void;
		(e: 'blur', event: Event): void;
	}>();

	const inputRef = ref(null);

	const onInput = (value: never) => {
		const node = inputRef.value.node;
		if (!node) return;
		emit('update:modelValue', value);
	};

	const onBlur = (e: Event) => {
		const inputElement = e.target as HTMLInputElement;

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
		ref="inputRef"
		:model-value="modelValue"
		:value="modelValue"
		:name="name"
		:placeholder="placeholder"
		:prefix-icon="prefixIcon"
		:label="label"
		:validation="validation"
		:validation-visibility="validationVisibility"
		:disabled="disabled"
		:classes="{
			inner: 'max-h-10',
			input: 'text-sm',
		}"
		type="number"
		@blur="onBlur"
		@input="onInput($event)"
	/>
</template>
<style scoped>
	.group {
		margin-bottom: 4px !important;
	}
</style>
