import Vue from 'vue'
import Router from 'vue-router'

import Hello from '../views/Hello'
import Home from '../views/Home'

Vue.use(Router)

export default new Router({
  	routes: [
	    {
	        path: '/',
	        name: 'home',
	        component: Home
	    },
	    {
	        path: '/hello',
	        name: 'hello',
	        component: Hello,
	    },
  	]
})
