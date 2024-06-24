<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import ModalComponent from '@/Components/ModalComponent.vue';
	import { ref, computed, onMounted } from 'vue';
	import { useRouter } from 'vue-router';
	import { useSheltersStore } from '@/Stores/SheltersStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import { Shelter } from '@/Interfaces/Shelter.ts';
	import LoaderComponent from '@/Components/LoaderComponent.vue';
	
	const showModal = ref(false);
	const shelterToDelete = ref(null);

	const t = i18n.global.t;
	const router = useRouter();
	const sheltersStore = useSheltersStore();

	console.log(sheltersStore.isLoading)

	const sheltersTransformed = computed(() => {
		return sheltersStore.shelters.map((shelter) => ({
			...shelter,
		}));
	});

	const editItem = (item: Shelter) => {
		router.push({
			name: 'EditShelter',
			params: { id: item.id },
		});
	};

	const addItem = () => {
		router.push({
			name: 'CreateShelters',
		});
	};

	const openModal = (item: Shelter) => {
		shelterToDelete.value = item;
		showModal.value = true;
	};

	const onConfirmDelete = () => {
		sheltersStore.deleteShelter(shelterToDelete.value.id);
		showModal.value = false;
	};
	
	onMounted(async () => {
		await sheltersStore.getShelters();
	});
</script>

<template>
	<div class="w-full p-0">
		<DataGridComponent
			:store="sheltersStore"
			:model-value="sheltersTransformed"
			:title="getCapitalizedText(t('navigation.shelters'))"
			:description="getCapitalizedText(t('pages.shelters.title'))"
			:columns="[
				{ label: getCapitalizedText(t('common.name')), key: 'name' },
				{
					label: getCapitalizedText(t('pages.shelters.quantity')),
					key: 'animals',
				},
				{ label: getCapitalizedText(t('pages.shelters.phone')), key: 'phone' },
			]"
			@edit="editItem"
			@add="addItem"
			@delete="openModal"
		/>
		<ModalComponent
			v-if="showModal"
			:isOpen="showModal"
			:title="getCapitalizedText(t('pages.shelters.messages.deleteShelter'))"
			:description="getCapitalizedText(t('pages.shelters.messages.delete'))"
			:center="true"
			:confirmButton="true"
			:cancelButton="true"
			:confirmButtonText="getCapitalizedText(t('common.confirm'))"
			:cancelButtonText="getCapitalizedText(t('common.cancel'))"
			confirmButtonColor="rgb(151,166,166)"
			cancelButtonColor="rgb(242,138,128)"
			buttonOrder="confirm-cancel"
			@close="showModal = false"
			@confirm="onConfirmDelete"
		>
		</ModalComponent>
		<LoaderComponent
			class="mt-5"
			v-if="sheltersStore.isLoading"
		/>
	</div>
</template>

<style scoped></style>
