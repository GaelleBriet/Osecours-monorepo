<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { onMounted, ref } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import { useMembersStore } from '@/Stores/MembersStore.ts';
	import { User } from '@/Interfaces/User.ts';
	import router from '@/Router';

	const t = i18n.global.t;
	const membersStore = useMembersStore();
	let members = ref<User[]>([]);

	const columns = ref([
		{
			label: 'Nom',
			key: 'fullName',
		},
		{
			label: "Nombre d'animaux",
			key: 'animalCount',
		},
		{
			label: 'Adresse',
			key: 'email',
			visibility: { sm: true },
		},
	]);

	const editItem = (item) => {
		router.push({
			name: 'EditFamilies',
			params: { id: item.id },
		});
	};

	onMounted(async () => {
		await membersStore.getAllFamilies();
		members.value = membersStore.members;
		members.value = membersStore.members.map((member) => ({
			...member,
			fullName: `${member.firstName} ${member.lastName}`,
			animalCount: member.existingCatCount + member.existingDogCount,
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
