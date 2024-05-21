<script setup lang="ts">
	import { getNode } from '@formkit/core';
	import { computed } from 'vue';
	import { FormKit } from '@formkit/vue';
	import { getValidationMessages } from '@formkit/validation';

	const props = defineProps<{
		id: string | number;
		modelValue?: string | boolean | number | undefined | null;
		value?: number | string;
		name: string;
		label?: string;
		options: never;
		placeholder?: string;
		validation?: string;
		validationVisibility?: string;
		disabled?: boolean;
		classes?: object;
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: never): void;
		(e: 'validation', message: object): void;
	}>();

	const stringId = computed(() => props.id.toString());

	const onChange = (e: Event) => {
		const selectElement = e.target as HTMLSelectElement;
		if (selectElement.id) {
			const node = getNode(selectElement.id);
			if (!node) return;

			if (props.validation) {
				getValidationMessages(node).forEach((inputMessage) => {
					inputMessage.forEach((error) => {
						emit('validation', error);
					});
				});
			}
			node.input(selectElement.value);
			let value: never = props.value ?? props.modelValue;

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
	>
		<template #label>
			<span
				v-html="label"
				class="block text-neutral-700 text-sm font-medium mb-1 dark:text-neutral-700 formkit-label"
			></span>
		</template>
	</FormKit>
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
