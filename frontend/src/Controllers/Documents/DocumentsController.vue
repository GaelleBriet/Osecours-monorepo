<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { useDocumentsStore } from '@/Stores/DocumentsStore.ts';
	import { computed, onMounted, ref } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import { useRouter } from 'vue-router';
	import TabsComponent from '@/Components/TabsComponent.vue';

	const t = i18n.global.t;
	const router = useRouter();
	const documentsStore = useDocumentsStore();
	//const documents = computed(() => documentsStore.documents);

	const documentsTransformed = computed(() => {
		return documentsStore.documents.map((document) => ({
			...document,
		}));
	});
	//console.log(documentsTransformed)
	const currentTab = ref(0);
	const updateCurrentTab = (index) => {
		currentTab.value = index;
	};

	const editItem = (item) => {
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

	// const deleteItem = (item) => {
	// 	documentsStore.deleteDocument(item.id);
	// };

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
						:store="documentsStore"
						:model-value="documentsTransformed"
						:description="getCapitalizedText(t('pages.documents.title'))"
						:columns="[
							{ label: getCapitalizedText(t('common.name')), key: 'filename' },
							{
								label: getCapitalizedText(t('pages.documents.type')),
								key: 'mimeType',
							},
							{
								label: getCapitalizedText(t('pages.animals.size')),
								key: 'size',
							},
							{
								label: getCapitalizedText(t('pages.documents.date')),
								key: 'date',
							},
						]"
						@edit="editItem"
						@add="addItem"
					/>
				</div>
			</template>
			<template v-if="currentTab === 1">
				<AnimalDocuments :animal="currentAnimal" />
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
