<script setup lang="ts">
	import FormToggle from '@/Components/Forms/FormToggle.vue';
	import { defineEmits } from 'vue';
	import { Animal } from '@/Interfaces/Animals/Animal.ts';

	const props = defineProps<{
		editMode: boolean;
		animal: Animal;
	}>();

	const emit = defineEmits<{
		(e: 'update:childrenAgreements', value: string): void;
		(e: 'update:catsAgreements', value: string): void;
		(e: 'update:dogsAgreements', value: string): void;
	}>();

	const updateChildrenAgreements = (value: boolean) => {
		emit('update:childrenAgreements', value);
	};

	const updateCatsAgreements = (value: boolean) => {
		emit('update:catsAgreements', value);
	};

	const updateDogsAgreements = (value: boolean) => {
		emit('update:dogsAgreements', value);
	};
</script>
<template>
	<div>
		<div>
			<p class="mb-5">
				<span
					class="border-b-2 border-osecours-pink border-opacity-50 text-osecours-black text-lg"
					>Ententes de l'animal</span
				>
			</p>
		</div>
		<div>
			<FormToggle
				:model-value="animal.children_friendly"
				label="Entente avec les enfants"
				id="children-agreement"
				label-position="secondary"
				off-value-label="NON"
				on-value-label="OUI"
				value-label-display="inner"
				:disabled="!editMode"
				@update:modelValue="updateChildrenAgreements"
			/>
			<FormToggle
				:model-value="animal.cats_friendly"
				label="Entente avec les chats"
				id="cat-agreement"
				label-position="secondary"
				off-value-label="NON"
				on-value-label="OUI"
				value-label-display="inner"
				:disabled="!editMode"
				@update:modelValue="updateCatsAgreements"
			/>
			<FormToggle
				:model-value="animal.dogs_friendly"
				label="Entente avec les chiens"
				id="dog-agreement"
				label-position="secondary"
				off-value-label="NON"
				on-value-label="OUI"
				value-label-display="inner"
				:disabled="!editMode"
				@update:modelValue="updateDogsAgreements"
			/>
		</div>
	</div>
</template>
