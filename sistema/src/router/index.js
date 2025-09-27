import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ResponsablesView from '@/components/ResponsablesView.vue'    
import EditarRespView from '@/components/EditarRespView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/responsablesView',
    name: 'responsablesView',
    component: ResponsablesView
  },
  {
    path: '/editar-responsable/:id?', // <--- DEBE INCLUIR EL PARÁMETRO DINÁMICO :id
    name: 'EditarRespView', 
    component: EditarRespView
  },  
  {
    path: '/about',
    name: 'about',
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
