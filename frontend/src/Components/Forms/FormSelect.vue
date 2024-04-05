<script setup lang="ts">
	import { FormKitOptionsLoader } from '@formkit/pro';
	import { getNode } from '@formkit/core';
	import { computed } from 'vue';
	import { FormKit } from '@formkit/vue';

	const props = defineProps<{
		id: string | number;
		modelValue?: string | boolean | number;
		value?: number | string;
		name: string;
		label?: string;
		options:
			| string[]
			| number[]
			| Record<string | number, string>
			| FormKitOptionsLoader
			| undefined;
		placeholder?: string;
		validation?: string;
		validationVisibility?: string;
		disabled?: boolean;
		classes?: object;
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: number | string | boolean): void;
	}>();

	const stringId = computed(() => props.id.toString());
	const onChange = (e: Event) => {
		const selectElement = e.target as HTMLSelectElement;
		if (selectElement.id) {
			const node = getNode(selectElement.id);
			if (!node) return;
			node.input(selectElement.value);
			let value: string | boolean | number | undefined =
				props.value ?? props.modelValue;
			switch (typeof value) {
				case 'boolean':
					value = selectElement.value === 'true';
					break;
				case 'number':
					value = +selectElement.value;
					break;
				default:
					value = selectElement.value;
			}
			console.log('value', value);
			emit('update:modelValue', value);
		}
	};
</script>
<template>
	<FormKit
		:id="stringId"
		:model-value="modelValue"
		:value="modelValue"
		:name="name"
		:label="label"
		:options="options"
		:placeholder="placeholder"
		:validation="validation"
		:validation-visibility="validationVisibility"
		:disabled="disabled"
		:classes="{
			inner: 'max-h-10',
			input: 'text-sm',
		}"
		type="select"
		@change="onChange"
	></FormKit>
</template>

<style lang="postcss" scoped>
	.formkit-outer .formkit-icon {
		padding-top: 10px;
	}
	[data-type='checkbox'] .formkit-input:focus ~ .formkit-decorator,
	[data-type='radio'] .formkit-input:focus ~ .formkit-decorator {
		outline: none;
	}
	.group {
		margin-bottom: 4px !important;
	}
</style>
