import api from './api.js'

const wahanaService = {
  async getAll() {
    const res = await api.get('/wahana')
    return res.data
  },

  async getById(id) {
    const res = await api.get(`/wahana/${id}`)
    return res.data
  },
}

export default wahanaService