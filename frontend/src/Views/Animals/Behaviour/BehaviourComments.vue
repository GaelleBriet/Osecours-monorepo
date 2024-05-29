<script setup lang="ts">
	import FormTextArea from '@/Components/Forms/FormTextArea.vue';
	import { Animal } from '@/Interfaces/Animals/Animal.ts';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const t = i18n.global.t;

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
					>{{ getCapitalizedText(t('pages.animals.animalBehaviour')) }}</span
				>
			</p>
		</div>
		<div>
			<FormTextArea
				:model-value="animal.behavioral_comment"
				:label="getCapitalizedText(t('pages.animals.comment'))"
				id="comments"
				:placeholder="getCapitalizedText(t('pages.animals.addComment'))"
				:disabled="!editMode"
				@update:modelValue="onUpdatedComments"
			/>
		</div>
	</div>
</template>
