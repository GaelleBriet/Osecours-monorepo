<script setup lang="ts">
	import { FormKit } from '@formkit/vue';
	import { defineProps, defineEmits, watch } from 'vue';
	import { FormKitNode, getNode } from '@formkit/core';

	const props = defineProps<{
		id: string;
		modelValue?: string | undefined;
		value?: string | number;
		label?: string;
		name?: string;
		placeholder?: string;
		prefixIcon?: string;
		validation?: string | any[];
		validationVisibility?: string;
		disabled?: boolean;
		classes?: Object;
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

		// node.input(inputElement.value);
		// if (props.validation) {
		// 	applyValidation(node);
		// }

		if (inputElement.value === '') {
			const innerWrapper = inputElement.closest('[data-complete]');
			if (innerWrapper) innerWrapper.removeAttribute('data-complete');
		}
		emit('blur', e);
	};
	// watch(
	// 	() => props.modelValue,
	// 	() => {
	// 		const node = getNode(props.id);
	// 		if (!node) return;
	// 		node.input(props.modelValue, false);
	// 	}
	// );
</script>
<template>
	<FormKit
		:id="id"
		:model-value="modelValue"
		:value="modelValue"
		:name="name"
		:placeholder="placeholder"
		:prefix-icon="prefixIcon"
		:label="label"
		:validation="validation"
		:validation-visibility="validationVisibility"
		:disabled="disabled"
		type="text"
		@blur="onBlur"
	/>
</template>
<style scoped></style>
<!--		@update:model-value="emit('update:modelValue', $event as string)"-->
