<script setup lang="ts">
	import { getCapitalizedText } from '../Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';

	const t = i18n.global.t;
	import { ref, computed } from 'vue';
	const props = defineProps<{
		store: object;
		modelValue: object[];
		title?: string;
		description?: string;
		availability?: string;
		columns: {
			label: string;
			key: string | ((item: object) => string);
			visibility?: {
				sm?: boolean;
				md?: boolean;
				lg?: boolean;
			};
			truncate?: boolean;
		}[];
		animalsChars?: boolean;
		disableAddBtn?: boolean;
		disableEditIcon?: boolean;
	}>();

	const emit = defineEmits<{
		(event: 'edit', item: object): void;
		(event: 'add'): void;
		(event: 'delete', item: object): void;
		(event: 'documentSaved'): void;
	}>();

	const editItem = (item: object) => {
		emit('edit', item);
	};

	const addItem = () => {
		emit('add');
	};

	const deleteItem = (item: object) => {
		emit('delete', item);
		emit('documentSaved');
	};

	const searchQuery = ref('');

	const filteredItems = computed(() => {
		const query = searchQuery.value.toLowerCase().trim();
		if (!query) {
			return props.modelValue || [];
		} else {
			return (props.modelValue || []).filter((item) => {
			for (const key in item) {
				if (Object.hasOwnProperty.call(item, key)) {
				if (item[key]?.toString().toLowerCase().includes(query)) {
					return true;
				}
				}
			}
			return false;
			});
		}
	});
</script>

<template>
	<div>
		<div
			v-if="!animalsChars"
			class="sm:flex sm:items-center"
		>
			<div class="sm:flex-auto">
				<h1 class="text-base leading-6 text-gray-900 mb-5">
					{{ props.title }}
				</h1>
				<p class="mt-2 text-sm text-gray-700">
					{{ props.modelValue?.length ? props.description : props.availability }}
				</p>
			</div>
			<div class="flex justify-between">
				<div 
					v-if="props.modelValue.length"
					class="mt-4 flex sm:mr-12"
				>
					<input
						v-model="searchQuery"
						type="text"
						id="search-input"
						class="rounded-l-md px-2 py-1 w-28 text-sm lg:w-36 lg:text-md border border-gray-300 focus:outline-none focus:border-orange-300"
						:placeholder="getCapitalizedText(t('common.search'))"
					/>
					<button
						id="search-btn"
						type="button"
						class="rounded-r-md px-2 py-1 text-center text-sm text-white"
					>
						<!-- @todo: changer le svg pour une icone  -->
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="w-4 h-4"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
							/>
						</svg>
					</button>
				</div>
				<div
					v-if="!disableAddBtn"
					class="mt-4 ml-22"
				>
					<button
						id="add-animal-btn"
						type="button"
						class="rounded-md px-3 py-2 text-center text-sm"
						@click="addItem"
					>
						{{ getCapitalizedText(t('common.add')) }}
					</button>
				</div>
			</div>
		</div>
		<div
			v-else
			class="relative flex justify-end -top-8 z-0"
		>
			<button
				v-tooltip="getCapitalizedText(t('common.notImplemented'))"
				id="add-btn"
				type="button"
				class="rounded-md px-3 py-2 text-center text-sm"
				@click="addItem"
			>
				{{ getCapitalizedText(t('pages.animals.addChar')) }}
			</button>
		</div>

		<div class="-mx-4 mt-8 sm:-mx-0 overflow-hidden">
			<!-- view cards for smartphones -->
			<div 
				v-if="props.modelValue.length"
				class="custonmXs:hidden"
			>
				<div
					v-for="item in filteredItems"
					:key="item.id"
					class="p-4 bg-white mb-4 shadow rounded-lg"
				>
					<template
						v-for="column in props.columns"
						:key="column.key"
					>
						<ul>
							<li class="flex flex-row space-x-2 items-baseline">
								<span class="text-l text-osecours-black"
									>{{ column.label }}:</span
								>
								<span class="text-sm text-osecours-black">{{
									typeof column.key === 'function'
										? column.key(item)
										: item[column.key]
								}}</span>
							</li>
						</ul>
					</template>
					<div class="flex justify-between">
						<div class="pt-4">
							<a
								class="cursor-pointer text-osecours-beige-dark hover:text-indigo-900"
								@click="editItem(item)"
								>{{ getCapitalizedText(t('common.edit')) }}</a
							>
						</div>
						<div class="pt-4">
							<a
								class="cursor-pointer text-red-600 hover:text-red-900"
								@click="deleteItem(item)"
								>{{ getCapitalizedText(t('common.delete')) }}</a
							>
						</div>
					</div>
				</div>
			</div>
			<!-- vue table for large screens -->
			<div
				v-if="props.modelValue.length"
				class="hidden custonmXs:block overflow-x-auto"
			>
				<table class="min-w-full divide-y divide-gray-300">
					<thead class="bg-gray-50">
						<tr>
							<template
								v-for="column in props.columns"
								:key="column.key"
							>
								<th
									scope="col"
									:class="[
										'py-3.5 pl-4 pr-3 text-left text-sm text-gray-900',
										column.visibility?.md ? 'hidden customMd:block' : '',
										column.visibility?.sm ? 'hidden customSm:block' : '',
									]"
								>
									{{ column.label }}
								</th>
							</template>
							<th
								scope="col"
								class="relative py-3.5 pl-3 pr-4 sm:pr-2 text-gray-900 text-left text-sm"
							>
								{{ getCapitalizedText(t('common.actions', 1)) }}
							</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-200">
						<tr
							v-for="item in filteredItems"
							:key="`large-${item.id}`"
						>
							<template
								v-for="column in props.columns"
								:key="column.key"
							>
								<td
									:class="[
										'whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500',
										column.visibility?.md ? 'hidden customMd:block' : '',
										column.visibility?.sm ? 'hidden customSm:block' : '',
										column.truncate ? 'truncate max-w-[200px]' : '',
									]"
									v-tooltip="column.truncate ? item[column.key] : ''"
								>
									{{
										typeof column.key === 'function'
											? column.key(item)
											: item[column.key]
									}}
								</td>
							</template>
							<td
								class="whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm sm:pr-2"
							>
								<div class="flex gap-3">
									<a
										v-tooltip="
											disableEditIcon
												? getCapitalizedText(t('common.consult'))
												: getCapitalizedText(t('common.edit'))
										"
										class="cursor-pointer"
										@click="editItem(item)"
									>
										<i
											class="text-indigo-600 hover:text-indigo-900 text-lg"
											:class="[disableEditIcon ? 'icon-oeil' : 'icon-pencil ']"
										/>
									</a>
									<a
										v-tooltip="getCapitalizedText(t('common.delete'))"
										class="cursor-pointer"
										@click="deleteItem(item)"
									>
										<i
											class="icon-trash-empty text-red-600 hover:text-red-900 text-lg"
										/>
									</a>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>
<style lang="postcss" scoped>
	#add-animal-btn,
	#add-btn,
	#search-btn {
		background-color: rgba(217, 153, 98);
		color: #fff;
		&:hover {
			background-color: var(--color-withe);
			color: #d99962;
			outline: 1px solid #d99962;
		}
	}
</style>
