<template>
  <PublicLayout>

    <section id="tentang-hero">
      <div class="container">
        <div class="tentang-hero-content">
          <span class="section-label-hero">Tentang Kami</span>
          <h1 class="tentang-hero-title">Mengenal Lebih Dekat<br>Bumi Sempaja</h1>
          <p class="tentang-hero-desc">Waterpark terbaik di Samarinda yang hadir untuk memberikan kesenangan bagi seluruh keluarga</p>
        </div>
      </div>
      <div class="tentang-hero-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0,120 L0,60 C200,20 400,90 600,50 C800,10 1000,70 1200,40 C1320,24 1400,50 1440,60 L1440,120 Z" fill="rgba(255,255,255,0.3)"/>
          <path d="M0,120 L0,85 C360,50 720,110 1080,80 C1260,65 1380,85 1440,80 L1440,120 Z" fill="#ffffff"/>
        </svg>
      </div>
    </section>

    <section id="brand-purpose">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-7">
            <span class="section-label">Tentang Kami</span>
            <h2 class="section-title">Kami Hadir untuk Kebahagiaan Keluarga</h2>
            <p class="tentang-body">
              Bumi Sempaja Waterpark adalah destinasi wisata air terkemuka di Kota Samarinda, Kalimantan Timur.
              Berdiri sejak 2010, kami telah melayani ratusan ribu pengunjung dari berbagai penjuru Kalimantan
              dengan menyediakan wahana air berkualitas, fasilitas lengkap, dan layanan prima.
            </p>
            <p class="tentang-body">
              Berlokasi strategis di kawasan Sempaja, kami hadir dengan misi tunggal: menciptakan kenangan
              indah bagi setiap keluarga yang mengunjungi kami. Dengan lahan seluas 5 hektar dan lebih dari
              15 wahana unggulan, Bumi Sempaja Waterpark siap menjadi tujuan liburan utama Anda.
            </p>
            <div class="purpose-statement">
              <i class="bi bi-quote purpose-icon"></i>
              <p class="purpose-text">
                "Kami percaya bahwa setiap keluarga berhak mendapatkan momen kebahagiaan yang tak terlupakan,
                dan kami hadir untuk mewujudkan itu setiap harinya."
              </p>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="row g-3">
              <div class="col-6" v-for="stat in statList" :key="stat.number">
                <div class="stat-box">
                  <div class="stat-box-number">
                    {{ stat.number }}<span class="stat-box-plus">{{ stat.plus }}</span>
                  </div>
                  <p class="stat-box-label">{{ stat.label }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="visi-misi">
      <div class="container">
        <div class="text-center mb-5">
          <span class="section-label">Arah Kami</span>
          <h2 class="section-title">Visi & Misi</h2>
        </div>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="vm-card vm-visi">
              <div class="vm-icon"><i class="bi bi-eye-fill"></i></div>
              <h3 class="vm-title">Visi</h3>
              <p class="vm-desc">Menjadi destinasi wisata air terdepan di Kalimantan Timur yang mengutamakan keselamatan, kenyamanan, dan kebahagiaan pengunjung.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="vm-card vm-misi">
              <div class="vm-icon"><i class="bi bi-bullseye"></i></div>
              <h3 class="vm-title">Misi</h3>
              <ul class="vm-list">
                <li>Menyediakan wahana berkualitas tinggi yang aman untuk semua usia</li>
                <li>Memberikan pelayanan prima dengan senyum dan ketulusan hati</li>
                <li>Menjaga kebersihan dan kelestarian lingkungan sekitar</li>
                <li>Terus berinovasi dalam menghadirkan wahana dan fasilitas baru</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="core-values">
      <div class="container">
        <div class="text-center mb-5">
          <span class="section-label" style="color:#1D3461;">Nilai Kami</span>
          <h2 class="section-title" style="color:#1D3461;">Nilai-Nilai Inti</h2>
        </div>
        <div class="row g-4 justify-content-center">
          <div class="col-lg-4 col-md-6" v-for="nilai in nilaiList" :key="nilai.title">
            <div class="nilai-card">
              <div class="nilai-icon">{{ nilai.emoji }}</div>
              <h4 class="nilai-title">{{ nilai.title }}</h4>
              <p class="nilai-desc">{{ nilai.desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import PublicLayout from '@/components/layout/PublicLayout.vue'

const statList = [
  { number: '14',  plus: '+', label: 'Tahun Pengalaman' },
  { number: '50K', plus: '+', label: 'Pengunjung / Tahun' },
  { number: '5',   plus: '+', label: 'Wahana Unggulan' },
  { number: '4.8', plus: '★', label: 'Rating Kepuasan' },
]

const nilaiList = [
  { emoji: '💧', title: 'SPLASH — Kesenangan',   desc: 'Setiap momen di Waterpark Bumi Sempaja harus membawa kegembiraan. Kami merancang setiap detail untuk menciptakan senyum di wajah pengunjung.' },
  { emoji: '🛡️', title: 'SHIELD — Keamanan',    desc: 'Keselamatan adalah prioritas utama, bukan pilihan. Setiap staf, setiap wahana, dan setiap prosedur dirancang untuk melindungi setiap pengunjung.' },
  { emoji: '👨‍👩‍👧‍👦', title: 'FAMILY — Kebersamaan', desc: 'Kami adalah ruang untuk keluarga. Semua fasilitas dirancang agar dapat dinikmati bersama, dari anak-anak hingga kakek-nenek.' },
  { emoji: '⭐', title: 'SPARK — Inovasi',       desc: 'Kami terus berinovasi dalam wahana, layanan, dan pengalaman agar selalu relevan dan mengejutkan pengunjung.' },
  { emoji: '🤝', title: 'SINCERE — Ketulusan',  desc: 'Kami melayani dengan hati. Setiap staf membawa energi positif dan ketulusan dalam setiap interaksi.' },
]
</script>

<style scoped>
/* --- HERO SECTION  --- */
#tentang-hero {
  background-color: #0a3d5c;
  min-height: 65vh; 
  display: flex; 
  align-items: center;
  position: relative; 
  overflow: hidden;
}

#tentang-hero::before {
  content: ""; 
  position: absolute; 
  top: 0; left: 0; right: 0; bottom: 0;
  background-image: url('/img/tentang.jpg');
  background-size: cover; 
  background-position: center;
  background-attachment: fixed;
  z-index: 0;
}

#tentang-hero::after {
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

.tentang-hero-content { 
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

.tentang-hero-title { 
  font-family: 'Montserrat', sans-serif; 
  font-size: clamp(32px, 5vw, 60px); 
  font-weight: 800; 
  color: #ffffff; 
  line-height: 1.1; 
}

.tentang-hero-desc { 
  font-family: 'Open Sans', sans-serif; 
  font-size: 18px; 
  color: rgba(255,255,255,0.9); 
  margin: 20px auto 0; 
  max-width: 600px; 
}

.tentang-hero-wave { 
  position: absolute; 
  bottom: -1px; 
  left: 0; 
  width: 100%; 
  line-height: 0; 
  z-index: 11; 
}

/* --- BRAND PURPOSE --- */
#brand-purpose { background-color: #ffffff; padding: 100px 0; }
.section-label { color: #1ea8d4; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; font-size: 13px; display: block; margin-bottom: 8px; }
.section-title { font-family: 'Montserrat', sans-serif; font-size: 32px; font-weight: 800; color: #1D3461; margin-bottom: 24px; }
.tentang-body { font-family: 'Open Sans', sans-serif; font-size: 16px; color: #444; line-height: 1.8; margin-bottom: 24px; }
.purpose-statement { background-color: #EAF6FF; border-left: 4px solid #1ea8d4; border-radius: 0 12px 12px 0; padding: 25px; display: flex; gap: 16px; align-items: flex-start; }
.purpose-icon { font-size: 22px; color: #1ea8d4; flex-shrink: 0; }
.purpose-text { font-family: 'Open Sans', sans-serif; font-size: 15px; font-style: italic; color: #1D3461; line-height: 1.7; margin: 0; }
.stat-box { background: #ffffff; border: 1.5px solid #eef2f7; border-radius: 20px; padding: 30px 20px; display: flex; flex-direction: column; align-items: center; text-align: center; transition: 0.3s; }
.stat-box:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-color: #1ea8d4; }
.stat-box-number { font-family: 'Montserrat', sans-serif; font-size: 36px; font-weight: 800; color: #1D3461; line-height: 1; }
.stat-box-plus { color: #f5a623; font-size: 28px; }
.stat-box-label { font-family: 'Open Sans', sans-serif; font-size: 13px; color: #888; margin-top: 10px; margin-bottom: 0; }

/* --- VISI MISI --- */
#visi-misi { background-color: #f8fbfd; padding: 100px 0; }
.vm-card { background: #ffffff; border-radius: 25px; padding: 45px 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); transition: 0.3s; height: 100%; }
.vm-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.08); }
.vm-icon { width: 60px; height: 60px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 25px; }
.vm-visi .vm-icon { background-color: #EAF6FF; color: #1ea8d4; }
.vm-misi .vm-icon { background-color: #fff3e0; color: #f5a623; }
.vm-title { font-family: 'Montserrat', sans-serif; font-size: 26px; font-weight: 700; color: #1D3461; margin-bottom: 20px; }
.vm-desc { font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic; color: #444; line-height: 1.8; margin: 0; }
.vm-list { font-family: 'Open Sans', sans-serif; font-size: 15px; color: #444; line-height: 1.8; padding-left: 20px; margin: 0; }
.vm-list li { margin-bottom: 12px; }

/* --- CORE VALUES --- */
#core-values { background-color: #f5a623; padding: 100px 0; }
.nilai-card { background: #ffffff; border-radius: 20px; padding: 35px 25px; text-align: center; height: 100%; transition: 0.3s; }
.nilai-card:hover { transform: translateY(-8px); box-shadow: 0 15px 40px rgba(0,0,0,0.15); }
.nilai-icon { font-size: 48px; margin-bottom: 20px; line-height: 1; }
.nilai-title { font-family: 'Montserrat', sans-serif; font-size: 19px; font-weight: 800; color: #1D3461; margin-bottom: 15px; letter-spacing: 0.5px; }
.nilai-desc { font-family: 'Open Sans', sans-serif; font-size: 14px; color: #555; line-height: 1.7; margin: 0; }

@media (max-width: 768px) {
  .tentang-hero-content { padding: 80px 20px; }
  #brand-purpose, #visi-misi, #core-values { padding: 60px 0; }
}
</style>```