<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import ModalComponent from '@/Components/ModalComponent.vue';
	import { Members } from '@/Interfaces/Members.ts';
	import { Role } from '@/Enums/Role.ts';
	import { Scopes } from '@/Enums/Scopes.ts';
	import router from '@/Router';
	import i18n from '@/Services/Translations';
	import { onMounted, ref } from 'vue';
	import { useUserStore } from '@/Stores/UserStore.ts';
	import { useMembersStore } from '@/Stores/MembersStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { hasScope } from '@/Services/Helpers/ScopeCheck.ts';
	import LoaderComponent from '@/Components/LoaderComponent.vue';

	const membersStore = useMembersStore();
	const userStore = useUserStore();
	const currentUser = userStore.user;

	let members = ref<Members[]>([]);
	const showModal = ref(false);
	const memberIDToDelete = ref<number | undefined | string>(undefined);

	const t = i18n.global.t;
	const currentAssociationId = userStore.user?.associationId;

	const columns = ref([
		{
			label: getCapitalizedText(t('pages.members.name')),
			key: 'fullName',
		},
		{
			label: getCapitalizedText(t('pages.members.role')),
			key: 'role',
			visibility: { sm: true },
		},
		{
			label: getCapitalizedText(t('pages.members.email')),
			key: 'email',
			truncate: true,
		},
	]);

	const editItem = (item: Members) => {
		router.push({
			name: 'EditMembers',
			params: { id: item.id },
		});
	};

	const addItem = () => {
		if (!hasScope(currentUser?.scopes, Scopes.GLOBAL_ACCESS)) {
			return;
		} else {
			router.push({
				name: 'AddMembers',
			});
		}
	};

	const openModal = (item: Members) => {
		memberIDToDelete.value = item.id;
		showModal.value = true;
	};

	const onConfirmDelete = async () => {
		const response = await membersStore.deleteMember(memberIDToDelete.value);
		if (response) {
			members.value = members.value.filter(
				(member) => member.id !== memberIDToDelete.value,
			);
			showModal.value = false;
		}
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
			:title="getCapitalizedText(t('navigation.members'))"
			:description="getCapitalizedText(t('pages.users.title'))"
			:columns="columns"
			:disable-add-btn="false"
			:disable-edit-icon="true"
			@edit="editItem"
			@delete="openModal"
			@add="addItem"
		/>
		<ModalComponent
			:isOpen="showModal"
			:title="getCapitalizedText(t('pages.users.messages.deleteMember'))"
			:description="getCapitalizedText(t('pages.users.messages.delete'))"
			:center="true"
			:confirmButton="true"
			:cancelButton="true"
			@close="showModal = false"
			@confirm="onConfirmDelete"
		>
		</ModalComponent>
		<LoaderComponent
			class="mt-5"
			v-if="membersStore.isLoading"
		/>
	</div>
</template>

<style scoped lang="postcss"></style>
