<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import ModalComponent from '@/Components/ModalComponent.vue';
	import { Members } from '@/Interfaces/Members.ts';
	import router from '@/Router';
	import { onMounted, ref } from 'vue';
	import { useUserStore } from '@/Stores/UserStore.ts';
	import { useMembersStore } from '@/Stores/MembersStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import LoaderComponent from '@/Components/LoaderComponent.vue';

	const membersStore = useMembersStore();
	const userStore = useUserStore();

	let members = ref<Members[]>([]);
	const showModal = ref(false);
	const familyIDToDelete = ref<number | undefined | string>(undefined);

	const t = i18n.global.t;
	const currentAssociationId = userStore.user?.associationId;

	const columns = ref([
		{
			label: getCapitalizedText(t('pages.families.name')),
			key: 'fullName',
		},
		{
			label: getCapitalizedText(t('pages.families.animalsNumber')),
			key: 'animalCount',
		},
		{
			label: getCapitalizedText(t('pages.families.address')),
			key: 'email',
			visibility: { sm: true },
		},
	]);

	const editItem = (item: Members) => {
		router.push({
			name: 'EditFamilies',
			params: { id: item.id },
		});
	};

	const addItem = () => {
		router.push({
			name: 'CreateFamily',
		});
	};

	const openModal = (item: Members) => {
		familyIDToDelete.value = item.id;
		showModal.value = true;
	};

	const onConfirmDelete = async () => {
		const response = await membersStore.deleteMember(familyIDToDelete.value);
		if (response) {
			members.value = members.value.filter(
				(member) => member.id !== familyIDToDelete.value,
			);
			showModal.value = false;
		}
	};

	onMounted(async () => {
		await membersStore.getAllFamilies(currentAssociationId ?? '');
		members.value = membersStore.members;

		members.value = membersStore.members.map((member) => ({
			...member,
			fullName: `${member.first_name} ${member.last_name}`,
			animalCount:
				(member.existing_cat_count ?? 0) + (member.existing_dog_count ?? 0),
		}));
	});
</script>

<template>
	<div>
		<DataGridComponent
			v-if="!membersStore.isLoading"
			:store="membersStore"
			:model-value="members"
			:title="getCapitalizedText(t('navigation.families'))"
			:description="getCapitalizedText(t('pages.families.title'))"
			:columns="columns"
			@edit="editItem"
			@add="addItem"
			@delete="openModal"
		/>
		<ModalComponent
			:isOpen="showModal"
			:title="getCapitalizedText(t('pages.families.messages.deleteFamily'))"
			:description="getCapitalizedText(t('pages.families.messages.delete'))"
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
	</div>
	<LoaderComponent
		class="h-full"
		v-if="membersStore.isLoading"
	/>
</template>

<style scoped lang="postcss"></style>
