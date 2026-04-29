<template>
  <div class="login-wrapper">
    <div class="login-left">
      <div class="login-left-content">
        <RouterLink to="/" class="brand-wrap">
          <div class="brand-icon">
            <img src="/img/LOGOIcon.svg" alt="Bumi Sempaja Logo" width="38" height="38">
          </div>
          <div class="brand-text">
            <span class="brand-top">Bumi Sempaja</span>
            <span class="brand-bottom">WATERPARK</span>
          </div>
        </RouterLink>
        <div class="login-left-body">
          <h1 class="login-left-title">Selamat Datang<br>Kembali!</h1>
          <p class="login-left-desc">Masuk untuk mengakses seluruh fitur sistem waterpark</p>
          <div class="login-features">
            <div class="login-feature-item">
              <div class="login-feature-icon"><i class="bi bi-ticket-perforated-fill"></i></div>
              <span>Kelola Tiket & Reservasi</span>
            </div>
            <div class="login-feature-item">
              <div class="login-feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
              <span>Laporan Pengunjung</span>
            </div>
            <div class="login-feature-item">
              <div class="login-feature-icon"><i class="bi bi-gear-fill"></i></div>
              <span>Manajemen Wahana</span>
            </div>
          </div>
        </div>
        <div class="login-left-wave">
          <svg viewBox="0 0 400 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,120 L0,80 C80,40 160,100 240,60 C320,20 380,70 400,60 L400,120 Z" fill="rgba(255,255,255,0.08)"/>
            <path d="M0,120 L0,95 C100,65 200,110 300,85 C350,72 380,88 400,82 L400,120 Z" fill="rgba(255,255,255,0.06)"/>
          </svg>
        </div>
      </div>
    </div>
    <div class="login-right">
      <div class="login-form-wrap">
        <div class="login-form-header">
          <h2 class="login-form-title">Masuk ke Akun</h2>
          <p class="login-form-subtitle">Masukkan kredensial Anda untuk melanjutkan</p>
        </div>
        <AlertMessage :show="!!errorMsg" type="error" :message="errorMsg" @close="errorMsg = ''" />
        <div class="login-form">
          <div class="form-group-login">
            <label class="form-label-login">Username atau Email</label>
            <div class="form-input-wrap">
              <i class="bi bi-person form-input-icon"></i>
              <input v-model="form.login" type="text" class="form-input-login" :class="{ 'input-error': errors.login }" placeholder="Masukkan username atau email" @keyup.enter="handleLogin">
            </div>
            <span v-if="errors.login" class="input-error-msg">{{ errors.login }}</span>
          </div>
          <div class="form-group-login">
            <div class="form-label-row">
              <label class="form-label-login">Password</label>
              <a href="#" class="form-forgot">Lupa password?</a>
            </div>
            <div class="form-input-wrap">
              <i class="bi bi-lock form-input-icon"></i>
              <input v-model="form.password" :type="showPassword ? 'text' : 'password'" class="form-input-login" :class="{ 'input-error': errors.password }" placeholder="Masukkan password" @keyup.enter="handleLogin">
              <button type="button" class="form-input-toggle" @click="showPassword = !showPassword">
                <i class="bi" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
              </button>
            </div>
            <span v-if="errors.password" class="input-error-msg">{{ errors.password }}</span>
          </div>
          <div class="form-remember">
            <label class="remember-label">
              <input v-model="form.remember" type="checkbox" class="remember-check">
              <span>Ingat saya</span>
            </label>
          </div>
          <button type="button" class="btn-login" :disabled="authStore.loading" @click="handleLogin">
            <span v-if="authStore.loading" class="spinner-border spinner-border-sm me-2"></span>
            <i v-else class="bi bi-box-arrow-in-right me-2"></i>
            {{ authStore.loading ? 'Memproses...' : 'Masuk' }}
          </button>
          <div class="login-divider"><span>atau</span></div>
          <RouterLink to="/" class="btn-login-back">
            <i class="bi bi-house-door me-2"></i>Kembali ke Halaman Utama
          </RouterLink>
          <div class="login-register-link">
            Belum punya akun? <RouterLink to="/register">Daftar Sekarang</RouterLink>
          </div>
        </div>
        <p class="login-form-footer">© 2025 Bumi Sempaja Waterpark. All rights reserved.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { RouterLink, useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth.js'
import AlertMessage from '@/components/common/AlertMessage.vue'

const router    = useRouter()
const route     = useRoute()
const authStore = useAuthStore()

const showPassword = ref(false)
const errorMsg     = ref('')

const form = reactive({ login: '', password: '', remember: false })
const errors = reactive({ login: '', password: '' })

function validate() {
  errors.login = ''; errors.password = ''
  let valid = true
  if (!form.login.trim())  { errors.login    = 'Username atau email wajib diisi'; valid = false }
  if (!form.password)      { errors.password = 'Password wajib diisi';            valid = false }
  return valid
}

async function handleLogin() {
  if (!validate()) return
  errorMsg.value = ''
  try {
    const res = await authStore.login({ login: form.login, password: form.password })
    if (res.success) {
      const role = res.data?.user?.role
      const redirect = route.query.redirect
      if (redirect) return router.push(redirect)
      if (role === 'admin') router.push({ name: 'dashboard-admin' })
      else router.push({ name: 'dashboard-user' })
    }
  } catch (err) {
    errorMsg.value = err.response?.data?.message || 'Login gagal, periksa kembali kredensial Anda'
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400&display=swap');
.login-wrapper { display: flex; min-height: 100vh; }
.login-left { width: 45%; background: linear-gradient(135deg, #0a3d5c 0%, #1ea8d4 60%, #7dd8f0 100%); position: relative; overflow: hidden; display: flex; align-items: stretch; }
.login-left::before { content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('/img/bg-waterpark.jpg'); background-size: cover; background-position: center; filter: blur(4px); opacity: 0.25; z-index: 1; }
.login-left-content { display: flex; flex-direction: column; padding: 48px 52px; width: 100%; position: relative; z-index: 5; }
.brand-wrap  { display: flex; align-items: center; gap: 12px; text-decoration: none; margin-bottom: auto; }
.brand-icon  { width: 42px; height: 42px; border-radius: 50%; overflow: hidden; flex-shrink: 0; }
.brand-text  { display: flex; flex-direction: column; line-height: 1.1; }
.brand-top   { font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.8); letter-spacing: 1px; text-transform: uppercase; }
.brand-bottom{ font-family: 'Montserrat', sans-serif; font-size: 18px; font-weight: 700; color: #ffffff; }
.login-left-body { margin-top: auto; margin-bottom: 48px; }
.login-left-title { font-family: 'Montserrat', sans-serif; font-size: clamp(28px, 3vw, 40px); font-weight: 800; color: #ffffff; line-height: 1.2; margin-bottom: 16px; }
.login-left-desc  { font-family: 'Open Sans', sans-serif; font-size: 15px; color: rgba(255,255,255,0.8); line-height: 1.7; margin-bottom: 32px; }
.login-features { display: flex; flex-direction: column; gap: 16px; }
.login-feature-item { display: flex; align-items: center; gap: 14px; font-family: 'Open Sans', sans-serif; font-size: 14px; color: rgba(255,255,255,0.9); }
.login-feature-icon { width: 38px; height: 38px; background: rgba(255,255,255,0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #ffffff; flex-shrink: 0; }
.login-left-wave { position: absolute; bottom: 0; left: 0; width: 100%; line-height: 0; z-index: 6; }
.login-left-wave svg { width: 100%; height: 120px; display: block; }
.login-right { width: 55%; display: flex; align-items: center; justify-content: center; padding: 48px 40px; background-color: #ffffff; }
.login-form-wrap { width: 100%; max-width: 420px; display: flex; flex-direction: column; }
.login-form-header { margin-bottom: 28px; }
.login-form-title  { font-family: 'Montserrat', sans-serif; font-size: 28px; font-weight: 800; color: #1D3461; margin-bottom: 8px; }
.login-form-subtitle { font-family: 'Open Sans', sans-serif; font-size: 14px; color: #888888; margin: 0; }
.login-form { display: flex; flex-direction: column; gap: 20px; }
.form-group-login { display: flex; flex-direction: column; gap: 8px; }
.form-label-row   { display: flex; align-items: center; justify-content: space-between; }
.form-label-login { font-family: 'Inter', sans-serif; font-size: 14px; font-weight: 500; color: #1D3461; }
.form-forgot      { font-family: 'Inter', sans-serif; font-size: 13px; color: #1ea8d4; text-decoration: none; }
.form-input-wrap  { position: relative; display: flex; align-items: center; }
.form-input-icon  { position: absolute; left: 14px; font-size: 17px; color: #aaaaaa; pointer-events: none; }
.form-input-login { width: 100%; font-family: 'Open Sans', sans-serif; font-size: 14px; color: #333333; background-color: #f8fbfd; border: 1.5px solid #e0e0e0; border-radius: 10px; padding: 13px 16px 13px 44px; outline: none; transition: border-color 0.25s ease, box-shadow 0.25s ease; }
.form-input-login:focus { border-color: #1ea8d4; box-shadow: 0 0 0 3px rgba(30,168,212,0.12); background-color: #ffffff; }
.form-input-login.input-error { border-color: #dc3545; }
.input-error-msg { font-family: 'Open Sans', sans-serif; font-size: 12px; color: #dc3545; }
.form-input-toggle { position: absolute; right: 14px; background: transparent; border: none; font-size: 17px; color: #aaaaaa; cursor: pointer; padding: 0; }
.form-remember { display: flex; align-items: center; }
.remember-label { display: flex; align-items: center; gap: 10px; font-family: 'Open Sans', sans-serif; font-size: 14px; color: #555555; cursor: pointer; }
.remember-check { width: 16px; height: 16px; accent-color: #1ea8d4; cursor: pointer; }
.btn-login { font-family: 'Inter', sans-serif; font-weight: 600; font-size: 15px; background-color: #1D3461; color: #ffffff; border: none; border-radius: 10px; padding: 14px; width: 100%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.25s ease, transform 0.2s ease; }
.btn-login:hover:not(:disabled) { background-color: #0a3d5c; transform: translateY(-2px); }
.btn-login:disabled { opacity: 0.7; cursor: not-allowed; }
.login-divider { display: flex; align-items: center; gap: 16px; font-family: 'Open Sans', sans-serif; font-size: 13px; color: #cccccc; }
.login-divider::before, .login-divider::after { content: ''; flex: 1; height: 1px; background: #e8e8e8; }
.btn-login-back { font-family: 'Inter', sans-serif; font-weight: 500; font-size: 14px; color: #1D3461; border: 1.5px solid #e0e0e0; border-radius: 10px; padding: 12px; text-decoration: none; width: 100%; display: flex; align-items: center; justify-content: center; transition: all 0.25s ease; }
.btn-login-back:hover { border-color: #1D3461; background-color: #EAF6FF; color: #1D3461; }
.login-register-link { text-align: center; font-family: 'Open Sans', sans-serif; font-size: 14px; color: #555555; }
.login-register-link a { color: #1ea8d4; text-decoration: none; font-weight: 600; }
.login-form-footer { font-family: 'DM Sans', sans-serif; font-size: 12px; color: #cccccc; text-align: center; margin-top: 40px; }
@media (max-width: 991.98px) { .login-wrapper { flex-direction: column; } .login-left { width: 100%; min-height: 40vh; } .login-right { width: 100%; padding: 48px 24px; } }
@media (max-width: 575.98px) { .login-left-content { padding: 28px 20px; } .login-right { padding: 36px 20px; } }
</style>