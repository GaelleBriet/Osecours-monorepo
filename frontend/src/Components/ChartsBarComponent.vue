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
		animalsCount: number;
		catsCount: number;
		dogsCount: number;
	}>();

	const catsCount = ref(props.catsCount);
	const dogsCount = ref(props.dogsCount);

	const chartData = ref({
		labels: ['Chiens', 'Chats'],
		datasets: [
			{
				label: "Nombre d'animaux",
				data: [catsCount.value, dogsCount.value],
			},
		],
	});

	const chartOptions = ref({
		responsive: true,
		maintainAspectRatio: false,
	});

	watchEffect(() => {
		catsCount.value = props.catsCount;
		dogsCount.value = props.dogsCount;

		chartData.value = {
			labels: ['Chiens', 'Chats'],
			datasets: [
				{
					label: "Nombre d'animaux",
					data: [catsCount.value, dogsCount.value],
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
