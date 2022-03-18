import { createRouter, createWebHistory } from 'vue-router';
import Guest from "@/services/midlewares";
import LoginView from '../views/LoginView.vue';
import ListView from '../views/ListView.vue';
import SubTasksView from '../views/SubTasksView.vue';
import LogoutComponent from '../components/LogoutComponent.vue';
import RegisterView from "@/views/RegisterView.vue";

const routes = [
  {
    path: '/',
    name: 'login',
    beforeEnter: Guest.blockLogin,
    component: LoginView
  },
  {
    path: '/register',
    name: 'register',
    beforeEnter: Guest.blockLogin,
    component: RegisterView
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
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
