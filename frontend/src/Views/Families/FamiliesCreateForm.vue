<script setup lang="ts">
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import FamiliesForm from '@/Views/Families/FamiliesForm.vue';

	const t = i18n.global.t;
</script>

<template>
	<div class="container">
		<div class="flex flex-row justify-between mb-2">
			<div class="text-2xl mb-1">
				{{ getCapitalizedText(t('pages.families.card')) }}
			</div>
			<button
				id="back-btn"
				class="me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors duration-200 ease-in-out"
				@click="$router.go(-1)"
			>
				{{ getCapitalizedText(t('common.back')) }}
			</button>
		</div>
		<div class="content">
			<FamiliesForm
				:is-edit-mode="true"
				:is-create-mode="true"
			/>
		</div>
	</div>
</template>

<style scoped lang="postcss">
	.container {
		display: flex;
		flex-direction: column;
		height: 100%;
		padding: 0;
	}

	.content {
		flex-grow: 1;
		overflow-y: auto;
	}

	#back-btn {
		background-color: #d99962;
		color: #fff;
		&:hover {
			background-color: var(--color-withe);
			color: #d99962;
			outline: 1px solid #d99962;
		}
	}
</style>
