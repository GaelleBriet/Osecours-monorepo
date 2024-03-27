<script setup lang="ts">
	const props = defineProps({
		msg: String,
	});
</script>
<template>
	<h1>Demo View</h1>
	<p>Message props : {{ msg }}</p>
</template>
<style lang="scss" scoped></style>
