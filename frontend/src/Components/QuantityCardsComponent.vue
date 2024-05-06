<script lang="ts" setup>
	defineProps<{
		title: string;
		quantity: string;
	}>();
</script>
<template>
	<div
		class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm hover:border-osecours-pink"
	>
		<div class="min-w-0 flex-1">
			<span
				class="absolute inset-0"
				aria-hidden="true"
			/>
			<p class="text-sm font-medium text-gray-900 mb-2.5">
				{{ title }}
			</p>
			<p class="truncate text-sm text-gray-500">
				{{ quantity }}
			</p>
		</div>
	</div>
</template>

<style scoped></style>
