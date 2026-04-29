<template>
  <PublicLayout>

    <section id="tiket-hero">
      <div class="container">
        <div class="tiket-hero-content">
          <span class="section-label-hero">Pilihan Paket</span>
          <h1 class="tiket-hero-title">Pilih Tiket<br><span class="text-accent">Sesuai Kebutuhan</span></h1>
          <p class="tiket-hero-desc">Harga terjangkau untuk pengalaman bermain air yang tak terlupakan bersama keluarga di Bumi Sempaja</p>
        </div>
      </div>
      <div class="tiket-hero-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0,120 L0,60 C200,20 400,90 600,50 C800,10 1000,70 1200,40 C1320,24 1400,50 1440,60 L1440,120 Z" fill="rgba(255,255,255,0.3)"/>
          <path d="M0,120 L0,85 C360,50 720,110 1080,80 C1260,65 1380,85 1440,80 L1440,120 Z" fill="#ffffff"/>
        </svg>
      </div>
    </section>

    <section id="tiket-list">
      <div class="container">
        <div class="row g-4 justify-content-center align-items-stretch">
          <div class="col-lg-4 col-md-6" v-for="tiket in tiketList" :key="tiket.name">
            <div class="tiket-card-page" :class="{ 'tiket-featured': tiket.featured }">
              <span v-if="tiket.featured" class="tiket-featured-badge">⭐ Paling Populer</span>
              <div class="tiket-page-body">
                <p class="tiket-page-label">{{ tiket.label }}</p>
                <h3 class="tiket-page-name">{{ tiket.name }}</h3>
                <p class="tiket-page-sub">{{ tiket.sub }}</p>
                <div class="tiket-page-harga">
                  <span class="tiket-page-rp">Rp</span>
                  <span class="tiket-page-nominal">{{ tiket.harga }}</span>
                </div>
                <p class="tiket-page-per">{{ tiket.per }}</p>
                <hr class="tiket-page-divider">
                <ul class="tiket-page-benefit">
                  <li v-for="b in tiket.benefit" :key="b">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ b }}</span>
                  </li>
                </ul>
              </div>
              <a :href="tiket.wa" target="_blank" class="btn-tiket-page" :class="{ 'btn-tiket-featured': tiket.featured }">
                <i class="bi bi-whatsapp me-2"></i> Pesan via WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="tiket-info">
      <div class="container">
        <div class="text-center mb-5">
          <span class="section-label-dark">Panduan</span>
          <h3 class="tiket-info-title">Informasi Penting</h3>
        </div>
        <div class="row g-4">
          <div class="col-lg-3 col-md-6" v-for="info in infoList" :key="info.title">
            <div class="info-card">
              <div class="info-icon"><i class="bi" :class="info.icon"></i></div>
              <div class="info-content">
                <p class="info-title">{{ info.title }}</p>
                <p class="info-desc">{{ info.desc }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="kontak-faq">
      <div class="container">
        <div class="text-center mb-5">
          <span class="section-label-dark">FAQ</span>
          <h3 class="section-title-faq">Pertanyaan Umum</h3>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div v-for="(faq, i) in faqList" :key="i" class="faq-item">
              <button class="faq-btn" :aria-expanded="faqOpen === i" @click="faqOpen = faqOpen === i ? null : i">
                {{ faq.q }}
                <i class="bi bi-chevron-down faq-icon"></i>
              </button>
              <Transition name="faq">
                <div v-if="faqOpen === i" class="faq-body">{{ faq.a }}</div>
              </Transition>
            </div>
          </div>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import { ref } from 'vue'
import PublicLayout from '@/components/layout/PublicLayout.vue'

const faqOpen = ref(null)

const tiketList = [
  {
    label: 'TIKET', name: 'Weekdays', sub: 'Senin – Jumat', harga: '30.000', per: 'per orang', featured: false,
    wa: 'https://wa.me/62811551227?text=Halo, saya ingin pesan tiket weekdays',
    benefit: [
      'Akses semua wahana',
      'Gratis 1 loker standar',
      'Berlaku 1 hari kunjungan',
      'Berlaku Senin – Jumat',
    ],
  },
  {
    label: 'TIKET', name: 'Weekend', sub: 'Sabtu & Minggu', harga: '35.000', per: 'per orang', featured: true,
    wa: 'https://wa.me/62811551227?text=Halo, saya ingin pesan tiket weekend',
    benefit: [
      'Akses semua wahana',
      'Gratis 1 loker standar',
      'Berlaku 1 hari kunjungan',
      'Berlaku Sabtu & Minggu',
      'Diskon 10% di kantin',
    ],
  },
  {
    label: 'MEMBER', name: 'Bulanan', sub: 'Akses tidak terbatas sebulan', harga: '300.000', per: 'per bulan', featured: false,
    wa: 'https://wa.me/62811551227?text=Halo, saya ingin daftar member bulanan',
    benefit: [
      'Akses wahana sepuasnya',
      'Loker prioritas member',
      'Diskon 20% di kantin',
      'Berlaku 30 hari penuh',
      'Kartu member eksklusif',
    ],
  },
]

const infoList = [
  { icon: 'bi-clock-fill',       title: 'Jam Operasional',   desc: 'Senin–Jumat: 08.00–17.00 WITA\nSabtu–Minggu: 07.00–18.00 WITA' },
  { icon: 'bi-calendar-check',   title: 'Reservasi',          desc: 'Dapat dilakukan melalui WhatsApp atau langsung di loket.' },
  { icon: 'bi-bag-check-fill',   title: 'Yang Boleh Dibawa', desc: 'Baju ganti, handuk, sunscreen, dan minuman pribadi.' },
  { icon: 'bi-x-circle-fill',    title: 'Dilarang Masuk',   desc: 'Makanan berat, alkohol, kamera profesional, & hewan.' },
]

const faqList = [
  { q: 'Apakah tiket bisa dibeli secara online?',          a: 'Saat ini pembelian tiket dapat dilakukan via WhatsApp atau langsung di loket pada hari kunjungan.' },
  { q: 'Apa perbedaan tiket Weekdays dan Weekend?',        a: 'Tiket Weekdays (Senin-Jumat) Rp30.000, sedangkan Weekend (Sabtu-Minggu) Rp35.000 termasuk diskon kantin.' },
  { q: 'Bagaimana cara mendaftar member bulanan?',         a: 'Cukup hubungi admin WhatsApp kami atau datang ke loket dengan membawa kartu identitas untuk pendaftaran.' },
  { q: 'Apakah ada diskon untuk rombongan?',               a: 'Ya, tersedia harga khusus untuk rombongan minimal 20 orang. Silakan hubungi WA admin untuk penawaran.' },
]
</script>

<style scoped>
/* --- HERO SECTION --- */
#tiket-hero {
  background: linear-gradient(135deg, #0a3d5c 0%, #1ea8d4 55%, #7dd8f0 100%);
  min-height: 50vh; display: flex; align-items: center;
  position: relative; overflow: hidden;
}

#tiket-hero::before {
  content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
  background-image: url('/img/bg-tes.jpg');
  background-size: 150%; 
  background-position: center;
  opacity: 0.3; 
  z-index: 0;
}

.tiket-hero-content { position: relative; z-index: 1; padding: 110px 0; text-align: center; width: 100%; }
.section-label-hero { color: rgba(255,255,255,0.8); font-weight: 700; text-transform: uppercase; letter-spacing: 3px; font-size: 14px; display: block; margin-bottom: 10px; }
.tiket-hero-title { font-family: 'Montserrat', sans-serif; font-size: clamp(32px, 5vw, 60px); font-weight: 800; color: #ffffff; line-height: 1.1; }
.text-accent { color: #f5a623; }
.tiket-hero-desc { font-family: 'Open Sans', sans-serif; font-size: 18px; color: rgba(255,255,255,0.9); margin: 20px auto 0; max-width: 600px; }
.tiket-hero-wave { position: absolute; bottom: 0; left: 0; width: 100%; line-height: 0; z-index: 2; }

/* --- TIKET LIST  --- */
#tiket-list { 
  background-color: #ffffff; 
  padding: 80px 0 100px; 
}

.tiket-card-page {
  background: #1D3461; border-radius: 24px; padding: 40px 32px; height: 100%;
  transition: all 0.3s ease; position: relative; display: flex; flex-direction: column; color: #fff;
}
.tiket-card-page:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
.tiket-featured { background: #0a3d5c; border: 2.5px solid #1ea8d4; transform: scale(1.05); }
.tiket-featured-badge { position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: #f5a623; color: #fff; font-size: 12px; font-weight: 700; padding: 6px 20px; border-radius: 50px; white-space: nowrap; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

.tiket-page-body { flex-grow: 1; }
.tiket-page-label { font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.5); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 5px; }
.tiket-page-name { font-family: 'Montserrat', sans-serif; font-size: 32px; font-weight: 700; margin-bottom: 5px; }
.tiket-page-sub { font-size: 13px; color: rgba(255,255,255,0.6); margin-bottom: 20px; }
.tiket-page-harga { display: flex; align-items: baseline; gap: 5px; color: #f5a623; }
.tiket-page-rp { font-size: 20px; font-weight: 800; }
.tiket-page-nominal { font-size: 48px; font-weight: 800; line-height: 1; }
.tiket-page-per { font-size: 13px; color: rgba(255,255,255,0.5); margin-bottom: 20px; }
.tiket-page-divider { border-top: 1px solid rgba(255,255,255,0.1); margin: 25px 0; }

.tiket-page-benefit { list-style: none; padding: 0; margin-bottom: 30px; }
.tiket-page-benefit li { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; font-size: 14px; }
.tiket-page-benefit i { color: #28a745; font-size: 16px; }

.btn-tiket-page { 
  display: flex; align-items: center; justify-content: center; width: 100%;
  padding: 14px; border-radius: 12px; font-weight: 700; text-decoration: none;
  border: 2px solid #1ea8d4; color: #1ea8d4; transition: 0.3s;
}
.btn-tiket-page:hover { background: #25D366; border-color: #25D366; color: #fff; transform: translateY(-2px); }
.btn-tiket-featured { border-color: #f5a623; color: #f5a623; }

/* --- INFO & FAQ --- */
#tiket-info { background-color: #f8fbfd; padding: 100px 0; }
.section-label-dark { color: #1ea8d4; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; font-size: 13px; display: block; margin-bottom: 8px; }
.tiket-info-title, .section-title-faq { font-family: 'Montserrat', sans-serif; font-size: 32px; font-weight: 800; color: #1D3461; }

.info-card { background: #fff; border-radius: 20px; padding: 25px; display: flex; gap: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.04); height: 100%; transition: 0.3s; }
.info-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
.info-icon { width: 50px; height: 50px; background: #EAF6FF; color: #1ea8d4; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
.info-title { font-weight: 700; color: #1D3461; margin-bottom: 5px; font-size: 16px; }
.info-desc { font-size: 13px; color: #666; line-height: 1.6; margin: 0; white-space: pre-line; }

#kontak-faq { padding: 100px 0; background: #fff; }
.faq-item { border-bottom: 1px solid #f0f0f0; }
.faq-btn { 
  width: 100%; padding: 25px 0; background: none; border: none; 
  display: flex; justify-content: space-between; align-items: center;
  font-family: 'Montserrat', sans-serif; font-weight: 700; color: #1D3461; font-size: 16px; cursor: pointer; text-align: left;
}
.faq-icon { transition: 0.3s; color: #1ea8d4; }
.faq-btn[aria-expanded="true"] .faq-icon { transform: rotate(180deg); }
.faq-body { padding-bottom: 25px; color: #666; font-size: 15px; line-height: 1.7; }

/* Transition FAQ */
.faq-enter-active, .faq-leave-active { transition: all 0.3s ease; max-height: 200px; overflow: hidden; }
.faq-enter-from, .faq-leave-to { opacity: 0; max-height: 0; }

@media (max-width: 991px) {
  .tiket-featured { transform: scale(1); margin: 10px 0; }
  #tiket-list, #tiket-info, #kontak-faq { padding: 60px 0; }
}
</style>