<template>
	<div class="task">
		<input type="checkbox" class="checkbox" v-model="task.isCompleted" @change="updateTask()"/>
		<span :class="[task.isCompleted ? 'completed' : '' ,'task-text']">{{ task.title }}</span>
		<button class="delete" @click="deleteTask()">Delete</button>
	</div>
</template>

<script>
	export default{
		props: ['task'],
		methods: {
			deleteTask(){
				var self = this;
				axios.delete('/todo-auth/public/api/tasks/' + this.task.id,  {headers: {"Authorization": "Bearer " + self.$store.state.token}})
				.then(function(response){
					if (response.data.status) {
						self.$emit('taskDeleted');
					}
				})
				.catch(function(error){
					console.log(error);
				});
			},
			updateTask(){
				var self = this;
				axios.put('/todo-auth/public/api/tasks/' + this.task.id, {"isCompleted" : this.task.isCompleted} ,{headers: {"Authorization": "Bearer " + self.$store.state.token}})
				.then(function(response){
					if (response.data.status) {
						console.log('updated');
					}
				})
				.catch(function(error){
					console.log(error);
				});
			}
		}
	}
</script>

<style>
.task{
	background: #1a568c;
	color: #fff;
	padding: 8px;
	margin: 5px auto;
}

.task:nth-of-type(2n+1){
	background: #2984d5;
}

.checkbox,
.delete{
	border: 0;
	outline: 0;
}

.task-text{
	display: inline-block;
	text-align:center;
	width: 80%;
}

.completed{
	text-decoration: line-through;
}

.delete{
	background: red;
	color: #fff;
	padding: 5px 20px;
	cursor: pointer;
}
</style>