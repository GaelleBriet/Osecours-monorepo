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
	<div class="p-3 bg-osecours-white rounded h-full">
		<p>
			<span
				class="border-b-2 border-osecours-pink border-opacity-60 text-osecours-pink"
				>Dernières mesures</span
			>
		</p>
		<div
			v-for="measure in measures"
			:key="measure.id"
		>
			<div class="my-2">
				<p class="text-osecours-black">
					Poids: <span class="text-gray-500">{{ measure.weight }} cm.</span>
				</p>
				<p class="text-osecours-black">
					Taille: <span class="text-gray-500">{{ measure.size }} kg.</span>
				</p>
				<p>
					Date:
					<span class="text-gray-500"
						>{{ formatDate(measure.date, 'medium') }}
					</span>
				</p>
			</div>
		</div>
	</div>
</template>
