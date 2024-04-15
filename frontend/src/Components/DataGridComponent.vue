<script setup lang="ts">
	import { getCapitalizedText } from '../Services/Helpers/TextFormat.ts';
	import i18n from '@/Services/Translations';

	const t = i18n.global.t;

	const props = defineProps<{
		store: object;
		modelValue: object[];
		title?: string;
		description: string;
		columns: {
			label: string;
			key: string | ((item: object) => string);
			visibility?: {
				sm?: boolean;
				md?: boolean;
				lg?: boolean;
			};
		}[];
	}>();

	const emit = defineEmits<{
		(event: 'edit', item: object): void;
	}>();

	const editItem = (item: object) => {
		emit('edit', item);
		// router.push({
		// 	name: props.route,
		// 	params: { id: item.id },
		// });
	};

	const deleteItem = (item: object) => {
		emit('delete', item);
		// router.push({
		// 	name: props.route,
		// 	params: { id: item.id },
		// });
	};
</script>

<template>
	<div>
		<div class="sm:flex sm:items-center">
			<div class="sm:flex-auto">
				<h1 class="text-base leading-6 text-gray-900">
					{{ props.title }}
				</h1>
				<p class="mt-2 text-sm text-gray-700">
					{{ props.description }}
				</p>
			</div>
			<div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
				<button
					id="add-animal-btn"
					type="button"
					class="rounded-md px-3 py-2 text-center text-sm"
				>
					{{ getCapitalizedText(t('common.add')) }}
				</button>
			</div>
		</div>

		<div class="-mx-4 mt-8 sm:-mx-0 overflow-hidden">
			<!-- view cards for smartphones -->
			<div class="custonmXs:hidden">
				<div
					v-for="item in modelValue"
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
									>{{ column.label }}:
								</span>
								<span class="text-sm text-osecours-black">{{
									item[column.key]
								}}</span>
							</li>
						</ul>
					</template>
					<div class="pt-4 flex justify-between">
						<a
							class="text-osecours-beige-dark hover:text-indigo-900 cursor-pointer"
							@click="editItem(item)"
							>{{ getCapitalizedText(t('common.edit')) }}</a
						>
						<a
							class="text-red-600 hover:text-red-900 cursor-pointer"
							@click="deleteItem(item)"
							>{{ getCapitalizedText(t('common.delete')) }}</a
						>
					</div>
				</div>
			</div>
			<!-- vue table for screens -->
			<div class="hidden custonmXs:block overflow-x-auto">
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
							v-for="item in modelValue"
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
									]"
								>
									{{ item[column.key] }}
								</td>
							</template>
							<td
								class="whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm sm:pr-2"
							>
								<!--								<router-link-->
								<!--									:to="`${props.route}/${item.id}`"-->
								<!--									class="text-indigo-600 hover:text-indigo-900"-->
								<!--									>{{ getCapitalizedText(t('common.edit')) }}</router-link-->
								<!--								>-->
								<div class="flex justify-between">
									<a
									class="text-indigo-600 hover:text-indigo-900 cursor-pointer"
									@click="editItem(item)"
									>
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
											<path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
										</svg>
									</a>
									<a
									class="text-red-600 hover:text-red-900 cursor-pointer"
									@click="deleteItem(item)"
									>
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
											<path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
										</svg>
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
	#add-animal-btn {
		background-color: rgba(217, 153, 98);
		color: #fff;
		&:hover {
			background-color: var(--color-withe);
			color: #d99962;
			outline: 1px solid #d99962;
		}
	}
</style>
