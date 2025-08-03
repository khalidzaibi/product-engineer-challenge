import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/Login.vue'),
  },
  {
    path: '/',
    component: () => import('../components/Layout.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: 'app/dashboard',
        name: 'Dashboard',
        component: () => import('../views/Dashboard.vue'),
        meta: { requiresAuth: true, breadcrumb: ['Dashboard'] }
        
      },
      {
        path: 'app/users',
        name: 'Users',
        component: () => import('../views/users/Users.vue'),
        meta: { requiresAuth: true, breadcrumb: ['Dashboard', 'Users'] }
      },
      {
        path: 'app/tasks',
        name: 'Tasks',
        component: () => import('../views/tasks/Index.vue'),
        meta: { requiresAuth: true, breadcrumb: ['Dashboard', 'Tasks'] }
      },
      {
        path: 'app/teams',
        name: 'Teams',
        component: () => import('../views/teams/Index.vue'),
        meta: { requiresAuth: true, breadcrumb: ['Dashboard', 'Teams'] }
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const auth = useAuthStore()

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    next({ name: 'Login' })
  } else if (to.name === 'Login' && auth.isAuthenticated) {
    next({ name: 'Dashboard' })
  } else {
    next()
  }
})

export default router