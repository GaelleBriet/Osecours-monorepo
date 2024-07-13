<script lang="ts" setup>
	import { ref, defineProps, watch } from 'vue';
	import {
		Dialog,
		DialogPanel,
		TransitionChild,
		TransitionRoot,
	} from '@headlessui/vue';
	import ButtonComponent from '@/Components/ButtonComponent.vue';

	const props = defineProps<{
		isOpen: boolean;
		title?: string;
		description?: string;
		center?: boolean;
		confirmButton?: boolean;
		cancelButton?: boolean;
	}>();

	const emit = defineEmits<{
		(event: 'close'): void;
		(event: 'confirm'): void;
	}>();

	const isOpen = ref(props.isOpen);

	watch(
		() => props.isOpen,
		(newValue) => {
			isOpen.value = newValue;
			console.log('isOpen', isOpen.value);
		},
	);

	const closeModal = () => {
		isOpen.value = false;
		emit('close');
	};

	const onConfirm = () => {
		emit('confirm');
	};

	const onCancel = () => {
		isOpen.value = false;
		emit('close');
	};

	const onClose = () => {
		isOpen.value = false;
		emit('close');
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
					:class="{
						'flex min-h-full justify-center p-4 text-center sm:items-center sm:p-0': true,
						'lg:items-center': props.center,
						'lg:items-end': !props.center,
					}"
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
							<div>
								<p
									v-if="title"
									class="text-osecours-beige-dark font-bold"
								>
									{{ title }}
								</p>
								<p
									v-if="description"
									class="text-gray-700"
								>
									{{ description }}
								</p>
							</div>
							<slot name="beforeButtons"></slot>
							<div class="flex flex-row gap-2 mt-5 mb-2 justify-around">
								<ButtonComponent
									v-if="confirmButton"
									id="save-changes"
									size="sm"
									label="Confimer"
									@click="onConfirm"
								/>
								<ButtonComponent
									v-if="cancelButton"
									id="cancel"
									size="sm"
									label="Annuler"
									@click="onCancel"
								/>
							</div>
							<div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
								<ButtonComponent
									type="button"
									@click="onClose"
									size="xs"
									><span class="icon-cancel"></span>
								</ButtonComponent>
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

	#save-changes {
		background-color: rgba(242, 138, 128);
		color: #fff;
		&:hover {
			background-color: var(--color-withe);
			color: #f28a80;
			outline: 1px solid #f28a80;
		}
		&:focus {
			outline: none;
		}
	}

	#cancel {
		background-color: #d99962;
		color: #fff;
		&:hover {
			background-color: var(--color-withe);
			color: #d99962;
			outline: 1px solid #d99962;
		}
		&:focus {
			outline: none;
		}
	}
</style>
