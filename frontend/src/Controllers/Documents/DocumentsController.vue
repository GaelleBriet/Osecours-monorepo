<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import ModalComponent from '@/Components/ModalComponent.vue';
	import TabsComponent from '@/Components/TabsComponent.vue';
	import { useRouter } from 'vue-router';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import { computed, onMounted, ref } from 'vue';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { Document } from '@/Interfaces/Documents/Documents.ts';
	import AnimalsDocuments from "@/Views/Animals/Documents/AnimalsDocuments.vue";
  	import LoaderComponent from '@/Components/LoaderComponent.vue';

	const t = i18n.global.t;
	const router = useRouter();
	const documentsStore = useDocumentsStore();

	const currentTab = ref(0);
	const showModal = ref(false);
	const documentToDelete = ref(null);

	const documentsTransformed = computed(() => {
		return documentsStore.documents.map((document) => ({
			...document,
		}));
	});

	const updateCurrentTab = (index) => {
		currentTab.value = index;
	};

	const editItem = (item: Document) => {
		router.push({
			name: 'EditDocument',
			params: { id: item.id },
		});
	};

	const addItem = () => {
		router.push({
			name: 'CreateDocument',
		});
	};

	const openModal = (item: Document) => {
		documentToDelete.value = item;
		showModal.value = true;
	};

	const onConfirmDelete = () => {
		documentsStore.deleteDocument(documentToDelete.value.id);
		showModal.value = false;
	};

	onMounted(async () => {
		await documentsStore.getDocumentsByShelter();
	});
</script>

<template>
	<div class="container">
		<div class="text-2xl mb-3">
			{{ getCapitalizedText(t('navigation.documents')) }}
		</div>
		<TabsComponent
			id="docsTabsComponent"
			:name="'documentsTabs'"
			:tabs="[
				{ name: getCapitalizedText(t('navigation.all')) },
				{ name: getCapitalizedText(t('navigation.animals')) },
				{ name: getCapitalizedText(t('navigation.families')) },
				{ name: getCapitalizedText(t('common.other')) },
			]"
			:activeColorClass="'bg-osecours-beige-dark bg-opacity-10 text-gray-700'"
			:secondaryColorClass="'text-gray-500 hover:text-gray-500'"
			@update:current-tab="updateCurrentTab"
		/>
		<div class="content">
			<template v-if="currentTab === 0">
                <div class="content bg-osecours-beige-dark bg-opacity-10 p-4">
                    <DataGridComponent
						v-if="!documentsStore.isLoading"
                        :store="documentsStore" 
                        :model-value="documentsTransformed"
                        :description="getCapitalizedText(t('pages.documents.title'))"
                        :columns="[
                            { label: getCapitalizedText(t('common.name')), key: 'filename' },
                            { label: getCapitalizedText(t('pages.documents.type')), key: 'mimeType' },
                            { label: getCapitalizedText(t('pages.animals.size')), key: 'size' },
                            { label: getCapitalizedText(t('pages.documents.date')), key: 'date' },
                        ]"
                        @edit="editItem"
                        @add="addItem"
						@delete="openModal"
                    />
					<ModalComponent
						v-if="showModal"
						:isOpen="showModal"
						:title="getCapitalizedText(t('pages.documents.messages.deleteDocument'))"
						:description="getCapitalizedText(t('pages.documents.messages.delete'))"
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
						v-if="documentsStore.isLoading"
					/>
                </div>
				<LoaderComponent
					class="h-full"
					v-if="documentsStore.isLoading"
				/>
            </template>
			<template v-if="currentTab === 1">
<!--				<AnimalsDocuments  />-->
			</template>
		</div>
	</div>
</template>

<style scoped lang="postcss">
	.content {
		flex-grow: 1;
		overflow-y: auto;
	}
</style>
