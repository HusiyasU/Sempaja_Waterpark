import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import authService from '@/services/authService.js'

export const useAuthStore = defineStore('auth', () => {
  // =====================
  // STATE
  // =====================
  const user  = ref(JSON.parse(localStorage.getItem('user')) || null)
  const token = ref(localStorage.getItem('token') || null)
  const loading = ref(false)
  const error   = ref(null)

  // =====================
  // GETTERS
  // =====================
  const isLoggedIn = computed(() => !!token.value && !!user.value)
  const isAdmin    = computed(() => user.value?.role === 'admin')
  const isUser     = computed(() => user.value?.role === 'user')
  const fullName   = computed(() => {
    if (!user.value) return ''
    return `${user.value.nama_depan ?? ''} ${user.value.nama_belakang ?? ''}`.trim()
  })
  const initials = computed(() => {
    const name = fullName.value
    if (!name) return '?'
    return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
  })

  // =====================
  // ACTIONS
  // =====================
  async function login(credentials) {
    loading.value = true
    error.value   = null
    try {
      const res = await authService.login(credentials)
      if (res.success) {
        token.value = res.data.token
        user.value  = res.data.user
        localStorage.setItem('token', res.data.token)
        localStorage.setItem('user',  JSON.stringify(res.data.user))
      }
      return res
    } catch (err) {
      error.value = err.response?.data?.message || 'Login gagal'
      throw err
    } finally {
      loading.value = false
    }
  }

  async function register(data) {
    loading.value = true
    error.value   = null
    try {
      const res = await authService.register(data)
      return res
    } catch (err) {
      error.value = err.response?.data?.message || 'Registrasi gagal'
      throw err
    } finally {
      loading.value = false
    }
  }

  async function logout() {
    try {
      await authService.logout()
    } catch (_) {
      // tetap logout meski API error
    } finally {
      token.value = null
      user.value  = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    }
  }

  async function checkAuth() {
    if (!token.value) return
    try {
      const res = await authService.me()
      if (res.success) {
        user.value = res.data
        localStorage.setItem('user', JSON.stringify(res.data))
      }
    } catch (_) {
      // Token tidak valid → logout
      await logout()
    }
  }

  return {
    user, token, loading, error,
    isLoggedIn, isAdmin, isUser, fullName, initials,
    login, register, logout, checkAuth,
  }
})