import { createApp } from 'vue'
import App from './App.vue'

import { createRouter, createWebHistory } from "vue-router"

import HomeComponent from "./components/HomeComponent.vue"
import ProjectsComponent from "./components/ProjectsComponent.vue"
import ProjectDetailComponent from "./components/ProjectDetailComponent.vue"

const app = createApp(App)

const routes = [
	{ path: "/project/:id", component: ProjectDetailComponent },
	{ path: "/projects", component: ProjectsComponent },
	{ path: "/", component: HomeComponent }
]

const router = createRouter({
	history: createWebHistory(),
	routes
})

app.config.globalProperties.$apiURL = "http://127.0.0.1:8000/api"
app.config.globalProperties.$apiBaseURL = "http://127.0.0.1:8000"

app.use(router)

app.mount('#app')
