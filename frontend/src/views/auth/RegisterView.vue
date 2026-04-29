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
          <h1 class="login-left-title">Bergabung<br>Bersama Kami!</h1>
          <p class="login-left-desc">Daftarkan akun Anda untuk mulai menikmati layanan waterpark.</p>

          <div class="login-features">
            <div class="login-feature-item">
              <div class="login-feature-icon"><i class="bi bi-person-check-fill"></i></div>
              <span>Akun Pribadi Terverifikasi</span>
            </div>
            <div class="login-feature-item">
              <div class="login-feature-icon"><i class="bi bi-lock-fill"></i></div>
              <span>Data Aman & Terenkripsi</span>
            </div>
            <div class="login-feature-item">
              <div class="login-feature-icon"><i class="bi bi-lightning-charge-fill"></i></div>
              <span>Akses Cepat & Mudah</span>
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
      <div class="login-form-wrap register-form-wrap">

        <div class="login-form-header">
          <h2 class="login-form-title">Buat Akun Baru</h2>
          <p class="login-form-subtitle">Isi data di bawah untuk mendaftarkan akun Anda</p>
        </div>

        <AlertMessage :show="!!errorMsg"   type="error"   :message="errorMsg"   @close="errorMsg = ''" />
        <AlertMessage :show="!!successMsg" type="success" :message="successMsg" @close="successMsg = ''" />

        <div class="login-form">
          <div class="row g-3">
            
            <div class="col-md-6">
              <div class="form-group-login">
                <label class="form-label-login">Nama Depan</label>
                <div class="form-input-wrap">
                  <i class="bi bi-person form-input-icon"></i>
                  <input v-model="form.nama_depan" type="text" class="form-input-login" :class="{ 'input-error': errors.nama_depan }" placeholder="Nama depan">
                </div>
                <span v-if="errors.nama_depan" class="input-error-msg">{{ errors.nama_depan }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group-login">
                <label class="form-label-login">Nama Belakang</label>
                <div class="form-input-wrap">
                  <i class="bi bi-person form-input-icon"></i>
                  <input v-model="form.nama_belakang" type="text" class="form-input-login" placeholder="Nama belakang">
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group-login">
                <label class="form-label-login">Username</label>
                <div class="form-input-wrap">
                  <i class="bi bi-at form-input-icon"></i>
                  <input v-model="form.username" type="text" class="form-input-login" :class="{ 'input-error': errors.username }" placeholder="Masukkan username">
                </div>
                <span v-if="errors.username" class="input-error-msg">{{ errors.username }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group-login">
                <label class="form-label-login">Email</label>
                <div class="form-input-wrap">
                  <i class="bi bi-envelope form-input-icon"></i>
                  <input v-model="form.email" type="email" class="form-input-login" :class="{ 'input-error': errors.email }" placeholder="Email">
                </div>
                <span v-if="errors.email" class="input-error-msg">{{ errors.email }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group-login">
                <label class="form-label-login">Nomor Telepon</label>
                <div class="form-input-wrap">
                  <i class="bi bi-telephone form-input-icon"></i>
                  <input v-model="form.telepon" type="tel" class="form-input-login" placeholder="0812...">
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group-login">
                <label class="form-label-login">Password</label>
                <div class="form-input-wrap">
                  <i class="bi bi-lock form-input-icon"></i>
                  <input v-model="form.password" :type="showPass ? 'text' : 'password'" class="form-input-login" :class="{ 'input-error': errors.password }" placeholder="Minimal 8 karakter">
                  <button type="button" class="form-input-toggle" @click="showPass = !showPass">
                    <i class="bi" :class="showPass ? 'bi-eye-slash' : 'bi-eye'"></i>
                  </button>
                </div>
                <div class="password-strength">
                  <div class="strength-bar"><div class="strength-fill" :style="{ width: strengthWidth, backgroundColor: strengthColor }"></div></div>
                  <span class="strength-label" :style="{ color: strengthColor }">{{ strengthLabel }}</span>
                </div>
                <span v-if="errors.password" class="input-error-msg">{{ errors.password }}</span>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group-login">
                <label class="form-label-login">Konfirmasi Password</label>
                <div class="form-input-wrap">
                  <i class="bi bi-lock-fill form-input-icon"></i>
                  <input v-model="form.password_confirmation" :type="showConfirm ? 'text' : 'password'" class="form-input-login" :class="{ 'input-error': errors.password_confirmation }" placeholder="Ulangi password">
                  <button type="button" class="form-input-toggle" @click="showConfirm = !showConfirm">
                    <i class="bi" :class="showConfirm ? 'bi-eye-slash' : 'bi-eye'"></i>
                  </button>
                </div>
                <span v-if="errors.password_confirmation" class="input-error-msg">{{ errors.password_confirmation }}</span>
              </div>
            </div>

            <div class="col-12">
              <div class="form-syarat">
                <label class="remember-label">
                  <input v-model="form.syarat" type="checkbox" class="remember-check">
                  <span>Saya menyetujui <a href="#" class="form-forgot">Syarat & Ketentuan</a></span>
                </label>
                <span v-if="errors.syarat" class="input-error-msg d-block mt-1">{{ errors.syarat }}</span>
              </div>
            </div>

            <div class="col-12">
              <button type="button" class="btn-login" :disabled="authStore.loading" @click="handleRegister">
                <span v-if="authStore.loading" class="spinner-border spinner-border-sm me-2"></span>
                <i v-else class="bi bi-person-plus-fill me-2"></i>
                {{ authStore.loading ? 'Memproses...' : 'Daftar Sekarang' }}
              </button>
            </div>

            <div class="col-12">
              <RouterLink to="/login" class="btn-login-back">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sudah punya akun? Masuk
              </RouterLink>
            </div>

          </div>
        </div>

        <p class="login-form-footer">© 2025 Bumi Sempaja Waterpark. All rights reserved.</p>

      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth.js'
import AlertMessage from '@/components/common/AlertMessage.vue'

const router    = useRouter()
const authStore = useAuthStore()

const showPass    = ref(false)
const showConfirm = ref(false)
const errorMsg    = ref('')
const successMsg  = ref('')

const form = reactive({
  nama_depan:            '',
  nama_belakang:         '',
  username:              '',
  email:                 '',
  telepon:               '',
  password:              '',
  password_confirmation: '',
  syarat:                false,
})

const errors = reactive({
  nama_depan:            '',
  username:              '',
  email:                 '',
  password:              '',
  password_confirmation: '',
  syarat:                '',
})

const strengthLevel = computed(() => {
  const val = form.password
  if (!val) return 0
  let s = 0
  if (val.length >= 8) s++
  if (/[A-Z]/.test(val)) s++
  if (/[0-9]/.test(val)) s++
  return s
})

const strengthWidth = computed(() => ['0%','33%','66%','100%'][strengthLevel.value])
const strengthColor = computed(() => ['#e0e0e0','#dc3545','#f5a623','#28a745'][strengthLevel.value])
const strengthLabel = computed(() => ['','Lemah','Sedang','Kuat'][strengthLevel.value])

function validate() {
  Object.keys(errors).forEach(k => errors[k] = '')
  let valid = true
  if (!form.nama_depan.trim()) { errors.nama_depan = 'Wajib diisi'; valid = false }
  if (!form.username.trim())   { errors.username   = 'Wajib diisi';   valid = false }
  if (!form.email.trim())      { errors.email      = 'Wajib diisi';      valid = false }
  if (!form.password)           { errors.password   = 'Wajib diisi';   valid = false }
  else if (form.password.length < 8) { errors.password = 'Minimal 8 karakter'; valid = false }
  if (form.password !== form.password_confirmation) { errors.password_confirmation = 'Tidak cocok'; valid = false }
  if (!form.syarat) { errors.syarat = 'Wajib disetujui'; valid = false }
  return valid
}

async function handleRegister() {
  if (!validate()) return
  errorMsg.value  = ''
  successMsg.value = ''

  try {
    const res = await authStore.register({ ...form })
    if (res.success) {
      successMsg.value = 'Registrasi berhasil! Mengalihkan...'
      setTimeout(() => router.push({ name: 'login' }), 1500)
    }
  } catch (err) {
    errorMsg.value = err.response?.data?.message || 'Registrasi gagal.'
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400&display=swap');

.login-wrapper { display: flex; min-height: 100vh; }

.login-left {
  width: 45%;
  background: linear-gradient(135deg, #0a3d5c 0%, #1ea8d4 60%, #7dd8f0 100%);
  position: relative; overflow: hidden; display: flex; align-items: stretch;
}

/* Mengarah ke public/img/ */
.login-left::before {
  content: "";
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background-image: url('/img/bg-waterpark.jpg');
  background-size: cover;
  background-position: center;
  filter: blur(4px);
  opacity: 0.25;
  z-index: 1;
}

.login-left-content { display: flex; flex-direction: column; padding: 48px 52px; width: 100%; position: relative; z-index: 5; }
.brand-wrap  { display: flex; align-items: center; gap: 12px; text-decoration: none; margin-bottom: auto; }
.brand-icon  { width: 42px; height: 42px; border-radius: 50%; overflow: hidden; flex-shrink: 0; }
.brand-top   { font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.8); text-transform: uppercase; }
.brand-bottom{ font-family: 'Montserrat', sans-serif; font-size: 18px; font-weight: 700; color: #ffffff; }

.login-left-body { margin-top: auto; margin-bottom: 48px; }
.login-left-title { font-family: 'Montserrat', sans-serif; font-size: clamp(28px, 3vw, 40px); font-weight: 800; color: #ffffff; line-height: 1.2; margin-bottom: 16px; }
.login-left-desc  { font-size: 15px; color: rgba(255,255,255,0.8); line-height: 1.7; margin-bottom: 32px; }

.login-features { display: flex; flex-direction: column; gap: 16px; }
.login-feature-item { display: flex; align-items: center; gap: 14px; font-size: 14px; color: rgba(255,255,255,0.9); }
.login-feature-icon { width: 38px; height: 38px; background: rgba(255,255,255,0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #ffffff; }

.login-left-wave { position: absolute; bottom: 0; left: 0; width: 100%; z-index: 6; }
.login-left-wave svg { width: 100%; height: 120px; display: block; }

.login-right { width: 55%; display: flex; align-items: center; justify-content: center; padding: 40px; background-color: #ffffff; overflow-y: auto; }
.login-form-wrap { width: 100%; max-width: 480px; }
.login-form-header { margin-bottom: 24px; }
.login-form-title  { font-family: 'Montserrat', sans-serif; font-size: 26px; font-weight: 800; color: #1D3461; margin-bottom: 8px; }

.login-form { display: flex; flex-direction: column; gap: 4px; }
.form-group-login { display: flex; flex-direction: column; gap: 6px; }
.form-label-login { font-family: 'Inter', sans-serif; font-size: 14px; font-weight: 500; color: #1D3461; }
.form-input-wrap  { position: relative; display: flex; align-items: center; }
.form-input-icon  { position: absolute; left: 14px; color: #aaaaaa; pointer-events: none; }
.form-input-login { width: 100%; font-size: 14px; background: #f8fbfd; border: 1.5px solid #e0e0e0; border-radius: 10px; padding: 11px 16px 11px 44px; outline: none; }
.form-input-login:focus { border-color: #1ea8d4; background: #ffffff; }
.form-input-login.input-error { border-color: #dc3545; }
.input-error-msg { font-size: 12px; color: #dc3545; }
.form-input-toggle { position: absolute; right: 14px; background: transparent; border: none; color: #aaaaaa; cursor: pointer; }

.password-strength { display: flex; align-items: center; gap: 10px; margin-top: 4px; }
.strength-bar { flex: 1; height: 4px; background: #e2e8f0; border-radius: 10px; }
.strength-fill { height: 100%; border-radius: 10px; transition: width 0.3s; }
.strength-label { font-size: 11px; }

.form-syarat { padding: 10px 12px; background: #f1f5f9; border-radius: 8px; border-left: 3px solid #1ea8d4; }
.remember-label { display: flex; align-items: flex-start; gap: 8px; font-size: 13px; color: #555; cursor: pointer; }
.remember-check { width: 14px; height: 14px; accent-color: #1ea8d4; margin-top: 2px; }

.btn-login { font-family: 'Inter', sans-serif; font-weight: 600; background-color: #1D3461; color: #ffffff; border: none; border-radius: 10px; padding: 13px; width: 100%; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.btn-login-back { font-family: 'Inter', sans-serif; font-weight: 500; font-size: 14px; color: #1D3461; border: 1.5px solid #e0e0e0; border-radius: 10px; padding: 11px; text-decoration: none; width: 100%; display: flex; align-items: center; justify-content: center; }

.login-form-footer { font-family: 'DM Sans', sans-serif; font-size: 12px; color: #cccccc; text-align: center; margin-top: 32px; }

@media (max-width: 991.98px) {
  .login-wrapper { flex-direction: column; }
  .login-left  { width: 100%; min-height: 35vh; }
  .login-right { width: 100%; padding: 40px 24px; }
}
</style>