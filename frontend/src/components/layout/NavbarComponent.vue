<template>
  <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar" :class="{ 'navbar-scrolled': isScrolled }">
    <div class="container">

      <!-- Brand -->
      <RouterLink class="navbar-brand" to="/">
        <div class="brand-wrap">
          <div class="brand-icon">
            <img src="/img/LOGOIcon.svg" alt="Bumi Sempaja Logo" width="38" height="38">
          </div>
          <div class="brand-text">
            <span class="brand-top">Bumi Sempaja</span>
            <span class="brand-bottom">WATERPARK</span>
          </div>
        </div>
      </RouterLink>

      <!-- Toggler -->
      <button class="navbar-toggler" type="button"
        data-bs-toggle="collapse" data-bs-target="#navbarMain"
        aria-controls="navbarMain" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu -->
      <div class="collapse navbar-collapse" id="navbarMain">
        <div class="navbar-nav ms-auto">
          <RouterLink class="nav-link" to="/"             :class="{ active: route.name === 'home' }">Beranda</RouterLink>
          <RouterLink class="nav-link" to="/wahana"       :class="{ active: route.name === 'wahana' }">Wahana</RouterLink>
          <RouterLink class="nav-link" to="/harga-tiket"  :class="{ active: route.name === 'harga-tiket' }">Tiket & Harga</RouterLink>
          <RouterLink class="nav-link" to="/keselamatan"  :class="{ active: route.name === 'keselamatan' }">Keselamatan</RouterLink>
          <RouterLink class="nav-link" to="/tentang"      :class="{ active: route.name === 'tentang' }">Tentang Kami</RouterLink>
          <RouterLink class="nav-link" to="/kontak"       :class="{ active: route.name === 'kontak' }">Kontak</RouterLink>
        </div>

        <!-- Auth -->
        <div class="ms-lg-3">
          <!-- Belum login -->
          <RouterLink v-if="!authStore.isLoggedIn" to="/login" class="btn-navbar-login">
            <i class="bi bi-person-circle"></i>
          </RouterLink>

          <!-- Sudah login -->
          <div v-else class="dropdown">
            <button class="btn-navbar-user dropdown-toggle" type="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              <div class="navbar-avatar">{{ authStore.initials }}</div>
              <span class="navbar-username d-none d-lg-inline">{{ authStore.fullName }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end navbar-dropdown">
              <li>
                <RouterLink
                  class="dropdown-item"
                  :to="authStore.isAdmin ? '/admin' : '/dashboard'">
                  <i class="bi bi-grid-fill me-2"></i>Dashboard
                </RouterLink>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <button class="dropdown-item text-danger" @click="handleLogout">
                  <i class="bi bi-box-arrow-right me-2"></i>Keluar
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { RouterLink, useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth.js'

const route     = useRoute()
const router    = useRouter()
const authStore = useAuthStore()

// Scroll effect
const isScrolled = ref(false)
const handleScroll = () => { isScrolled.value = window.scrollY > 20 }
onMounted(() => window.addEventListener('scroll', handleScroll))
onUnmounted(() => window.removeEventListener('scroll', handleScroll))

// Logout
async function handleLogout() {
  await authStore.logout()
  router.push({ name: 'home' })
}
</script>

<style scoped>
#mainNavbar {
  background-color: #ffffff;
  box-shadow: 0 -5px 23.3px 4px rgba(0,0,0,0.25);
  padding: 12px 0;
  transition: all 0.3s ease;
}

#mainNavbar.navbar-scrolled {
  box-shadow: 0 4px 20px rgba(0,0,0,0.12);
  padding: 8px 0;
}

/* Auth buttons */
.btn-navbar-login {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px; height: 40px;
  border-radius: 50%;
  background-color: #EAF6FF;
  color: #1D3461;
  font-size: 22px;
  text-decoration: none;
  transition: all 0.25s ease;
}

.btn-navbar-login:hover {
  background-color: #1D3461;
  color: #ffffff;
}

.btn-navbar-user {
  display: flex;
  align-items: center;
  gap: 10px;
  background: transparent;
  border: 1.5px solid #e0e0e0;
  border-radius: 50px;
  padding: 6px 14px 6px 6px;
  cursor: pointer;
  transition: all 0.25s ease;
}

.btn-navbar-user:hover {
  border-color: #1D3461;
  background-color: #EAF6FF;
}

.navbar-avatar {
  width: 32px; height: 32px;
  border-radius: 50%;
  background: linear-gradient(135deg, #1ea8d4, #0a3d5c);
  color: #ffffff;
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
}

.navbar-username {
  font-family: 'Inter', sans-serif;
  font-size: 14px; font-weight: 500;
  color: #1D3461;
}

/* Dropdown */
.navbar-dropdown {
  border: 1.5px solid #e8e8e8;
  border-radius: 14px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
  padding: 8px;
  min-width: 180px;
}

.navbar-dropdown .dropdown-item {
  font-family: 'Inter', sans-serif;
  font-size: 14px; font-weight: 500;
  border-radius: 8px;
  padding: 10px 14px;
  transition: background 0.2s;
}

.navbar-dropdown .dropdown-item:hover {
  background-color: #EAF6FF;
  color: #1D3461;
}

.navbar-dropdown .dropdown-item.text-danger:hover {
  background-color: #ffeaea;
  color: #dc3545;
}
</style>