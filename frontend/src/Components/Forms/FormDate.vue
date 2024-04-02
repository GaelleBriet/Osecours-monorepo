<script setup lang="ts">
	import { FormKit } from '@formkit/vue';
	import { defineProps, defineEmits } from 'vue';

	defineProps<{
		id: string;
		modelValue?: string | undefined;
		value?: string | number;
		name?: string;
		label?: string;
		placeholder?: string;
		help?: string;
		validation?: string | never[];
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: string): void;
	}>();

	const onInput = (value: string) => {
		// const date = value ? new Date(value.replace('T', '')) : null;
		// console.log('date', date);
		emit('update:modelValue', value);
	};

	// const onSuffixIconClick = () => {
	// 	const inputElement = document.getElementById(props.id) as HTMLInputElement;
	// 	if (!inputElement) return;
	// 	inputElement.click();
	// };

	// const onBlur = (event: Event) => {
	// 	isFocus.value = false;
	//
	// 	const inputElement = event.target as HTMLInputElement;
	// 	const node = getNode(inputElement.id);
	// 	if (!node) return;
	//
	// 	// apply dirty state on form submit which use blur event
	// 	if (props.validationVisibility === 'dirty') {
	// 		if (!node.context) return;
	// 		node.context.state.dirty = true;
	// 	}
	// 	node.input(inputElement.value);
	// };
</script>
<template>
	<FormKit
		:id="id"
		:model-value="modelValue"
		:value="modelValue"
		:name="name"
		:label="label"
		:placeholder="placeholder"
		:help="help"
		:validation="validation"
		type="date"
		@input="onInput($event)"
	/>
</template>
<style scoped></style>

<!--		@update:model-value="emit('update:modelValue', $event as string)"-->
<!--:disabled="disabled"-->
<!--:validation="validation"-->
<!--:validation-visibility="validationVisibility"-->
