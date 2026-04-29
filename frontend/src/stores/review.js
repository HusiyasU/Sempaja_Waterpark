import { defineStore } from 'pinia'
import { ref } from 'vue'
import reviewService from '@/services/reviewService.js'

export const useReviewStore = defineStore('review', () => {
  // STATE
  const reviewList = ref([])
  const loading    = ref(false)
  const error      = ref(null)

  // ACTIONS
  async function fetchReview() {
    loading.value = true
    error.value   = null
    try {
      const res = await reviewService.getAll()
      if (res.success) {
        reviewList.value = res.data
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal memuat review'
    } finally {
      loading.value = false
    }
  }

  async function storeReview(data) {
    loading.value = true
    error.value   = null
    try {
      const res = await reviewService.store(data)
      if (res.success) {
        reviewList.value.unshift(res.data)
      }
      return res
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal mengirim review'
      throw err
    } finally {
      loading.value = false
    }
  }

  async function destroyReview(id) {
    try {
      const res = await reviewService.destroy(id)
      if (res.success) {
        reviewList.value = reviewList.value.filter(r => r.id !== id)
      }
      return res
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal menghapus review'
      throw err
    }
  }

  return {
    reviewList, loading, error,
    fetchReview, storeReview, destroyReview,
  }
})