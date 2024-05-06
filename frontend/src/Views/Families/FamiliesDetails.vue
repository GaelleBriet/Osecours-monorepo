<script setup lang="ts">
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';
	import { onMounted, ref } from 'vue';
	import { User } from '@/Interfaces/User.ts';
	import { useMembersStore } from '@/Stores/MembersStore.ts';

	const membersStore = useMembersStore();
	const t = i18n.global.t;

	const currentFamily = ref<User | null>(null);

	onMounted(async () => {
		console.log('FamiliesDetails.vue');
		currentFamily.value = await membersStore.getMemberById('1');
		console.log(currentFamily.value);
	});
</script>

<template>
	<div class="container">
		<div class="text-2xl mb-1">
			{{ getCapitalizedText(t('pages.families.card')) }}:
			{{ currentFamily?.firstName }} {{ currentFamily?.lastName }}
		</div>
		<div>@todo: afficher le détail de la famille</div>
	</div>
</template>

<style scoped lang="postcss"></style>
