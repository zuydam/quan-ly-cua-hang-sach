import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '../Dashboard.vue'

const routes = [
  {path: '/', component: Dashboard},
  {path: '/:pathMatch(.*)*', redirect: '/'}
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
