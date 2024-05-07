<script setup lang="ts">
	import { Doughnut } from 'vue-chartjs';
	import {
		Chart as ChartJS,
		Title,
		Tooltip,
		Legend,
		ArcElement,
		BarElement,
		CategoryScale,
		LinearScale,
	} from 'chart.js';
	import { ref, watchEffect } from 'vue';
	import { plugin } from '@formkit/vue';

	ChartJS.register(
		Title,
		Tooltip,
		Legend,
		ArcElement,
		BarElement,
		CategoryScale,
		LinearScale,
	);

	const props = defineProps<{
		data: number[];
		labels: string[];
		title: string;
		titleDisplay?: boolean;
	}>();

	const chartData = ref({
		labels: props.labels,
		datasets: [
			{
				data: props.data,
			},
		],
	});

	const chartOptions = ref({
		responsive: true,
		maintainAspectRatio: false,
		plugins: {
			legend: {
				position: 'top',
			},
			title: {
				display: true,
				text: props.title,
			},
		},
	});

	watchEffect(() => {
		chartData.value = {
			labels: props.labels,
			datasets: [
				{
					data: props.data,
					backgroundColor: [
						'rgba(242, 208, 167, 0.5)',
						'rgba(242, 138, 128, 0.5)',
					],
					borderColor: ['rgb(242, 208, 167)', 'rgb(242, 138, 128)'],
					borderWidth: 1,
				},
			],
		};
	});
</script>
<template>
	<div class="h-72">
		<Doughnut
			id="my-chart-id"
			:options="chartOptions"
			:data="chartData"
		/>
	</div>
</template>
<style scoped>
	#my-chart-id {
		width: 100%;
		height: 100%;
	}

	@media (max-width: 640px) {
		#my-chart-id {
			width: 100%;
			height: 100%;
		}
	}
</style>
