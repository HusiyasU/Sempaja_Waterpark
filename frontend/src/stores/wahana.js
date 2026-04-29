import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import wahanaService from '@/services/wahanaService.js'

export const useWahanaStore = defineStore('wahana', () => {
  // STATE
  const wahanaList = ref([])
  const loading    = ref(false)
  const error      = ref(null)
  const filterAktif = ref('semua')

  // GETTERS
  const wahanaFiltered = computed(() => {
    if (filterAktif.value === 'semua') return wahanaList.value
    return wahanaList.value.filter(w => w.kategori === filterAktif.value)
  })

  // ACTIONS
  async function fetchWahana() {
    loading.value = true
    error.value   = null
    try {
      const res = await wahanaService.getAll()
      if (res.success) {
        wahanaList.value = res.data
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal memuat wahana'
    } finally {
      loading.value = false
    }
  }

  function setFilter(kategori) {
    filterAktif.value = kategori
  }

  return {
    wahanaList, loading, error, filterAktif,
    wahanaFiltered,
    fetchWahana, setFilter,
  }
})