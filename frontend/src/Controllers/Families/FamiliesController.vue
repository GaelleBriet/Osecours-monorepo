<script setup lang="ts">
	import DataGridComponent from '@/Components/DataGridComponent.vue';
	import { useUserStore } from '@/Stores/UserStore.ts';
	import { computed, onMounted } from 'vue';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';

	const t = i18n.global.t;
	const userStore = useUserStore();
	const families = computed(() => userStore.users);

	const editItem = () => {
		console.log('edit');
	};

	onMounted(async () => {
		await userStore.getUsers();
	});
</script>

<template>
	<div>
		<DataGridComponent
			:store="userStore"
			:model-value="families"
			:title="getCapitalizedText(t('navigation.families'))"
			:description="getCapitalizedText(t('navigation.families'))"
			:columns="[
				{ label: 'Nom', key: 'name' },
				{ label: 'Nombre d\'animaux', key: 'icad' },
				{ label: 'Adresse', key: 'species', visibility: { sm: true } },
			]"
			@edit="editItem"
		/>
	</div>
</template>

<style scoped lang="postcss"></style>
