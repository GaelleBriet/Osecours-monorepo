<script lang="ts" setup>
	const props = defineProps<{
		editMode: boolean;
	}>();
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const t = i18n.global.t;

</script>
<template>
	<div>
		<p class="mb-5">
			<span
				class="border-b-2 border-osecours-pink border-opacity-50 text-osecours-black text-lg"
			>
				{{ getCapitalizedText(t('pages.documents.addDoc')) }}
			</span>
		</p>
		<FormKit
			type="file"
			accept=".jpg,.png,.pdf"
			:help="getCapitalizedText(t('pages.documents.selectDocs'))"
			multiple="true"
			:disabled="!props.editMode"
		/>
	</div>
</template>
