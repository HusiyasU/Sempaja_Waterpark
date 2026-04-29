<template>
  <div class="dashboard-wrapper">

    <!-- NAVBAR -->
    <NavbarComponent />

    <!-- HERO -->
    <section id="user-hero">
      <div class="container">
        <div class="user-hero-content">
          <div class="user-avatar-wrap">
            <div class="user-avatar">{{ authStore.initials }}</div>
            <div>
              <span class="user-hello">Halo,</span>
              <h1 class="user-name">{{ authStore.fullName }}</h1>
              <span class="user-role">
                <i class="bi bi-person-check-fill me-1"></i>Pengunjung
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="user-hero-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0,120 L0,60 C200,20 400,90 600,50 C800,10 1000,70 1200,40 C1320,24 1400,50 1440,60 L1440,120 Z" fill="rgba(125,216,240,0.3)"/>
          <path d="M0,120 L0,85 C360,50 720,110 1080,80 C1260,65 1380,85 1440,80 L1440,120 Z" fill="#f8fbfd"/>
        </svg>
      </div>
    </section>

    <!-- MAIN -->
    <section id="user-main">
      <div class="container">
        <div class="row g-4">

          <!-- PROFIL -->
          <div class="col-lg-5">
            <div class="user-card h-100">
              <h3 class="user-card-title text-center text-lg-start">Profil Saya</h3>

              <div class="user-profile-avatar">{{ authStore.initials }}</div>

              <div v-if="!editMode" class="user-profile-info">
                <div class="profile-item">
                  <i class="bi bi-person-fill"></i>
                  <div>
                    <span class="profile-label">Nama Lengkap</span>
                    <span class="profile-val">{{ authStore.fullName }}</span>
                  </div>
                </div>
                <div class="profile-item">
                  <i class="bi bi-envelope-fill"></i>
                  <div>
                    <span class="profile-label">Email</span>
                    <span class="profile-val">{{ authStore.user?.email }}</span>
                  </div>
                </div>
                <div class="profile-item">
                  <i class="bi bi-telephone-fill"></i>
                  <div>
                    <span class="profile-label">Telepon</span>
                    <span class="profile-val">{{ authStore.user?.telepon || '-' }}</span>
                  </div>
                </div>
                <div class="profile-item">
                  <i class="bi bi-person-badge-fill"></i>
                  <div>
                    <span class="profile-label">Username</span>
                    <span class="profile-val">@{{ authStore.user?.username }}</span>
                  </div>
                </div>
                <div class="profile-item">
                  <i class="bi bi-calendar3"></i>
                  <div>
                    <span class="profile-label">Bergabung</span>
                    <span class="profile-val">{{ formatDate(authStore.user?.created_at) }}</span>
                  </div>
                </div>

                <button class="btn-edit-profil mt-3" @click="startEdit">
                  <i class="bi bi-pencil-fill me-2"></i>Edit Profil
                </button>
              </div>

              <!-- Form Edit -->
              <div v-else class="edit-form">
                <AlertMessage :show="!!editError"   type="error"   :message="editError"   @close="editError = ''" />
                <AlertMessage :show="!!editSuccess" type="success" :message="editSuccess" @close="editSuccess = ''" />

                <div class="edit-field">
                  <label class="edit-label">Nama Depan</label>
                  <input v-model="editForm.nama_depan" type="text" class="edit-input" placeholder="Nama depan">
                </div>
                <div class="edit-field">
                  <label class="edit-label">Nama Belakang</label>
                  <input v-model="editForm.nama_belakang" type="text" class="edit-input" placeholder="Nama belakang">
                </div>
                <div class="edit-field">
                  <label class="edit-label">Telepon</label>
                  <input v-model="editForm.telepon" type="tel" class="edit-input" placeholder="0812...">
                </div>
                <div class="edit-actions">
                  <button class="btn-edit-cancel" @click="cancelEdit">Batal</button>
                  <button class="btn-edit-save" :disabled="editLoading" @click="saveEdit">
                    <span v-if="editLoading" class="spinner-border spinner-border-sm me-1"></span>
                    Simpan
                  </button>
                </div>
              </div>

            </div>
          </div>

          <!-- REVIEW -->
          <div class="col-lg-7">
            <div class="user-card h-100">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="user-card-title mb-0">Review Saya</h3>
                <button class="btn-lihat-semua" @click="showModalReview = true">
                  + Tulis Review
                </button>
              </div>

              <LoadingSpinner v-if="reviewStore.loading" text="Memuat review..." />

              <div v-else-if="myReviews.length === 0" class="review-empty">
                <i class="bi bi-chat-square-text"></i>
                <p>Belum ada review. Bagikan pengalaman kunjungan Anda!</p>
              </div>

              <div v-else class="review-list">
                <div class="review-item" v-for="r in myReviews" :key="r.id">
                  <div class="review-header">
                    <span class="review-stars">
                      <i class="bi bi-star-fill" v-for="s in r.rating" :key="s"></i>
                      <i class="bi bi-star" v-for="s in (5 - r.rating)" :key="'e'+s"></i>
                    </span>
                    <span class="review-date">{{ formatDate(r.tanggal_kunjungan) }}</span>
                    <button class="btn-delete-review" @click="hapusReview(r.id)" title="Hapus review">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                  <p class="review-text">"{{ r.komentar }}"</p>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- MODAL TULIS REVIEW -->
    <Teleport to="body">
      <div v-if="showModalReview" class="modal-overlay" @click.self="showModalReview = false">
        <div class="modal-box">
          <div class="modal-box-header">
            <h5 class="modal-box-title">Tulis Review</h5>
            <button class="modal-box-close" @click="showModalReview = false">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
          <div class="modal-box-body">
            <AlertMessage :show="!!reviewError" type="error" :message="reviewError" @close="reviewError = ''" />

            <div class="edit-field">
              <label class="edit-label">Rating</label>
              <div class="star-picker">
                <button
                  v-for="s in 5" :key="s"
                  class="star-btn"
                  :class="{ active: reviewForm.rating >= s }"
                  @click="reviewForm.rating = s"
                >
                  <i class="bi bi-star-fill"></i>
                </button>
              </div>
            </div>
            <div class="edit-field">
              <label class="edit-label">Tanggal Kunjungan</label>
              <input v-model="reviewForm.tanggal_kunjungan" type="date" class="edit-input">
            </div>
            <div class="edit-field">
              <label class="edit-label">Komentar</label>
              <textarea v-model="reviewForm.komentar" class="edit-input" rows="4" placeholder="Ceritakan pengalaman kunjungan Anda..."></textarea>
            </div>
          </div>
          <div class="modal-box-footer">
            <button class="btn-edit-cancel" @click="showModalReview = false">Batal</button>
            <button class="btn-edit-save" :disabled="reviewLoading" @click="kirimReview">
              <span v-if="reviewLoading" class="spinner-border spinner-border-sm me-1"></span>
              Kirim Review
            </button>
          </div>
        </div>
      </div>
    </Teleport>

    <!-- FOOTER -->
    <FooterComponent />

  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import NavbarComponent  from '@/components/layout/NavbarComponent.vue'
import FooterComponent  from '@/components/layout/FooterComponent.vue'
import LoadingSpinner   from '@/components/common/LoadingSpinner.vue'
import AlertMessage     from '@/components/common/AlertMessage.vue'
import { useAuthStore }   from '@/stores/auth.js'
import { useReviewStore } from '@/stores/review.js'
import api from '@/services/api.js'

const authStore   = useAuthStore()
const reviewStore = useReviewStore()

// =====================
// PROFIL
// =====================
const editMode    = ref(false)
const editLoading = ref(false)
const editError   = ref('')
const editSuccess = ref('')

const editForm = reactive({
  nama_depan:    '',
  nama_belakang: '',
  telepon:       '',
})

function startEdit() {
  editForm.nama_depan    = authStore.user?.nama_depan    || ''
  editForm.nama_belakang = authStore.user?.nama_belakang || ''
  editForm.telepon       = authStore.user?.telepon       || ''
  editMode.value = true
}

function cancelEdit() {
  editMode.value = false
  editError.value = ''
}

async function saveEdit() {
  editLoading.value = true
  editError.value   = ''
  try {
    const res = await api.put('/user/profile', editForm)
    if (res.data.success) {
      authStore.user = { ...authStore.user, ...editForm }
      localStorage.setItem('user', JSON.stringify(authStore.user))
      editSuccess.value = 'Profil berhasil diperbarui!'
      editMode.value    = false
    }
  } catch (err) {
    editError.value = err.response?.data?.message || 'Gagal memperbarui profil'
  } finally {
    editLoading.value = false
  }
}

// =====================
// REVIEW
// =====================
const showModalReview = ref(false)
const reviewLoading   = ref(false)
const reviewError     = ref('')

const reviewForm = reactive({
  rating:           5,
  tanggal_kunjungan: '',
  komentar:         '',
})

const myReviews = computed(() =>
  reviewStore.reviewList.filter(r => r.user_id === authStore.user?.id)
)

async function kirimReview() {
  if (!reviewForm.komentar.trim()) {
    reviewError.value = 'Komentar wajib diisi'
    return
  }
  reviewLoading.value = true
  reviewError.value   = ''
  try {
    await reviewStore.storeReview({ ...reviewForm })
    showModalReview.value    = false
    reviewForm.komentar      = ''
    reviewForm.rating        = 5
    reviewForm.tanggal_kunjungan = ''
  } catch (err) {
    reviewError.value = err.response?.data?.message || 'Gagal mengirim review'
  } finally {
    reviewLoading.value = false
  }
}

async function hapusReview(id) {
  if (!confirm('Hapus review ini?')) return
  await reviewStore.destroyReview(id)
}

// =====================
// HELPER
// =====================
function formatDate(date) {
  if (!date) return '-'
  return new Date(date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
}

onMounted(() => reviewStore.fetchReview())
</script>

<style scoped>
.dashboard-wrapper { min-height: 100vh; background: #f8fbfd; }

/* HERO */
#user-hero {
  background: linear-gradient(135deg, #0a3d5c 0%, #1ea8d4 55%, #7dd8f0 100%);
  padding-top: 70px;
  position: relative; overflow: hidden;
  min-height: 35vh; display: flex; align-items: center;
}
.user-hero-content { padding: 40px 0 80px; }
.user-avatar-wrap  { display: flex; align-items: center; gap: 24px; }
.user-avatar {
  width: 72px; height: 72px;
  background: rgba(255,255,255,0.2);
  border: 3px solid rgba(255,255,255,0.5);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-family: 'Montserrat', sans-serif;
  font-size: 22px; font-weight: 800; color: #ffffff;
  flex-shrink: 0;
}
.user-hello { font-family: 'Open Sans', sans-serif; font-size: 14px; color: rgba(255,255,255,0.75); display: block; margin-bottom: 4px; }
.user-name  { font-family: 'Montserrat', sans-serif; font-size: clamp(22px,4vw,32px); font-weight: 800; color: #ffffff; margin: 0 0 8px; line-height: 1.1; }
.user-role  { font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #f5a623; background: rgba(245,166,35,0.15); border: 1px solid rgba(245,166,35,0.3); border-radius: 50px; padding: 4px 14px; display: inline-block; }
.user-hero-wave { position: absolute; bottom: 0; left: 0; width: 100%; line-height: 0; }
.user-hero-wave svg { width: 100%; height: 120px; display: block; }

/* MAIN */
#user-main { margin-top: -60px; position: relative; z-index: 10; padding-bottom: 80px; }

.user-card { background: #ffffff; border-radius: 20px; padding: 32px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
.user-card-title { font-family: 'Montserrat', sans-serif; font-size: 20px; font-weight: 700; color: #1D3461; margin-bottom: 24px; }

/* Avatar profil */
.user-profile-avatar {
  width: 80px; height: 80px;
  background: linear-gradient(135deg, #1ea8d4, #0a3d5c);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-family: 'Montserrat', sans-serif;
  font-size: 24px; font-weight: 800; color: #ffffff;
  margin: 0 auto 24px;
}

/* Profile info */
.user-profile-info { display: flex; flex-direction: column; gap: 16px; }
.profile-item { display: flex; align-items: flex-start; gap: 14px; }
.profile-item > i { font-size: 18px; color: #1ea8d4; margin-top: 2px; flex-shrink: 0; width: 20px; }
.profile-label { font-family: 'DM Sans', sans-serif; font-size: 11px; color: #aaa; text-transform: uppercase; letter-spacing: 0.5px; display: block; }
.profile-val   { font-family: 'Open Sans', sans-serif; font-size: 15px; color: #333; font-weight: 600; }

.btn-edit-profil {
  width: 100%; padding: 12px;
  background: #EAF6FF; color: #1ea8d4;
  border: none; border-radius: 12px;
  font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px;
  cursor: pointer; transition: all 0.25s ease;
  display: flex; align-items: center; justify-content: center;
}
.btn-edit-profil:hover { background: #1ea8d4; color: #ffffff; }

/* Edit form */
.edit-form { display: flex; flex-direction: column; gap: 16px; }
.edit-field { display: flex; flex-direction: column; gap: 6px; }
.edit-label { font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #1D3461; }
.edit-input {
  width: 100%; font-family: 'Open Sans', sans-serif; font-size: 14px; color: #333;
  background: #f8fbfd; border: 1.5px solid #e0e0e0; border-radius: 10px;
  padding: 10px 14px; outline: none; resize: vertical;
  transition: border-color 0.25s, box-shadow 0.25s;
}
.edit-input:focus { border-color: #1ea8d4; box-shadow: 0 0 0 3px rgba(30,168,212,0.12); background: #ffffff; }
.edit-actions { display: flex; gap: 10px; margin-top: 4px; }
.btn-edit-cancel {
  flex: 1; padding: 10px;
  background: transparent; color: #555;
  border: 1.5px solid #e0e0e0; border-radius: 10px;
  font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px;
  cursor: pointer; transition: all 0.2s;
}
.btn-edit-cancel:hover { background: #f8fbfd; }
.btn-edit-save {
  flex: 1; padding: 10px;
  background: #1ea8d4; color: #ffffff;
  border: none; border-radius: 10px;
  font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px;
  cursor: pointer; transition: all 0.25s;
  display: flex; align-items: center; justify-content: center;
}
.btn-edit-save:hover:not(:disabled) { background: #1D3461; }
.btn-edit-save:disabled { opacity: 0.7; cursor: not-allowed; }

/* Review */
.review-empty { text-align: center; padding: 40px 0; color: #aaa; }
.review-empty i { font-size: 40px; display: block; margin-bottom: 12px; }
.review-empty p { font-family: 'Open Sans', sans-serif; font-size: 15px; }

.review-list { display: flex; flex-direction: column; gap: 16px; }
.review-item { background: #f8fbfd; border-radius: 12px; border: 1.5px solid #eef2f7; padding: 16px 20px; transition: border-color 0.2s; }
.review-item:hover { border-color: #1ea8d4; }
.review-header { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; flex-wrap: wrap; }
.review-stars  { color: #f5a623; font-size: 15px; }
.review-date   { font-size: 12px; color: #aaa; margin-left: auto; }
.review-text   { font-size: 14px; color: #555; line-height: 1.6; margin: 0; font-style: italic; }

.btn-delete-review { background: transparent; border: none; color: #dc3545; cursor: pointer; font-size: 15px; padding: 0; transition: opacity 0.2s; }
.btn-delete-review:hover { opacity: 0.7; }

.btn-lihat-semua {
  font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600;
  color: #1ea8d4; background: #EAF6FF;
  border: none; border-radius: 50px;
  padding: 8px 20px; cursor: pointer; transition: all 0.25s ease;
}
.btn-lihat-semua:hover { background: #1ea8d4; color: #ffffff; }

/* Modal */
.modal-overlay {
  position: fixed; inset: 0;
  background: rgba(0,0,0,0.45);
  display: flex; align-items: center; justify-content: center;
  z-index: 9999; padding: 20px;
}
.modal-box {
  background: #ffffff; border-radius: 20px;
  width: 100%; max-width: 480px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.2);
  overflow: hidden;
}
.modal-box-header { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px 0; }
.modal-box-title  { font-family: 'Montserrat', sans-serif; font-size: 18px; font-weight: 700; color: #1D3461; margin: 0; }
.modal-box-close  { background: transparent; border: none; font-size: 18px; color: #aaa; cursor: pointer; transition: color 0.2s; }
.modal-box-close:hover { color: #1D3461; }
.modal-box-body   { padding: 20px 24px; display: flex; flex-direction: column; gap: 14px; }
.modal-box-footer { padding: 0 24px 24px; display: flex; gap: 10px; }

/* Star picker */
.star-picker { display: flex; gap: 8px; }
.star-btn { background: transparent; border: none; font-size: 24px; color: #e0e0e0; cursor: pointer; padding: 0; transition: color 0.15s, transform 0.15s; }
.star-btn.active { color: #f5a623; }
.star-btn:hover  { transform: scale(1.2); }

@media (max-width: 991.98px) {
  #user-main { margin-top: -40px; padding-bottom: 60px; }
  .user-card { padding: 20px; }
}
@media (max-width: 767.98px) {
  .user-avatar-wrap { flex-direction: column; align-items: flex-start; gap: 16px; }
  .user-name { font-size: 24px; }
}
</style>