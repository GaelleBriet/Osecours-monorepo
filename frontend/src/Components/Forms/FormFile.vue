<script setup lang="ts">
	import { getNode } from '@formkit/core';

	const props = defineProps<{
		id: string;
		modelValue?: string | undefined;
		value?: string | number;
		name?: string;
		label?: string;
		placeholder?: string;
		validation?: string | never[];
		validationVisibility?: string;
		accept: string;
		multiple: boolean;
		disabled?: boolean;
		help?: string;
		fileItemIcon?: string;
		noFilesIcon?: string;
		outerClass?: string;
		wrapperClass?: string;
		innerClass?: string;
	}>();

	defineEmits<{
		(e: 'update:modelValue', value: string): void;
		(e: 'blur', event: Event): void;
	}>();

	const onInput = (e: Event) => {
		const inputElement = e.target as HTMLInputElement;
		const node = getNode(inputElement.id);
		if (!node) return;
		emit('update:modelValue', inputElement.value);
	};
</script>

<template>
	<FormKit
		:id="id"
		:name="name"
		:label="label"
		:validation="validation"
		:validation-visibility="validationVisibility"
		:accept="accept"
		:help="help"
		:multiple="multiple"
		:file-item-icon="fileItemIcon"
		:no-files-icon="noFilesIcon"
		:outer-class="outerClass"
		:wrapper-class="wrapperClass"
		:inner-class="innerClass"
		type="file"
		@change="onInput"
	/>
</template>

<style scoped>
	.group {
		margin-bottom: 4px !important;
	}
</style>
