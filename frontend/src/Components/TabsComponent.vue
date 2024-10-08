<script setup lang="ts">
	import { onMounted, ref } from 'vue';
	import {
		getFromStorage,
		setToStorage,
	} from '@/Services/Helpers/LocalStorage.ts';

	const props = defineProps<{
		name: string;
		tabs: Array<{ name: string }>;
		activeColorClass?: string;
		secondaryColorClass?: string;
	}>();

	const emit = defineEmits<{
		(event: 'update:currentTab', index: number): void;
	}>();

	const currentTab = ref(0);
	const activeTabClass = ref(props.activeColorClass || '');

	const selectTabs = (index: number) => {
		currentTab.value = index;
		setToStorage(props.name, index);
		emit('update:currentTab', index);
	};

	onMounted(() => {
		if (getFromStorage('currentTab')) {
			currentTab.value = Number(getFromStorage(props.name));
		}
		emit('update:currentTab', currentTab.value);
	});
</script>
<template>
	<div>
		<!--		affiche un select sur ecran mobile    -->
		<div class="sm:hidden">
			<label
				for="tabs"
				class="sr-only"
				>Select a tab</label
			>
			<select
				id="tabs"
				v-model="currentTab"
				name="tabs"
				class="block w-full rounded-md border-gray-300 mb-2"
				@change="emit('update:currentTab', currentTab)"
			>
				<template
					v-for="(tab, index) in tabs"
					:key="tab.name"
				>
					<option
						v-if="tab"
						:value="index"
					>
						{{ tab.name }}
					</option>
				</template>
			</select>
		</div>
		<!--		affiche les tabs sur grand écran   -->
		<div class="hidden sm:block">
			<nav
				class="flex relative space-x-4 z-20"
				aria-label="Tabs"
			>
				<template
					v-for="(tab, index) in tabs"
					:key="tab.name"
				>
					<a
						v-if="tab"
						:class="[
							index === currentTab ? activeTabClass : secondaryColorClass,
							'rounded-t-md px-3 py-2 text-sm font-medium cursor-pointer',
						]"
						:aria-current="index === currentTab ? 'page' : undefined"
						@click.prevent="selectTabs(index)"
					>
						{{ tab.name }}
					</a>
				</template>
			</nav>
		</div>
	</div>
</template>
