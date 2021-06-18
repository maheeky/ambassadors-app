import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import Layout from '@/views/Layout.vue';
import Login from '@/views/Login.vue';
import Register from '@/views/Register.vue';
import Profile from '@/views/Profile.vue';
import ProductsFrontend from '@/views/ProductsFrontend.vue';

const routes: Array<RouteRecordRaw> = [
  {path: '/login', component: Login},
  {path: '/register', component: Register},
  {
    path: '',
    component: Layout,
    children: [
      {path: '/profile', component: Profile},
      {path: '', component: ProductsFrontend}
    ]
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
