<script setup lang="ts">
	import ChartsBarComponent from '@/Components/ChartsBarComponent.vue';
	import QuantityCardsComponent from '@/Components/QuantityCardsComponent.vue';
	import i18n from '@/Services/Translations/index.ts';
	import { useUserStore } from '@/Stores/UserStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { onMounted, ref } from 'vue';
	import { useSheltersStore } from '@/Stores/SheltersStore.ts';
	import { useMembersStore } from '@/Stores/MembersStore.ts';

	const t = i18n.global.t;
	const userStore = useUserStore();
	const animalStore = useAnimalsStore();
	const shelterStore = useSheltersStore();
	const membersStore = useMembersStore();

	const associationName = userStore.user?.associationName as string;
	const currentAssociationId = userStore.user?.associationId;
	const animalsQuantity = ref(0);
	const catsQuantity = ref(0);
	const dogsQuantity = ref(0);
	const sheltersQuantity = ref(0);
	const membersQuantity = ref(0);
	const fosterQuantity = ref(0);
	const adoptQuantity = ref(0);

	onMounted(async () => {
		await animalStore.getAnimals();
		animalsQuantity.value = animalStore.animalsQuantity;

		await animalStore.getCats();
		catsQuantity.value = animalStore.catsQuantity;

		await animalStore.getDogs();
		dogsQuantity.value = animalStore.dogsQuantity;

		await shelterStore.getShelters();
		sheltersQuantity.value = shelterStore.sheltersQuantity;

		await membersStore.getMembers();
		membersQuantity.value = membersStore.membersQuantity;

		await membersStore.getMembersByFamilyType(
			'foster',
			currentAssociationId ?? '',
		);
		fosterQuantity.value = membersStore.fosterFamiliesQuantity;

		await membersStore.getMembersByFamilyType(
			'adopt',
			currentAssociationId ?? '',
		);
		adoptQuantity.value = membersStore.adoptFamiliesQuantity;
	});
</script>
<template>
	<div class="flex flex-col w-full p-0 h-full">
		<h1 class="text-center mt-6 mb-12">
			{{ getCapitalizedText(associationName) }}
		</h1>

		<div class="flex flex-col flex-grow items-center justify-between">
			<div class="flex flex-col md:flex-row">
				<div class="mr-5 mb-5">
					<ChartsBarComponent
						:data="[catsQuantity, dogsQuantity]"
						:labels="[
							getCapitalizedText(t('navigation.cats')),
							getCapitalizedText(t('navigation.dogs')),
						]"
						:title="getCapitalizedText(t('pages.home.animalsNumber'))"
					/>
				</div>
				<div class="mb-5">
					<ChartsBarComponent
						:data="[fosterQuantity, adoptQuantity]"
						:labels="[
							getCapitalizedText(t('pages.home.fosterFamily')),
							getCapitalizedText(t('pages.home.adoptFamily')),
						]"
						:title="getCapitalizedText(t('pages.home.familiesNumber'))"
					/>
				</div>
			</div>
			<div class="flex flex-col md:flex-row">
				<div class="mb-2">
					<QuantityCardsComponent
						:title="getCapitalizedText(t('pages.home.sheltersNumber'))"
						:quantity="sheltersQuantity + ' ' + t('pages.home.shelters')"
						class="md:mr-2"
					/>
				</div>
				<div class="">
					<QuantityCardsComponent
						:title="getCapitalizedText(t('pages.home.membersNumber'))"
						:quantity="membersQuantity + ' ' + t('pages.home.members')"
					/>
				</div>
			</div>
		</div>
	</div>
</template>
<style lang="css" scoped></style>
