<script setup lang="ts">
	import { FormKit } from '@formkit/vue';
	import { defineProps, defineEmits } from 'vue';
	import { getNode } from '@formkit/core';
	import { getValidationMessages } from '@formkit/validation';

	const props = defineProps<{
		id: string;
		modelValue?: string | undefined;
		value?: string | number;
		label?: string;
		labelClass?: string;
		name?: string;
		prefixIcon?: string;
		validation?: string | any[];
		disabled?: boolean;
		confirmationLabel?: string;
		validationVisibility?: string;
		validationMessages?: object;
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: string): void;
		(e: 'update:passwordConfirmation', value: string): void;
		(e: 'validation', message: string): void;
		(e: 'blur', event: Event): void;
	}>();

	const handleIconClick = (node: any, e) => {
		node.props.suffixIcon =
			node.props.suffixIcon === 'eye' ? 'eyeClosed' : 'eye';
		node.props.type = node.props.type === 'password' ? 'text' : 'password';
	};

	const onBlur = (e: Event) => {
		const inputElement = e.target as HTMLInputElement;
		if (inputElement.id === props.id) {
			emit('update:modelValue', inputElement.value);
		}
		// Send the password confirmation
		// else {
		// 	emit('update:passwordConfirmation', inputElement.value);
		// }

		const node = getNode(inputElement.id);
		if (!node) return;
		node.input(inputElement.value);
		if (props.validation) {
			const errors = getValidationMessages(node);
			errors.forEach((inputMessages) => {
				inputMessages.forEach((error) => {
					emit('validation', error.value as string);
				});
			});
		}
	};
</script>
<template>
	<FormKit
		:id="id"
		:model-value="modelValue"
		:value="modelValue"
		:name="name"
		:prefix-icon="prefixIcon"
		:label="label"
		:label-class="labelClass"
		:validation="validation"
		:validation-messages="validationMessages"
		:validation-visibility="validationVisibility"
		:disabled="disabled"
		suffix-icon="eyeClosed"
		@suffix-icon-click="handleIconClick"
		suffix-icon-class="hover:text-blue-500"
		type="password"
		@blur="onBlur"
	/>
</template>
<style scoped></style>
