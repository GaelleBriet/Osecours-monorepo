<script setup lang="ts">
	import { FormKit } from '@formkit/vue';
	import { defineProps, defineEmits } from 'vue';
	import { getNode } from '@formkit/core';
	import { getValidationMessages } from '@formkit/validation';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const props = defineProps<{
		id: string;
		modelValue?: string | undefined;
		value?: string | number;
		label?: string;
		confirmLabel?: string;
		labelClass?: string;
		name?: string;
		prefixIcon?: string;
		validation: string | [rule: string, ...args: any[]][] | undefined;
		disabled?: boolean;
		confirmationLabel?: string;
		validationVisibility?: string;
		validationMessages?: object;
		classes?: object;
		showConfirm?: boolean;
		placeholder?: string;
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: string): void;
		(e: 'update:passwordConfirmation', value: string): void;
		(e: 'validation', message: string): void;
		(e: 'blur', event: Event): void;
	}>();

	const confirmationId = 'confirmation' + getCapitalizedText(props.id);

	// eslint-disable-next-line @typescript-eslint/no-explicit-any
	const handleIconClick = (node: any) => {
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
		else {
			emit('update:passwordConfirmation', inputElement.value);
		}

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

	const isRequired = () => {
		let isRequired = false;
		if (typeof props.validation === 'string') {
			isRequired = props.validation.includes('required');
		}

		if (typeof props.validation === 'object') {
			props.validation.forEach((rule: string[]) => {
				if (rule.includes('required')) {
					isRequired = true;
				}
			});
		}
		return isRequired;
	};
</script>
<template>
	<FormKit
		:id="id"
		:model-value="modelValue"
		:value="modelValue"
		name="password"
		:is-required="isRequired()"
		:prefix-icon="prefixIcon"
		:label="label"
		:label-class="labelClass"
		:validation="validation"
		:validation-messages="validationMessages"
		:validation-visibility="validationVisibility"
		:disabled="disabled"
		:placeholder="placeholder"
		suffix-icon="eyeClosed"
		@suffix-icon-click="handleIconClick"
		suffix-icon-class="hover:text-osecours-beige-dark"
		:classes="{
			inner: 'max-h-10 mb-4',
			input: 'text-sm',
		}"
		type="password"
		@blur="onBlur"
	/>
	<FormKit
		v-if="showConfirm"
		:id="confirmationId"
		name="password_confirm"
		:is-required="isRequired()"
		:prefix-icon="prefixIcon"
		:label="confirmLabel"
		:label-class="labelClass"
		validation="required|confirm"
		:disabled="disabled"
		suffix-icon="eyeClosed"
		@suffix-icon-click="handleIconClick"
		suffix-icon-class="hover:text-osecours-beige-dark"
		:classes="{
			inner: 'max-h-10',
			input: 'text-sm',
		}"
		type="password"
		@blur="onBlur"
	/>
</template>
<style scoped>
	.group {
		margin-bottom: 4px !important;
	}
</style>
