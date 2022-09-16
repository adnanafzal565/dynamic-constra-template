import { createApp } from 'vue'
import App from './App.vue'

import { createRouter, createWebHistory } from "vue-router"

import HomeComponent from "./components/HomeComponent.vue"

const app = createApp(App)

const routes = [
	{ path: "/", component: HomeComponent }
]

const router = createRouter({
	history: createWebHistory(),
	routes
})
app.use(router)

app.mount('#app')
