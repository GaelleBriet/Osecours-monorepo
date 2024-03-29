<script lang="ts" setup>
	import { getNode } from '@formkit/core';
	import { computed, watch } from 'vue';

	const props = defineProps<{
		id: string;
		modelValue?: string[] | number[] | boolean;
		name: string;
		label?: string;
		labelClass?: string;
		legendClass?: string;
		help?: string;
		value?: string[] | number[];
		onValue?: never;
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: string[] | number[]): void;
		(e: 'newValue', value: string[]): void;
		(e: 'validation', message: string): void;
	}>();

	const checkBoxesValues = computed({
		get(): string[] | number[] {
			if (props.modelValue === undefined) {
				return [];
			}
			return props.modelValue;
		},
		set(value: string[] | number[]) {
			emit('update:modelValue', value);
		},
	});

	watch(
		() => checkBoxesValues,
		(value) => {
			emit('newValue', value.value as string[]);
		},
		{ deep: true },
	);

	watch(
		() => props.options,
		() => {
			const node = getNode(props.id);
			if (node) {
				node.reset();
			}
		},
	);
</script>

<template>
	<div>
		<FormKit
			:id="id"
			v-model="checkBoxesValues"
			:classes="{
				decoratorIcon: 'd-flex justify-content-center align-items-center',
			}"
			:help="help"
			:label="label"
			:label-class="'ml-3 block text-sm leading-6 text-gray-700 ' + labelClass"
			:legend-class="legendClass"
			:name="name"
			:on-value="onValue"
			:value="value"
			autocomplete="off"
			fieldset-class="$reset"
			type="checkbox"
		/>
	</div>
</template>
<style lang="postcss">
	[data-type='checkbox'] .formkit-input:checked ~ .formkit-decorator,
	[data-type='radio'] .formkit-input:checked ~ .formkit-decorator {
		box-shadow: none;
		background-color: #d99962;
		&:hover {
			cursor: pointer;
		}
	}
	[data-type='checkbox']
		.formkit-input:checked
		~ .formkit-decorator
		.formkit-icon {
		color: white;
	}
	[data-type='checkbox'] .formkit-input:focus ~ .formkit-decorator,
	[data-type='radio'] .formkit-input:focus ~ .formkit-decorator {
		outline: none;
		box-shadow: 0px 0px 0px 1px #d99962;
		&:hover {
			cursor: pointer;
		}
	}
	[data-type='checkbox'] .formkit-input ~ .formkit-decorator,
	[data-type='radio'] .formkit-input ~ .formkit-decorator {
		outline: none;
		&:hover {
			cursor: pointer;
		}
		//box-shadow: none;
	}
	.dark\:ring-offset-blue-500 {
		--tw-ring-offset-color: white;
	}
</style>
