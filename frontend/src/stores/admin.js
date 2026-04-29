import { defineStore } from 'pinia'
import { ref } from 'vue'
import adminService from '@/services/adminService.js'

export const useAdminStore = defineStore('admin', () => {
  // STATE
  const dashboard  = ref(null)
  const users      = ref([])
  const tiketList  = ref([])
  const wahanaList = ref([])
  const reviewList = ref([])
  const loading    = ref(false)
  const error      = ref(null)

  // =====================
  // DASHBOARD
  // =====================
  async function fetchDashboard() {
    loading.value = true
    error.value   = null
    try {
      const res = await adminService.getDashboard()
      if (res.success) dashboard.value = res.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal memuat dashboard'
    } finally {
      loading.value = false
    }
  }

  // =====================
  // USERS
  // =====================
  async function fetchUsers() {
    loading.value = true
    try {
      const res = await adminService.getUsers()
      if (res.success) users.value = res.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal memuat users'
    } finally {
      loading.value = false
    }
  }

  async function deleteUser(id) {
    try {
      const res = await adminService.deleteUser(id)
      if (res.success) users.value = users.value.filter(u => u.id !== id)
      return res
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal menghapus user'
      throw err
    }
  }

  // =====================
  // TIKET
  // =====================
  async function fetchTiket() {
    loading.value = true
    try {
      const res = await adminService.getTiket()
      if (res.success) tiketList.value = res.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal memuat tiket'
    } finally {
      loading.value = false
    }
  }

  async function updateTiket(id, data) {
    try {
      const res = await adminService.updateTiket(id, data)
      if (res.success) {
        const idx = tiketList.value.findIndex(t => t.id === id)
        if (idx !== -1) tiketList.value[idx] = { ...tiketList.value[idx], ...data }
      }
      return res
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal update tiket'
      throw err
    }
  }

  // =====================
  // WAHANA
  // =====================
  async function fetchWahana() {
    loading.value = true
    try {
      const res = await adminService.getWahana()
      if (res.success) wahanaList.value = res.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal memuat wahana'
    } finally {
      loading.value = false
    }
  }

  async function createWahana(data) {
    try {
      const res = await adminService.createWahana(data)
      if (res.success) wahanaList.value.push(res.data)
      return res
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal menambah wahana'
      throw err
    }
  }

  async function updateWahana(id, data) {
    try {
      const res = await adminService.updateWahana(id, data)
      if (res.success) {
        const idx = wahanaList.value.findIndex(w => w.id === id)
        if (idx !== -1) wahanaList.value[idx] = { ...wahanaList.value[idx], ...data }
      }
      return res
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal update wahana'
      throw err
    }
  }

  async function deleteWahana(id) {
    try {
      const res = await adminService.deleteWahana(id)
      if (res.success) wahanaList.value = wahanaList.value.filter(w => w.id !== id)
      return res
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal menghapus wahana'
      throw err
    }
  }

  // =====================
  // REVIEW
  // =====================
  async function fetchReview() {
    loading.value = true
    try {
      const res = await adminService.getReview()
      if (res.success) reviewList.value = res.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal memuat review'
    } finally {
      loading.value = false
    }
  }

  async function deleteReview(id) {
    try {
      const res = await adminService.deleteReview(id)
      if (res.success) reviewList.value = reviewList.value.filter(r => r.id !== id)
      return res
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal menghapus review'
      throw err
    }
  }

  return {
    dashboard, users, tiketList, wahanaList, reviewList,
    loading, error,
    fetchDashboard,
    fetchUsers, deleteUser,
    fetchTiket, updateTiket,
    fetchWahana, createWahana, updateWahana, deleteWahana,
    fetchReview, deleteReview,
  }
})