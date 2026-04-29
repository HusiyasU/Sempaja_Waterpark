import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth.js'
console.log(import.meta.url)
// =====================
// LAZY LOAD VIEWS
// =====================

// Public
const HomeView        = () => import('@/views/public/HomeView.vue')
const WahanaView      = () => import('@/views/public/WahanaView.vue')
const HargaTiketView  = () => import('@/views/public/HargaTiketView.vue')
const KeselamatanView = () => import('@/views/public/KeselamatanView.vue')
const TentangView     = () => import('@/views/public/TentangView.vue')
const KontakView      = () => import('@/views/public/KontakView.vue')

// Auth
const LoginView    = () => import('@/views/auth/LoginView.vue')
const RegisterView = () => import('@/views/auth/RegisterView.vue')

// User
const DashboardUserView = () => import('@/views/user/DashboardUserView.vue')

// Admin
const DashboardAdminView = () => import('@/views/admin/DashboardAdminView.vue')

// Error
const NotFoundView = () => import('@/views/NotFoundView.vue')

// =====================
// ROUTES
// =====================
const routes = [
  // ---- PUBLIC ----
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: { title: 'Beranda — Bumi Sempaja Waterpark' }
  },
  {
    path: '/wahana',
    name: 'wahana',
    component: WahanaView,
    meta: { title: 'Wahana — Bumi Sempaja Waterpark' }
  },
  {
    path: '/harga-tiket',
    name: 'harga-tiket',
    component: HargaTiketView,
    meta: { title: 'Harga Tiket — Bumi Sempaja Waterpark' }
  },
  {
    path: '/keselamatan',
    name: 'keselamatan',
    component: KeselamatanView,
    meta: { title: 'Keselamatan — Bumi Sempaja Waterpark' }
  },
  {
    path: '/tentang',
    name: 'tentang',
    component: TentangView,
    meta: { title: 'Tentang Kami — Bumi Sempaja Waterpark' }
  },
  {
    path: '/kontak',
    name: 'kontak',
    component: KontakView,
    meta: { title: 'Kontak — Bumi Sempaja Waterpark' }
  },

  // ---- AUTH ----
  {
    path: '/login',
    name: 'login',
    component: LoginView,
    meta: { title: 'Login — Bumi Sempaja Waterpark', guestOnly: true }
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView,
    meta: { title: 'Register — Bumi Sempaja Waterpark', guestOnly: true }
  },

  // ---- USER ----
  {
    path: '/dashboard',
    name: 'dashboard-user',
    component: DashboardUserView,
    meta: { title: 'Dashboard — Bumi Sempaja Waterpark', requiresAuth: true, role: 'user' }
  },

  // ---- ADMIN ----
  {
    path: '/admin',
    name: 'dashboard-admin',
    component: DashboardAdminView,
    meta: { title: 'Dashboard Admin — Bumi Sempaja Waterpark', requiresAuth: true, role: 'admin' }
  },

  // ---- 404 ----
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: NotFoundView,
    meta: { title: '404 — Halaman Tidak Ditemukan' }
  }
]

// =====================
// CREATE ROUTER
// =====================
const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition
    return { top: 0, behavior: 'smooth' }
  }
})

// =====================
// NAVIGATION GUARD
// =====================
router.beforeEach(async (to, from, next) => {
  document.title = to.meta.title || 'Bumi Sempaja Waterpark'

  const authStore = useAuthStore()

  if (to.meta.requiresAuth) {
    if (!authStore.isLoggedIn) {
      return next({ name: 'login', query: { redirect: to.fullPath } })
    }

    if (to.meta.role && authStore.user?.role !== to.meta.role) {
      if (authStore.user?.role === 'user') {
        return next({ name: 'dashboard-user' })
      }
      if (authStore.user?.role === 'admin') {
        return next({ name: 'dashboard-admin' })
      }
    }
  }

  if (to.meta.guestOnly && authStore.isLoggedIn) {
    if (authStore.user?.role === 'admin') {
      return next({ name: 'dashboard-admin' })
    }
    return next({ name: 'dashboard-user' })
  }

  next()
})

export default router