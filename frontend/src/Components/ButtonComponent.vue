<script setup lang="ts">
	import { computed } from 'vue';

	const props = defineProps<{
		id?: string;
		label?: string;
		type?: 'button' | 'submit' | 'reset';
		disabled?: boolean;
		size: 'xs' | 'sm' | 'md' | 'lg';
	}>();

	const emit = defineEmits<{
		(e: 'click', event: Event): void;
	}>();

	const onClick = (event: Event) => {
		emit('click', event);
	};

	const buttonClass = computed(() => ({
		'button-xs rounded dialog-color text-gray-400 hover:text-gray-500 disabled:opacity-50 disabled:cursor-not-allowed':
			props.size === 'xs',
		'button-sm transition-colors duration-200 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed':
			props.size === 'sm',
		'button-md rounded px-2 py-1 text-center text-sm text-white h-8 w-32 disabled:opacity-50 disabled:cursor-not-allowed':
			props.size === 'md',
		'button-lg rounded px-3 py-1.5 shadow-sm justify-center text-center text-sm  leading-6 text-white h-10 w-60 disabled:opacity-50 disabled:cursor-not-allowed':
			props.size === 'lg',
	}));
</script>
<template>
	<div>
		<button
			:id="id"
			:type="type"
			:class="buttonClass"
			:disabled="disabled"
			@click="onClick"
		>
			{{ label }}
			<slot></slot>
		</button>
	</div>
</template>

<style scoped lang="postcss">
	.button-sm {
		padding: 0.25rem 0.5rem;
		text-align: center;
		background-color: #d99962;
		color: white;
		/* text-sm */
		font-size: 0.875rem;
		/* h-7 */
		height: 1.75rem;
		/* w-20 */
		width: 5rem;
		/* rounded */
		border-radius: 0.25rem;

		&:hover {
			background-color: #f3f4f6;
			color: #d99962;
			outline: 1px solid #d99962;
		}
	}
	.button-md {
		background-color: #d99962;
		color: white;
		&:hover {
			background-color: #f3f4f6;
			color: #d99962;
			outline: 1px solid #d99962;
		}
	}
	.button-lg {
		background-color: #d99962;
		color: white;
		&:hover {
			background-color: #f3f4f6;
			color: #d99962;
			outline: 1px solid #d99962;
		}
	}
</style>
