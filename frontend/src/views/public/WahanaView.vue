<template>
  <PublicLayout>

    <section id="wahana-hero">
      <div class="container">
        <div class="wahana-hero-content">
          <span class="section-label-hero">Eksplorasi Wahana</span>
          <h1 class="wahana-hero-title">Wahana Seru<br><span class="text-accent">Untuk Semua</span></h1>
          <p class="wahana-hero-desc">Temukan berbagai wahana air yang dirancang untuk kesenangan seluruh keluarga di Bumi Sempaja Waterpark</p>
        </div>
      </div>
      
      <div class="wahana-hero-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0,120 L0,60 C200,20 400,90 600,50 C800,10 1000,70 1200,40 C1320,24 1400,50 1440,60 L1440,120 Z" fill="rgba(255,255,255,0.3)"/>
          <path d="M0,120 L0,85 C360,50 720,110 1080,80 C1260,65 1380,85 1440,80 L1440,120 Z" fill="#ffffff"/>
        </svg>
      </div>
    </section>

    <section id="wahana-filter">
      <div class="container">
        <div class="filter-wrap">
          <button
            v-for="f in filterList" :key="f.value"
            class="filter-btn"
            :class="{ active: wahanaStore.filterAktif === f.value }"
            @click="wahanaStore.setFilter(f.value)"
          >
            <i class="bi me-2" :class="f.icon"></i>{{ f.label }}
          </button>
        </div>
      </div>
    </section>

    <section id="wahana-list">
      <div class="container">

        <LoadingSpinner v-if="wahanaStore.loading" text="Memuat wahana..." />

        <div v-else-if="wahanaStore.wahanaFiltered.length === 0" class="wahana-empty">
          <div class="empty-icon-wrap">
            <i class="bi bi-water"></i>
          </div>
          <h4>Wahana Tidak Ditemukan</h4>
          <p>Belum ada wahana untuk kategori ini. Coba pilih kategori lainnya.</p>
          <button @click="wahanaStore.setFilter('semua')" class="btn-reset-filter">Lihat Semua Wahana</button>
        </div>

        <div v-else class="row g-4">
          <div
            class="col-lg-4 col-md-6"
            v-for="wahana in wahanaStore.wahanaFiltered"
            :key="wahana.id"
          >
            <div class="wahana-card-page">
              <div class="wahana-card-img-wrap">
                <img
                  :src="wahana.gambar ? 'http://localhost' + wahana.gambar : '/img/wahana-placeholder.jpg'"
                  :alt="wahana.nama"
                  class="wahana-card-img"
                >
                <span class="wahana-card-badge" :class="`badge-${wahana.kategori}`">
                  {{ wahana.kategori }}
                </span>
              </div>
              <div class="wahana-card-body">
                <h5 class="wahana-card-title">{{ wahana.nama }}</h5>
                <p class="wahana-card-desc">{{ wahana.deskripsi }}</p>
                
                <div class="wahana-card-info">
                  <div class="wahana-info-item">
                    <i class="bi bi-people-fill"></i>
                    <span><strong>{{ wahana.kapasitas || '-' }}</strong> orang / sesi</span>
                  </div>
                  <div class="wahana-info-item">
                    <i class="bi bi-rulers"></i>
                    <span>Min. tinggi <strong>{{ wahana.min_tinggi || '-' }}</strong> cm</span>
                  </div>
                  <div class="wahana-info-item">
                    <i class="bi bi-clock-fill"></i>
                    <span>Durasi ± <strong>{{ wahana.durasi || '-' }}</strong> menit</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <section id="cta-wahana">
      <div class="container text-center">
        <h2 class="section-title">Tertarik Mencoba?</h2>
        <p class="section-desc mb-4">Dapatkan tiket masuk dan nikmati semua wahana seru ini sekarang!</p>
        <RouterLink to="/harga-tiket" class="btn-cta-wahana">
          <i class="bi bi-ticket-perforated-fill me-2"></i>Lihat Harga Tiket
        </RouterLink>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import { onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import PublicLayout from '@/components/layout/PublicLayout.vue'
import LoadingSpinner from '@/components/common/LoadingSpinner.vue'
import { useWahanaStore } from '@/stores/wahana.js'

const wahanaStore = useWahanaStore()
onMounted(() => wahanaStore.fetchWahana())

const filterList = [
  { value: 'semua',   label: 'Semua',         icon: 'bi-grid-fill' },
  { value: 'anak',    label: 'Anak-Anak',     icon: 'bi-emoji-smile-fill' },
  { value: 'remaja',  label: 'Remaja',        icon: 'bi-lightning-charge-fill' },
  { value: 'dewasa',  label: 'Dewasa',        icon: 'bi-person-fill' },
  { value: 'keluarga',label: 'Keluarga',      icon: 'bi-house-heart-fill' },
]
</script>

<style scoped>
/* --- HERO SECTION --- */
#wahana-hero {
  background-color: #0a3d5c;
  min-height: 65vh; 
  display: flex; 
  align-items: center;
  position: relative; 
  overflow: hidden;
}

#wahana-hero::before {
  content: ""; 
  position: absolute; 
  top: 0; left: 0; right: 0; bottom: 0;
  background-image: url('/img/kikin.jpg');
  background-size: cover; 
  background-position: center;
  background-attachment: fixed;
  z-index: 0;
}

#wahana-hero::after {
  content: "";
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: linear-gradient(
    180deg, 
    rgba(10, 61, 92, 0.85) 0%,   
    rgba(30, 168, 212, 0.8) 70%, 
    rgba(10, 61, 92, 1) 100%
  );
  z-index: 1;
}

.wahana-hero-content { 
  position: relative; 
  z-index: 10; 
  padding: 120px 0; 
  text-align: center; 
  width: 100%; 
}

.section-label-hero { 
  color: #7dd8f0; 
  font-weight: 700; 
  text-transform: uppercase; 
  letter-spacing: 3px; 
  font-size: 14px; 
  display: block; 
  margin-bottom: 10px; 
}

.wahana-hero-title { 
  font-family: 'Montserrat', sans-serif; 
  font-size: clamp(32px, 5vw, 60px); 
  font-weight: 800; 
  color: #ffffff; 
  line-height: 1.1; 
}

.text-accent { color: #f5a623; }

.wahana-hero-desc { 
  font-family: 'Open Sans', sans-serif; 
  font-size: 18px; 
  color: rgba(255,255,255,0.9); 
  margin: 20px auto 0; 
  max-width: 600px; 
}

.wahana-hero-wave { 
  position: absolute; 
  bottom: -1px; 
  left: 0; 
  width: 100%; 
  line-height: 0; 
  z-index: 11; 
}

/* --- FILTER SECTION (SEKARANG TIDAK FIXED) --- */
#wahana-filter { 
  background-color: #ffffff; 
  padding: 90px 0 40px; /* Padding atas dinaikkan agar lega seperti home */
  /* position: sticky DIHAPUS agar tidak ngikut scroll */
  position: relative; 
  z-index: 5;
}

.filter-wrap { display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; }
.filter-btn {
  font-family: 'Inter', sans-serif; font-size: 14px; font-weight: 600;
  color: #1D3461; background: #f8fbfd;
  border: 1.5px solid #eef2f7; border-radius: 50px;
  padding: 10px 24px; cursor: pointer; transition: all 0.3s ease;
}
.filter-btn:hover { border-color: #1ea8d4; color: #1ea8d4; background: #fff; }
.filter-btn.active { background-color: #1D3461; border-color: #1D3461; color: #ffffff; box-shadow: 0 4px 15px rgba(29, 52, 97, 0.3); }

/* --- LIST SECTION --- */
#wahana-list { background-color: #ffffff; padding: 20px 0 100px; min-height: 400px; }
.wahana-empty { text-align: center; padding: 80px 0; }
.empty-icon-wrap { width: 80px; height: 80px; background: #f8fbfd; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px; color: #ccc; }
.btn-reset-filter { background: none; border: 1.5px solid #1ea8d4; color: #1ea8d4; padding: 8px 20px; border-radius: 50px; font-weight: 600; margin-top: 15px; transition: 0.3s; }
.btn-reset-filter:hover { background: #1ea8d4; color: #fff; }

/* --- CARD DESIGN --- */
.wahana-card-page { background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 25px rgba(0,0,0,0.07); transition: all 0.3s ease; height: 100%; border: 1px solid #f0f4f8; }
.wahana-card-page:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.12); border-color: #1ea8d4; }
.wahana-card-img-wrap { position: relative; overflow: hidden; height: 230px; }
.wahana-card-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
.wahana-card-page:hover .wahana-card-img { transform: scale(1.1); }
.wahana-card-badge { position: absolute; top: 15px; right: 15px; font-size: 11px; font-weight: 700; background-color: #1ea8d4; color: #ffffff; padding: 5px 15px; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px; z-index: 5; }

.badge-dewasa  { background-color: #1D3461 !important; }
.badge-anak    { background-color: #28a745 !important; }
.badge-remaja  { background-color: #9b59b6 !important; }
.badge-keluarga{ background-color: #f5a623 !important; }

.wahana-card-body { padding: 25px; }
.wahana-card-title { font-family: 'Montserrat', sans-serif; font-size: 22px; font-weight: 700; color: #1D3461; margin-bottom: 12px; }
.wahana-card-desc { font-family: 'Open Sans', sans-serif; font-size: 14px; color: #6c757d; line-height: 1.6; margin-bottom: 20px; }
.wahana-card-info { display: flex; flex-direction: column; gap: 10px; border-top: 1px solid #f1f4f9; padding-top: 20px; }
.wahana-info-item { display: flex; align-items: center; gap: 12px; font-size: 13px; color: #444; }
.wahana-info-item i { color: #1ea8d4; font-size: 16px; width: 20px; text-align: center; }

/* --- CTA SECTION --- */
#cta-wahana { background: linear-gradient(rgba(248, 251, 253, 0.9), rgba(248, 251, 253, 0.9)), url('/img/bg-waterpark.jpg'); background-size: cover; background-position: center; padding: 120px 0; }
.section-title { font-family: 'Montserrat', sans-serif; font-weight: 800; color: #1D3461; margin-bottom: 15px; }
.btn-cta-wahana { font-family: 'Inter', sans-serif; font-weight: 700; background-color: #1D3461; color: #ffffff; border-radius: 50px; padding: 16px 40px; text-decoration: none; display: inline-flex; align-items: center; transition: 0.3s; box-shadow: 0 4px 15px rgba(29, 52, 97, 0.2); }
.btn-cta-wahana:hover { background-color: #0a3d5c; color: #ffffff; transform: translateY(-3px); box-shadow: 0 8px 25px rgba(29, 52, 97, 0.3); }

@media (max-width: 768px) {
  .wahana-hero-content { padding: 80px 20px; }
  #wahana-filter { padding: 60px 0 20px; }
}
</style>