<script setup lang="ts">
	import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid';
	import { XMarkIcon } from '@heroicons/vue/20/solid';

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

	const emit = defineEmits(['close']);

	const closeAlert = () => {
		emit('close');
	};
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
		<div class="flex justify-around">
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
				</p>
			</div>
			<div class="-mx-1.5 -my-1.5">
				<button
					type="button"
					class="inline-flex rounded-md"
					:class="{
						'bg-yellow-50 text-yellow-500 hover:bg-yellow-100 focus:ring-yellow-600 focus:ring-offset-yellow-50':
							props.warning,
						'bg-red-50 text-red-500 hover:bg-red-100 focus:ring-red-600 focus:ring-offset-red-50':
							props.error,
						'bg-green-50 text-green-500 hover:bg-green-100 focus:ring-green-600 focus:ring-offset-green-50':
							props.success,
					}"
					@click="closeAlert"
				>
					<XMarkIcon
						class="h-5 w-5"
						aria-hidden="true"
					/>
				</button>
			</div>
		</div>
	</div>
</template>
