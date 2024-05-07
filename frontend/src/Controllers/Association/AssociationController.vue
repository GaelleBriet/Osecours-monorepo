<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import GeneralInformation from '@/Views/Association/GeneralInformation.vue';
	import { Association } from '@/Interfaces/Associations.ts';
	import { AssociationsRequestStatus } from '@/Enums/Associations.ts';
	import { computed, onMounted, ref } from 'vue';
	import { useRouter } from 'vue-router';
	import { useAssociationsStore } from '@/Stores/AssociationsStore.ts';
	import { useUserStore } from '@/Stores/UserStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { generateOptionsFromEnum } from '@/Services/Helpers/Enums.ts';
	import i18n from '@/Services/Translations';

	const userStore = useUserStore();
	const currentTab = ref(0);
	const currentAssociation = ref<Association | null>(null);
	const t = i18n.global.t;
	const router = useRouter();
	const associationsStore = useAssociationsStore();

	const associationsTransformed = computed(() => {
		return associationsStore.associations.map((association) => ({
			...association,
			status:
				generateOptionsFromEnum(
					AssociationsRequestStatus,
					'enums.associationStatus',
				)[association.request_status - 1]?.label || association.request_status,
		}));
	});

	const editItem = (item: Association) => {
		router.push({
			name: 'EditAssociation',
			params: { id: item.id },
		});
	};

	const addItem = () => {
		router.push({
			name: 'CreateAssociation',
		});
	};

	onMounted(async () => {
		currentAssociation.value = await associationsStore.getAssociation(
			userStore.user?.associations[0]?.id,
		);
		await associationsStore.getAssociations();
	});
</script>

<template>
	<div class="">
		<template v-if="userStore.user?.scopes !== 'global_access_scope'">
			<div class="grid grid-cols-3 grid-rows-1 gap-4">
				{{ getCapitalizedText(t('pages.associations.card')) }}:
				{{ currentAssociation?.name }}

				<div class="col-start-3 text-center lg:text-right">
					<span v-if="currentAssociation">
						<span
							class="inline-block rounded-full px-3 py-1 text-sm font-semibold leading-tight"
							:class="{
								'bg-gray-200 text-gray-800':
									currentAssociation.request_status === 1, // pending
								'bg-blue-200 text-blue-800':
									currentAssociation.request_status === 2, // in_progress
								'bg-red-200 text-red-800':
									currentAssociation.request_status === 3, // cancelled
								'bg-yellow-200 text-yellow-800':
									currentAssociation.request_status === 4, // on_hold
								'bg-green-200 text-green-800':
									currentAssociation.request_status === 5, // completed
								'bg-purple-200 text-purple-800':
									currentAssociation.request_status === 6, // archived
								'bg-orange-200 text-orange-800':
									currentAssociation.request_status === 7, // draft
								'bg-indigo-200 text-indigo-800':
									currentAssociation.request_status === 8, // accepted
								'bg-pink-200 text-pink-800':
									currentAssociation.request_status === 9, // rejected
							}"
						>
							{{ getCapitalizedText(t('pages.animals.status')) }}:
							{{
								generateOptionsFromEnum(
									AssociationsRequestStatus,
									'enums.associationStatus',
								)[currentAssociation.request_status - 1]?.label
							}}
						</span>
					</span>
				</div>
			</div>
		</template>
		<template v-else> </template>

		<div class="content">
			<template v-if="currentTab === 0 && currentAssociation">
				<template v-if="userStore.user?.scopes === 'global_access_scope'">
					<DataGridComponent
						:store="associationsStore"
						:model-value="associationsTransformed"
						:title="getCapitalizedText(t('navigation.all-associations'))"
						:description="
							getCapitalizedText(t('pages.associations.associations'))
						"
						:columns="[
							{ label: getCapitalizedText(t('common.name')), key: 'name' },
							{
								label: getCapitalizedText(t('pages.associations.siret')),
								key: 'siret',
							},
							{
								label: getCapitalizedText(t('pages.animals.status')),
								key: 'status',
							},
						]"
						@edit="editItem"
						@add="addItem"
					/>
				</template>
				<template v-else>
					<GeneralInformation :association="currentAssociation" />
				</template>
			</template>
			<template v-if="currentTab === 1 && currentAssociation"> </template>
		</div>
	</div>
</template>

<style scoped></style>
