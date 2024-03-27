<script setup lang="ts">
	import DemoView from '@/Views/DemoView.vue';
</script>

<template>
	<h1>Hello App!</h1>
	<p><strong>Current route path:</strong> {{ $route.fullPath }}</p>
	<nav>
		<RouterLink :to="{ name: 'HelloWorld', props: { msg: 'Hello World' } }"
			>Go to Hello world</RouterLink
		>
	</nav>
	<DemoView :msg="'Message in a props'" />
</template>

<style scoped></style>
