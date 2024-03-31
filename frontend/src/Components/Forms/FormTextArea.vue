<script setup lang="ts">
	const props = defineProps<{
		id: string;
		modelValue?: string | undefined;
		value?: string | number;
		name?: string;
		label?: string;
		placeholder?: string;
		help?: string;
		validation?: string | never[];
		validationVisibility?: string;
		disabled?: boolean;
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: string): void;
		(e: 'blur', event: Event): void;
	}>();

	const onBlur = (e: Event) => {
		const inputElement = e.target as HTMLInputElement;
		emit('update:modelValue', inputElement.value);
		if (!inputElement.id) return;
		const node = getNode(inputElement.id);
		if (!node) return;

		// apply dirty state on form submit which use blur event
		if (props.validationVisibility === 'dirty') {
			if (!node.context) return;
			node.context.state.dirty = true;
		}

		if (inputElement.value === '') {
			const innerWrapper = inputElement.closest('[data-complete]');
			if (innerWrapper) innerWrapper.removeAttribute('data-complete');
		}
		emit('blur', e);
	};
</script>

<template>
	<FormKit
		:id="id"
		:name="name"
		:label="label"
		:placeholder="placeholder"
		:help="help"
		:validation="validation"
		:validation-visibility="validationVisibility"
		type="textarea"
		@blur="onBlur"
	/>
</template>

<style scoped></style>
