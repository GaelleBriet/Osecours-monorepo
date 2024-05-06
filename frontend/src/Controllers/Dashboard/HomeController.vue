<script setup lang="ts">
	import i18n from '@/Services/Translations/index.ts';
	import { useUserStore } from '@/Stores/UserStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { onMounted, ref } from 'vue';
	import { useSheltersStore } from '@/Stores/SheltersStore.ts';
	import { useMembersStore } from '@/Stores/MembersStore.ts';
	import { formatDate } from '@/Services/Helpers/Date.ts';
	import QuantityCardsComponent from '@/Components/QuantityCardsComponent.vue';

	const t = i18n.global.t;
	const userStore = useUserStore();
	const animalStore = useAnimalsStore();
	const shelterStore = useSheltersStore();
	const membersStore = useMembersStore();

	const associationName = userStore.user?.associationName as string;
	const animalsQuantity = ref(0);
	const sheltersQuantity = ref(0);
	const membersQuantity = ref(0);

	onMounted(async () => {
		await animalStore.getAnimals();
		animalsQuantity.value = animalStore.animalsQuantity;

		await shelterStore.getShelters();
		sheltersQuantity.value = shelterStore.sheltersQuantity;

		await membersStore.getMembers();
		membersQuantity.value = membersStore.membersQuantity;
	});
</script>
<template>
	<div class="flex flex-col">
		<h1 class="text-center mt-6 mb-12">
			{{ getCapitalizedText(associationName) }}
		</h1>

		<div class="h-full lg:h-full grid grid-cols-3 grid-rows-none gap-1">
			<div class="flex justify-center">
				<QuantityCardsComponent
					:title="
						getCapitalizedText(
							'animaux sous la responsabilité de l\'association',
						)
					"
					:quantity="animalsQuantity + ' ' + 'animaux'"
					class="mr-4"
				/>
			</div>
			<div class="flex justify-center">
				<QuantityCardsComponent
					:title="getCapitalizedText('nombre de refuges')"
					:quantity="sheltersQuantity + ' ' + 'refuges'"
					class="mr-4"
				/>
			</div>
			<div class="flex justify-center">
				<QuantityCardsComponent
					:title="getCapitalizedText('nombre de membres')"
					:quantity="membersQuantity + ' ' + 'membres'"
					class="mr-4"
				/>
			</div>
		</div>
		<img
			src="../../Assets/Images/dashboard.jpg"
			alt="dashboard"
			class="h-auto object-cover pt-8"
		/>
	</div>
</template>
<style lang="css" scoped></style>
