<script setup lang="ts">
	import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid';

	import { defineProps } from 'vue';
	const props = defineProps({
		message: {
			type: String,
			required: true,
		},
		warning: {
			type: Boolean,
			default: false,
		},
		error: {
			type: Boolean,
			default: false,
		},
		success: {
			type: Boolean,
			default: false,
		},
	});
</script>
<template>
	<div
		class="border-l-4 p-4"
		:class="{
			'border-yellow-400 bg-yellow-50': props.warning,
			'border-red-400 bg-red-50': props.error,
			'border-green-400 bg-green-50': props.success,
		}"
	>
		<div class="flex">
			<div class="flex-shrink-0">
				<ExclamationTriangleIcon
					class="h-5 w-5"
					:class="{
						'text-yellow-400': props.warning,
						'text-red-400': props.error,
						'text-green-400': props.success,
					}"
					aria-hidden="true"
				/>
			</div>
			<div class="ml-3">
				<p
					class="text-sm"
					:class="{
						'text-yellow-700': props.warning,
						'text-red-700': props.error,
						'text-green-700': props.success,
					}"
				>
					{{ props.message }}
					<!--					<a-->
					<!--						href="#"-->
					<!--						class="font-medium text-yellow-700 underline hover:text-yellow-600"-->
					<!--						>Upgrade your account to add more credits.</a-->
					<!--					>-->
				</p>
			</div>
		</div>
	</div>
</template>
