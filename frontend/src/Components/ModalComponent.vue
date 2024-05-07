<script lang="ts" setup>
	import { ref, defineProps, watch } from 'vue';
	import {
		Dialog,
		DialogPanel,
		TransitionChild,
		TransitionRoot,
	} from '@headlessui/vue';

	const props = defineProps({
		isOpen: Boolean,
	});

	const isOpen = ref(props.isOpen);

	watch(
		() => props.isOpen,
		(newValue) => {
			isOpen.value = newValue;
		},
	);

	const closeModal = () => {
		isOpen.value = false;
	};
</script>

<template>
	<TransitionRoot
		as="template"
		:show="isOpen"
	>
		<Dialog
			as="div"
			class="relative z-30"
			@close="closeModal"
		>
			<TransitionChild
				as="template"
				enter="ease-out duration-300"
				enter-from="opacity-0"
				enter-to="opacity-100"
				leave="ease-in duration-200"
				leave-from="opacity-100"
				leave-to="opacity-0"
			>
				<div
					class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
					@click="closeModal"
				/>
			</TransitionChild>

			<div class="fixed inset-0 z-30 w-screen overflow-y-auto">
				<div
					class="flex min-h-full lg:items-end justify-center p-4 text-center sm:items-center sm:p-0"
				>
					<TransitionChild
						as="template"
						enter="ease-out duration-300"
						enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
						enter-to="opacity-100 translate-y-0 sm:scale-100"
						leave="ease-in duration-200"
						leave-from="opacity-100 translate-y-0 sm:scale-100"
						leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
					>
						<DialogPanel
							class="dialog-color relative transform overflow-hidden rounded-lg px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6"
						>
							<div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
								<button
									type="button"
									class="rounded-md dialog-color text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
									@click="closeModal"
								>
									<span class="sr-only">Close</span>
									&times;
								</button>
							</div>
							<slot></slot>
						</DialogPanel>
					</TransitionChild>
				</div>
			</div>
		</Dialog>
	</TransitionRoot>
</template>
<style scoped lang="postcss">
	.dialog-color {
		background-color: rgb(254, 241, 228);
	}
</style>
