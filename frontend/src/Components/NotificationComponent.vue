<script setup>
	import { CheckCircleIcon } from '@heroicons/vue/24/outline';
	import { XMarkIcon } from '@heroicons/vue/20/solid';
	import { computed } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import ButtonComponent from '@/Components/ButtonComponent.vue';

	const t = i18n.global.t;

	const props = defineProps({
		config: {
			type: Object,
			default: () => ({
				show: false,
				title: '',
				message: '',
				type: 'info',
			}),
		},
	});

	const emit = defineEmits(['close']);

	const hideNotification = () => {
		emit('close');
	};

	const textClass = computed(() => {
		switch (props.config.type) {
			case 'success':
				return 'text-green-400';
			case 'error':
				return 'text-red-400';
			case 'warning':
				return 'text-yellow-400';
			default:
				return 'text-gray-400';
		}
	});

	const iconClass = computed(() => {
		switch (props.config.type) {
			case 'success':
				return 'text-green-400 icon-check';
			case 'error':
				return 'text-red-400 icon-triangle-exclamation-solid';
			case 'warning':
				return 'text-yellow-400 icon-triangle-exclamation-solid';
			default:
				return 'text-gray-400 icon-info-1';
		}
	});
</script>
<template>
	<div
		v-if="props.config.show"
		aria-live="assertive"
		class="notification pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6"
	>
		<div class="flex w-full flex-col items-center space-y-4 sm:items-end">
			<transition
				enter-active-class="transform ease-out duration-300 transition"
				enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
				enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
				leave-active-class="transition ease-in duration-100"
				leave-from-class="opacity-100"
				leave-to-class="opacity-0"
			>
				<div
					v-if="props.config.show"
					class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5"
				>
					<div class="p-4">
						<div class="flex items-start">
							<div class="flex-shrink-0">
								<span :class="iconClass"></span>
							</div>
							<div class="ml-3 w-0 flex-1 pt-0.5">
								<p
									class="text-sm font-medium"
									:class="textClass"
								>
									{{ props.config.title }}
								</p>
								<p class="mt-1 text-sm text-gray-500">
									{{ props.config.message }}
								</p>
							</div>
							<div class="ml-4 flex flex-shrink-0">
								<ButtonComponent
									id="close-notification"
									size="xs"
									type="button"
									@click="hideNotification"
									><span class="icon-cancel"></span
								></ButtonComponent>
							</div>
						</div>
					</div>
				</div>
			</transition>
		</div>
	</div>
</template>
<style scoped lang="postcss">
	@tailwind base;
	@tailwind components;
	@tailwind utilities;
	.notification {
		z-index: 9999 !important;
	}
</style>
