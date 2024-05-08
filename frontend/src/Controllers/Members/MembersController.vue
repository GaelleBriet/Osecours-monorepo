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
	import { Role } from '@/Enums/Role.ts';

	const membersStore = useMembersStore();
	const userStore = useUserStore();

	let members = ref<Members[]>([]);
	const showModal = ref(false);
	// const familyIDToDelete = ref<number | undefined | string>(undefined);

	const t = i18n.global.t;
	const currentAssociationId = userStore.user?.associationId;

	const columns = ref([
		{
			label: getCapitalizedText(t('pages.families.name')),
			key: 'fullName',
		},
		{
			label: getCapitalizedText(t('pages.families.role')),
			key: 'role',
		},
		{
			label: getCapitalizedText(t('pages.families.email')),
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

	const openModal = (item: Members) => {
		// familyIDToDelete.value = item.id;
		showModal.value = true;
	};

	const onConfirmDelete = async () => {
		// const response = await membersStore.deleteMember(familyIDToDelete.value);
		// if (response) {
		// 	members.value = members.value.filter(
		// 		(member) => member.id !== familyIDToDelete.value,
		// 	);
		// 	showModal.value = false;
		// }
	};

	const getRoleName = (roleId: number | string | undefined) => {
		switch (roleId) {
			case Role.ADMIN:
				return getCapitalizedText(t('enums.role.admin'));
			case Role.USER:
				return getCapitalizedText(t('enums.role.user'));
			case Role.ACCOUNTANT:
				return getCapitalizedText(t('enums.role.accountant'));
			case Role.PRESIDENT:
				return getCapitalizedText(t('enums.role.president'));
			case Role.ADOPTER:
				return getCapitalizedText(t('enums.role.adopter'));
			case Role.OTHER:
				return getCapitalizedText(t('enums.role.other'));
			case Role.FOSTER:
				return getCapitalizedText(t('enums.role.foster'));
			default:
				return '';
		}
	};

	onMounted(async () => {
		await membersStore.getMembers(currentAssociationId ?? '');
		members.value = membersStore.members;
		console.log(members.value);
		members.value = membersStore.members.map((member) => ({
			...member,
			fullName: `${member.first_name} ${member.last_name}`,
			animalCount:
				(member.existing_cat_count ?? 0) + (member.existing_dog_count ?? 0),
			role: getRoleName(member.pivot?.role_id),
		}));
	});
</script>

<template>
	<div>
		<DataGridComponent
			:store="membersStore"
			:model-value="members"
			:title="getCapitalizedText(t('navigation.families'))"
			:description="getCapitalizedText(t('pages.families.title'))"
			:columns="columns"
			@edit="editItem"
			@delete="openModal"
		/>
		<ModalComponent
			:isOpen="showModal"
			:title="getCapitalizedText(t('pages.families.messages.deleteFamily'))"
			:description="getCapitalizedText(t('pages.families.messages.delete'))"
			:center="true"
			:confirmButton="true"
			:cancelButton="true"
			@close="showModal = false"
			@confirm="onConfirmDelete"
		>
		</ModalComponent>
	</div>
</template>

<style scoped lang="postcss"></style>
