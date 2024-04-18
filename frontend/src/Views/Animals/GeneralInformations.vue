<script lang="ts" setup>
	import { Animal } from '@/Interfaces/Animals/Animal.ts';
	import AnimalsForm from '@/Views/Animals/AnimalsForm.vue';

	const props = defineProps<{
		animal: Animal;
	}>();
</script>

<template>
	<AnimalsForm
		:animal="props.animal"
		:is-create-mode="false"
	/>
</template>
