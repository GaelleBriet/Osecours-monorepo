<script lang="ts" setup>
	import { Document } from '@/Interfaces/Document.ts';
	import DocumentsForm from '@/Views/Documents/DocumentsForm.vue';

	const props = defineProps<{
		document: Document;
	}>();
</script>

<template>
	<DocumentsForm
		:document="props.document"
		:is-create-mode="false"
	/>
</template>
