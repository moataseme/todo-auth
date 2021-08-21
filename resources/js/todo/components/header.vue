<template>
	<div class="nav">
		<ul>
			<li><router-link to="/">Home</router-link></li>
			<li v-if="$store.state.token"><router-link to="/tasks">Tasks</router-link></li>
			<li v-if="!$store.state.token"><router-link to="/register">Register</router-link></li>
			<li v-if="!$store.state.token"><router-link to="/login">Login</router-link></li>
			<li v-if="$store.state.token" @click.prevent="logout()"><a>Logout</a></li>
		</ul>
	</div>
</template>

<script>
	export default{
		methods: {
			logout(){
				this.$store.dispatch('logout');
			}
		}
	}
</script>

<style>
*{
	padding: 0;
	margin: 0;
	box-sizing: border-box;
}

.nav{
	/*background: #2984d5;*/
	background: #1a568c;
}

.nav ul{
	list-style-type: none;
	text-align: center;
}

.nav ul li{
	display: inline-block;
}

.nav ul li a{
	display: inline-block;
	text-decoration: none;
	color: #fff;
	padding: 20px;
}

.nav ul li a:hover,
.nav ul li a.router-link-exact-active{
	background: #2984d5;
}
</style>