<script lang="ts" setup>
	import { Shelter } from '@/Interfaces/Shelter.ts';
	import SheltersForm from '@/Views/Shelters/SheltersForm.vue';

	const props = defineProps<{
		shelter: Shelter;
	}>();
</script>

<template>
	<SheltersForm
		:shelter="props.shelter"
		:is-create-mode="false"
	/>
</template>
