<?php

namespace App\Controllers;

use App\Core\Response;
use App\Core\Middleware;
use App\Models\UserModel;

class UserController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // =====================
    // GET /api/user/profile
    // =====================
    public function profile(): void
    {
        $payload = Middleware::auth();

        $user = $this->userModel->findById($payload->id);

        if (!$user) {
            Response::notFound('User tidak ditemukan');
        }

        unset($user['password']);

        Response::success($user, 'Profil berhasil diambil');
    }

    // =====================
    // PUT /api/user/profile
    // =====================
    public function updateProfile(): void
    {
        $payload = Middleware::auth();
        $body    = json_decode(file_get_contents('php://input'), true);

        $namaDepan    = trim($body['nama_depan']    ?? '');
        $namaBelakang = trim($body['nama_belakang'] ?? '');
        $telepon      = trim($body['telepon']        ?? '');

        if (!$namaDepan) {
            Response::error('Nama depan wajib diisi', 422);
        }

        $updated = $this->userModel->update($payload->id, [
            'nama_depan'    => $namaDepan,
            'nama_belakang' => $namaBelakang,
            'telepon'       => $telepon,
        ]);

        if (!$updated) {
            Response::error('Gagal memperbarui profil', 500);
        }

        $user = $this->userModel->findById($payload->id);
        unset($user['password']);

        Response::success($user, 'Profil berhasil diperbarui');
    }

    // ============================
    // PUT /api/user/change-password
    // ============================
    public function changePassword(): void
    {
        $payload = Middleware::auth();
        $body    = json_decode(file_get_contents('php://input'), true);

        $oldPassword = $body['old_password'] ?? '';
        $newPassword = $body['new_password'] ?? '';
        $konfirmasi  = $body['password_confirmation'] ?? '';

        if (!$oldPassword || !$newPassword) {
            Response::error('Password lama dan baru wajib diisi', 422);
        }

        if (strlen($newPassword) < 8) {
            Response::error('Password baru minimal 8 karakter', 422);
        }

        if ($newPassword !== $konfirmasi) {
            Response::error('Konfirmasi password tidak cocok', 422);
        }

        $user = $this->userModel->findById($payload->id);

        if (!password_verify($oldPassword, $user['password'])) {
            Response::error('Password lama tidak sesuai', 401);
        }

        $hashed  = password_hash($newPassword, PASSWORD_BCRYPT);
        $updated = $this->userModel->update($payload->id, ['password' => $hashed]);

        if (!$updated) {
            Response::error('Gagal mengubah password', 500);
        }

        Response::success(null, 'Password berhasil diubah');
    }
}   