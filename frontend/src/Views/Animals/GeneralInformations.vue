<script lang="ts" setup>
	import { Animal } from '@/Interfaces/Animal.ts';
	import AnimalsFormComponent from '@/Views/Animals/AnimalsForm.vue';

	const props = defineProps<{
		animal: Animal;
	}>();
</script>

<template>
	<AnimalsFormComponent
		:animal="props.animal"
		:is-create-mode="false"
	/>
</template>
