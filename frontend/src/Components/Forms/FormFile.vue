<script setup lang="ts">
	defineProps<{
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

	const emit = defineEmits<{
		(e: 'update:modelValue', value: string): void;
		(e: 'blur', event: Event): void;
	}>();
</script>

<template>
	<FormKit
		id="id"
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
	/>
</template>

<style scoped>
	.group {
		margin-bottom: 4px !important;
	}
</style>
