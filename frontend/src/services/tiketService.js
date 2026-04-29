import api from './api.js'

const tiketService = {
  async getAll() {
    const res = await api.get('/tiket')
    return res.data
  },

  async pesan(data) {
    const res = await api.post('/tiket/pesan', data)
    return res.data
  },

  async riwayat() {
    const res = await api.get('/tiket/riwayat')
    return res.data
  },
}

export default tiketService