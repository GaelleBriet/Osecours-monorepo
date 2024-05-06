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

	const onClick = (e: Event) => {
		const inputElement = e.target as HTMLInputElement;
		emit('update:modelValue', inputElement.checked);
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
		@click="onClick"
	/>
</template>
<style lang="postcss">
	.group {
		margin-bottom: 4px !important;
	}
	[data-type='toggle'] input:checked ~ .formkit-track {
		background-color: var(--color-pink);
	}
	[data-type='toggle']:focus-within .formkit-track {
		box-shadow: none;
	}
	[type='checkbox']:focus {
		box-shadow: none;
	}
	[data-type='toggle']:focus-within input:checked ~ .formkit-track {
		box-shadow: none;
	}
	.formkit-innerLabel {
		font-size: 0.58rem;
	}
</style>
