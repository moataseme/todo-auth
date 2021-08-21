require('./bootstrap');

//Import vue
import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';

//Import pages
import Home from './todo/home';
import Login from './todo/login';
import Register from './todo/register';
import Tasks from './todo/tasks';

//Import components
import appHeader from './todo/components/header';

Vue.use(Vuex);

Vue.use(VueRouter);

//Routes
const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/tasks', component: Tasks },
];

//Router
const router = new VueRouter({
	mode: 'hash',
	routes: routes,
});


//Vuex store
const store = new Vuex.Store({
	state: {
		token: null,
		loginMessages: null
	},
	mutations: {
		LOGGEDIN(state, token){
			state.token = token;
		},
		UPDATE_MESSAGES(state, errors){
			state.loginMessages = errors;
		},
		LOGOUT(state){
			state.token = null;
			state.loginMessages = null;
		}
	},
	actions:{
		login(context, user){
			var self = this;
			axios.get('/todo-auth/public/sanctum/csrf-cookie').then(function(response){
				axios.post('/todo-auth/public/api/login', user)
				.then(function(response){
					if (response.data.status == false) {
						context.commit('UPDATE_MESSAGES', response.data.errors);
					}else{
						context.commit('UPDATE_MESSAGES', []);
						context.commit('LOGGEDIN', response.data.data.token);
						router.push({path: '/tasks'});
					}
				})
				.catch(function(error){
					console.log(error)
				})
			});
		},
		logout(context){
			var self = this;
				axios.get('/todo-auth/public/api/logout', {headers: {"Authorization": "Bearer " + self.state.token}})
				.then(function(response){
					context.commit('LOGOUT');
					router.push({path: '/login'});
				})
				.catch(function(error){

				})
			
		}
	}
});

//Redirecting if not authenticated
router.beforeEach((to, from, next) => {
	 if (to.path == "/tasks") {
	 		if (!store.state.token) {
	 			//return next({path:'/login'});
	 		}
	 }else if(to.path == "/login" || to.path == "/register"){
	 	if (store.state.token) {
	 		return next({path:'/tasks'});
	 	}
	 }
	 return next();
});


//Vue config
const vm = new Vue({
	el: '#app',
	router: router,
	store: store,
	components: {appHeader}
});