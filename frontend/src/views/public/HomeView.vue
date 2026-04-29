<template>
  <PublicLayout>

    <section id="hero">
      <div class="container">
        <div class="hero-content">
          <span class="hero-label">Selamat Datang di</span>
          <h1 class="hero-title">Bumi Sempaja<br><span class="hero-title-accent">Waterpark</span></h1>
          <p class="hero-desc">Nikmati wahana air terbaik bersama keluarga tercinta di jantung Kota Samarinda</p>
          
          <div class="hero-buttons">
            <RouterLink to="/harga-tiket" class="btn-hero-primary">
              <i class="bi bi-ticket-perforated-fill me-2"></i>Beli Tiket Sekarang
            </RouterLink>
            <RouterLink to="/wahana" class="btn-hero-secondary">
              <i class="bi bi-water me-2"></i>Lihat Wahana
            </RouterLink>
          </div>

          <div class="hero-stats">
            <div class="hero-stat">
              <span class="hero-stat-number">15+</span>
              <span class="hero-stat-label">Wahana Seru</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
              <span class="hero-stat-number">50K+</span>
              <span class="hero-stat-label">Pengunjung/Tahun</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
              <span class="hero-stat-number">4.8★</span>
              <span class="hero-stat-label">Rating Pengunjung</span>
            </div>
          </div>
        </div>
      </div>

      <div class="hero-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0,120 L0,60 C200,20 400,90 600,50 C800,10 1000,70 1200,40 C1320,24 1400,50 1440,60 L1440,120 Z" fill="rgba(125,216,240,0.3)"/>
          <path d="M0,120 L0,85 C360,50 720,110 1080,80 C1260,65 1380,85 1440,80 L1440,120 Z" fill="#f8fbfd"/>
        </svg>
      </div>
    </section>

    <section id="fitur">
      <div class="container">
        <div class="row g-4 justify-content-center">
          <div class="col-lg-3 col-md-6" v-for="item in fiturList" :key="item.icon">
            <div class="fitur-card">
              <div class="fitur-icon" :style="{ backgroundColor: item.bg, color: item.color }">
                <i class="bi" :class="item.icon"></i>
              </div>
              <h5 class="fitur-title">{{ item.title }}</h5>
              <p class="fitur-desc">{{ item.desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="wahana-home">
      <div class="container">
        <div class="text-center mb-5">
          <span class="section-label">Wahana Kami</span>
          <h2 class="section-title">Wahana Unggulan</h2>
          <p class="section-desc">Pilihan wahana seru untuk semua usia</p>
        </div>
        
        <LoadingSpinner v-if="wahanaStore.loading" text="Memuat wahana..." />
        
        <div v-else class="row g-4">
          <div class="col-lg-4 col-md-6"
            v-for="wahana in wahanaStore.wahanaList.slice(0, 3)"
            :key="wahana.id">
            <div class="wahana-card-home">
              <div class="wahana-card-img-wrap">
                <img :src="wahana.gambar ? 'http://localhost' + wahana.gambar : '/img/wahana-placeholder.jpg'" :alt="wahana.nama" class="wahana-card-img">
                <span class="wahana-card-badge" :class="`badge-${wahana.kategori}`">{{ wahana.kategori }}</span>
              </div>
              <div class="wahana-card-body">
                <h5 class="wahana-card-title">{{ wahana.nama }}</h5>
                <p class="wahana-card-desc">{{ wahana.deskripsi }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="text-center mt-5">
          <RouterLink to="/wahana" class="btn-lihat-semuall">
            Lihat Semua Wahana <i class="bi bi-arrow-right ms-2"></i>
          </RouterLink>
        </div>
      </div>
    </section>

    <section id="tiket-home">
      <div class="container">
        <div class="text-center mb-5">
          <span class="section-label">Harga Tiket</span>
          <h2 class="section-title">Pilih Paket Terbaik</h2>
        </div>
        <div class="row g-4 justify-content-center">
          <div class="col-lg-4 col-md-6" v-for="tiket in tiketHome" :key="tiket.name">
            <div class="tiket-home-card" :class="{ 'tiket-home-featured': tiket.featured }">
              <span v-if="tiket.featured" class="tiket-featured-badge">⭐ Paling Populer</span>
              <p class="tiket-home-label">{{ tiket.label }}</p>
              <h3 class="tiket-home-name">{{ tiket.name }}</h3>
              <div class="tiket-home-harga">
                <span class="tiket-home-rp">Rp</span>
                <span class="tiket-home-nominal">{{ tiket.harga }}</span>
              </div>
              <p class="tiket-home-per">{{ tiket.per }}</p>
              <hr class="tiket-home-divider">
              <ul class="tiket-home-benefit">
                <li v-for="b in tiket.benefit" :key="b">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>{{ b }}
                </li>
              </ul>
              <RouterLink to="/harga-tiket" class="btn-tiket-home" :class="{ 'btn-tiket-featured': tiket.featured }">
                <i class="bi bi-whatsapp me-2"></i>Pesan via WhatsApp
              </RouterLink>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="review-home">
      <div class="container-fluid px-0">
        <div class="text-center mb-5">
          <span class="section-label">Testimoni</span>
          <h2 class="section-title">Kata Pengunjung Kami</h2>
        </div>
        <div class="floating-reviews-container">
          <div class="marquee-wrapper">
            <div class="marquee-content">
              <div class="review-float-card" v-for="(r, i) in [...reviewHome, ...reviewHome, ...reviewHome]" :key="'r1-'+i">
                <div class="review-card-inner">
                  <div class="review-home-stars">
                    <i class="bi bi-star-fill" v-for="s in r.rating" :key="s"></i>
                  </div>
                  <p class="review-text">"{{ r.text }}"</p>
                  <div class="review-user">
                    <div class="review-avatar">{{ r.name[0] }}</div>
                    <div class="review-info">
                      <span class="review-name">{{ r.name }}</span>
                      <span class="review-date">{{ r.date }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="cta-home">
      <div class="container text-center">
        <h2 class="cta-home-title">Siap Merasakan Keseruan?</h2>
        <p class="cta-home-desc">Dapatkan pengalaman bermain air terbaik bersama keluarga</p>
        <div class="cta-home-buttons">
          <RouterLink to="/harga-tiket" class="btn-cta-primary">
            <i class="bi bi-ticket-perforated-fill me-2"></i>Beli Tiket Sekarang
          </RouterLink>
          <RouterLink to="/kontak" class="btn-cta-secondary">
            <i class="bi bi-telephone-fill me-2"></i>Hubungi Kami
          </RouterLink>
        </div>
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

const fiturList = [
  { icon: 'bi-water', bg: '#EAF6FF', color: '#1ea8d4', title: 'Wahana Lengkap', desc: 'Lebih dari 15 wahana air yang aman dan menyenangkan.' },
  { icon: 'bi-shield-check', bg: '#e8f5e9', color: '#28a745', title: 'Keamanan Terjamin', desc: 'Tim lifeguard berpengalaman siaga setiap saat.' },
  { icon: 'bi-geo-alt-fill', bg: '#fff3e0', color: '#f5a623', title: 'Lokasi Strategis', desc: 'Mudah dijangkau di jantung Kota Samarinda.' },
  { icon: 'bi-people-fill', bg: '#fdecea', color: '#dc3545', title: 'Ramah Keluarga', desc: 'Fasilitas lengkap untuk kenyamanan seluruh keluarga.' },
]

const tiketHome = [
  { label: 'TIKET', name: 'Weekdays', harga: '30.000', per: 'per orang', featured: false, benefit: ['Akses semua wahana', 'Gratis 1 loker', 'Berlaku 1 hari'] },
  { label: 'TIKET', name: 'Weekend', harga: '35.000', per: 'per orang', featured: true, benefit: ['Akses semua wahana', 'Loker standar', 'Diskon 10% kantin'] },
  { label: 'MEMBER', name: 'Bulanan', harga: '300.000', per: 'per bulan', featured: false, benefit: ['Akses sepuasnya', 'Loker prioritas', 'Diskon 20% kantin'] },
]

const reviewHome = [
  { name: 'Andi Pratama', rating: 5, text: 'Kolam renang bersih, wahana lengkap. Anak-anak senang banget!', date: '12 Apr 2025' },
  { name: 'Siti Rahma', rating: 5, text: 'Tempat yang bagus untuk liburan keluarga. Petugasnya ramah.', date: '28 Mar 2025' },
  { name: 'Budi Santoso', rating: 4, text: 'Seru banget! Overall sangat memuaskan.', date: '15 Mar 2025' },
]
</script>

<style scoped>
/* --- GLOBAL STYLES --- */
.section-label { color: #f5a623; font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 2px; display: block; margin-bottom: 8px; }
.section-title { font-family: 'Montserrat', sans-serif; font-weight: 800; color: #1D3461; font-size: 36px; }
.section-desc { color: #666; font-size: 16px; }

/* --- HERO SECTION --- */
#hero { 
  background: linear-gradient(135deg, #0a3d5c 0%, #1ea8d4 55%, #7dd8f0 100%); 
  min-height: 92vh; 
  display: flex; 
  align-items: center; 
  position: relative; 
  overflow: hidden; 
  padding: 120px 0 0; 
}
#hero::before {
  content: "";
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background-image: url('/img/bg-main.jpg');
  background-size: cover;
  background-position: center;
  opacity: 0.15;
  z-index: 0;
}
.hero-content { position: relative; z-index: 1; padding-bottom: 140px; }
.hero-label { color: rgba(255,255,255,0.8); font-weight: 700; text-transform: uppercase; font-size: 14px; letter-spacing: 2px; }
.hero-title { font-family: 'Montserrat', sans-serif; font-size: clamp(36px, 6vw, 72px); font-weight: 800; color: #fff; line-height: 1.1; }
.hero-title-accent { color: #f5a623; }
.hero-desc { color: rgba(255,255,255,0.85); font-size: 18px; max-width: 520px; margin: 20px 0 36px; }
.btn-hero-primary { background: #f5a623; color: #fff; padding: 14px 32px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; transition: 0.3s; }
.btn-hero-primary:hover { background: #d4891a; transform: translateY(-3px); color: #fff; }
.btn-hero-secondary { background: rgba(255,255,255,0.15); border: 1.5px solid rgba(255,255,255,0.4); color: #fff; padding: 14px 32px; border-radius: 50px; text-decoration: none; font-weight: 600; margin-left: 15px; transition: 0.3s; }
.btn-hero-secondary:hover { background: rgba(255,255,255,0.25); color: #fff; }
.hero-stats { display: flex; gap: 32px; margin-top: 48px; flex-wrap: wrap; }
.hero-stat-number { font-family: 'Montserrat', sans-serif; font-size: 28px; font-weight: 800; color: #fff; display: block; }
.hero-stat-label { font-size: 13px; color: rgba(255,255,255,0.7); }
.hero-stat-divider { width: 1px; height: 40px; background: rgba(255,255,255,0.3); }
.hero-wave { position: absolute; bottom: 0; width: 100%; line-height: 0; z-index: 2; }

/* --- FITUR SECTION --- */
#fitur { padding: 80px 0; background: #f8fbfd; }
.fitur-card { background: #fff; padding: 32px 24px; border-radius: 20px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: 0.3s; height: 100%; }
.fitur-card:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); }
.fitur-icon { width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 26px; margin: 0 auto 20px; }
.fitur-title { font-weight: 700; color: #1D3461; margin-bottom: 10px; }
.fitur-desc { font-size: 14px; color: #666; line-height: 1.6; }

/* --- WAHANA SECTION --- */
#wahana-home { padding: 80px 0; }
.wahana-card-home { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); height: 100%; transition: 0.3s; }
.wahana-card-home:hover { transform: translateY(-8px); }
.wahana-card-img-wrap { position: relative; overflow: hidden; }
.wahana-card-img { width: 100%; height: 220px; object-fit: cover; transition: 0.5s; }
.wahana-card-home:hover .wahana-card-img { transform: scale(1.1); }
.wahana-card-badge { position: absolute; top: 14px; right: 14px; background: #1ea8d4; color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-dewasa { background: #1D3461 !important; }
.badge-anak { background: #28a745 !important; }
.wahana-card-body { padding: 24px; }
.btn-lihat-semuall { border: 2px solid #1D3461; color: #1D3461; padding: 12px 32px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: 0.3s; display: inline-block; }
.btn-lihat-semuall:hover { background: #1D3461; color: #fff; }

/* --- TIKET SECTION --- */
#tiket-home { padding: 80px 0; background: #f8fbfd; }
.tiket-home-card { background: #1D3461; color: #fff; padding: 40px 32px; border-radius: 20px; height: 100%; position: relative; transition: 0.3s; display: flex; flex-direction: column; }
.tiket-home-card:hover { transform: translateY(-8px); }
.tiket-home-featured { background: #0a3d5c; border: 2.5px solid #1ea8d4; transform: scale(1.03); }
.tiket-featured-badge { position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: #f5a623; padding: 5px 20px; border-radius: 20px; font-size: 12px; font-weight: 700; white-space: nowrap; }
.tiket-home-harga { display: flex; align-items: baseline; gap: 4px; color: #f5a623; margin: 15px 0; }
.tiket-home-nominal { font-size: 48px; font-weight: 800; }
.tiket-home-divider { border-top: 1px solid rgba(255,255,255,0.15); margin: 20px 0; }
.tiket-home-benefit { list-style: none; padding: 0; margin-bottom: 24px; flex-grow: 1; }
.tiket-home-benefit li { margin-bottom: 10px; font-size: 14px; display: flex; align-items: center; }
.btn-tiket-home { border: 1.5px solid #1ea8d4; color: #1ea8d4; text-decoration: none; display: block; text-align: center; padding: 12px; border-radius: 10px; font-weight: 600; transition: 0.3s; }
.btn-tiket-home:hover { background: #25D366; border-color: #25D366; color: #fff; }

/* --- REVIEW MARQUEE --- */
#review-home { padding: 80px 0; overflow: hidden; }
.marquee-wrapper { display: flex; overflow: hidden; padding: 20px 0; }
.marquee-content { display: flex; gap: 32px; animation: scrollMarquee 40s linear infinite; }
@keyframes scrollMarquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
.marquee-wrapper:hover .marquee-content { animation-play-state: paused; }
.review-float-card { width: 380px; flex-shrink: 0; }
.review-card-inner { background: #f8fbfd; padding: 32px; border-radius: 24px; border: 1px solid #eef2f7; transition: 0.3s; }
.review-float-card:hover .review-card-inner { border-color: #1ea8d4; transform: scale(1.05); }
.review-home-stars { color: #f5a623; margin-bottom: 16px; }
.review-text { font-style: italic; color: #444; margin-bottom: 24px; }
.review-user { display: flex; align-items: center; gap: 14px; }
.review-avatar { width: 44px; height: 44px; border-radius: 50%; background: #1ea8d4; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; }

/* --- CTA SECTION --- */
#cta-home { padding: 80px 0; background: linear-gradient(135deg, #0a3d5c 0%, #1ea8d4 100%); color: #fff; }
.cta-home-title { font-size: 36px; font-weight: 800; margin-bottom: 16px; }
.btn-cta-primary { background: #f5a623; color: #fff; padding: 14px 40px; border-radius: 50px; text-decoration: none; font-weight: 700; transition: 0.3s; display: inline-block; }
.btn-cta-primary:hover { background: #d4891a; transform: translateY(-3px); }
.btn-cta-secondary { background: rgba(255,255,255,0.15); border: 1px solid #fff; color: #fff; padding: 14px 40px; border-radius: 50px; text-decoration: none; margin-left: 15px; font-weight: 700; transition: 0.3s; display: inline-block; }

/* --- RESPONSIVE --- */
@media (max-width: 768px) {
  #hero { padding: 100px 0 60px; text-align: center; }
  .hero-desc { margin: 20px auto; }
  .btn-hero-secondary { margin-left: 0; margin-top: 15px; display: block; }
  .hero-stats { justify-content: center; }
  .hero-stat-divider { display: none; }
  .tiket-home-featured { transform: scale(1); }
  .btn-cta-secondary { margin-left: 0; margin-top: 15px; display: block; }
}
</style>