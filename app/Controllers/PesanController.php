<?php

namespace App\Controllers;

use App\Core\Response;
use App\Core\Middleware;
use App\Models\PesanModel;

class PesanController
{
    private PesanModel $pesanModel;

    public function __construct()
    {
        $this->pesanModel = new PesanModel();
    }

    public function store(): void
    {
        $body = json_decode(file_get_contents('php://input'), true);

        $nama     = trim($body['nama']     ?? '');
        $email    = trim($body['email']    ?? '');
        $telepon  = trim($body['telepon']  ?? '');
        $subjek   = trim($body['subjek']   ?? '');
        $isiPesan = trim($body['pesan']    ?? '');

        // Validasi
        if (!$nama || !$email || !$isiPesan) {
            Response::error('Nama, email, dan pesan wajib diisi', 422);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Response::error('Format email tidak valid', 422);
        }

        $id = $this->pesanModel->create([
            'nama'      => $nama,
            'email'     => $email,
            'telepon'   => $telepon,
            'subjek'    => $subjek,
            'isi_pesan' => $isiPesan,
            'status'    => 'belum_dibaca',
        ]);

        if (!$id) {
            Response::error('Gagal mengirim pesan', 500);
        }

        Response::success(['id' => $id], 'Pesan berhasil dikirim', 201);
    }

    // =====================
    // GET /api/admin/pesan
    // Lihat semua pesan (admin only)
    // =====================
    public function index(): void
    {
        Middleware::admin();
        $pesan = $this->pesanModel->getAll();
        Response::success($pesan, 'Data pesan berhasil diambil');
    }

    // ==============================
    // PUT /api/admin/pesan/{id}/baca
    // Tandai pesan sudah dibaca
    // ==============================
    public function tandaiBaca(string $id): void
    {
        Middleware::admin();

        $pesan = $this->pesanModel->findById((int)$id);
        if (!$pesan) {
            Response::notFound('Pesan tidak ditemukan');
        }

        $this->pesanModel->tandaiBaca((int)$id);
        Response::success(null, 'Pesan ditandai sudah dibaca');
    }

    // ==============================
    // DELETE /api/admin/pesan/{id}
    // ==============================
    public function destroy(string $id): void
    {
        Middleware::admin();

        $pesan = $this->pesanModel->findById((int)$id);
        if (!$pesan) {
            Response::notFound('Pesan tidak ditemukan');
        }

        $this->pesanModel->delete((int)$id);
        Response::success(null, 'Pesan berhasil dihapus');
    }
}