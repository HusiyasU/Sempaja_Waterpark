<template>
  <PublicLayout>

    <section id="kontak-hero">
      <div class="container">
        <div class="kontak-hero-content">
          <span class="section-label-hero">Kontak</span>
          <h1 class="kontak-hero-title">Hubungi Kami</h1>
          <p class="kontak-hero-desc">Ada pertanyaan atau ingin reservasi? Kami siap membantu Anda</p>
        </div>
      </div>
      <div class="kontak-hero-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0,120 L0,60 C200,20 400,90 600,50 C800,10 1000,70 1200,40 C1320,24 1400,50 1440,60 L1440,120 Z" fill="rgba(255,255,255,0.3)"/>
          <path d="M0,120 L0,85 C360,50 720,110 1080,80 C1260,65 1380,85 1440,80 L1440,120 Z" fill="#ffffff"/>
        </svg>
      </div>
    </section>

    <section id="kontak-main">
      <div class="container">
        <div class="row g-5">

          <div class="col-lg-5">
            <h3 class="kontak-info-title">Informasi Kontak</h3>
            <p class="kontak-info-desc">Jangan ragu untuk menghubungi kami melalui berbagai saluran komunikasi di bawah ini.</p>
            <div class="kontak-info-list">
              <div class="kontak-info-item" v-for="info in kontakList" :key="info.label">
                <div class="kontak-info-icon"><i class="bi" :class="info.icon"></i></div>
                <div>
                  <p class="kontak-info-label">{{ info.label }}</p>
                  <p class="kontak-info-text">{{ info.text }}</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="kontak-form-card">
              <h4 class="kontak-form-title">Kirim Pesan</h4>
              <p class="kontak-form-desc">Isi form di bawah dan kami akan segera merespons dalam 1x24 jam</p>

              <AlertMessage :show="!!successMsg" type="success" :message="successMsg" @close="successMsg = ''" />
              <AlertMessage :show="!!errorMsg"   type="error"   :message="errorMsg"   @close="errorMsg = ''" />

              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label-custom">Nama Lengkap</label>
                  <input v-model="form.nama" type="text" class="form-input-custom" placeholder="Nama Anda">
                </div>
                <div class="col-md-6">
                  <label class="form-label-custom">Email</label>
                  <input v-model="form.email" type="email" class="form-input-custom" placeholder="email@domain.com">
                </div>
                <div class="col-12">
                  <label class="form-label-custom">No. Telepon</label>
                  <input v-model="form.telepon" type="tel" class="form-input-custom" placeholder="0812...">
                </div>
                <div class="col-12">
                  <label class="form-label-custom">Subjek</label>
                  <select v-model="form.subjek" class="form-input-custom">
                    <option value="">Pilih subjek...</option>
                    <option>Informasi Tiket</option>
                    <option>Reservasi Rombongan</option>
                    <option>Kerjasama & Sponsorship</option>
                    <option>Keluhan & Saran</option>
                    <option>Lainnya</option>
                  </select>
                </div>
                <div class="col-12">
                  <label class="form-label-custom">Pesan</label>
                  <textarea v-model="form.pesan" class="form-input-custom" rows="5" placeholder="Tuliskan pesan Anda..."></textarea>
                </div>
                <div class="col-12">
                  <button class="btn-kontak-submit" :disabled="loading" @click="handleSubmit">
                    <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                    <i v-else class="bi bi-send-fill me-2"></i>
                    {{ loading ? 'Mengirim...' : 'Kirim Pesan' }}
                  </button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <section id="kontak-maps">
      <div class="container">
        <h3 class="text-center mb-5" style="font-family:'Montserrat',sans-serif;font-weight:700;color:#1D3461;">Lokasi Kami</h3>
        <div class="maps-wrap">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6917646679586!2d117.14713781534341!3d-0.4563914996670868!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f336688f1f5%3A0x6b4453531b78297b!2sBumi%20Sempaja%20Waterpark!5e0!3m2!1sid!2sid!4v1655000000000!5m2!1sid!2sid"
            allowfullscreen="" loading="lazy">
          </iframe>
        </div>
      </div>
    </section>

    <section id="kontak-faq">
      <div class="container">
        <h3 class="text-center mb-5" style="font-family:'Montserrat',sans-serif;font-weight:700;color:#1D3461;">Pertanyaan Umum</h3>
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
import { ref, reactive } from 'vue'
import PublicLayout from '@/components/layout/PublicLayout.vue'
import AlertMessage from '@/components/common/AlertMessage.vue'

const faqOpen   = ref(null)
const loading   = ref(false)
const successMsg = ref('')
const errorMsg   = ref('')

const form = reactive({ nama: '', email: '', telepon: '', subjek: '', pesan: '' })

const kontakList = [
  { icon: 'bi-geo-alt-fill',    label: 'Alamat',          text: 'Sempaja Sel., Kec. Samarinda Utara, Kota Samarinda, Kalimantan Timur 75242' },
  { icon: 'bi-telephone-fill',  label: 'Telepon',         text: '+62 811 551 227' },
  { icon: 'bi-whatsapp',        label: 'WhatsApp',        text: '+62 811 551 227' },
  { icon: 'bi-envelope-fill',   label: 'Email',           text: 'info@bumisempajawaterpark.com' },
  { icon: 'bi-instagram',       label: 'Instagram',       text: '@bumisempajawaterpark' },
  { icon: 'bi-clock-fill',      label: 'Jam Operasional', text: 'Sen–Jum: 08.00–17.00 | Sab–Min: 07.00–18.00 WITA' },
]

const faqList = [
  { q: 'Bagaimana cara reservasi untuk rombongan?',       a: 'Hubungi kami via WhatsApp atau email minimal 3 hari sebelum kunjungan dengan menyebutkan jumlah peserta dan tanggal kunjungan.' },
  { q: 'Apakah tersedia area parkir yang luas?',          a: 'Ya, kami menyediakan area parkir yang luas dan aman untuk kendaraan roda dua maupun roda empat.' },
  { q: 'Apakah ada fasilitas kantin atau restoran?',      a: 'Ya, tersedia kantin dengan berbagai pilihan makanan dan minuman dengan harga yang terjangkau.' },
  { q: 'Apakah bisa membawa makanan dari luar?',          a: 'Makanan ringan dan minuman pribadi diperbolehkan. Namun makanan berat dan minuman beralkohol tidak diperkenankan.' },
]

async function handleSubmit() {
  if (!form.nama || !form.email || !form.pesan) {
    errorMsg.value = 'Nama, email, dan pesan wajib diisi.'
    return
  }
  loading.value = true
  await new Promise(r => setTimeout(r, 1200))
  loading.value   = false
  successMsg.value = 'Pesan berhasil dikirim! Kami akan merespons dalam 1x24 jam.'
  Object.keys(form).forEach(k => form[k] = '')
}
</script>

<style scoped>
#kontak-hero {
  background-color: #0a3d5c;
  min-height: 65vh; 
  display: flex; 
  align-items: center;
  position: relative; 
  overflow: hidden;
}

#kontak-hero::before {
  content: ""; 
  position: absolute; 
  top: 0; left: 0; right: 0; bottom: 0;
  background-image: url('/img/swpark.jpg');
  background-size: cover; 
  background-position: center;
  background-attachment: fixed;
  z-index: 0;
}

#kontak-hero::after {
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

.kontak-hero-content { 
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

.kontak-hero-title { 
  font-family: 'Montserrat', sans-serif; 
  font-size: clamp(32px, 5vw, 60px); 
  font-weight: 800; 
  color: #ffffff; 
  line-height: 1.1; 
}

.kontak-hero-desc { 
  font-family: 'Open Sans', sans-serif; 
  font-size: 18px; 
  color: rgba(255,255,255,0.9); 
  margin: 20px auto 0; 
  max-width: 600px; 
}

.kontak-hero-wave { 
  position: absolute; 
  bottom: -1px; 
  left: 0; 
  width: 100%; 
  line-height: 0; 
  z-index: 11; 
}

/* --- KONTAK MAIN --- */
#kontak-main { background-color: #ffffff; padding: 100px 0; }
.kontak-info-title { font-family: 'Montserrat', sans-serif; font-size: 28px; font-weight: 700; color: #1D3461; margin-bottom: 12px; }
.kontak-info-desc  { font-family: 'Open Sans', sans-serif; font-size: 15px; color: #666; line-height: 1.7; margin-bottom: 32px; }
.kontak-info-list  { display: flex; flex-direction: column; gap: 20px; }
.kontak-info-item  { display: flex; align-items: flex-start; gap: 16px; }
.kontak-info-icon  { width: 46px; height: 46px; background-color: #EAF6FF; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #1ea8d4; flex-shrink: 0; }
.kontak-info-label { font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 600; color: #1D3461; margin-bottom: 2px; }
.kontak-info-text  { font-family: 'Open Sans', sans-serif; font-size: 14px; color: #555; line-height: 1.5; margin: 0; }

.kontak-form-card  { background: #ffffff; border: 1.5px solid #e8e8e8; border-radius: 20px; padding: 40px 36px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
.kontak-form-title { font-family: 'Montserrat', sans-serif; font-size: 22px; font-weight: 700; color: #1D3461; margin-bottom: 8px; }
.kontak-form-desc  { font-family: 'Open Sans', sans-serif; font-size: 14px; color: #888; margin-bottom: 24px; }
.form-label-custom { font-family: 'Inter', sans-serif; font-size: 14px; font-weight: 500; color: #1D3461; margin-bottom: 6px; display: block; }
.form-input-custom { width: 100%; font-family: 'Open Sans', sans-serif; font-size: 14px; color: #333; background-color: #f8fbfd; border: 1.5px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; outline: none; transition: 0.3s; appearance: none; resize: vertical; }
.form-input-custom:focus { border-color: #1ea8d4; box-shadow: 0 0 0 3px rgba(30,168,212,0.12); background-color: #ffffff; }
.btn-kontak-submit { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 15px; background-color: #1D3461; color: #ffffff; border: none; border-radius: 50px; padding: 14px 32px; width: 100%; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; }
.btn-kontak-submit:hover:not(:disabled) { background-color: #0a3d5c; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(29, 52, 97, 0.2); }

#kontak-maps { background-color: #f8fbfd; padding: 100px 0; }
.maps-wrap { width: 100%; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); border: 1.5px solid rgba(29,52,97,0.1); }
.maps-wrap iframe { width: 100%; height: 450px; border: none; display: block; }

#kontak-faq { background-color: #ffffff; padding: 100px 0; }
.faq-item { border-bottom: 1px solid #e8e8e8; }
.faq-item:first-child { border-top: 1px solid #e8e8e8; }
.faq-btn { width: 100%; font-family: 'Montserrat', sans-serif; font-size: 16px; font-weight: 600; color: #1D3461; background: transparent; border: none; padding: 20px 0; display: flex; align-items: center; justify-content: space-between; gap: 16px; cursor: pointer; text-align: left; }
.faq-btn:hover { color: #1ea8d4; }
.faq-icon { font-size: 16px; flex-shrink: 0; transition: transform 0.25s ease; }
.faq-btn[aria-expanded="true"] .faq-icon { transform: rotate(180deg); }
.faq-body { font-family: 'Open Sans', sans-serif; font-size: 15px; color: #555; line-height: 1.8; padding: 0 0 20px; }

@media (max-width: 768px) {
  .kontak-hero-content { padding: 80px 20px; }
  #kontak-main, #kontak-maps, #kontak-faq { padding: 60px 0; }
  .kontak-form-card { padding: 30px 20px; }
  .maps-wrap iframe { height: 300px; }
}
</style>