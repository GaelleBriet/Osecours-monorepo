<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { onMounted, ref } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import { useMembersStore } from '@/Stores/MembersStore.ts';
	import { User } from '@/Interfaces/User.ts';
	import router from '@/Router';
	import { useUserStore } from '@/Stores/UserStore.ts';
	import { Members } from '@/Interfaces/Members.ts';

	const t = i18n.global.t;
	const membersStore = useMembersStore();
	const userStore = useUserStore();
	let members = ref<Members[]>([]);
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

	const editItem = (item: User) => {
		router.push({
			name: 'EditFamilies',
			params: { id: item.id },
		});
	};

	onMounted(async () => {
		await membersStore.getAllFamilies(currentAssociationId ?? '');
		members.value = membersStore.members;

		members.value = membersStore.members.map((member) => ({
			...member,
			fullName: `${member.first_name} ${member.last_name}`,
			animalCount:
				(member.existingCatCount ?? 0) + (member.existingDogCount ?? 0),
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
		/>
	</div>
</template>

<style scoped lang="postcss"></style>
