import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost/Sempaja_Waterpark/api',
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials: false,
})

// REQUEST INTERCEPTOR - Tambah token JWT
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => Promise.reject(error)
)

// RESPONSE INTERCEPTOR - Handle error global
api.interceptors.response.use(
  (response) => response,
  (error) => {
    const status = error.response?.status

    if (status === 401) {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      window.location.href = '/login'
    }

    if (status === 403) {
      console.warn('Akses ditolak.')
    }

    if (status === 500) {
      console.error('Server error:', error.response?.data?.message)
    }

    return Promise.reject(error)
  }
)

export default api