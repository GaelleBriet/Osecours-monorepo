<script setup lang="ts">
	import TabsComponent from '@/Components/TabsComponent.vue';
	import GeneralInformations from '@/Views/Animals/Details/GeneralInformations.vue';
	import AnimalsDocuments from '@/Views/Animals/Documents/AnimalsDocuments.vue';
	import AnimalsPhotos from '@/Views/Animals/Documents/AnimalsPhotos.vue';
	import HealthInformations from '@/Views/Animals/Details/HealthInformations.vue';
	import AnimalsBehaviour from '@/Views/Animals/Details/BehaviouralInformations.vue';
	import { Animal } from '@/Interfaces/Animals/Animal.ts';
	import i18n from '@/Services/Translations';
	import { onMounted, ref } from 'vue';
	import { useRoute } from 'vue-router';
	import { useAnimalsStore } from '@/Stores/AnimalsStore.ts';
	import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';

	const route = useRoute();
	const animalsStore = useAnimalsStore();

	const t = i18n.global.t;
	const animalId = route.params.id;

	const currentTab = ref(0);
	const currentAnimal = ref<Animal | null>(null);

	const updateCurrentTab = (index) => {
		currentTab.value = index;
	};

	onMounted(async () => {
		// Logique pour récupérer les données de l'animal à afficher
		currentAnimal.value = await animalsStore.getAnimal(animalId);
	});
</script>

<template>
	<div class="container">
		<div class="flex flex-row justify-between">
			<div class="text-2xl mb-1">
				{{ getCapitalizedText(t('pages.animals.card')) }}:
				{{ currentAnimal?.name }}
			</div>
			<button
				id="back-btn"
				class="me-1.5 px-4 py-2 text-white lg:text-sm rounded transition-colors duration-200 ease-in-out"
				@click="$router.go(-1)"
			>
				{{ getCapitalizedText(t('common.back')) }}
			</button>
		</div>
		<TabsComponent
			id="animalsTabsComponent"
			:tabs="[
				{ name: getCapitalizedText(t('pages.animals.details')) },
				{ name: getCapitalizedText(t('pages.animals.behaviour')) },
				{ name: getCapitalizedText(t('pages.animals.health')) },
				{ name: getCapitalizedText(t('pages.animals.docs')) },
				{ name: getCapitalizedText(t('pages.documents.photos')) },
			]"
			:activeColorClass="'bg-osecours-beige-dark bg-opacity-10 text-gray-700'"
			:secondaryColorClass="'text-gray-500 hover:text-gray-500'"
			@update:current-tab="updateCurrentTab"
		/>
		<div class="content">
			<template v-if="currentTab === 0 && currentAnimal">
				<GeneralInformations :animal="currentAnimal" />
			</template>
			<template v-if="currentTab === 1 && currentAnimal">
				<AnimalsBehaviour :animal="currentAnimal" />
			</template>
			<template v-if="currentTab === 2 && currentAnimal">
				<HealthInformations :animal="currentAnimal" />
			</template>
			<template v-if="currentTab === 3 && currentAnimal">
				<AnimalsDocuments :animal="currentAnimal" />
			</template>
			<template v-if="currentTab === 4 && currentAnimal">
				<AnimalsPhotos :animal="currentAnimal" />
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
