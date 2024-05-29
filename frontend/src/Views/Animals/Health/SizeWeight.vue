<script lang="ts" setup>
	import { formatDate } from '@/Services/Helpers/Date.ts';

	defineProps<{
		measures: Array<{
			id: number;
			date: string;
			report: string;
			weight: number;
			size: number;
		}>;
	}>();
</script>
<template>
	<div class="rounded h-full">
		<div>
			<p class="mb-5">
				<span
					class="border-b-2 border-osecours-pink border-opacity-50 text-osecours-black text-lg"
					>Derniers rapports</span
				>
			</p>
			<div class="grid grid-cols-1 gap-4">
				<template
					v-for="measure in measures"
					:key="measure.id"
				>
					<div
						v-if="measure.size && measure.weight && measure.date"
						class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm hover:border-osecours-pink mb-2"
					>
						<div class="min-w-0 flex-1">
							<span
								class="absolute inset-0"
								aria-hidden="true"
							/>
							<p
								v-if="measure.size && measure.weight"
								class="text-sm font-medium text-gray-900"
							>
								Taille:
								<span class="text-gray-500">{{ measure.size }} cm.</span> Poids:
								<span class="text-gray-500">{{ measure.weight }} kg.</span>
							</p>
							<p class="truncate text-sm text-gray-500">
								{{ formatDate(measure.date, 'medium') }}
							</p>
						</div>
					</div>
				</template>
			</div>
		</div>
		<div>
			<div class="grid grid-cols-1 gap-4">
				<template
					v-for="measure in measures"
					:key="measure.id"
				>
					<div
						v-if="measure.report && measure.date"
						class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm hover:border-osecours-pink"
					>
						<div class="min-w-0 flex-1">
							<p
								v-if="measure.report"
								class="truncate text-sm text-gray-500"
							>
								{{ measure.report }}
							</p>
							<p class="truncate text-sm text-gray-500">
								{{ formatDate(measure.date, 'medium') }}
							</p>
						</div>
					</div>
				</template>
			</div>
		</div>
	</div>
</template>
