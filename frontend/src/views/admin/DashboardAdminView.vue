<template>
  <div class="dashboard-wrapper">

    <NavbarComponent />

    <!-- HERO -->
    <section id="admin-hero">
      <div class="container">
        <div class="py-4">
          <span class="hero-label">Panel Admin</span>
          <h1 class="hero-title">Dashboard Admin<br>Bumi Sempaja Waterpark</h1>
        </div>
      </div>
      <div class="hero-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0,120 L0,60 C200,20 400,90 600,50 C800,10 1000,70 1200,40 C1320,24 1400,50 1440,60 L1440,120 Z" fill="rgba(125,216,240,0.3)"/>
          <path d="M0,120 L0,85 C360,50 720,110 1080,80 C1260,65 1380,85 1440,80 L1440,120 Z" fill="#f8fbfd"/>
        </svg>
      </div>
    </section>

    <!-- MAIN -->
    <section id="admin-main">
      <div class="container">

        <!-- STAT CARDS (hanya 2) -->
        <div class="row g-3 mb-4">
          <div class="col-6">
            <div class="stat-card">
              <div class="stat-icon" style="background:#EAF6FF;color:#1ea8d4;">
                <i class="bi bi-people-fill"></i>
              </div>
              <div class="stat-info">
                <span class="stat-number">{{ dashboard?.total_users ?? '—' }}</span>
                <span class="stat-label">Total Pengguna</span>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="stat-card">
              <div class="stat-icon" style="background:#fdecea;color:#dc3545;">
                <i class="bi bi-chat-square-text-fill"></i>
              </div>
              <div class="stat-info">
                <span class="stat-number">{{ dashboard?.total_review ?? '—' }}</span>
                <span class="stat-label">Total Review</span>
              </div>
            </div>
          </div>
        </div>

        <!-- TABS -->
        <ul class="nav admin-tabs mb-4">
          <li class="nav-item" v-for="tab in tabs" :key="tab.key">
            <button
              class="nav-link"
              :class="{ active: activeTab === tab.key }"
              @click="switchTab(tab.key)"
            >
              <i class="bi me-1" :class="tab.icon"></i>
              {{ tab.label }}
              <span v-if="tab.key === 'pesan' && pesanBelumDibaca > 0" class="badge-notif">
                {{ pesanBelumDibaca }}
              </span>
            </button>
          </li>
        </ul>

        <!-- ===== TAB: PESAN ===== -->
        <div v-if="activeTab === 'pesan'" class="admin-card">
          <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h5 class="card-title-custom">
              Kotak Pesan
              <span v-if="pesanBelumDibaca > 0" class="badge-notif ms-2">{{ pesanBelumDibaca }} belum dibaca</span>
            </h5>
            <button class="btn-refresh-custom" @click="loadPesan">
              <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
          </div>

          <LoadingSpinner v-if="loadingPesan" />

          <div v-else-if="pesanList.length === 0" class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Belum ada pesan masuk</p>
          </div>

          <div v-else class="pesan-list">
            <div
              v-for="p in pesanList"
              :key="p.id"
              class="pesan-item"
              :class="{ 'pesan-unread': p.status === 'belum_dibaca' }"
            >
              <div class="pesan-header">
                <div class="pesan-meta">
                  <div class="pesan-avatar">{{ p.nama[0] }}</div>
                  <div>
                    <span class="pesan-nama">{{ p.nama }}</span>
                    <span class="pesan-email">{{ p.email }}</span>
                  </div>
                </div>
                <div class="pesan-right">
                  <span class="pesan-status" :class="p.status === 'belum_dibaca' ? 'status-unread' : 'status-read'">
                    {{ p.status === 'belum_dibaca' ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                  </span>
                  <span class="pesan-tanggal">{{ formatDate(p.created_at) }}</span>
                </div>
              </div>

              <div class="pesan-body">
                <span class="pesan-subjek" v-if="p.subjek">{{ p.subjek }}</span>
                <p class="pesan-isi">{{ p.isi_pesan }}</p>
                <div class="pesan-info" v-if="p.telepon">
                  <i class="bi bi-telephone-fill me-1"></i>{{ p.telepon }}
                </div>
              </div>

              <div class="pesan-actions">
                <button
                  v-if="p.status === 'belum_dibaca'"
                  class="btn-action-pesan btn-baca"
                  @click="tandaiBaca(p.id)"
                >
                  <i class="bi bi-check2-circle me-1"></i>Tandai Dibaca
                </button>
                <button class="btn-action-pesan btn-hapus" @click="hapusPesan(p.id)">
                  <i class="bi bi-trash me-1"></i>Hapus
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== TAB: REVIEW ===== -->
        <div v-if="activeTab === 'review'" class="admin-card">
          <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h5 class="card-title-custom">Manajemen Review</h5>
            <button class="btn-primary-custom" @click="openReviewModal()">
              <i class="bi bi-plus-lg"></i> Tambah Review
            </button>
          </div>
          <LoadingSpinner v-if="loadingReview" />
          <div v-else-if="reviewList.length === 0" class="empty-state">
            <i class="bi bi-chat-square-text"></i>
            <p>Belum ada review</p>
          </div>
          <div v-else class="review-admin-list">
            <div class="review-admin-item" v-for="r in reviewList" :key="r.id">
              <div class="review-admin-header">
                <div class="review-admin-meta">
                  <div class="pesan-avatar">{{ (r.nama_user || 'A')[0] }}</div>
                  <div>
                    <span class="pesan-nama">{{ r.nama_user || 'Admin' }}</span>
                    <span class="review-stars-sm">
                      <i class="bi bi-star-fill" v-for="s in r.rating" :key="s"></i>
                      <i class="bi bi-star"      v-for="s in (5 - r.rating)" :key="'e'+s"></i>
                    </span>
                  </div>
                </div>
                <div class="pesan-right">
                  <span class="pesan-tanggal">{{ formatDate(r.tanggal_kunjungan) }}</span>
                  <button class="btn-action delete ms-2" @click="hapusReview(r.id)">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
              </div>
              <p class="review-admin-text">"{{ r.komentar }}"</p>
            </div>
          </div>
        </div>

        <!-- ===== TAB: WAHANA ===== -->
        <div v-if="activeTab === 'wahana'" class="admin-card">
          <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h5 class="card-title-custom">Manajemen Wahana</h5>
            <button class="btn-primary-custom" @click="openWahanaModal()">
              <i class="bi bi-plus-lg"></i> Tambah Wahana
            </button>
          </div>
          <LoadingSpinner v-if="loadingWahana" />
          <div v-else class="table-responsive">
            <table class="table table-custom">
              <thead>
                <tr><th>No</th><th>Nama</th><th>Kategori</th><th>Kapasitas</th><th>Min. Tinggi</th><th>Status</th><th>Aksi</th></tr>
              </thead>
              <tbody>
                <tr v-if="wahanaList.length === 0">
                  <td colspan="7" class="text-center py-4 text-muted">Tidak ada data</td>
                </tr>
                <tr v-for="(w, i) in wahanaList" :key="w.id">
                  <td>{{ i + 1 }}</td>
                  <td class="fw-bold">{{ w.nama }}</td>
                  <td><span class="badge-custom" :class="`badge-${w.kategori}`">{{ w.kategori }}</span></td>
                  <td>{{ w.kapasitas || '-' }} orang</td>
                  <td>{{ w.min_tinggi || '-' }} cm</td>
                  <td><span class="badge-custom" :class="w.status !== 'aktif' ? 'badge-keluhan' : ''">{{ w.status }}</span></td>
                  <td>
                    <button class="btn-action edit" @click="openWahanaModal(w)"><i class="bi bi-pencil"></i></button>
                    <button class="btn-action delete" @click="confirmDelete('wahana', w.id, w.nama)"><i class="bi bi-trash"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>

    <!-- MODAL WAHANA -->
    <Teleport to="body">
      <div v-if="showWahanaModal" class="modal-overlay" @click.self="showWahanaModal = false">
        <div class="modal-box modal-box-lg">
          <div class="modal-box-header">
            <h5 class="modal-box-title">{{ wahanaForm.id ? 'Edit Wahana' : 'Tambah Wahana' }}</h5>
            <button class="modal-box-close" @click="showWahanaModal = false"><i class="bi bi-x-lg"></i></button>
          </div>
          <div class="modal-box-body">
            <AlertMessage :show="!!wahanaError" type="error" :message="wahanaError" @close="wahanaError = ''" />
            <div class="row g-3">
              <div class="col-12">
                <label class="edit-label">Nama Wahana</label>
                <input v-model="wahanaForm.nama" type="text" class="edit-input" placeholder="Nama wahana">
              </div>
              <div class="col-md-6">
                <label class="edit-label">Kategori</label>
                <select v-model="wahanaForm.kategori" class="edit-input">
                  <option value="">Pilih kategori</option>
                  <option value="anak">Anak</option>
                  <option value="remaja">Remaja</option>
                  <option value="dewasa">Dewasa</option>
                  <option value="keluarga">Keluarga</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="edit-label">Status</label>
                <select v-model="wahanaForm.status" class="edit-input">
                  <option value="aktif">Aktif</option>
                  <option value="nonaktif">Nonaktif</option>
                  <option value="maintenance">Maintenance</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="edit-label">Kapasitas (orang)</label>
                <input v-model="wahanaForm.kapasitas" type="number" class="edit-input" placeholder="0">
              </div>
              <div class="col-md-4">
                <label class="edit-label">Min. Tinggi (cm)</label>
                <input v-model="wahanaForm.min_tinggi" type="number" class="edit-input" placeholder="0">
              </div>
              <div class="col-md-4">
                <label class="edit-label">Durasi (menit)</label>
                <input v-model="wahanaForm.durasi" type="number" class="edit-input" placeholder="0">
              </div>
              <div class="col-12">
                <label class="edit-label">Deskripsi</label>
                <textarea v-model="wahanaForm.deskripsi" class="edit-input" rows="3" placeholder="Deskripsi wahana..."></textarea>
              </div>
              <div class="col-12">
                <label class="edit-label">Gambar Wahana</label>
                <div class="upload-wrap">
                  <label class="upload-label" :class="{ loading: uploadLoading }">
                    <input type="file" accept="image/*" style="display:none" @change="handleImageUpload">
                    <span v-if="uploadLoading">
                      <span class="spinner-border spinner-border-sm me-1"></span> Mengupload...
                    </span>
                    <span v-else>
                      <i class="bi bi-cloud-upload me-2"></i>
                      {{ imagePreview ? 'Ganti Gambar' : 'Upload Gambar' }}
                    </span>
                  </label>
                  <div v-if="imagePreview" class="image-preview-wrap">
                    <img :src="imagePreview" alt="Preview" class="image-preview">
                    <button type="button" class="btn-remove-img" @click="wahanaForm.gambar = ''; imagePreview = ''">
                      <i class="bi bi-x-circle-fill"></i>
                    </button>
                  </div>
                  <span class="upload-hint">JPG, PNG, WEBP — Maks. 3MB</span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-box-footer">
            <button class="btn-edit-cancel" @click="showWahanaModal = false">Batal</button>
            <button class="btn-edit-save" :disabled="wahanaLoading || uploadLoading" @click="saveWahana">
              <span v-if="wahanaLoading" class="spinner-border spinner-border-sm me-1"></span>
              {{ wahanaForm.id ? 'Simpan Perubahan' : 'Tambah Wahana' }}
            </button>
          </div>
        </div>
      </div>
    </Teleport>

    <!-- MODAL TAMBAH REVIEW -->
    <Teleport to="body">
      <div v-if="showReviewModal" class="modal-overlay" @click.self="showReviewModal = false">
        <div class="modal-box">
          <div class="modal-box-header">
            <h5 class="modal-box-title">Tambah Review</h5>
            <button class="modal-box-close" @click="showReviewModal = false"><i class="bi bi-x-lg"></i></button>
          </div>
          <div class="modal-box-body">
            <AlertMessage :show="!!reviewError" type="error" :message="reviewError" @close="reviewError = ''" />
            <div class="edit-field">
              <label class="edit-label">Nama Pengunjung</label>
              <input v-model="reviewForm.nama_custom" type="text" class="edit-input" placeholder="Contoh: Budi Santoso">
              <small style="color:#aaa;font-size:12px;">Kosongkan jika ingin pakai nama akun admin</small>
            </div>
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
              <textarea v-model="reviewForm.komentar" class="edit-input" rows="4" placeholder="Tulis komentar..."></textarea>
            </div>
          </div>
          <div class="modal-box-footer">
            <button class="btn-edit-cancel" @click="showReviewModal = false">Batal</button>
            <button class="btn-edit-save" :disabled="reviewLoading" @click="saveReview">
              <span v-if="reviewLoading" class="spinner-border spinner-border-sm me-1"></span>
              Simpan Review
            </button>
          </div>
        </div>
      </div>
    </Teleport>

    <!-- MODAL KONFIRMASI DELETE -->
    <Teleport to="body">
      <div v-if="showDeleteModal" class="modal-overlay" @click.self="showDeleteModal = false">
        <div class="modal-box modal-box-sm">
          <div class="modal-box-header">
            <h5 class="modal-box-title text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
            <button class="modal-box-close" @click="showDeleteModal = false"><i class="bi bi-x-lg"></i></button>
          </div>
          <div class="modal-box-body">
            <p style="font-family:'Open Sans',sans-serif;font-size:15px;color:#444;">
              Apakah Anda yakin ingin menghapus <strong>{{ deleteTarget.name }}</strong>? Tindakan ini tidak dapat dibatalkan.
            </p>
          </div>
          <div class="modal-box-footer">
            <button class="btn-edit-cancel" @click="showDeleteModal = false">Batal</button>
            <button class="btn-delete-confirm" :disabled="deleteLoading" @click="doDelete">
              <span v-if="deleteLoading" class="spinner-border spinner-border-sm me-1"></span>
              Ya, Hapus
            </button>
          </div>
        </div>
      </div>
    </Teleport>

    <FooterComponent />
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import NavbarComponent from '@/components/layout/NavbarComponent.vue'
import FooterComponent from '@/components/layout/FooterComponent.vue'
import LoadingSpinner  from '@/components/common/LoadingSpinner.vue'
import AlertMessage    from '@/components/common/AlertMessage.vue'
import adminService    from '@/services/adminService.js'

// =====================
// STATE
// =====================
const dashboard  = ref(null)
const activeTab  = ref('pesan')

const pesanList      = ref([])
const loadingPesan   = ref(false)
const wahanaList     = ref([])
const loadingWahana  = ref(false)
const reviewList     = ref([])
const loadingReview  = ref(false)

const pesanBelumDibaca = computed(() =>
  pesanList.value.filter(p => p.status === 'belum_dibaca').length
)

// =====================
// TABS
// =====================
const tabs = [
  { key: 'pesan',  label: 'Pesan Masuk', icon: 'bi-inbox-fill' },
  { key: 'wahana', label: 'Wahana',      icon: 'bi-water' },
  { key: 'review', label: 'Review',      icon: 'bi-chat-square-text-fill' },
]

function switchTab(key) {
  activeTab.value = key
  if (key === 'pesan'  && !pesanList.value.length)  loadPesan()
  if (key === 'wahana' && !wahanaList.value.length)  loadWahana()
  if (key === 'review' && !reviewList.value.length)  loadReview()
}

// =====================
// LOAD DATA
// =====================
async function loadDashboard() {
  try {
    const res = await adminService.getDashboard()
    if (res.success) dashboard.value = res.data
  } catch (e) { console.error(e) }
}

async function loadPesan() {
  loadingPesan.value = true
  try {
    const res = await adminService.getPesan()
    if (res.success) pesanList.value = res.data
  } catch (e) { console.error(e) }
  finally { loadingPesan.value = false }
}

async function loadWahana() {
  loadingWahana.value = true
  try {
    const res = await adminService.getWahana()
    if (res.success) wahanaList.value = res.data
  } catch (e) { console.error(e) }
  finally { loadingWahana.value = false }
}

async function loadReview() {
  loadingReview.value = true
  try {
    const res = await adminService.getReview()
    if (res.success) reviewList.value = res.data
  } catch (e) { console.error(e) }
  finally { loadingReview.value = false }
}

// =====================
// REVIEW ACTIONS
// =====================
const showReviewModal  = ref(false)
const reviewLoading    = ref(false)
const reviewError      = ref('')
const reviewForm       = reactive({ rating: 5, nama_custom: '', komentar: '', tanggal_kunjungan: '' })

function openReviewModal() {
  reviewError.value = ''
  reviewForm.rating = 5
  reviewForm.nama_custom = ''
  reviewForm.komentar = ''
  reviewForm.tanggal_kunjungan = ''
  showReviewModal.value = true
}

async function saveReview() {
  if (!reviewForm.komentar.trim()) {
    reviewError.value = 'Komentar wajib diisi'
    return
  }
  reviewLoading.value = true
  reviewError.value   = ''
  try {
    const res = await adminService.addReview({ ...reviewForm })
    if (res.success) {
      reviewList.value.unshift(res.data)
      showReviewModal.value = false
      await loadDashboard()
    }
  } catch (e) {
    reviewError.value = e.response?.data?.message || 'Gagal menambah review'
  } finally {
    reviewLoading.value = false
  }
}

async function hapusReview(id) {
  if (!confirm('Hapus review ini?')) return
  try {
    await adminService.deleteReview(id)
    reviewList.value = reviewList.value.filter(r => r.id !== id)
    await loadDashboard()
  } catch (e) { console.error(e) }
}

// =====================
// PESAN ACTIONS
// =====================
async function tandaiBaca(id) {
  try {
    await adminService.tandaiBaca(id)
    const p = pesanList.value.find(p => p.id === id)
    if (p) p.status = 'sudah_dibaca'
    await loadDashboard()
  } catch (e) { console.error(e) }
}

async function hapusPesan(id) {
  if (!confirm('Hapus pesan ini?')) return
  try {
    await adminService.deletePesan(id)
    pesanList.value = pesanList.value.filter(p => p.id !== id)
    await loadDashboard()
  } catch (e) { console.error(e) }
}

// =====================
// WAHANA MODAL
// =====================
const showWahanaModal = ref(false)
const wahanaLoading   = ref(false)
const wahanaError     = ref('')
const uploadLoading   = ref(false)
const imagePreview    = ref('')

const wahanaForm = reactive({
  id: null, nama: '', kategori: '', status: 'aktif',
  kapasitas: '', min_tinggi: '', durasi: '', deskripsi: '', gambar: '',
})

function openWahanaModal(wahana = null) {
  wahanaError.value = ''
  imagePreview.value = ''
  if (wahana) {
    Object.assign(wahanaForm, { ...wahana })
    imagePreview.value = wahana.gambar ? 'http://localhost' + wahana.gambar : ''
  } else {
    Object.assign(wahanaForm, { id: null, nama: '', kategori: '', status: 'aktif', kapasitas: '', min_tinggi: '', durasi: '', deskripsi: '', gambar: '' })
  }
  showWahanaModal.value = true
}

async function handleImageUpload(event) {
  const file = event.target.files[0]
  if (!file) return

  const allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif']
  if (!allowed.includes(file.type)) {
    wahanaError.value = 'Format tidak didukung. Gunakan JPG, PNG, atau WEBP'
    return
  }
  if (file.size > 3 * 1024 * 1024) {
    wahanaError.value = 'Ukuran file maksimal 3MB'
    return
  }

  uploadLoading.value = true
  wahanaError.value   = ''

  const reader = new FileReader()
  reader.onload = (e) => { imagePreview.value = e.target.result }
  reader.readAsDataURL(file)

  const formData = new FormData()
  formData.append('image', file)

  try {
    const token = localStorage.getItem('token')
    const res   = await fetch('http://localhost/Sempaja_Waterpark/api/admin/upload', {
      method: 'POST',
      headers: {
        'Authorization': token ? `Bearer ${token}` : '',
      },
      body: formData,
    })

    const data = await res.json()

    if (data.success) {
      wahanaForm.gambar  = data.data.url
      // Preview pakai URL absolut ke XAMPP
      imagePreview.value = 'http://localhost' + data.data.url
    } else {
      wahanaError.value = data.message || 'Gagal upload gambar'
    }
  } catch (e) {
    wahanaError.value = 'Gagal terhubung ke server. Coba lagi.'
    console.error(e)
  } finally {
    uploadLoading.value = false
  }
}

async function saveWahana() {
  if (!wahanaForm.nama || !wahanaForm.kategori) {
    wahanaError.value = 'Nama dan kategori wajib diisi'
    return
  }
  wahanaLoading.value = true
  try {
    if (wahanaForm.id) {
      const res = await adminService.updateWahana(wahanaForm.id, { ...wahanaForm })
      if (res.success) {
        const idx = wahanaList.value.findIndex(w => w.id === wahanaForm.id)
        if (idx !== -1) wahanaList.value[idx] = res.data
      }
    } else {
      const res = await adminService.createWahana({ ...wahanaForm })
      if (res.success) wahanaList.value.unshift(res.data)
    }
    showWahanaModal.value = false
  } catch (e) {
    wahanaError.value = e.response?.data?.message || 'Gagal menyimpan wahana'
  } finally {
    wahanaLoading.value = false
  }
}

// =====================
// DELETE
// =====================
const showDeleteModal = ref(false)
const deleteLoading   = ref(false)
const deleteTarget    = reactive({ type: '', id: null, name: '' })

function confirmDelete(type, id, name) {
  deleteTarget.type = type
  deleteTarget.id   = id
  deleteTarget.name = name
  showDeleteModal.value = true
}

async function doDelete() {
  deleteLoading.value = true
  try {
    if (deleteTarget.type === 'wahana') {
      await adminService.deleteWahana(deleteTarget.id)
      wahanaList.value = wahanaList.value.filter(w => w.id !== deleteTarget.id)
    }
    showDeleteModal.value = false
  } catch (e) { console.error(e) }
  finally { deleteLoading.value = false }
}

// =====================
// HELPER
// =====================
function formatDate(date) {
  if (!date) return '-'
  return new Date(date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })
}

onMounted(() => {
  loadDashboard()
  loadPesan()
})
</script>

<style scoped>
.dashboard-wrapper { min-height: 100vh; background: #f8fbfd; }

/* HERO */
#admin-hero { background: linear-gradient(135deg, #0a3d5c 0%, #1ea8d4 55%, #7dd8f0 100%); padding-top: 70px; position: relative; overflow: hidden; min-height: 40vh; display: flex; align-items: center; }
.hero-label { font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 13px; color: #f5a623; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 12px; display: block; }
.hero-title { font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: clamp(24px, 4vw, 38px); color: #ffffff; line-height: 1.15; margin: 0; }
.hero-wave  { position: absolute; bottom: 0; left: 0; width: 100%; line-height: 0; }
.hero-wave svg { width: 100%; height: 120px; display: block; }

/* MAIN */
#admin-main { margin-top: -60px; position: relative; z-index: 10; padding-bottom: 80px; }

/* STAT CARDS */
.stat-card { background: #ffffff; border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: transform 0.25s ease; }
.stat-card:hover { transform: translateY(-4px); }
.stat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; }
.stat-number { font-family: 'Montserrat', sans-serif; font-size: 30px; font-weight: 800; color: #1D3461; line-height: 1; display: block; }
.stat-label  { font-family: 'Open Sans', sans-serif; font-size: 13px; color: #888; margin-top: 4px; display: block; }

/* TABS */
.admin-tabs { gap: 8px; flex-wrap: wrap; }
.admin-tabs .nav-link { background: #ffffff; color: #1D3461; border-radius: 50px; padding: 10px 20px; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px; border: 1.5px solid #e0e0e0; transition: all 0.25s ease; display: flex; align-items: center; gap: 6px; cursor: pointer; position: relative; }
.admin-tabs .nav-link:hover { border-color: #1ea8d4; color: #1ea8d4; }
.admin-tabs .nav-link.active { background: #1D3461; color: #ffffff; border-color: #1D3461; box-shadow: 0 4px 15px rgba(29,52,97,0.2); }

/* Badge notif */
.badge-notif { background: #dc3545; color: #ffffff; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 50px; min-width: 20px; text-align: center; }

/* CARD */
.admin-card { background: #ffffff; border-radius: 20px; padding: 32px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
.card-title-custom { font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 20px; color: #1D3461; margin: 0; display: flex; align-items: center; flex-wrap: wrap; gap: 8px; }

/* PESAN LIST */
.empty-state { text-align: center; padding: 60px 0; color: #aaa; }
.empty-state i { font-size: 48px; display: block; margin-bottom: 12px; }
.empty-state p { font-family: 'Open Sans', sans-serif; font-size: 16px; }

.pesan-list { display: flex; flex-direction: column; gap: 16px; }

.pesan-item { background: #f8fbfd; border-radius: 16px; border: 1.5px solid #eef2f7; padding: 20px 24px; transition: border-color 0.2s, box-shadow 0.2s; }
.pesan-item:hover { border-color: #1ea8d4; box-shadow: 0 4px 16px rgba(30,168,212,0.08); }
.pesan-unread { border-color: #1ea8d4; background: #f0f9ff; }

.pesan-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 14px; flex-wrap: wrap; }
.pesan-meta   { display: flex; align-items: center; gap: 12px; }
.pesan-avatar { width: 42px; height: 42px; border-radius: 50%; background: linear-gradient(135deg, #1ea8d4, #0a3d5c); color: #fff; font-family: 'Montserrat', sans-serif; font-size: 15px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.pesan-nama   { font-family: 'Montserrat', sans-serif; font-size: 15px; font-weight: 700; color: #1D3461; display: block; }
.pesan-email  { font-family: 'Open Sans', sans-serif; font-size: 13px; color: #888; display: block; }
.pesan-right  { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; }
.pesan-tanggal{ font-family: 'DM Sans', sans-serif; font-size: 12px; color: #aaa; }

.pesan-status { font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; padding: 3px 12px; border-radius: 50px; }
.status-unread { background: #fdecea; color: #dc3545; }
.status-read   { background: #e8f5e9; color: #28a745; }

.pesan-body   { margin-bottom: 16px; }
.pesan-subjek { font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 700; color: #1D3461; display: block; margin-bottom: 8px; }
.pesan-isi    { font-family: 'Open Sans', sans-serif; font-size: 14px; color: #444; line-height: 1.7; margin: 0 0 8px; }
.pesan-info   { font-family: 'Open Sans', sans-serif; font-size: 13px; color: #888; }

.pesan-actions { display: flex; gap: 10px; flex-wrap: wrap; }
.btn-action-pesan { font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; border: none; border-radius: 8px; padding: 8px 16px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; }
.btn-baca  { background: #EAF6FF; color: #1ea8d4; }
.btn-baca:hover  { background: #1ea8d4; color: #fff; }
.btn-hapus { background: #ffeaea; color: #dc3545; }
.btn-hapus:hover { background: #dc3545; color: #fff; }

/* TABLE */
.table-custom { border-collapse: separate; border-spacing: 0 8px; margin-bottom: 0; }
.table-custom thead th { border: none; color: #94a3b8; font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 8px 16px; background: transparent; }
.table-custom tbody tr { transition: transform 0.2s ease; }
.table-custom tbody tr:hover { transform: translateY(-2px); }
.table-custom tbody td { background: #f8fbfd; border-top: 1px solid #eef2f7; border-bottom: 1px solid #eef2f7; padding: 14px 16px; font-family: 'Open Sans', sans-serif; font-size: 14px; color: #444; vertical-align: middle; }
.table-custom tbody tr td:first-child { border-left: 1px solid #eef2f7; border-radius: 12px 0 0 12px; }
.table-custom tbody tr td:last-child  { border-right: 1px solid #eef2f7; border-radius: 0 12px 12px 0; }
.table-custom .fw-bold { font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 14px; color: #1D3461; }

/* BUTTONS */
.btn-primary-custom { background: #1ea8d4; color: #ffffff; border: none; border-radius: 50px; padding: 9px 22px; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px; transition: all 0.25s ease; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
.btn-primary-custom:hover { background: #1D3461; color: #ffffff; transform: translateY(-2px); }
.btn-refresh-custom { background: #EAF6FF; color: #1ea8d4; border: none; border-radius: 50px; padding: 9px 22px; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.25s ease; display: inline-flex; align-items: center; gap: 6px; }
.btn-refresh-custom:hover { background: #1ea8d4; color: #ffffff; }
.btn-action { width: 36px; height: 36px; border: none; border-radius: 10px; cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center; justify-content: center; font-size: 15px; }
.btn-action + .btn-action { margin-left: 6px; }
.edit   { background: #fff4e0; color: #f5a623; }
.delete { background: #ffeaea; color: #ef4444; }
.btn-action:hover { background: #1D3461 !important; color: #ffffff !important; }

/* BADGES */
.badge-custom { background: #EAF6FF; color: #1ea8d4; padding: 5px 14px; border-radius: 50px; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 11px; display: inline-block; text-transform: capitalize; }
.badge-keluhan { background: #ffeaea; color: #ef4444; }
.badge-anak    { background: #e8f5e9; color: #28a745; }
.badge-remaja  { background: #f3e8ff; color: #9b59b6; }
.badge-dewasa  { background: #EAF6FF; color: #1D3461; }
.badge-keluarga{ background: #fff3e0; color: #f5a623; }

/* MODAL */
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 20px; }
.modal-box { background: #ffffff; border-radius: 20px; width: 100%; max-width: 480px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); overflow: hidden; }
.modal-box-lg { max-width: 640px; }
.modal-box-sm { max-width: 400px; }
.modal-box-header { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px 0; }
.modal-box-title  { font-family: 'Montserrat', sans-serif; font-size: 18px; font-weight: 700; color: #1D3461; margin: 0; }
.modal-box-close  { background: transparent; border: none; font-size: 18px; color: #aaa; cursor: pointer; }
.modal-box-body   { padding: 20px 24px; display: flex; flex-direction: column; gap: 12px; max-height: 70vh; overflow-y: auto; }
.modal-box-footer { padding: 0 24px 24px; display: flex; gap: 10px; }
.edit-label { font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #1D3461; display: block; margin-bottom: 6px; }
.edit-input { width: 100%; font-family: 'Open Sans', sans-serif; font-size: 14px; color: #333; background: #f8fbfd; border: 1.5px solid #e0e0e0; border-radius: 10px; padding: 10px 14px; outline: none; resize: vertical; transition: border-color 0.25s, box-shadow 0.25s; appearance: none; }
.edit-input:focus { border-color: #1ea8d4; box-shadow: 0 0 0 3px rgba(30,168,212,0.12); background: #ffffff; }
.btn-edit-cancel { flex: 1; padding: 10px; background: transparent; color: #555; border: 1.5px solid #e0e0e0; border-radius: 10px; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px; cursor: pointer; }
.btn-edit-cancel:hover { background: #f8fbfd; }
.btn-edit-save { flex: 1; padding: 10px; background: #1ea8d4; color: #ffffff; border: none; border-radius: 10px; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.25s; display: flex; align-items: center; justify-content: center; }
.btn-edit-save:hover:not(:disabled) { background: #1D3461; }
.btn-edit-save:disabled { opacity: 0.7; cursor: not-allowed; }
.btn-delete-confirm { flex: 1; padding: 10px; background: #dc3545; color: #ffffff; border: none; border-radius: 10px; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.btn-delete-confirm:hover:not(:disabled) { background: #b02a37; }
.btn-delete-confirm:disabled { opacity: 0.7; cursor: not-allowed; }

/* UPLOAD GAMBAR */
.upload-wrap { display: flex; flex-direction: column; gap: 10px; }
.upload-label {
  display: inline-flex; align-items: center; justify-content: center;
  background: #EAF6FF; color: #1ea8d4;
  border: 1.5px dashed #1ea8d4; border-radius: 10px;
  padding: 12px 20px; cursor: pointer; font-family: 'Inter', sans-serif;
  font-size: 14px; font-weight: 600; transition: all 0.25s ease;
  width: 100%;
}
.upload-label:hover { background: #1ea8d4; color: #ffffff; }
.upload-label.loading { opacity: 0.7; cursor: not-allowed; }
.upload-hint { font-family: 'DM Sans', sans-serif; font-size: 12px; color: #aaa; }
.image-preview-wrap { position: relative; display: inline-block; width: 100%; }
.image-preview { width: 100%; max-height: 180px; object-fit: cover; border-radius: 10px; border: 1.5px solid #e0e0e0; display: block; }
.btn-remove-img { position: absolute; top: 8px; right: 8px; background: rgba(220,53,69,0.9); border: none; border-radius: 50%; width: 28px; height: 28px; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; transition: background 0.2s; }
.btn-remove-img:hover { background: #dc3545; }

/* REVIEW ADMIN */
.review-admin-list { display: flex; flex-direction: column; gap: 16px; }
.review-admin-item { background: #f8fbfd; border-radius: 14px; border: 1.5px solid #eef2f7; padding: 18px 22px; transition: border-color 0.2s; }
.review-admin-item:hover { border-color: #1ea8d4; }
.review-admin-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 10px; }
.review-admin-meta { display: flex; align-items: center; gap: 12px; }
.review-stars-sm { color: #f5a623; font-size: 13px; display: block; margin-top: 3px; }
.review-admin-text { font-family: 'Open Sans', sans-serif; font-size: 14px; color: #555; line-height: 1.7; font-style: italic; margin: 0; }

/* Star picker */
.edit-field { display: flex; flex-direction: column; gap: 6px; }
.star-picker { display: flex; gap: 8px; }
.star-btn { background: transparent; border: none; font-size: 26px; color: #e0e0e0; cursor: pointer; padding: 0; transition: color 0.15s, transform 0.15s; }
.star-btn.active { color: #f5a623; }
.star-btn:hover  { transform: scale(1.2); }

@media (max-width: 991.98px) {
  #admin-main { margin-top: -40px; }
  .admin-card { padding: 20px; }
}
@media (max-width: 767.98px) {
  .admin-tabs .nav-link { padding: 8px 14px; font-size: 13px; }
  .pesan-header { flex-direction: column; }
  .pesan-right { align-items: flex-start; }
}
</style>