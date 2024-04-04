<script setup lang="ts">
	import TabsComponent from '@/Components/TabsComponent.vue';
	import { ref } from 'vue';

	const currentTab = ref(0);

	const updateCurrentTab = (index) => {
		currentTab.value = index;
	};
</script>
<template>
	<div>
		<TabsComponent
			:tabs="[{ name: 'un' }, { name: 'deux' }]"
			@update:current-tab="updateCurrentTab"
		/>
		<div v-if="currentTab === 0">premier contenu</div>
		<div v-if="currentTab === 1">second contenu</div>
	</div>
</template>
