<template>
	<div class="error">
		<p>{{ error[0] }}</p>
	</div>
</template>

<script>
	export default{
		props: ['error']
	}
</script>

<style>
.error{
	width: 60%;
	margin: auto;
	background: red;
	padding: 5px;
	margin-top: 5px;
	text-align: center;
	font-size: 18px;
}

.error p{
	color: #fff;
}
</style>