<script lang="ts" setup>
	import { Association } from '@/Interfaces/Associations.ts';
	import AssociationsFormComponent from '@/Components/AssociationsFormComponent.vue';

	const props = defineProps<{
		association: Association;
	}>();
</script>

<template>
	<AssociationsFormComponent
		:association="props.association"
		:is-create-mode="false"
	/>
</template>
