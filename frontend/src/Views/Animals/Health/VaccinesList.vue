<script lang="ts" setup>
	import { formatDate } from '@/Services/Helpers/Date.ts';

	defineProps<{
		vaccines: Array<{
			id: number;
			name: string;
			date: string;
			reminder: string;
		}>;
	}>();
</script>
<template>
	<div class="p-3 bg-osecours-white rounded h-full">
		<p>
			<span
				class="border-b-2 border-osecours-pink border-opacity-60 text-osecours-pink"
				>Statut vaccinal</span
			>
		</p>
		<div
			v-for="vaccine in vaccines"
			:key="vaccine.id"
		>
			<ul>
				<div class="my-2">
					<p class="text-osecours-black">Vaccin: {{ vaccine.name }}</p>
					<p>
						Date:
						<span class="text-gray-500">
							{{ formatDate(vaccine.date, 'medium') }}</span
						>
					</p>
				</div>
			</ul>
		</div>
	</div>
</template>
