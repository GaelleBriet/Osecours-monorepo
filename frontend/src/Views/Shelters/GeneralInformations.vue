<script lang="ts" setup>
	import { Shelter } from '@/Interfaces/Shelter.ts';
	import SheltersFormComponent from '@/Components/SheltersFormComponent.vue';

	const props = defineProps<{
		shelter: Shelter;
	}>();
</script>

<template>
	<SheltersFormComponent
		:shelter="props.shelter"
		:is-create-mode="false"
	/>
</template>
