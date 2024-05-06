<script setup lang="ts">
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import { Animal } from '@/Interfaces/Animals/Animal.ts';

	defineProps<{
		editMode: boolean;
		animal: Animal;
	}>();

	const emit = defineEmits<{
		(e: 'update:comments', value: string): void;
	}>();

	const onUpdatedComments = (value: string) => {
		emit('update:comments', value);
	};
</script>
<template>
	<div>
		<div>
			<p class="mb-5">
				<span
					class="border-b-2 border-osecours-pink border-opacity-50 text-osecours-black text-lg"
					>Comportement de l'animal</span
				>
			</p>
		</div>
		<div>
			<FormTextArea
				:model-value="animal.behavioral_comment"
				label="Commentaires"
				id="comments"
				placeholder="Ajouter des commentaires"
				:disabled="!editMode"
				@update:modelValue="onUpdatedComments"
			/>
		</div>
	</div>
</template>
