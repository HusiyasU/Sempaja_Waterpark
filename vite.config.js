import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

export default defineConfig({
  plugins: [vue()],

  // Root diarahkan ke folder frontend
  root: 'frontend',

  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./frontend/src', import.meta.url))
    }
  },

  server: {
    port: 5173,
    proxy: {
      '/api': {
        target: 'http://localhost/Sempaja_Waterpark',
        changeOrigin: true,
        secure: false
      }
    }
  },

  build: {
    // Output ke public/dist (relatif dari root: frontend/../public/dist)
    outDir: '../public/dist',
    emptyOutDir: true
  }
})