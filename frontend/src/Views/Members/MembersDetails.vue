<script setup lang="ts">
	import MembersForm from '@/Views/Members/MembersForm.vue';
	import { Members } from '@/Interfaces/Members.ts';
	import { onMounted, ref } from 'vue';
	import { useMembersStore } from '@/Stores/MembersStore.ts';
	import { useUserStore } from '@/Stores/UserStore.ts';
	import { useRouter } from 'vue-router';
	import i18n from '@/Services/Translations';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const router = useRouter();
	const membersStore = useMembersStore();
	const userStore = useUserStore();
	const t = i18n.global.t;
	const route = router.currentRoute;
	const currentId = route.value.params.id;
	const currentFamily = ref<Members | null>(null);
	const currentMemberRole = ref<number | undefined>(undefined);
	const currentAssociation = userStore.getCurrentUser;

	onMounted(async () => {
		currentFamily.value = await membersStore.getMemberById(currentId);
		currentMemberRole.value = await membersStore.getMemberRole(
			currentFamily.value?.id as number,
			Number(currentAssociation?.associationId),
		);
	});
</script>

<template>
	<div class="container">
		<div class="flex flex-row justify-between">
			<div class="text-2xl mb-1">
				{{ getCapitalizedText(t('pages.members.card')) }}:
				{{ currentFamily?.first_name }} {{ currentFamily?.last_name }}
			</div>
			<button
				id="back-btn"
				class="me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors duration-200 ease-in-out"
				@click="$router.go(-1)"
			>
				{{ getCapitalizedText(t('common.back')) }}
			</button>
		</div>
		<div class="content">
			<template v-if="currentFamily && currentMemberRole">
				<MembersForm
					:family="currentFamily"
					:role="currentMemberRole"
					:is-create-mode="false"
				/>
			</template>
		</div>
	</div>
</template>

<style scoped lang="postcss">
	.container {
		display: flex;
		flex-direction: column;
		height: 100%;
		padding: 0;
	}

	.content {
		flex-grow: 1;
		overflow-y: auto;
	}

	#back-btn {
		background-color: #d99962;
		color: #fff;
		&:hover {
			background-color: var(--color-withe);
			color: #d99962;
			outline: 1px solid #d99962;
		}
	}
</style>
