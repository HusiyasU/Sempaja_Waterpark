<template>
  <PublicLayout>

    <section id="keselamatan-hero">
      <div class="container">
        <div class="keselamatan-hero-content">
          <span class="section-label-hero">Standard Operasional</span>
          <h1 class="keselamatan-hero-title">Keselamatan Anda<br><span class="text-accent">Prioritas Kami</span></h1>
          <p class="keselamatan-hero-desc">Kami berkomitmen menjaga keceriaan Anda dengan standar keselamatan tinggi di setiap sudut Bumi Sempaja Waterpark</p>
        </div>
      </div>
      
      <div class="keselamatan-hero-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0,120 L0,60 C200,20 400,90 600,50 C800,10 1000,70 1200,40 C1320,24 1400,50 1440,60 L1440,120 Z" fill="rgba(255,255,255,0.3)"/>
          <path d="M0,120 L0,85 C360,50 720,110 1080,80 C1260,65 1380,85 1440,80 L1440,120 Z" fill="#ffffff"/>
        </svg>
      </div>
    </section>

    <section id="standar">
      <div class="container">
        <div class="text-center mb-5">
          <span class="section-label-dark">Keamanan</span>
          <h2 class="section-title-dark">Standar Keselamatan</h2>
          <p class="section-desc-dark">Prosedur keselamatan ketat diterapkan di setiap wahana</p>
        </div>
        <div class="row g-4">
          <div class="col-lg-4 col-md-6" v-for="s in standarList" :key="s.title">
            <div class="standar-card">
              <div class="standar-icon" :class="s.iconClass"><i class="bi" :class="s.icon"></i></div>
              <h5 class="standar-title">{{ s.title }}</h5>
              <p class="standar-desc">{{ s.desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="aturan">
      <div class="container">
        <div class="text-center mb-5">
          <span class="section-label-dark">Informasi</span>
          <h2 class="section-title-dark">Aturan Pengunjung</h2>
          <p class="section-desc-dark">Bumi Sempaja Waterpark Samarinda</p>
        </div>

        <div class="aturan-intro-banner mb-5">
          <i class="bi bi-info-circle-fill me-2"></i>
          <div>
            Dengan berada di dalam area kolam renang, Anda dianggap telah <strong>menyetujui seluruh peraturan</strong> yang berlaku di Bumi Sempaja Waterpark.
          </div>
        </div>

        <div class="row g-4 mb-5">
          <div class="col-md-6">
            <div class="aturan-group">
              <div class="aturan-group-header aturan-wajib">
                <i class="bi bi-check-circle-fill"></i>
                <h5 class="aturan-group-title">Wajib Dilakukan</h5>
              </div>
              <ul class="aturan-list">
                <li v-for="a in aturanWajib" :key="a">
                  <span class="aturan-icon aturan-icon-green"><i class="bi bi-check"></i></span>
                  <span>{{ a }}</span>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-6">
            <div class="aturan-group">
              <div class="aturan-group-header aturan-larangan">
                <i class="bi bi-x-circle-fill"></i>
                <h5 class="aturan-group-title">Dilarang Keras</h5>
              </div>
              <ul class="aturan-list">
                <li v-for="a in aturanLarangan" :key="a">
                  <span class="aturan-icon aturan-icon-red"><i class="bi bi-x"></i></span>
                  <span>{{ a }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="ketentuan-wrap">
          <h5 class="ketentuan-title mb-4"><i class="bi bi-shield-lock-fill me-2"></i>Ketentuan Khusus Wahana</h5>
          <div class="row g-3">
            <div class="col-md-3 col-6" v-for="k in ketentuanList" :key="k.label">
              <div class="ketentuan-item">
                <span class="ketentuan-label">{{ k.label }}</span>
                <span class="ketentuan-val">{{ k.val }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="darurat">
      <div class="container">
        <div class="text-center mb-5">
          <span class="section-label-hero" style="color:#f5a623;">Prosedur Darurat</span>
          <h2 class="section-title-dark" style="color:#ffffff;">Apa Yang Harus Dilakukan</h2>
        </div>
        <div class="row g-4 mb-5">
          <div class="col-lg-4 col-md-6" v-for="(d, i) in daruratList" :key="d.title">
            <div class="darurat-card">
              <div class="darurat-number">0{{ i + 1 }}</div>
              <h5 class="darurat-title">{{ d.title }}</h5>
              <p class="darurat-desc">{{ d.desc }}</p>
              <ul class="darurat-list">
                <li v-for="item in d.items" :key="item">
                  <i class="bi bi-chevron-right"></i><span>{{ item }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="darurat-banner">
          <i class="bi bi-telephone-fill darurat-banner-icon"></i>
          <div>
            <h5 class="darurat-banner-title">Hubungi Petugas Segera</h5>
            <p class="darurat-banner-text">Dalam keadaan darurat, segera hubungi petugas lifeguard atau security kami. Nomor darurat: <strong>+62 811 551 227</strong></p>
          </div>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import PublicLayout from '@/components/layout/PublicLayout.vue'

const standarList = [
  { icon: 'bi-shield-fill-check', iconClass: 'standar-icon-blue',   title: 'Lifeguard Bersertifikat', desc: 'Setiap wahana dijaga oleh lifeguard bersertifikat nasional yang siap membantu selama jam operasional.' },
  { icon: 'bi-wrench-adjustable', iconClass: 'standar-icon-green',  title: 'Perawatan Rutin',         desc: 'Seluruh wahana dan fasilitas diperiksa dan dirawat secara berkala oleh tim teknis berpengalaman.' },
  { icon: 'bi-droplet-fill',      iconClass: 'standar-icon-orange', title: 'Kualitas Air Terjaga',    desc: 'Air kolam diuji secara rutin untuk memastikan kebersihan dan keamanan bagi semua pengunjung.' },
]

const aturanWajib = [
  'Memiliki tiket masuk resmi sesuai ketentuan',
  'Menjaga keamanan dan ketertiban di lingkungan waterpark',
  'Mematuhi arahan petugas Bumi Sempaja Waterpark',
  'Berenang di kolam yang sesuai kedalaman/usia',
  'Wajib menggunakan pakaian renang di dalam kolam',
  'Anak di bawah 10 tahun wajib didampingi dewasa',
]

const aturanLarangan = [
  'Merokok di pinggir kolam atau area waterpark',
  'Membawa senjata tajam, alkohol, dan obat terlarang',
  'Membawa makanan dan minuman dari luar area',
  'Makan atau minum di pinggir area kolam renang',
  'Menggunakan alas kaki di area steril kolam',
]

const ketentuanList = [
  { label: 'Usia Anak',         val: 'Di bawah 10 tahun wajib didampingi' },
  { label: 'Tanggung Jawab',    val: 'Manajemen tidak bertanggung jawab atas kelalaian' },
  { label: 'Barang Bawaan',     val: 'Kehilangan barang bukan tanggung jawab pengelola' },
  { label: 'Sanksi',            val: 'Pelanggaran dapat dikenai sanksi pengeluaran' },
]

const daruratList = [
  {
    title: 'Jika Kecelakaan', desc: 'Tetap tenang dan segera laporkan ke petugas lifeguard terdekat.',
    items: ['Jangan memindahkan korban', 'Tunggu pertolongan medis', 'Ikuti instruksi petugas'],
  },
  {
    title: 'Kehilangan Barang', desc: 'Segera laporkan ke pos keamanan atau pusat informasi.',
    items: ['Datangi pos security', 'Berikan detail barang', 'Gunakan loker untuk keamanan'],
  },
  {
    title: 'Cuaca Buruk', desc: 'Wahana akan ditutup sementara jika terjadi hujan deras atau petir.',
    items: ['Keluar dari kolam segera', 'Cari tempat berteduh aman', 'Tunggu aba-aba operasional'],
  },
]
</script>

<style scoped>
/* --- HERO SECTION --- */
#keselamatan-hero {
  background-color: #0a3d5c; 
  min-height: 70vh; 
  display: flex; 
  align-items: center;
  position: relative; 
  overflow: hidden;
}

#keselamatan-hero::before {
  content: ""; 
  position: absolute; 
  top: 0; left: 0; right: 0; bottom: 0;
  background-image: url('/img/bg-kes.jpg');
  background-size: cover; 
  background-position: center;
  background-attachment: fixed;
  z-index: 0;
}

#keselamatan-hero::after {
  content: "";
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: linear-gradient(
    180deg, 
    rgba(10, 61, 92, 0.85) 0%,   
    rgba(30, 168, 212, 0.8) 60%, 
    rgba(10, 61, 92, 1) 100%
  );
  z-index: 1;
}

.keselamatan-hero-content { 
  position: relative; 
  z-index: 10; 
  padding: 140px 0; 
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

.keselamatan-hero-title { 
  font-family: 'Montserrat', sans-serif; 
  font-size: clamp(32px, 5vw, 60px); 
  font-weight: 800; 
  color: #ffffff; 
  line-height: 1.1; 
}

.text-accent { color: #f5a623; }

.keselamatan-hero-desc { 
  font-family: 'Open Sans', sans-serif; 
  font-size: 18px; 
  color: rgba(255,255,255,0.9); 
  margin: 20px auto 0; 
  max-width: 600px; 
}

.keselamatan-hero-wave { 
  position: absolute; 
  bottom: -1px; 
  left: 0; 
  width: 100%; 
  line-height: 0; 
  z-index: 11; 
}

/* --- STANDAR, ATURAN, DARURAT --- */
#standar, #aturan { padding: 100px 0; background-color: #ffffff; }
#aturan { background-color: #f8fbfd; }

.section-label-dark { color: #1ea8d4; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; font-size: 13px; display: block; margin-bottom: 8px; }
.section-title-dark { font-family: 'Montserrat', sans-serif; font-size: 32px; font-weight: 800; color: #1D3461; }
.section-desc-dark { color: #666; font-size: 16px; }

.standar-card { 
  background: #ffffff; border-radius: 20px; padding: 35px; height: 100%; 
  box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #f0f4f8; transition: 0.3s; 
}
.standar-card:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); border-color: #1ea8d4; }
.standar-icon { width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 25px; }
.standar-icon-blue { background: #EAF6FF; color: #1ea8d4; }
.standar-icon-green { background: #e8f5e9; color: #28a745; }
.standar-icon-orange { background: #fff3e0; color: #f5a623; }
.standar-title { font-family: 'Montserrat', sans-serif; font-weight: 700; color: #1D3461; margin-bottom: 15px; }

.aturan-intro-banner { 
  background: #EAF6FF; border-left: 5px solid #1ea8d4; padding: 25px; 
  border-radius: 12px; display: flex; align-items: center; color: #1D3461; font-size: 16px; 
}

.aturan-group { background: #fff; border-radius: 20px; overflow: hidden; height: 100%; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
.aturan-group-header { padding: 20px 25px; display: flex; align-items: center; gap: 12px; }
.aturan-wajib { background: #e8f5e9; color: #28a745; }
.aturan-larangan { background: #fdecea; color: #dc3545; }
.aturan-group-title { font-family: 'Montserrat', sans-serif; font-weight: 700; margin: 0; font-size: 18px; }

.aturan-list { list-style: none; padding: 25px; margin: 0; }
.aturan-list li { display: flex; gap: 15px; margin-bottom: 15px; align-items: flex-start; font-size: 14px; color: #444; }
.aturan-icon { width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }
.aturan-icon-green { background: #28a745; color: #fff; }
.aturan-icon-red { background: #dc3545; color: #fff; }

.ketentuan-wrap { background: #1D3461; border-radius: 20px; padding: 40px; }
.ketentuan-title { color: #fff; font-weight: 700; }
.ketentuan-item { background: rgba(255,255,255,0.05); padding: 20px; border-radius: 15px; height: 100%; }
.ketentuan-label { display: block; color: #1ea8d4; font-weight: 700; font-size: 12px; margin-bottom: 5px; text-transform: uppercase; }
.ketentuan-val { color: rgba(255,255,255,0.8); font-size: 13px; line-height: 1.5; }

#darurat { background-color: #1D3461; padding: 100px 0; }
.darurat-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 35px; height: 100%; transition: 0.3s; }
.darurat-card:hover { background: rgba(255,255,255,0.08); transform: translateY(-5px); }
.darurat-number { font-size: 40px; font-weight: 800; color: #f5a623; opacity: 0.4; margin-bottom: 10px; }
.darurat-title { color: #fff; font-weight: 700; margin-bottom: 15px; }
.darurat-desc { color: rgba(255,255,255,0.6); font-size: 14px; margin-bottom: 20px; }
.darurat-list { list-style: none; padding: 0; }
.darurat-list li { color: #fff; font-size: 13px; margin-bottom: 8px; display: flex; align-items: center; gap: 10px; }
.darurat-list i { color: #1ea8d4; }

.darurat-banner { background: #dc3545; padding: 30px; border-radius: 20px; display: flex; gap: 20px; align-items: center; color: #fff; margin-top: 40px; }
.darurat-banner-icon { font-size: 40px; }
.darurat-banner-title { font-weight: 700; margin-bottom: 5px; }
.darurat-banner-text { margin: 0; font-size: 15px; opacity: 0.9; }

@media (max-width: 768px) {
  #standar, #aturan, #darurat { padding: 60px 0; }
  .keselamatan-hero-content { padding: 80px 20px; }
}
</style>