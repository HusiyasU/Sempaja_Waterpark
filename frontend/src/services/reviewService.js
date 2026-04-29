import api from './api.js'

const reviewService = {
  async getAll() {
    const res = await api.get('/review')
    return res.data
  },

  async store(data) {
    const res = await api.post('/review', data)
    return res.data
  },

  async destroy(id) {
    const res = await api.delete(`/review/${id}`)
    return res.data
  },
}

export default reviewService