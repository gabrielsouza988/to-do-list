import { createRouter, createWebHistory } from 'vue-router';
import Guest from "@/services/midlewares";
import LoginView from '../views/LoginView.vue';
import TaskView from '../views/TaskView.vue';
import ItemsTaskView from '../views/ItemsTaskView.vue';
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
    component: TaskView
  },
  {
    path: '/task/:id',
    name: 'ItemsTask',
    beforeEnter: Guest.auth,
    component: ItemsTaskView
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
