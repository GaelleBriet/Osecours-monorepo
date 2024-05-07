<script setup lang="ts">
	import { onMounted, ref } from 'vue';

	// defineProps({
	// 	tabs: {
	// 		type: Array,
	// 		default: () => [],
	// 		required: true,
	// 	},
	// 	activeColorClass?: string,
	// 	secondaryColorClass?: string,
	// });

	const props = defineProps<{
		tabs: Array<{ name: string }>;
		activeColorClass?: string;
		secondaryColorClass?: string;
	}>();

	const emit = defineEmits<{
		(event: 'update:currentTab', index): void;
	}>();

	const currentTab = ref(0);
	const activeTabClass = ref(props.activeColorClass || '');

	const selectTabs = (index) => {
		currentTab.value = index;
		localStorage.setItem('currentTab', index);
		emit('update:currentTab', index);
	};

	onMounted(() => {
		if (localStorage.getItem('currentTab')) {
			currentTab.value = Number(localStorage.getItem('currentTab'));
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
				class="block w-full rounded-md border-gray-300"
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
