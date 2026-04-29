<template>
  <div class="public-layout">
    <NavbarComponent />
    <main style="padding-top: 70px;">
      <slot />
    </main>
    <FooterComponent />

    <!-- FLOATING REVIEW BUTTON -->
    <div class="float-review-btn" @click="handleReviewClick" title="Tulis Review">
      <i class="bi bi-star-fill"></i>
      <span class="float-review-label">Review</span>
    </div>

    <!-- MODAL LOGIN REQUIRED -->
    <Teleport to="body">
      <Transition name="modal-fade">
        <div v-if="showLoginModal" class="modal-overlay" @click.self="showLoginModal = false">
          <div class="modal-review-box">
            <div class="modal-review-icon">
              <i class="bi bi-star-fill"></i>
            </div>
            <h5 class="modal-review-title">Tulis Review</h5>
            <p class="modal-review-desc">
              Bagikan pengalaman kunjungan Anda! Login terlebih dahulu untuk menulis review.
            </p>
            <div class="modal-review-actions">
              <RouterLink to="/login" class="btn-modal-login" @click="showLoginModal = false">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login Sekarang
              </RouterLink>
              <button class="btn-modal-cancel" @click="showLoginModal = false">
                Nanti Saja
              </button>
            </div>
            <button class="modal-close-btn" @click="showLoginModal = false">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
        </div>
      </Transition>
    </Teleport>

    <!-- MODAL TULIS REVIEW (sudah login) -->
    <Teleport to="body">
      <Transition name="modal-fade">
        <div v-if="showReviewModal" class="modal-overlay" @click.self="showReviewModal = false">
          <div class="modal-review-box modal-review-form">
            <div class="modal-review-header">
              <h5 class="modal-review-title">Tulis Review</h5>
              <button class="modal-close-btn-inline" @click="showReviewModal = false">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>

            <AlertMessage :show="!!reviewError"   type="error"   :message="reviewError"   @close="reviewError = ''" />
            <AlertMessage :show="!!reviewSuccess" type="success" :message="reviewSuccess" @close="reviewSuccess = ''" />

            <!-- Star Picker -->
            <div class="review-field">
              <label class="review-label">Rating</label>
              <div class="star-picker">
                <button
                  v-for="s in 5" :key="s"
                  class="star-btn"
                  :class="{ active: reviewForm.rating >= s }"
                  @click="reviewForm.rating = s"
                >
                  <i class="bi bi-star-fill"></i>
                </button>
                <span class="star-text">{{ starLabel }}</span>
              </div>
            </div>

            <div class="review-field">
              <label class="review-label">Tanggal Kunjungan</label>
              <input v-model="reviewForm.tanggal_kunjungan" type="date" class="review-input" :max="today">
            </div>

            <div class="review-field">
              <label class="review-label">Komentar</label>
              <textarea
                v-model="reviewForm.komentar"
                class="review-input"
                rows="4"
                placeholder="Ceritakan pengalaman kunjungan Anda..."
              ></textarea>
            </div>

            <div class="modal-review-actions">
              <button class="btn-modal-cancel" @click="showReviewModal = false">Batal</button>
              <button class="btn-modal-submit" :disabled="reviewLoading" @click="submitReview">
                <span v-if="reviewLoading" class="spinner-border spinner-border-sm me-1"></span>
                <i v-else class="bi bi-send-fill me-1"></i>
                Kirim Review
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>

  </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { RouterLink } from 'vue-router'
import NavbarComponent from '@/components/layout/NavbarComponent.vue'
import FooterComponent from '@/components/layout/FooterComponent.vue'
import AlertMessage    from '@/components/common/AlertMessage.vue'
import { useAuthStore }   from '@/stores/auth.js'
import { useReviewStore } from '@/stores/review.js'

const authStore   = useAuthStore()
const reviewStore = useReviewStore()

const showLoginModal  = ref(false)
const showReviewModal = ref(false)
const reviewLoading   = ref(false)
const reviewError     = ref('')
const reviewSuccess   = ref('')

const today = new Date().toISOString().split('T')[0]

const reviewForm = reactive({
  rating:            5,
  tanggal_kunjungan: '',
  komentar:          '',
})

const starLabel = computed(() => {
  const labels = ['', 'Buruk', 'Kurang', 'Cukup', 'Bagus', 'Sangat Bagus!']
  return labels[reviewForm.rating] || ''
})

function handleReviewClick() {
  if (!authStore.isLoggedIn) {
    showLoginModal.value = true
  } else {
    reviewForm.rating            = 5
    reviewForm.tanggal_kunjungan = ''
    reviewForm.komentar          = ''
    reviewError.value            = ''
    reviewSuccess.value          = ''
    showReviewModal.value = true
  }
}

async function submitReview() {
  if (!reviewForm.komentar.trim()) {
    reviewError.value = 'Komentar wajib diisi'
    return
  }
  reviewLoading.value = true
  reviewError.value   = ''
  try {
    await reviewStore.storeReview({ ...reviewForm })
    reviewSuccess.value = 'Review berhasil dikirim! Terima kasih 😊'
    reviewForm.komentar          = ''
    reviewForm.tanggal_kunjungan = ''
    reviewForm.rating            = 5
    setTimeout(() => {
      showReviewModal.value = false
      reviewSuccess.value   = ''
    }, 1800)
  } catch (err) {
    reviewError.value = err.response?.data?.message || 'Gagal mengirim review'
  } finally {
    reviewLoading.value = false
  }
}
</script>

<style scoped>
/* FLOATING BUTTON */
.float-review-btn {
  position: fixed;
  bottom: 32px;
  right: 32px;
  z-index: 1000;
  background: linear-gradient(135deg, #1D3461, #1ea8d4);
  color: #ffffff;
  border-radius: 50px;
  padding: 14px 22px;
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  box-shadow: 0 8px 24px rgba(29,52,97,0.35);
  transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  user-select: none;
}
.float-review-btn:hover {
  transform: translateY(-4px) scale(1.05);
  box-shadow: 0 12px 32px rgba(29,52,97,0.45);
}
.float-review-btn i { font-size: 18px; color: #f5a623; }
.float-review-label {
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  font-weight: 700;
  letter-spacing: 0.3px;
}

/* MODAL OVERLAY */
.modal-overlay {
  position: fixed; inset: 0;
  background: rgba(0,0,0,0.5);
  display: flex; align-items: center; justify-content: center;
  z-index: 9999; padding: 20px;
  backdrop-filter: blur(4px);
}

/* MODAL BOX */
.modal-review-box {
  background: #ffffff;
  border-radius: 24px;
  padding: 40px 36px;
  width: 100%;
  max-width: 420px;
  text-align: center;
  box-shadow: 0 24px 64px rgba(0,0,0,0.2);
  position: relative;
}

.modal-review-form {
  text-align: left;
  max-width: 480px;
}

/* Icon bintang di modal login */
.modal-review-icon {
  width: 72px; height: 72px;
  background: linear-gradient(135deg, #1D3461, #1ea8d4);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 20px;
  font-size: 28px;
  color: #f5a623;
}

.modal-review-title {
  font-family: 'Montserrat', sans-serif;
  font-size: 22px; font-weight: 800;
  color: #1D3461; margin-bottom: 12px;
}

.modal-review-desc {
  font-family: 'Open Sans', sans-serif;
  font-size: 15px; color: #666;
  line-height: 1.7; margin-bottom: 28px;
}

.modal-review-header {
  display: flex; align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}

.modal-review-header .modal-review-title { margin: 0; }

/* Buttons */
.modal-review-actions {
  display: flex; gap: 12px;
  margin-top: 24px;
}

.btn-modal-login {
  flex: 1;
  font-family: 'Inter', sans-serif; font-weight: 700; font-size: 15px;
  background: linear-gradient(135deg, #1D3461, #1ea8d4);
  color: #ffffff; border: none; border-radius: 12px;
  padding: 14px; text-decoration: none;
  display: flex; align-items: center; justify-content: center;
  transition: all 0.25s ease;
}
.btn-modal-login:hover { opacity: 0.9; transform: translateY(-2px); color: #ffffff; }

.btn-modal-cancel {
  flex: 1;
  font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px;
  background: transparent; color: #888;
  border: 1.5px solid #e0e0e0; border-radius: 12px;
  padding: 14px; cursor: pointer; transition: all 0.2s;
}
.btn-modal-cancel:hover { background: #f8fbfd; color: #555; }

.btn-modal-submit {
  flex: 1;
  font-family: 'Inter', sans-serif; font-weight: 700; font-size: 14px;
  background: #1D3461; color: #ffffff;
  border: none; border-radius: 12px;
  padding: 14px; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: all 0.25s ease;
}
.btn-modal-submit:hover:not(:disabled) { background: #0a3d5c; transform: translateY(-2px); }
.btn-modal-submit:disabled { opacity: 0.7; cursor: not-allowed; }

/* Close buttons */
.modal-close-btn {
  position: absolute; top: 16px; right: 16px;
  background: #f8fbfd; border: none; border-radius: 50%;
  width: 36px; height: 36px;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; font-size: 14px; color: #888;
  transition: all 0.2s;
}
.modal-close-btn:hover { background: #eee; color: #333; }

.modal-close-btn-inline {
  background: #f8fbfd; border: none; border-radius: 50%;
  width: 36px; height: 36px;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; font-size: 14px; color: #888;
  transition: all 0.2s; flex-shrink: 0;
}
.modal-close-btn-inline:hover { background: #eee; color: #333; }

/* Review Form Fields */
.review-field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
.review-label { font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #1D3461; }
.review-input {
  width: 100%; font-family: 'Open Sans', sans-serif; font-size: 14px; color: #333;
  background: #f8fbfd; border: 1.5px solid #e0e0e0; border-radius: 10px;
  padding: 11px 14px; outline: none; resize: vertical;
  transition: border-color 0.25s, box-shadow 0.25s;
}
.review-input:focus { border-color: #1ea8d4; box-shadow: 0 0 0 3px rgba(30,168,212,0.12); background: #ffffff; }

/* Star Picker */
.star-picker { display: flex; align-items: center; gap: 6px; }
.star-btn { background: transparent; border: none; font-size: 28px; color: #e0e0e0; cursor: pointer; padding: 0; transition: color 0.15s, transform 0.15s; }
.star-btn.active { color: #f5a623; }
.star-btn:hover  { transform: scale(1.2); }
.star-text { font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #f5a623; margin-left: 8px; }

/* Transition */
.modal-fade-enter-active, .modal-fade-leave-active { transition: all 0.3s ease; }
.modal-fade-enter-from, .modal-fade-leave-to { opacity: 0; transform: scale(0.95); }

@media (max-width: 575.98px) {
  .float-review-btn { bottom: 20px; right: 20px; padding: 12px 18px; }
  .float-review-label { display: none; }
  .float-review-btn { border-radius: 50%; width: 52px; height: 52px; justify-content: center; }
  .modal-review-box { padding: 28px 20px; }
}
</style>