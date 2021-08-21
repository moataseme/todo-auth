<template>
	<div class="tasks">
		<div class="tasks-header">
			<h3>Tasks</h3>
		</div>
		<form @submit.prevent="addTask()">
			<div class="input-group">
				<label for="task">Task:</label>
				<input type="text" id="task" class="txt-input" v-model="task.title"/>
			</div>
			<error v-if="errors" v-for="(error, index) in errors" :key="index" :error="error"></error>
			<error v-if="task.errors" v-for="(error, index) in task.errors" :key="index" :error="error"></error>
			<div class="input-group add-btn-wrap">
				<input type="submit" value="+ Add" class="add-btn"/>
			</div>
		</form>
		<task v-if="tasks" v-for="(task, index) in tasks" :key="index" :task="task" @taskDeleted="getTasks()"></task>
		<p v-if="tasks.length < 1" class="no-tasks">No tasks, Start adding new ones</p>
	</div>
	</div>
</template>

<script>
import task from './components/task';
import error from './components/error';

	export default{
		created(){
			this.getTasks();
		},
		data(){
			return{
				task: {
					title: null,
					errors: []
				},
				tasks: [],
				errors: []
			}
		},
		methods: {
			addTask(){
				if (this.task.title) {
					var self = this;
					axios.post('/todo-auth/public/api/tasks', {"title" : self.task.title}, {headers: {"Authorization": "Bearer " + self.$store.state.token}})
					.then(function(response){
						if (response.data.status) {
							self.task.errors = [];
							self.task.title = '';
							self.getTasks();
						}else{
							self.task.errors = response.data.errors;
						}
					})
					.catch(function(error){
						console.log(error);
					});
				}
			},
			getTasks(){
				var self = this;
				axios.get('/todo-auth/public/api/tasks', {headers: {"Authorization": "Bearer " + self.$store.state.token}})
				.then(function(response){
					if (response.data.status) {
						self.tasks = response.data.data;
					}
				})
				.catch(function(error){
					console.log(error);
				});	
			}
		},
		components: {
			task,
			error
		}
	}
</script>

<style>
.tasks{
	position: relative;
	padding: 30px;
	border: 1px solid #2984d5;
	width: 50%;
	margin: 40px auto;
	border-radius: 10px;
}

.tasks-header{
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

.add-btn-wrap{
	text-align: center;
}

.input-group .add-btn{
	cursor: pointer;
	width: auto;
	padding: 12px 50px;
	color: #fff;
	border-radius: 10px;
	outline: none;
	background: #1a568c;
}

.add-btn:hover{
	background: #2984d5;
}

.no-tasks{
	text-align: center;
	background: #1a568c;
	color: #fff;
	padding: 8px;
	margin: 5px auto;
}
</style>