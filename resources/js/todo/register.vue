<template>
	<div class="register">
		<div class="register-header">
			<h3>Register</h3>
		</div>
		<form @submit.prevent="register()">
			<div class="input-group">
				<label for="name">Name:</label>
				<input type="text" id="name" class="txt-input" v-model="user.name"/>
			</div>
			<div class="input-group">
				<label for="email">Email:</label>
				<input type="email" id="email" class="txt-input" v-model="user.email"/>
			</div>
			<div class="input-group">
				<label for="password">Password:</label>
				<input type="password" id="password" class="txt-input" v-model="user.password"/>
			</div>
			<div class="input-group">
				<label for="password_con">Password Confirm:</label>
				<input type="password" id="password_con" class="txt-input" v-model="user.password_confirmation"/>
			</div>
			<error v-for="(error, index) in this.errors" :key="index" :error="error"></error>
			<div class="input-group register-btn-wrap">
				<input type="submit" value="Register" class="register-btn"/>
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
					name: '',
					email: '',
					password: '',
					password_confirmation: '',
				},
				errors: [],
			}
		},
		methods: {
			register: function(){
				var self = this;
				axios.post('/todo-auth/public/api/register',self.user)
				.then(function(response){
					console.log(response);
					if (response.data.status == true) {
						//self.$router.push({name: '/todo-auth/public/login', params:{success:1}})
						self.$router.push({path: '/login', query: {success: 'success'}})
					}else{
						self.errors = response.data.errors
					}
				})
				.catch(function(error){
					console.log(error);
				});
			}
		},
		components:{
			error
		}
	}
</script>

<style scoped>
.register{
	position: relative;
	padding: 30px;
	border: 1px solid #2984d5;
	width: 50%;
	margin: 40px auto;
	border-radius: 10px;
}

.register-header{
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

.register-btn-wrap{
	text-align: center;
}

.input-group .register-btn{
	cursor: pointer;
	width: auto;
	padding: 12px 50px;
	color: #fff;
	border-radius: 10px;
	outline: none;
	background: #1a568c;
}

.register-btn:hover{
	background: #2984d5;
}
</style>