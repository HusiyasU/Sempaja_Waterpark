<template>
  <div id="footer-wrap">
    <div class="footer-wave">
      <svg viewBox="0 0 1440 180" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,60 C240,120 480,20 720,80 C960,140 1200,40 1440,90 L1440,180 L0,180 Z" fill="#EAF6FF"/>
      </svg>
    </div>

    <footer id="footer">
      <div class="container">
        <div class="row gy-4 justify-content-center">

          <!-- Brand -->
          <div class="col-lg-3 col-md-6">
            <div class="brand-wrap mb-3">
              <img src="/img/LOGOIcon.svg" alt="Logo" width="38" height="38" style="border-radius:50%;">
              <div class="brand-text ms-2">
                <span class="brand-top">Bumi Sempaja</span>
                <span class="brand-bottom">WATERPARK</span>
              </div>
            </div>
            <p class="footer-desc">
              Ajaklah seluruh keluarga Tercinta dan bersiaplah untuk Menikmati Hari Yang Penuh Keceriaan.
            </p>
          </div>

          <!-- Menu -->
          <div class="col-lg-2 col-md-4 col-6">
            <h6 class="footer-heading">Menu</h6>
            <ul class="footer-links">
              <li><RouterLink to="/">Beranda</RouterLink></li>
              <li><RouterLink to="/wahana">Wahana</RouterLink></li>
              <li><RouterLink to="/harga-tiket">Tiket & Harga</RouterLink></li>
              <li><RouterLink to="/tentang">Tentang Kami</RouterLink></li>
              <li><RouterLink to="/kontak">Kontak</RouterLink></li>
            </ul>
          </div>

          <!-- Jam Operasional -->
          <div class="col-lg-2 col-md-4 col-6">
            <h6 class="footer-heading">Jam Operasional</h6>
            <ul class="footer-links">
              <li>Senin - Jumat</li>
              <li>08.00 - 17.00 WITA</li>
              <li class="mt-2">Sabtu - Minggu</li>
              <li>07.00 - 18.00 WITA</li>
            </ul>
          </div>

          <!-- Kontak -->
          <div class="col-lg-3 col-md-4 col-12">
            <h6 class="footer-heading">Kontak</h6>
            <ul class="footer-links">
              <li>
                <i class="bi bi-geo-alt-fill me-2"></i>
                Sempaja Sel., Kec. Samarinda Utara, Kota Samarinda, Kalimantan Timur 75242
              </li>
              <li><i class="bi bi-telephone-fill me-2"></i>+62-811-551-227</li>
              <li><i class="bi bi-instagram me-2"></i>@bumisempajawaterpark</li>
            </ul>
          </div>

        </div>

        <hr class="footer-divider">
        <p class="footer-copy">© 2025 Bumi Sempaja Waterpark. All rights reserved.</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { RouterLink } from 'vue-router'
</script>