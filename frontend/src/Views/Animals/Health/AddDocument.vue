<script lang="ts" setup>
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';

	const t = i18n.global.t;

	const props = defineProps<{
		editMode: boolean;
	}>();
</script>
<template>      
	<div>
		<p class="mb-5">
			<span
				class="border-b-2 border-osecours-pink border-opacity-50 text-osecours-black text-lg"
			>
				Ajouter un document
			</span>
		</p>
		<FormKit
			type="file"
			accept=".jpg,.png,.pdf"
			help="Select as many documents as you would like."
			multiple="true"
			:disabled="!props.editMode"
		/>
	</div>
</template>
