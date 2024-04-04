<script setup lang="ts">
	import TabsComponent from '@/Components/TabsComponent.vue';
	import GeneralInformations from '@/Views/Animals/GeneralInformations.vue';

	import { nextTick, onMounted, ref } from 'vue';
	import { useRoute } from 'vue-router';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import i18n from '@/Services/Translations';

	const t = i18n.global.t;
	const route = useRoute();
	const animalsStore = useAnimalsStore();
	const animalId = route.params.id;

	const currentTab = ref(0);

	const updateCurrentTab = (index) => {
		currentTab.value = index;
	};

	onMounted(async () => {
		// Logique pour récupérer les données de l'animal à afficher
		await animalsStore.getAnimal(animalId);
	});
</script>

<template>
	<div class="h-full">
		<TabsComponent
			id="animalsTabsComponent"
			:tabs="[
				{ name: 'caractéristiques' },
				{ name: 'documents' },
				{ name: 'santé' },
				{ name: 'famille' },
			]"
			@update:current-tab="updateCurrentTab"
		/>
		<template v-if="currentTab === 0">
			<GeneralInformations />
		</template>
		<template v-if="currentTab === 1"></template>
	</div>
</template>
<style scoped lang="postcss"></style>
