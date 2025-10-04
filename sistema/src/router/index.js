import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ResponsablesView from '@/components/ResponsablesView.vue'    
import UbicacionesView from '@/components/UbicacionesView.vue'   
import EditarRespView from '@/components/EditarRespView.vue'
import EditarUbicacionView from '@/components/EditarUbicacionView.vue'
import CrearUbicacionView from '@/components/CrearUbicacionView.vue'
import CrearRespView from '@/components/CrearRespView.vue'
import InicioView from '@/components/InicioView.vue'
import CrearEquipoView from '@/components/CrearEquipoView.vue'
import EditarEquipoView from '@/components/EditarEquipoView.vue'
import EquiposView from '@/components/EquiposView.vue'

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
    path: '/ubicacionesView', 
    name: 'UbicacionesView', 
    component: UbicacionesView },
  { 
    path: '/EquiposView', 
    name: 'EquiposView', 
    component: EquiposView },
  {
    path: '/editar-responsable/:id?', // <--- DEBE INCLUIR EL PARÁMETRO DINÁMICO :id
    name: 'EditarRespView', 
    component: EditarRespView
  },  
  {
    path: '/ubicaciones/editar/:id?', 
    name: 'EditarUbicacionView', 
    component: EditarUbicacionView 
  },
  {
    path: '/equipos/editar/:id?', 
    name: 'EditarEquipoView', 
    component: EditarEquipoView 
  },
  {
    path: "/responsables/crear",
    name: "CrearUbicacionView",   
    component: CrearUbicacionView,
  },
  {
    path: "/responsables/crear",
    name: "CrearRespView",   
    component: CrearRespView,
  },
  {
    path: "/equipos/crear",
    name: "CrearEquipoView",   
    component: CrearEquipoView
  },
  {
    path: "/inicioView",
    name: "InicioView",   
    component: InicioView,
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
