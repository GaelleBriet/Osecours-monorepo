<script lang="ts" setup></script>
<template>
	<div>
		<p>Ajouter un document, une ordonnance ...</p>
		<FormKit
			type="file"
			label="Documents"
			accept=".jpg,.png,.pdf"
			help="Select as many documents as you would like."
			multiple="true"
		/>
	</div>
</template>
