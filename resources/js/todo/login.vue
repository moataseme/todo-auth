<template>
	<div class="login">
		<div class="login-header">
			<h3>Login</h3>
		</div>
		<div class="success" v-if="$route.query.success">
			<p>Registered successfully, Please login</p>
		</div>
		<form @submit.prevent="login()">
			<div class="input-group">
				<label for="email">Email:</label>
				<input type="email" id="email" class="txt-input" v-model="user.email"/>
			</div>
			<div class="input-group">
				<label for="password">Password:</label>
				<input type="password" id="password" class="txt-input" v-model="user.password"/>
			</div>
			<error v-if="$store.state.loginMessages" v-for="(error, index) in $store.state.loginMessages" :key="index" :error="error"></error>
			<div class="input-group login-btn-wrap">
				<input type="submit" value="Login" class="login-btn"/>
			</div>
		</form>
	</div>
	</div>
</template>

<script>
import error from './components/error';

	export default{
		data(){
			return{
				user:{
					email: '',
					password: '',
				}
			}
		},
		methods: {
			login: function(){
				this.$store.dispatch('login', this.user);
			}
		},
		components: {error}
	}
</script>

<style scoped>
.login{
	position: relative;
	padding: 30px;
	border: 1px solid #2984d5;
	width: 50%;
	margin: 40px auto;
	border-radius: 10px;
}

.login-header{
	position: absolute;
	top: -28px;
	right: 0;
	left: 0;
	margin: auto;
	background: #fff;
	border: 1px solid #2984d5;
	border-radius: 10px;
	width: 20%;
    text-align: center;
    padding: 15px;
}

.success{
	width: 60%;
	background: green;
	padding: 5px;
	text-align: center;
	margin: auto;
	margin-top: 20px;
}

.success p{
	color: #fff;
	font-size: 18px;
}

form{
	margin-top: 30px;
}

.input-group{
	margin: 20px auto;
	width: 60%;
}

.input-group label,
.input-group .txt-input{
	display: block;
	width: 100%
}

.input-group .txt-input{
	padding-top: 5px;
	height: 30px;
}

.login-btn-wrap{
	text-align: center;
}

.input-group .login-btn{
	cursor: pointer;
	width: auto;
	padding: 12px 50px;
	color: #fff;
	border-radius: 10px;
	outline: none;
	background: #1a568c;
}

.login-btn:hover{
	background: #2984d5;
}
</style>