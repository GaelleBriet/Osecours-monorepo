<script lang="ts" setup>
	import { ref, defineProps, watch, computed } from 'vue';
	import {
		Dialog,
		DialogPanel,
		TransitionChild,
		TransitionRoot,
	} from '@headlessui/vue';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const t = i18n.global.t;

	const props = defineProps<{
		isOpen: boolean;
		title?: string;
		description?: string;
		center?: boolean;
		confirmButton?: boolean;
		cancelButton?: boolean;
		confirmButtonText?: string,
		cancelButtonText?: string,
		confirmButtonColor?: string,
		cancelButtonColor?: string,
		buttonOrder?: string,
		docForm?: boolean,
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
		},
	);

	const closeModal = () => {
		isOpen.value = false;
	};

	const onConfirm = () => {
		emit('confirm');
	};

	const onClose = () => {
		emit('close');
	};

	const confirmButtonClass = computed(() => {
		return props.buttonOrder === 'confirm-cancel' ? 'confirm' : 'cancel';
	});

	const cancelButtonClass = computed(() => {
		return [

			props.buttonOrder === 'confirm-cancel' ? 'cancel' : 'confirm'
		];
	});

	const buttonContainerClass = computed(() => {
		return [
			'flex',
			'gap-2',
			'mb-2',
			'justify-around',
			props.buttonOrder === 'confirm-cancel' ? 'flex-row' : 'flex-row-reverse'
		];
	});
	const dialogPanelClass = computed(() => {
		return [
			'dialog-color',
			'relative',
			'transform',
			'overflow-hidden',
			'rounded-lg',
			'px-4',
			'pb-4',
			'pt-5',
			'text-left',
			'shadow-xl',
			'transition-all',			
			props.docForm === true ? '' :  ['md:my-0', 'sm:my-8', 'sm:w-full', 'sm:max-w-sm', 'sm:p-6']
		];
	});

	const closeBtnClass = computed(() => {
		return [
			'absolute',
			'right-0',
			'top-0',
			'hidden',
			'sm:block',
			props.docForm === true ? ['pr-2', 'pt-2'] : ['pr-4', 'pt-4']
		];
	});
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

			<div class="fixed inset-0 z-30 w-screen overflow-y-auto content-center">
				<div
					:class="{
						'flex justify-center p-4 text-center sm:items-center sm:p-0': true,
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
							:class="dialogPanelClass"
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
									class="text-gray-700 py-4"
								>
									{{ description }}
								</p>
							</div>
							<slot name="beforeButtons"></slot>
							<div
								:style="{
									'--confirm-color': confirmButtonColor,
									'--cancel-color': cancelButtonColor,
									'--hover-color': 'var(--color-withe)'
								}"
								:class="buttonContainerClass"
							>
								<button
									v-if="confirmButton"
									id="save-changes"
									type="button"
									:class="[
										'button', confirmButtonClass]"
									@click="onConfirm"
								>
									{{ getCapitalizedText(t('common.confirm')) }}
								</button>
								<button
									v-if="cancelButton"
									id="cancel"
									type="button"
									:class="['button', cancelButtonClass]"
									@click="onClose"
								>
									{{ getCapitalizedText(t('common.cancel')) }}
								</button>
							</div>
							<div :class="closeBtnClass">
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
		background-color: rgb(252, 252, 252);
	}

	.button {
		border-radius: 0.375rem;
		padding: 0.25rem 0.5rem;
		text-align: center;
		font-size: 0.875rem;
		color: #fff;
		height: 2rem;
		width: 5.25rem;
	}

	.confirm {
		background-color: var(--confirm-color);
		color: #fff;
	}
	.confirm:hover {
		background-color: var(--hover-color);
		color: var(--confirm-color);
		outline: 1px solid var(--confirm-color);
	}
	.confirm:focus {
		outline: none;
	}

	.cancel {
		background-color: var(--cancel-color);
		color: #fff;
	}
	.cancel:hover {
		background-color: var(--hover-color);
		color: var(--cancel-color);
		outline: 1px solid var(--cancel-color);
	}
	.cancel:focus {
		outline: none;
	}
</style>
