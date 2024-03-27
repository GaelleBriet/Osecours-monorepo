<script setup lang="ts">
	import { ref } from 'vue';

	const props = defineProps({
		msg: String,
	});

	const count = ref(0);
</script>

<template>
	<h1>Hello World</h1>

	<div class="card">
		<button
			type="button"
			@click="count++"
		>
			count is {{ count }}
		</button>
		<p><strong>Current route path:</strong> {{ $route.fullPath }}</p>
		<router-link to="/">Go back</router-link>
	</div>
</template>

<style scoped></style>
