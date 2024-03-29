<script setup lang="ts">
	import { FormKitOptionsLoader } from '@formkit/pro';
	import { getNode } from '@formkit/core';

	defineProps<{
		id: string;
		modelValue?: string | boolean | number;
		value?: number;
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
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: number | string | boolean): void;
	}>();

	const onChange = (e: Event) => {
		const selectElement = e.target as HTMLSelectElement;
		if (selectElement.id) {
			const node = getNode(selectElement.id);
			if (!node) return;
			node.input(selectElement.value);

			emit('update:modelValue', selectElement.id);
		}
	};
</script>
<template>
	<FormKit
		:id="id"
		model-value="modelValue"
		:value="modelValue"
		:name="name"
		:label="label"
		:options="options"
		:placeholder="placeholder"
		:validation="validation"
		:validation-visibility="validationVisibility"
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
</style>
<style></style>
