<script setup lang="ts">
	import { ref } from 'vue';
	import { getCapitalizedText } from '../Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';

	const t = i18n.global.t;

	const props = defineProps({
		tabs: {
			type: Array,
			default: () => [],
			required: true,
		},
	});

	const emit = defineEmits<{
		(event: 'update:currentTab', index: any): void;
	}>();

	const currentTab = ref(0);

	const selectTabs = (index) => {
		currentTab.value = index;
		emit('update:currentTab', index);
	};
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
				class="block w-full rounded-md border-gray-300 focus:border-osecours-beige-dark focus:ring-osecours-beige-dark"
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
						{{ getCapitalizedText(t(tab.name)) }}
					</option>
				</template>
			</select>
		</div>
		<!--		affiche les tabs sur grand écran   -->
		<div class="hidden sm:block">
			<nav
				class="flex space-x-4"
				aria-label="Tabs"
			>
				<template
					v-for="(tab, index) in tabs"
					:key="tab.name"
				>
					<a
						v-if="tab"
						:class="[
							index === currentTab
								? 'bg-indigo-100 text-indigo-700'
								: 'text-gray-500 hover:text-gray-700',
							'rounded-md px-3 py-2 text-sm font-medium cursor-pointer',
						]"
						:aria-current="index === currentTab ? 'page' : undefined"
						@click.prevent="selectTabs(index)"
					>
						{{ getCapitalizedText(t(tab.name)) }}
					</a>
				</template>
			</nav>
		</div>
	</div>
</template>
