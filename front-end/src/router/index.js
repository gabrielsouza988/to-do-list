import { createRouter, createWebHistory } from 'vue-router'
import Guest from "@/services/midlewares";
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import ListView from '../views/ListView.vue'
import SubTasksView from '../views/SubTasksView.vue'
import LogoutComponent from '../components/LogoutComponent.vue'

const routes = [
  {
    path: '/login',
    name: 'login',
    beforeEnter: Guest.blockLogin,
    component: LoginView
  },
  {
    path: '/logout',
    name: 'logout',
    beforeEnter: Guest.auth,
    component: LogoutComponent
  },
  {
    path: '/task',
    name: 'task',
    beforeEnter: Guest.auth,
    component: ListView
  },
  {
    path: '/task/:id',
    name: 'SubTasksView',
    beforeEnter: Guest.auth,
    component: SubTasksView
  },
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    beforeEnter: Guest.auth,
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
