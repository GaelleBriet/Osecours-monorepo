<script lang="ts" setup>
	import { Association } from '@/Interfaces/Association.ts';
	import AssociationsForm from '@/Views/Association/AssociationsForm.vue';

	const props = defineProps<{
		association: Association;
	}>();
</script>

<template>
	<AssociationsForm
		:association="props.association"
		:is-create-mode="false"
	/>
</template>
