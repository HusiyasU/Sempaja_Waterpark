<template>
  <div class="notfound-wrap">
    <div class="notfound-content">
      <div class="notfound-code">404</div>
      <h2 class="notfound-title">Halaman Tidak Ditemukan</h2>
      <p class="notfound-desc">Halaman yang kamu cari tidak ada atau sudah dipindahkan.</p>
      <RouterLink to="/" class="btn-notfound">
        <i class="bi bi-house-door me-2"></i>Kembali ke Beranda
      </RouterLink>
    </div>
  </div>
</template>

<script setup>
import { RouterLink } from 'vue-router'
</script>

<style scoped>
.notfound-wrap {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #0a3d5c 0%, #1ea8d4 55%, #7dd8f0 100%);
}

.notfound-content {
  text-align: center;
  padding: 40px 24px;
}

.notfound-code {
  font-family: 'Montserrat', sans-serif;
  font-size: clamp(80px, 15vw, 140px);
  font-weight: 800;
  color: rgba(255, 255, 255, 0.15);
  line-height: 1;
  margin-bottom: 16px;
}

.notfound-title {
  font-family: 'Montserrat', sans-serif;
  font-size: clamp(22px, 4vw, 32px);
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 12px;
}

.notfound-desc {
  font-family: 'Open Sans', sans-serif;
  font-size: 16px;
  color: rgba(255, 255, 255, 0.8);
  margin-bottom: 32px;
}

.btn-notfound {
  display: inline-flex;
  align-items: center;
  font-family: 'Inter', sans-serif;
  font-weight: 600;
  font-size: 15px;
  background-color: #ffffff;
  color: #1D3461;
  border-radius: 50px;
  padding: 14px 32px;
  text-decoration: none;
  transition: all 0.25s ease;
}

.btn-notfound:hover {
  background-color: #f5a623;
  color: #ffffff;
  transform: translateY(-2px);
}
</style>